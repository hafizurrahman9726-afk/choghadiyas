<?php
/**
 * Responsive Footer with Full Footer Bar
 * Includes all footer widgets and bottom bar
 */

// Fallback site settings if database not available
$site_settings = $site_settings ?? [
    'name' => 'Choghadiya Muhurat',
    'description' => 'Your trusted guide for auspicious timings and Vedic astrology',
    'logo' => '',
    'facebook' => '#',
    'twitter' => '#',
    'instagram' => '#',
    'youtube' => '#',
    'linkedin' => '#'
];

// Fallback categories if database not available
$footer_categories = $footer_categories ?? [
    ['id' => 1, 'name' => 'blog', 'slug' => 'blog'],
];

$footer_posts = [];

// Get base URL
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
?>

<!-- Full Footer Bar -->
<footer class="site-footer">
    <div class="footer-main">
        <div class="container">
            <div class="footer-widgets">
                <!-- About Widget -->
                <div class="footer-widget footer-about">
                    <div class="footer-logo">
                        <?php if (!empty($site_settings['logo'])): ?>
                        <img src="<?php echo $site_settings['logo']; ?>" alt="<?php echo htmlspecialchars($site_settings['name']); ?>">
                        <?php else: ?>
                        <h3><?php echo htmlspecialchars($site_settings['name']); ?></h3>
                        <?php endif; ?>
                    </div>
                    <p class="footer-description"><?php echo htmlspecialchars($site_settings['description']); ?></p>
                    <div class="footer-social">
                        <?php if (!empty($site_settings['whatsapp']) && $site_settings['whatsapp'] !== '#'): ?>
                        <a href="<?php echo htmlspecialchars($site_settings['whatsapp']); ?>" target="_blank" rel="noopener noreferrer" class="social-icon social-whatsapp" aria-label="Join our WhatsApp Channel" title="WhatsApp Channel">
                            <i class="fab fa-whatsapp" aria-hidden="true"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($site_settings['instagram']) && $site_settings['instagram'] !== '#'): ?>
                        <a href="<?php echo htmlspecialchars($site_settings['instagram']); ?>" target="_blank" rel="noopener noreferrer" class="social-icon social-instagram" aria-label="Follow us on Instagram" title="Instagram">
                            <i class="fab fa-instagram" aria-hidden="true"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($site_settings['youtube']) && $site_settings['youtube'] !== '#'): ?>
                        <a href="<?php echo htmlspecialchars($site_settings['youtube']); ?>" target="_blank" rel="noopener noreferrer" class="social-icon social-youtube" aria-label="Subscribe to our YouTube Channel" title="YouTube">
                            <i class="fab fa-youtube" aria-hidden="true"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($site_settings['facebook']) && $site_settings['facebook'] !== '#'): ?>
                        <a href="<?php echo htmlspecialchars($site_settings['facebook']); ?>" target="_blank" rel="noopener noreferrer" class="social-icon social-facebook" aria-label="Follow us on Facebook" title="Facebook">
                            <i class="fab fa-facebook-f" aria-hidden="true"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Contact Widget -->
                <div class="footer-widget footer-contact">
                    <h3 class="footer-widget-title">Contact Us</h3>
                    <ul class="footer-contact-list">
                        <?php if (!empty($site_settings['contact_phone'])): ?>
                        <li>
                            <i class="fas fa-phone"></i>
                            <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $site_settings['contact_phone']); ?>">
                                <?php echo htmlspecialchars($site_settings['contact_phone']); ?>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (!empty($site_settings['contact_email'])): ?>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:<?php echo htmlspecialchars($site_settings['contact_email']); ?>">
                                <?php echo htmlspecialchars($site_settings['contact_email']); ?>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <address class="footer-address" style="font-style: normal; line-height: 1.6;">
                                <strong><?php echo htmlspecialchars($site_settings['name']); ?></strong><br>
                                <?php echo htmlspecialchars(OFFICE_STREET); ?>,<br>
                                <?php echo htmlspecialchars(OFFICE_LOCALITY); ?>, <?php echo htmlspecialchars(OFFICE_REGION); ?> <?php echo htmlspecialchars(OFFICE_POSTAL_CODE); ?>, India
                            </address>
                        </li>
                    </ul>
                </div>
                
                <!-- Quick Links Widget -->
                <div class="footer-widget footer-links">
                    <h3 class="footer-widget-title">Quick Links</h3>
                    <ul class="footer-links-list">
                        <li><a href="<?php echo $base_url; ?>/">Home</a></li>
                        <li><a href="<?php echo $base_url; ?>/about">About Us</a></li>
                        <li><a href="<?php echo $base_url; ?>/contact">Contact Us</a></li>
                        <li><a href="<?php echo $base_url; ?>/privacy-policy">Privacy Policy</a></li>
                        <li><a href="<?php echo $base_url; ?>/disclaimer">Disclaimer</a></li>
                        <li><a href="<?php echo $base_url; ?>/terms">Terms & Conditions</a></li>
                        <li><a href="<?php echo $base_url; ?>/editorial-policy">Editorial Policy</a></li>
                    </ul>
                </div>
                
                <!-- Categories Widget -->
                <div class="footer-widget footer-categories">
                    <h3 class="footer-widget-title">Categories</h3>
                    <ul class="footer-links-list">
                        <?php foreach ($footer_categories as $cat): ?>
                        <li><a href="<?php echo $base_url; ?>/<?php echo $cat['slug']; ?>"><?php echo htmlspecialchars($cat['name']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <!-- Recent Posts Widget -->
                <div class="footer-widget footer-recent">
                    <h3 class="footer-widget-title">Recent Posts</h3>
                    <ul class="footer-recent-list">
                        <?php foreach ($footer_posts as $post): ?>
                        <li>
                            <a href="<?php echo $base_url; ?>/<?php echo $post['slug']; ?>">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer Bottom Bar -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <p class="copyright">
                    <?php if (!empty($site_settings['copyright_text'])): ?>
                        <?php echo htmlspecialchars($site_settings['copyright_text']); ?>
                    <?php else: ?>
                        &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($site_settings['name']); ?>. All Rights Reserved.
                    <?php endif; ?>
                </p>
                <div class="footer-bottom-links">
                    <a href="<?php echo $base_url; ?>/privacy-policy">Privacy Policy</a>
                    <a href="<?php echo $base_url; ?>/terms">Terms & Conditions</a>
                    <a href="<?php echo $base_url; ?>/disclaimer">Disclaimer</a>
                    <a href="<?php echo $base_url; ?>/editorial-policy">Editorial Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- ============================================================
     Cookie Consent Banner (GDPR / CCPA compliant)
     ============================================================ -->
<div id="cookie-consent-banner" class="cookie-consent" role="dialog" aria-live="polite" aria-label="Cookie consent" hidden>
    <div class="cookie-consent-inner">
        <div class="cookie-consent-text">
            <strong>We value your privacy</strong>
            <p>This website uses cookies and similar technologies to deliver content, analyse traffic, and serve personalised ads (including via Google AdSense and its partners). By clicking "Accept", you consent to our use of cookies. Read our <a href="<?php echo SITE_URL; ?>/privacy-policy">Privacy Policy</a> for details.</p>
        </div>
        <div class="cookie-consent-actions">
            <button type="button" id="cookie-consent-reject" class="cookie-btn cookie-btn-secondary">Reject</button>
            <button type="button" id="cookie-consent-accept" class="cookie-btn cookie-btn-primary">Accept All</button>
        </div>
    </div>
</div>
<style>
.cookie-consent {
    position: fixed;
    left: 16px;
    right: 16px;
    bottom: 16px;
    z-index: 9999;
    background: #ffffff;
    color: #1f2937;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 18px 50px rgba(0,0,0,0.18);
    padding: 16px 20px;
    max-width: 880px;
    margin: 0 auto;
    font-family: 'Poppins', sans-serif;
    animation: cookieSlideUp 0.4s ease;
}
@keyframes cookieSlideUp { from { transform: translateY(40px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.cookie-consent-inner {
    display: flex;
    align-items: center;
    gap: 18px;
    flex-wrap: wrap;
}
.cookie-consent-text { flex: 1 1 320px; font-size: 13.5px; line-height: 1.5; }
.cookie-consent-text strong { display: block; font-size: 15px; color: #111827; margin-bottom: 4px; }
.cookie-consent-text p { margin: 0; color: #4b5563; }
.cookie-consent-text a { color: #667eea; text-decoration: underline; }
.cookie-consent-actions { display: flex; gap: 8px; }
.cookie-btn {
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13.5px;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
}
.cookie-btn-primary { background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; }
.cookie-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 18px rgba(102,126,234,0.35); }
.cookie-btn-secondary { background: #f3f4f6; color: #374151; }
.cookie-btn-secondary:hover { background: #e5e7eb; }
@media (max-width: 600px) {
    .cookie-consent { left: 10px; right: 10px; bottom: 10px; padding: 14px; }
    .cookie-consent-actions { width: 100%; }
    .cookie-consent-actions .cookie-btn { flex: 1; }
}
</style>
<script>
(function() {
    var KEY = 'choghadiya_cookie_consent';
    var banner = document.getElementById('cookie-consent-banner');
    if (!banner) return;
    var stored = null;
    try { stored = localStorage.getItem(KEY); } catch(e) {}
    if (!stored) {
        banner.hidden = false;
    }
    function setConsent(value) {
        try { localStorage.setItem(KEY, value); } catch(e) {}
        banner.hidden = true;
        // Notify any listening analytics/ad scripts
        document.dispatchEvent(new CustomEvent('cookieConsent', { detail: { value: value } }));
    }
    var accept = document.getElementById('cookie-consent-accept');
    var reject = document.getElementById('cookie-consent-reject');
    if (accept) accept.addEventListener('click', function(){ setConsent('accepted'); });
    if (reject) reject.addEventListener('click', function(){ setConsent('rejected'); });
})();
</script>

<!-- Professional Disclaimer -->
<section class="footer-disclaimer-section">
    <div class="container">
        <div class="disclaimer-content">
            <div class="disclaimer-header">
                <i class="fas fa-info-circle"></i>
                <span>DISCLAIMER</span>
            </div>
            <p class="disclaimer-text">The information provided on this website is for general informational and spiritual guidance purposes only. While we strive to ensure accuracy and authenticity, users are advised to verify important timings, Muhurat, Panchang, and astrological details independently before making decisions.</p>
        </div>
    </div>
</section>

<!-- Footer Styles -->
<style>
/* Footer Main Styles */
.site-footer {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    color: #94a3b8;
    font-family: 'Poppins', sans-serif;
}

.footer-main {
    padding: 60px 0 40px;
}

.footer-widgets {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
    gap: 40px;
}

.footer-widget {
    padding: 0;
}

.footer-logo h3 {
    color: #f8fafc;
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 16px;
    font-family: 'Montserrat', sans-serif;
}

.footer-logo img {
    max-height: 50px;
    margin-bottom: 16px;
}

.footer-description {
    font-size: 15px;
    line-height: 1.7;
    margin: 0 0 24px;
    color: #94a3b8;
}

.footer-social {
    display: flex;
    gap: 12px;
}

.footer-social a {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #e2e8f0;
    text-decoration: none;
    transition: all 0.3s ease;
}

.footer-social a:hover {
    background: #667eea;
    color: white;
    transform: translateY(-3px);
}

.footer-widget-title {
    color: #f8fafc;
    font-size: 18px;
    font-weight: 600;
    margin: 0 0 24px;
    padding-bottom: 12px;
    border-bottom: 2px solid #667eea;
    font-family: 'Montserrat', sans-serif;
}

.footer-links-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links-list li {
    margin-bottom: 12px;
}

.footer-links-list a {
    color: #94a3b8;
    text-decoration: none;
    font-size: 15px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.footer-links-list a:hover {
    color: #667eea;
    padding-left: 5px;
}

.footer-links-list a::before {
    content: '›';
    color: #667eea;
    font-weight: bold;
}

.footer-recent-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-recent-list li {
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.footer-recent-list li:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.footer-recent-list a {
    color: #94a3b8;
    text-decoration: none;
    font-size: 15px;
    line-height: 1.5;
    transition: color 0.3s ease;
}

.footer-recent-list a:hover {
    color: #667eea;
}

/* Footer Contact Widget Styles */
.footer-contact-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-contact-list li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 16px;
    color: #94a3b8;
    font-size: 15px;
    line-height: 1.5;
}

.footer-contact-list li i {
    color: #667eea;
    font-size: 16px;
    margin-top: 2px;
    flex-shrink: 0;
}

.footer-contact-list a {
    color: #94a3b8;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-contact-list a:hover {
    color: #667eea;
}

.footer-contact-list span {
    display: inline-block;
    line-height: 1.5;
}

/* Footer Bottom Bar */
.footer-bottom {
    background: rgba(0,0,0,0.3);
    border-top: 1px solid rgba(255,255,255,0.1);
    padding: 24px 0;
}

.footer-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.copyright {
    color: #64748b;
    font-size: 14px;
    margin: 0;
}

.footer-bottom-links {
    display: flex;
    gap: 24px;
}

.footer-bottom-links a {
    color: #64748b;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.3s ease;
}

.footer-bottom-links a:hover {
    color: #667eea;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .footer-widgets {
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }
}

@media (max-width: 768px) {
    .footer-widgets {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .footer-main {
        padding: 40px 0 30px;
    }
    
    .footer-bottom-content {
        flex-direction: column;
        text-align: center;
    }
    
    .footer-bottom-links {
        flex-wrap: wrap;
        justify-content: center;
    }
}

/* Professional Disclaimer */
.footer-disclaimer-section {
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    padding: 20px 0;
    font-family: 'Poppins', sans-serif;
}

.disclaimer-content {
    text-align: center;
    max-width: 900px;
    margin: 0 auto;
}

.disclaimer-header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-bottom: 12px;
}

.disclaimer-header i {
    color: #64748b;
    font-size: 14px;
}

.disclaimer-header span {
    color: #64748b;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-family: 'Montserrat', sans-serif;
}

.disclaimer-text {
    color: #475569;
    font-size: 13px;
    line-height: 1.7;
    margin: 0;
    font-weight: 400;
}

/* Responsive Design for Disclaimer */
@media (max-width: 768px) {
    .footer-disclaimer-section {
        padding: 16px 0;
    }
    
    .disclaimer-content {
        padding: 0 16px;
    }
    
    .disclaimer-text {
        font-size: 12px;
        line-height: 1.6;
    }
}
</style>

<!-- Font Awesome (for disclaimer icon) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Custom Footer Scripts -->
<?php global $site_settings; ?>
<?php if (!empty($site_settings['custom_footer_scripts'])): ?>
<?php echo $site_settings['custom_footer_scripts']; ?>
<?php endif; ?>
