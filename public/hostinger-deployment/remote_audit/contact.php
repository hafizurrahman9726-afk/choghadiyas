<?php
/**
 * Choghadiyas.in - Contact Us Page
 * Contact form with CSRF protection, input validation and responsive layout.
 */

require_once __DIR__ . '/../config/config.php';

/* Page metadata */
$site_name = !empty($site_settings['name']) ? (string) $site_settings['name'] : 'Choghadiyas.in';
$page_title = 'संपर्क करें | Choghadiyas.in';
$page_description = 'Choghadiyas.in से संपर्क करें। चौघड़िया, पंचांग, शुभ मुहूर्त, व्रत, त्योहार या वेबसाइट से संबंधित प्रश्नों के लिए हमसे संपर्क करें।';
$canonical_url = rtrim((string) SITE_URL, '/') . '/contact';

/* Escaping and input helpers */
if (!function_exists('contact_e')) {
    function contact_e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
if (!function_exists('contact_post_string')) {
    function contact_post_string(string $key): string
    {
        $value = $_POST[$key] ?? '';
        return is_string($value) ? trim($value) : '';
    }
}
if (!function_exists('contact_text_length')) {
    function contact_text_length(string $value): int
    {
        return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
    }
}

/* Use an actual configured recipient address only. */
$configured_email = defined('AUTHOR_EMAIL') ? trim((string) AUTHOR_EMAIL) : '';
$contact_email = filter_var($configured_email, FILTER_VALIDATE_EMAIL)
    ? $configured_email
    : 'contact@choghadiyas.in';

/* Prefer the complete configured address; do not invent an address if none exists. */
$office_address = '';
if (defined('OFFICE_ADDRESS_FULL') && trim((string) OFFICE_ADDRESS_FULL) !== '') {
    $office_address = trim((string) OFFICE_ADDRESS_FULL);
} else {
    $office_street = defined('OFFICE_STREET') ? trim((string) OFFICE_STREET) : '';
    $office_locality = defined('OFFICE_LOCALITY') ? trim((string) OFFICE_LOCALITY) : '';
    $office_region = defined('OFFICE_REGION') ? trim((string) OFFICE_REGION) : '';
    $office_postal = defined('OFFICE_POSTAL_CODE') ? trim((string) OFFICE_POSTAL_CODE) : '';
    $office_country = defined('OFFICE_COUNTRY') ? trim((string) OFFICE_COUNTRY) : '';
    if ($office_country === 'IN') {
        $office_country = 'India';
    }
    $office_parts = array_filter([$office_street, $office_locality, $office_region, $office_postal, $office_country], static fn($part) => $part !== '');
    $office_address = implode(', ', $office_parts);
}

/* Session and CSRF token */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['contact_csrf_token']) || !is_string($_SESSION['contact_csrf_token']) || !preg_match('/^[a-f0-9]{64}$/', $_SESSION['contact_csrf_token'])) {
    $_SESSION['contact_csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['contact_csrf_token'];

$form_errors = [];
$form_success = !empty($_SESSION['contact_form_success']);
unset($_SESSION['contact_form_success']);
$old_name = '';
$old_email = '';
$old_subject = '';
$old_message = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    /* Honeypot anti-spam field */
    if (contact_post_string('website') !== '') {
        $form_errors[] = 'अनुरोध स्वीकार नहीं किया जा सका। कृपया दोबारा प्रयास करें।';
    }

    $submitted_token = contact_post_string('csrf_token');
    $stored_token = $_SESSION['contact_csrf_token'] ?? '';
    if (!is_string($stored_token) || $submitted_token === '' || !hash_equals($stored_token, $submitted_token)) {
        $form_errors[] = 'सुरक्षा सत्यापन विफल हुआ। कृपया पेज रीफ्रेश करके दोबारा प्रयास करें।';
    }

    $old_name = contact_post_string('name');
    $old_email = contact_post_string('email');
    $old_subject = contact_post_string('subject');
    $old_message = contact_post_string('message');

    if ($old_name === '') {
        $form_errors[] = 'कृपया अपना नाम दर्ज करें।';
    } elseif (contact_text_length($old_name) > 100) {
        $form_errors[] = 'नाम 100 अक्षरों से अधिक नहीं होना चाहिए।';
    }

    if ($old_email === '' || contact_text_length($old_email) > 254 || !filter_var($old_email, FILTER_VALIDATE_EMAIL)) {
        $form_errors[] = 'कृपया एक मान्य ईमेल पता दर्ज करें।';
    }

    if ($old_subject === '') {
        $form_errors[] = 'कृपया विषय दर्ज करें।';
    } elseif (contact_text_length($old_subject) > 150) {
        $form_errors[] = 'विषय 150 अक्षरों से अधिक नहीं होना चाहिए।';
    }

    $message_length = contact_text_length($old_message);
    if ($old_message === '') {
        $form_errors[] = 'कृपया अपना संदेश लिखें।';
    } elseif ($message_length < 10) {
        $form_errors[] = 'कृपया थोड़ा विस्तृत संदेश लिखें।';
    } elseif ($message_length > 5000) {
        $form_errors[] = 'संदेश 5000 अक्षरों से अधिक नहीं होना चाहिए।';
    }

    if (empty($form_errors)) {
        $safe_name = preg_replace('/[\r\n]+/', ' ', $old_name) ?? $old_name;
        $safe_email = preg_replace('/[\r\n]+/', '', $old_email) ?? $old_email;
        $safe_subject = preg_replace('/[\r\n]+/', ' ', $old_subject) ?? $old_subject;

        $mail_subject_plain = 'Website Contact: ' . $safe_subject;
        $mail_subject = '=?UTF-8?B?' . base64_encode($mail_subject_plain) . '?=';
        $mail_body =
            "New contact message from Choghadiyas.in\n\n" .
            "Name: " . $safe_name . "\n" .
            "Email: " . $safe_email . "\n" .
            "Subject: " . $safe_subject . "\n\n" .
            "Message:\n" . $old_message . "\n\n" .
            "Submitted from: " . $canonical_url . "\n";

        $headers = [
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
            'From: Choghadiyas.in <' . $contact_email . '>',
            'Reply-To: ' . $safe_email
        ];

        $mail_sent = false;
        if (function_exists('mail')) {
            $mail_sent = @mail($contact_email, $mail_subject, $mail_body, implode("\r\n", $headers));
        }

        if ($mail_sent) {
            $_SESSION['contact_form_success'] = true;
            $_SESSION['contact_csrf_token'] = bin2hex(random_bytes(32));
            header('Location: ' . $canonical_url . '#contact-form', true, 303);
            exit;
        }

        $form_errors[] = 'संदेश भेजा नहीं जा सका। कृपया कुछ समय बाद दोबारा प्रयास करें या दिए गए ईमेल पते पर सीधे संपर्क करें।';
    }
}

/* Contact page structured data */
$contact_page_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'ContactPage',
    'name' => 'हमसे संपर्क करें - Choghadiyas.in',
    'url' => $canonical_url,
    'description' => $page_description,
    'isPartOf' => [
        '@type' => 'WebSite',
        'name' => $site_name,
        'url' => rtrim((string) SITE_URL, '/')
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => $site_name,
        'email' => $contact_email
    ],
    'mainEntity' => [
        '@type' => 'ContactPoint',
        'contactType' => 'customer support',
        'email' => $contact_email,
        'availableLanguage' => ['Hindi', 'English']
    ]
];
if ($office_address !== '') {
    $postal_address = ['@type' => 'PostalAddress'];
    if (defined('OFFICE_STREET') && trim((string) OFFICE_STREET) !== '') {
        $postal_address['streetAddress'] = trim((string) OFFICE_STREET);
    } elseif (defined('OFFICE_ADDRESS_FULL') && trim((string) OFFICE_ADDRESS_FULL) !== '') {
        $postal_address['streetAddress'] = trim((string) OFFICE_ADDRESS_FULL);
    }
    if (defined('OFFICE_LOCALITY') && trim((string) OFFICE_LOCALITY) !== '') {
        $postal_address['addressLocality'] = trim((string) OFFICE_LOCALITY);
    }
    if (defined('OFFICE_REGION') && trim((string) OFFICE_REGION) !== '') {
        $postal_address['addressRegion'] = trim((string) OFFICE_REGION);
    }
    if (defined('OFFICE_POSTAL_CODE') && trim((string) OFFICE_POSTAL_CODE) !== '') {
        $postal_address['postalCode'] = trim((string) OFFICE_POSTAL_CODE);
    }
    if (defined('OFFICE_COUNTRY') && trim((string) OFFICE_COUNTRY) !== '') {
        $postal_address['addressCountry'] = trim((string) OFFICE_COUNTRY);
    } else {
        $postal_address['addressCountry'] = 'IN';
    }
    $contact_page_schema['publisher']['address'] = $postal_address;
}

require_once __DIR__ . '/../includes/header_responsive.php';
?>

<main class="contact-page">

<!-- ============================================================
     CONTACT HERO
     ============================================================ -->
<section class="contact-hero-section">
    <div class="container">
        <div class="contact-hero-content">

            <div class="contact-hero-badge">
                <i class="fas fa-envelope" aria-hidden="true"></i>
                <span>संपर्क करें</span>
            </div>

            <h1>हमसे संपर्क करें</h1>

            <p class="contact-hero-subtitle">
                Choghadiya, Panchang और शुभ मुहूर्त से संबंधित प्रश्नों के लिए हमसे संपर्क करें।
            </p>

            <p class="contact-hero-description">
                यदि आपको वेबसाइट की जानकारी, किसी लेख, चौघड़िया, पंचांग,
                मुहूर्त या किसी अन्य विषय से संबंधित प्रश्न है, तो नीचे दिए
                गए संपर्क विकल्पों का उपयोग कर सकते हैं।
            </p>

        </div>
    </div>
</section>


<!-- ============================================================
     CONTACT MAIN
     ============================================================ -->
<section class="contact-main-section">
    <div class="container">

        <div class="contact-grid">

            <!-- Contact Information -->
            <aside class="contact-info-card">

                <div class="contact-info-header">

                    <div class="contact-info-icon">
                        <i class="fas fa-comments" aria-hidden="true"></i>
                    </div>

                    <h2>संपर्क जानकारी</h2>

                    <p>
                        हमसे संपर्क करने के लिए नीचे दिए गए विकल्पों में से
                        सुविधाजनक माध्यम चुनें।
                    </p>

                </div>


                <div class="contact-info-list">

                    <div class="contact-info-item">

                        <div class="contact-item-icon">
                            <i class="fas fa-envelope" aria-hidden="true"></i>
                        </div>

                        <div>
                            <span class="contact-item-label">ईमेल</span>

                            <a href="mailto:<?php echo contact_e($contact_email); ?>">
                                <?php echo contact_e($contact_email); ?>
                            </a>

                        </div>

                    </div>


                    <?php if ($office_address !== ''): ?>
                        <div class="contact-info-item">
                            <div class="contact-item-icon">
                                <i class="fas fa-location-dot" aria-hidden="true"></i>
                            </div>
                            <div class="contact-info-copy">
                                <span class="contact-item-label">कार्यालय का पता</span>
                                <address><?php echo contact_e($office_address); ?></address>
                            </div>
                        </div>
                    <?php endif; ?>


                    <div class="contact-info-item">

                        <div class="contact-item-icon">
                            <i class="fas fa-clock" aria-hidden="true"></i>
                        </div>

                        <div>
                            <span class="contact-item-label">संपर्क माध्यम</span>

                            <span>
                                ईमेल के माध्यम से संपर्क करें
                            </span>
                        </div>

                    </div>


                    <div class="contact-info-item">

                        <div class="contact-item-icon">
                            <i class="fas fa-circle-question" aria-hidden="true"></i>
                        </div>

                        <div>
                            <span class="contact-item-label">किस विषय पर संपर्क करें?</span>

                            <span>
                                वेबसाइट, चौघड़िया, पंचांग, मुहूर्त और संबंधित जानकारी
                            </span>
                        </div>

                    </div>

                </div>


                <!-- Social Links -->
                <div class="contact-social-section">

                    <h3>हमसे जुड़ें</h3>

                    <div class="contact-social-grid">

                        <a
                            href="https://whatsapp.com/channel/0029Vb7TUHHEquiNzOin5P0r"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="WhatsApp Channel"
                            class="contact-social whatsapp"
                        >
                            <i class="fab fa-whatsapp" aria-hidden="true"></i>
                            <span>WhatsApp</span>
                        </a>


                        <a
                            href="https://www.instagram.com/shivkumarpandit8053/"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Instagram"
                            class="contact-social instagram"
                        >
                            <i class="fab fa-instagram" aria-hidden="true"></i>
                            <span>Instagram</span>
                        </a>


                        <a
                            href="https://www.youtube.com/@SKPANDITJIOFFICIAL"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="YouTube"
                            class="contact-social youtube"
                        >
                            <i class="fab fa-youtube" aria-hidden="true"></i>
                            <span>YouTube</span>
                        </a>


                        <a
                            href="https://www.facebook.com/people/Shiv-Kumar-Pandit/61589328703704/"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Facebook"
                            class="contact-social facebook"
                        >
                            <i class="fab fa-facebook-f" aria-hidden="true"></i>
                            <span>Facebook</span>
                        </a>

                    </div>

                </div>

            </aside>


            <!-- Contact Form -->
            <div class="contact-form-card">

                <div class="contact-form-header">

                    <div class="section-badge">
                        <i class="fas fa-paper-plane" aria-hidden="true"></i>
                        <span>संपर्क फॉर्म</span>
                    </div>

                    <h2>हमसे संपर्क करें</h2>

                    <p>
                        अपना संदेश भेजने के लिए नीचे दिए गए फॉर्म को भरें।
                    </p>

                </div>


                <?php if ($form_success): ?>

                    <div class="contact-alert contact-success" role="status">

                        <i class="fas fa-circle-check" aria-hidden="true"></i>

                        <div>
                            <strong>आपका संदेश भेज दिया गया है।</strong>
                            <p>
                                धन्यवाद। आपका संदेश प्राप्त हो गया है।
                            </p>
                        </div>

                    </div>

                <?php endif; ?>


                <?php if (!empty($form_errors)): ?>

                    <div class="contact-alert contact-error" role="alert">

                        <i class="fas fa-circle-exclamation" aria-hidden="true"></i>

                        <div>
                            <strong>कृपया निम्न जानकारी जांचें:</strong>

                            <ul>
                                <?php foreach ($form_errors as $error): ?>
                                    <li><?php echo contact_e($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    </div>

                <?php endif; ?>


                <form
                    id="contact-form"
                    method="post"
                    action="<?php echo contact_e($canonical_url); ?>"
                    class="contact-form"
                >

                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?php echo contact_e($csrf_token); ?>"
                    >

                    <!-- Honeypot -->
                    <div
                        class="form-honeypot"
                        aria-hidden="true"
                    >
                        <label for="website">
                            Website
                        </label>

                        <input
                            type="text"
                            id="website"
                            name="website"
                            value=""
                            tabindex="-1"
                            autocomplete="off"
                        >
                    </div>


                    <div class="form-row">

                        <div class="form-group">

                            <label for="name">
                                नाम <span aria-hidden="true">*</span>
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="<?php echo contact_e($old_name); ?>"
                                maxlength="100"
                                autocomplete="name"
                                required
                                placeholder="अपना नाम दर्ज करें"
                            >

                        </div>


                        <div class="form-group">

                            <label for="email">
                                ईमेल <span aria-hidden="true">*</span>
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="<?php echo contact_e($old_email); ?>"
                                maxlength="254"
                                autocomplete="email"
                                required
                                placeholder="आपका ईमेल पता"
                            >

                        </div>

                    </div>


                    <div class="form-group">

                        <label for="subject">
                            विषय <span aria-hidden="true">*</span>
                        </label>

                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            value="<?php echo contact_e($old_subject); ?>"
                            maxlength="150"
                            required
                            placeholder="संदेश का विषय"
                        >

                    </div>


                    <div class="form-group">

                        <label for="message">
                            संदेश <span aria-hidden="true">*</span>
                        </label>

                        <textarea
                            id="message"
                            name="message"
                            rows="7"
                            maxlength="5000"
                            required
                            placeholder="अपना संदेश लिखें..."
                        ><?php echo contact_e($old_message); ?></textarea>

                    </div>


                    <div class="form-note">
                        <i class="fas fa-shield-halved" aria-hidden="true"></i>

                        <span>
                            कृपया संदेश में पासवर्ड, OTP या अन्य संवेदनशील
                            व्यक्तिगत जानकारी साझा न करें।
                        </span>
                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary btn-lg contact-submit-btn"
                    >
                        <i class="fas fa-paper-plane" aria-hidden="true"></i>
                        संदेश भेजें
                    </button>

                </form>

                <p class="contact-privacy-note">
                    फॉर्म में दी गई जानकारी का उपयोग आपकी पूछताछ का उत्तर देने के लिए किया जा सकता है।
                    अधिक जानकारी के लिए हमारी <a href="/privacy-policy">गोपनीयता नीति</a> पढ़ें।
                </p>

            </div>

        </div>

    </div>
</section>


<!-- ============================================================
     CONTACT PAGE STYLES (scoped and responsive)
     ============================================================ -->
<style>
.contact-page {
    color: #1f2937;
    background: #f8fafc;
    overflow-wrap: anywhere;
}

.contact-page * { box-sizing: border-box; }
.contact-page .container {
    width: min(1160px, calc(100% - 40px));
    max-width: 1160px;
    margin-inline: auto;
}

.contact-page .contact-hero-section {
    padding: clamp(42px, 6vw, 76px) 0 clamp(34px, 4.5vw, 54px);
    background: linear-gradient(135deg, #fff7ed 0%, #ffffff 58%, #f8fafc 100%);
    border-bottom: 1px solid #e5e7eb;
}
.contact-page .contact-hero-content { max-width: 820px; margin-inline: auto; }
.contact-page .contact-hero-badge,
.contact-page .section-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 13px;
    margin-bottom: 14px;
    border: 1px solid #fed7aa;
    border-radius: 999px;
    background: #fff7ed;
    color: #9a3412;
    font-size: 13px;
    font-weight: 700;
}
.contact-page .contact-hero-content h1 {
    margin: 0 0 16px;
    color: #111827;
    font-size: clamp(2rem, 4vw, 3rem);
    line-height: 1.2;
    letter-spacing: -0.025em;
}
.contact-page .contact-hero-subtitle {
    margin: 0 0 10px;
    color: #374151;
    font-size: clamp(1.05rem, 2vw, 1.2rem);
    font-weight: 600;
    line-height: 1.65;
}
.contact-page .contact-hero-description {
    max-width: 760px;
    margin: 0;
    color: #5b6472;
    font-size: 1rem;
    line-height: 1.85;
}

.contact-page .contact-main-section { padding: clamp(28px, 4vw, 52px) 0 68px; }
.contact-page .contact-grid {
    display: grid;
    grid-template-columns: minmax(280px, .82fr) minmax(0, 1.18fr);
    align-items: start;
    gap: 24px;
}
.contact-page .contact-info-card,
.contact-page .contact-form-card {
    min-width: 0;
    padding: clamp(20px, 3vw, 30px);
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 8px 28px rgba(15, 23, 42, .055);
}
.contact-page .contact-info-header { margin-bottom: 22px; }
.contact-page .contact-info-icon {
    display: grid;
    width: 48px;
    height: 48px;
    margin-bottom: 15px;
    place-items: center;
    border-radius: 14px;
    background: #fff7ed;
    color: #c2410c;
    font-size: 20px;
}
.contact-page .contact-info-header h2,
.contact-page .contact-form-header h2 {
    margin: 0 0 10px;
    color: #111827;
    font-size: clamp(1.35rem, 2.4vw, 1.7rem);
    line-height: 1.35;
}
.contact-page .contact-info-header p,
.contact-page .contact-form-header p {
    margin: 0;
    color: #5b6472;
    font-size: 15px;
    line-height: 1.75;
}
.contact-page .contact-info-list { display: grid; gap: 12px; }
.contact-page .contact-info-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    min-width: 0;
    padding: 14px;
    border: 1px solid #edf0f4;
    border-radius: 12px;
    background: #fbfcfe;
}
.contact-page .contact-item-icon {
    display: grid;
    flex: 0 0 38px;
    width: 38px;
    height: 38px;
    place-items: center;
    border-radius: 10px;
    background: #f3f4f6;
    color: #4b5563;
}
.contact-page .contact-info-copy,
.contact-page .contact-info-item > div:last-child { min-width: 0; }
.contact-page .contact-item-label {
    display: block;
    margin: 0 0 5px;
    color: #6b7280;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .025em;
}
.contact-page .contact-info-item a,
.contact-page .contact-info-item address,
.contact-page .contact-info-item span:not(.contact-item-label) {
    color: #374151;
    font-size: 14px;
    line-height: 1.7;
    overflow-wrap: anywhere;
}
.contact-page .contact-info-item a { color: #9a3412; text-decoration: underline; text-underline-offset: 3px; }
.contact-page .contact-info-item address { margin: 0; font-style: normal; }

.contact-page .contact-social-section { margin-top: 24px; padding-top: 21px; border-top: 1px solid #e5e7eb; }
.contact-page .contact-social-section h3 { margin: 0 0 13px; color: #111827; font-size: 17px; }
.contact-page .contact-social-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
.contact-page .contact-social {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 44px;
    padding: 10px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    background: #fff;
    color: #374151;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: background-color .18s ease, border-color .18s ease;
}
.contact-page .contact-social:hover { border-color: #d1d5db; background: #f9fafb; text-decoration: none; }

.contact-page .contact-form-header { margin-bottom: 22px; }
.contact-page .contact-form-header .section-badge { margin-bottom: 12px; }
.contact-page .contact-form .form-row { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
.contact-page .contact-form .form-group { min-width: 0; margin-bottom: 18px; }
.contact-page .contact-form label { display: block; margin: 0 0 7px; color: #374151; font-size: 14px; font-weight: 700; }
.contact-page .contact-form label span[aria-hidden="true"] { color: #b91c1c; }
.contact-page .contact-form input,
.contact-page .contact-form textarea {
    display: block;
    width: 100%;
    max-width: 100%;
    min-height: 46px;
    padding: 11px 13px;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    background: #fff;
    color: #111827;
    font: inherit;
    font-size: 15px;
    line-height: 1.5;
    transition: border-color .18s ease, box-shadow .18s ease;
}
.contact-page .contact-form textarea { min-height: 160px; resize: vertical; }
.contact-page .contact-form input::placeholder,
.contact-page .contact-form textarea::placeholder { color: #9ca3af; }
.contact-page .contact-form input:focus-visible,
.contact-page .contact-form textarea:focus-visible,
.contact-page .contact-social:focus-visible,
.contact-page .contact-info-item a:focus-visible,
.contact-page .contact-submit-btn:focus-visible {
    outline: 3px solid rgba(194, 65, 12, .25);
    outline-offset: 2px;
    border-color: #c2410c;
}
.contact-page .form-note {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    margin: 2px 0 18px;
    padding: 12px 13px;
    border-radius: 10px;
    background: #f8fafc;
    color: #5b6472;
    font-size: 13px;
    line-height: 1.65;
}
.contact-page .form-note i { flex: 0 0 auto; margin-top: 3px; color: #6b7280; }
.contact-page .contact-privacy-note { margin: 14px 0 0; color: #6b7280; font-size: 13px; line-height: 1.65; }
.contact-page .contact-privacy-note a { color: #9a3412; text-decoration: underline; text-underline-offset: 2px; }
.contact-page .contact-submit-btn { display: inline-flex; align-items: center; justify-content: center; gap: 9px; min-height: 46px; padding: 12px 19px; border-radius: 10px; cursor: pointer; }
.contact-page .contact-alert { display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; margin: 0 0 20px; border-radius: 11px; line-height: 1.55; }
.contact-page .contact-alert > i { flex: 0 0 auto; margin-top: 3px; }
.contact-page .contact-alert p { margin: 4px 0 0; }
.contact-page .contact-alert ul { margin: 6px 0 0; padding-left: 18px; }
.contact-page .contact-success { border: 1px solid rgba(34, 197, 94, .25); background: #f0fdf4; color: #166534; }
.contact-page .contact-error { border: 1px solid rgba(239, 68, 68, .22); background: #fef2f2; color: #991b1b; }
.contact-page .form-honeypot { position: absolute !important; left: -10000px !important; width: 1px !important; height: 1px !important; overflow: hidden !important; opacity: 0 !important; pointer-events: none !important; }

@media (max-width: 900px) {
    .contact-page .contact-grid { grid-template-columns: minmax(0, 1fr); }
    .contact-page .contact-info-card { order: 1; }
    .contact-page .contact-form-card { order: 2; }
}
@media (max-width: 600px) {
    .contact-page .container { width: calc(100% - 32px); }
    .contact-page .contact-hero-section { padding: 38px 0 30px; }
    .contact-page .contact-main-section { padding: 24px 0 44px; }
    .contact-page .contact-info-card,
    .contact-page .contact-form-card { padding: 20px 16px; border-radius: 14px; }
    .contact-page .contact-form .form-row { grid-template-columns: minmax(0, 1fr); gap: 0; }
    .contact-page .contact-social-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .contact-page .contact-submit-btn { width: 100%; }
}
@media (prefers-reduced-motion: reduce) {
    .contact-page *, .contact-page *::before, .contact-page *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; }
}
</style>

</main>

<!-- ============================================================
     CONTACT PAGE STRUCTURED DATA
     ============================================================ -->
<script type="application/ld+json">
<?php echo json_encode($contact_page_schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
</script>


<?php require_once __DIR__ . '/../includes/footer.php'; ?>