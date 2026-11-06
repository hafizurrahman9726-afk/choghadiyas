<?php
/**
 * Footer Template
 */

global $site_settings;

// Get categories for footer
$footer_categories = db_fetch_all("SELECT id, name, slug FROM categories WHERE status = 'active' ORDER BY sort_order ASC LIMIT 8");

// Get recent posts for footer
$footer_posts = db_fetch_all("SELECT id, title, slug FROM posts WHERE status = 'published' ORDER BY publish_date DESC LIMIT 3");
?>

<!-- Footer -->
<?php if ($site_settings['footer']): ?>
<div class="-footer">
    <div class="container">
        <?php echo $site_settings['footer']; ?>
    </div>
</div>
<?php endif; ?>

<!-- Footer -->
<footer class="site-footer">
    <div class="footer-main">
        <div class="container">
            <div class="footer-widgets">
                <!-- About Widget -->
                <div class="footer-widget footer-about">
                    <div class="footer-logo">
                        <?php if ($site_settings['logo']): ?>
                        <img src="<?php echo $site_settings['logo']; ?>" alt="<?php echo htmlspecialchars($site_settings['name']); ?>">
                        <?php else: ?>
                        <h3><?php echo htmlspecialchars($site_settings['name']); ?></h3>
                        <?php endif; ?>
                    </div>
                    <p class="footer-description"><?php echo htmlspecialchars($site_settings['description']); ?></p>
                    <div class="footer-social">
                        <?php if (!empty($site_settings['whatsapp'])): ?>
                        <a href="<?php echo htmlspecialchars($site_settings['whatsapp']); ?>" target="_blank" rel="noopener noreferrer" class="social-icon social-whatsapp" aria-label="WhatsApp Channel" title="WhatsApp Channel"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($site_settings['instagram'])): ?>
                        <a href="<?php echo htmlspecialchars($site_settings['instagram']); ?>" target="_blank" rel="noopener noreferrer" class="social-icon social-instagram" aria-label="Instagram" title="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($site_settings['youtube'])): ?>
                        <a href="<?php echo htmlspecialchars($site_settings['youtube']); ?>" target="_blank" rel="noopener noreferrer" class="social-icon social-youtube" aria-label="YouTube" title="YouTube"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($site_settings['facebook'])): ?>
                        <a href="<?php echo htmlspecialchars($site_settings['facebook']); ?>" target="_blank" rel="noopener noreferrer" class="social-icon social-facebook" aria-label="Facebook" title="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Quick Links Widget -->
                <div class="footer-widget footer-links">
                    <h3 class="footer-widget-title">Quick Links</h3>
                    <p class="footer-widget-description">जरूरी पेज और जानकारी तक आसानी से पहुँचें</p>
                    <ul class="footer-links-list">
                        <li><a href="<?php echo SITE_URL; ?>">Home</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/about">हमारे बारे में</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/contact">संपर्क करें</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/privacy-policy">गोपनीयता नीति</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/disclaimer">अस्वीकरण</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/terms">नियम और शर्तें</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/dmca">DMCA</a></l
                        <li><a href="<?php echo SITE_URL; ?>/editorial-policy">Editorial Policy</a></li>
                    </ul>
                </div>
                
                <!-- Categories Widget -->
                <div class="footer-widget footer-categories">
                    <h3 class="footer-widget-title">Categories</h3>
                    <p class="footer-widget-description">पंचांग, चौघड़िया, मुहूर्त और धार्मिक जानकारी देखेंँचें</p>
                    <ul class="footer-links-list">
                        <?php if ($footer_categories): ?>
                        <?php foreach ($footer_categories as $cat): ?>
                        <li><a href="<?php echo SITE_URL; ?>/category/<?php echo $cat['slug']; ?>"><?php echo htmlspecialchars($cat['name']); ?></a></li>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <!-- Recent Posts Widget -->
                <div class="footer-widget footer-recent">
                    <h3 class="footer-widget-title">Recent Posts</h3>
                    <p class="footer-widget-description">हाल ही में प्रकाशित लेख और उपयोगी जानकारी</p>
                    <ul class="footer-recent-list">
                        <?php if ($footer_posts): ?>
                        <?php foreach ($footer_posts as $post): ?>
                        <li>
                            <a href="<?php echo SITE_URL; ?>/<?php echo $post['slug']; ?>">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <div class="footer-contact-info">
                        <h4>संपर्क जानकारी / Contact</h4>
                        <p>
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:<?php echo htmlspecialchars(AUTHOR_EMAIL); ?>" style="color: inherit;"><?php echo htmlspecialchars(AUTHOR_EMAIL); ?></a>
                        </p>
                        <p>
                            <i class="fas fa-map-marker-alt"></i>
                            <address style="display:inline; font-style: normal; line-height: 1.5;">
                                <?php echo htmlspecialchars(OFFICE_STREET); ?>,<br>
                                <?php echo htmlspecialchars(OFFICE_LOCALITY); ?>, <?php echo htmlspecialchars(OFFICE_REGION); ?> <?php echo htmlspecialchars(OFFICE_POSTAL_CODE); ?>, India
                            </address>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <p class="copyright">&copy; <?php echo date('Y'); ?> Choghadiyas.in. All Rights Reserved.</p>
<div class="footer-bottom-links">
    <a href="<?php echo SITE_URL; ?>/about">परिचय</a>
    <a href="<?php echo SITE_URL; ?>/contact">संपर्क</a>
    <a href="<?php echo SITE_URL; ?>/privacy-policy">प्राइवेसी</a>
    <a href="<?php echo SITE_URL; ?>/terms">नियम व शर्तें</a>
    <a href="<?php echo SITE_URL; ?>/disclaimer">अस्वीकरण</a>
    <a href="<?php echo SITE_URL; ?>/editorial-policy">संपादकीय</a>
    <a href="<?php echo SITE_URL; ?>/dmca">DMCA</a>
</div>
            </div>
        </div>
    </div>
</footer>

<!-- Professional Disclaimer Section -->
<section class="footer-disclaimer-section">
    <div class="container">
        <div class="disclaimer-content">
            <div class="disclaimer-header">
                <i class="fas fa-info-circle"></i>
                <span>DISCLAIMER</span>
            </div>
            <p class="disclaimer-text">इस वेबसाइट पर दी गई जानकारी केवल सामान्य जानकारी और आध्यात्मिक मार्गदर्शन के उद्देश्य से प्रदान की गई है। हम जानकारी को सही और उपयोगी रखने का उचित प्रयास करते हैं, फिर भी उपयोगकर्ताओं को सलाह दी जाती है कि महत्वपूर्ण समय, मुहूर्त, पंचांग और अन्य संबंधित जानकारी के आधार पर कोई महत्वपूर्ण निर्णय लेने से पहले विश्वसनीय स्रोतों से उसका स्वतंत्र रूप से सत्यापन कर लें।</p>
        </div>
    </div>
</section>

<!-- Premium Back to Top Button -->
<button class="back-to-top-premium" id="backToTop" aria-label="Back to Top">
    <div class="button-glassmorphism">
        <div class="button-icon-wrapper">
            <i class="fas fa-arrow-up"></i>
            <div class="ripple-effect"></div>
        </div>
        <span class="button-text">Top</span>
    </div>
    <div class="button-glow"></div>
</button>

<style>
/* Enhanced Footer Widget Styles */
.footer-additional-info {
    margin: 15px 0;
    padding: 15px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    border-left: 3px solid #667eea;
    font-size: 14px;
    line-height: 1.6;
    color: #e2e8f0;
}

.footer-additional-info strong {
    color: #ffffff;
    display: block;
    margin-bottom: 8px;
    font-size: 16px;
}

.footer-stats {
    display: flex;
    gap: 15px;
    margin: 20px 0;
    flex-wrap: wrap;
}

.footer-stat-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 20px;
    font-size: 12px;
    color: #ffffff;
    border: 1px solid rgba(102, 126, 234, 0.2);
}

.footer-stat-item i {
    color: #667eea;
    font-size: 14px;
}

.footer-widget-description {
    margin-bottom: 15px;
    font-size: 14px;
    color: #94a3b8;
    line-height: 1.5;
}

.footer-contact-info {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.footer-contact-info h4 {
    color: #ffffff;
    font-size: 16px;
    margin-bottom: 12px;
    font-family: 'Montserrat', sans-serif;
}

.footer-contact-info p {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
    font-size: 14px;
    color: #94a3b8;
}

.footer-contact-info i {
    color: #667eea;
    font-size: 14px;
    width: 16px;
}

/* Premium Back to Top Button Styles */
.back-to-top-premium {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    background: transparent;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transform: translateY(100px) scale(0.8);
    transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.back-to-top-premium.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

.button-glassmorphism {
    position: relative;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    overflow: hidden;
}

.back-to-top-premium:hover .button-glassmorphism {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
}

.back-to-top-premium:active .button-glassmorphism {
    transform: scale(0.95);
}

.button-icon-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    margin-bottom: 2px;
}

.button-icon-wrapper i {
    font-size: 18px;
    color: white;
    z-index: 2;
    position: relative;
    transition: transform 0.3s ease;
}

.back-to-top-premium:hover .button-icon-wrapper i {
    transform: translateY(-2px);
}

.ripple-effect {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s ease, height 0.6s ease;
}

.back-to-top-premium:hover .ripple-effect {
    width: 40px;
    height: 40px;
}

.button-text {
    font-size: 10px;
    font-weight: 700;
    color: white;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.9;
}

.button-glow {
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, #667eea, #764ba2, #667eea);
    border-radius: 50%;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
    animation: glow-rotate 3s linear infinite;
}

.back-to-top-premium:hover .button-glow {
    opacity: 0.8;
}

@keyframes glow-rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Progress Ring */
.back-to-top-premium::before {
    content: '';
    position: absolute;
    top: -3px;
    left: -3px;
    right: -3px;
    bottom: -3px;
    border-radius: 50%;
    border: 2px solid transparent;
    border-top: 2px solid rgba(255, 255, 255, 0.8);
    animation: spin 2s linear infinite;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.back-to-top-premium.show::before {
    opacity: 1;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .back-to-top-premium {
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
    }
    
    .button-icon-wrapper i {
        font-size: 16px;
    }
    
    .button-text {
        font-size: 9px;
    }
}

@media (max-width: 480px) {
    .back-to-top-premium {
        bottom: 15px;
        right: 15px;
        width: 45px;
        height: 45px;
    }
    
    .button-icon-wrapper i {
        font-size: 14px;
    }
    
    .button-text {
        display: none;
    }
}

/* Professional Disclaimer Section */
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

<!-- Enhanced Back to Top JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const backToTopButton = document.getElementById('backToTop');
    let scrollProgress = 0;
    let ticking = false;
    
    // Show/hide button based on scroll position with smooth animation
    function updateButtonVisibility() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        scrollProgress = scrollTop / scrollHeight;
        
        if (scrollTop > 300) {
            backToTopButton.classList.add('show');
        } else {
            backToTopButton.classList.remove('show');
        }
        
        ticking = false;
    }
    
    // Optimized scroll event listener
    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(updateButtonVisibility);
            ticking = true;
        }
    });
    
    // Enhanced smooth scroll to top with easing
    backToTopButton.addEventListener('click', function() {
        const startPosition = window.pageYOffset;
        const startTime = performance.now();
        const duration = 800; // milliseconds
        
        function easeInOutCubic(t) {
            return t < 0.5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1;
        }
        
        function animateScroll(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easeProgress = easeInOutCubic(progress);
            
            window.scrollTo(0, startPosition * (1 - easeProgress));
            
            if (progress < 1) {
                requestAnimationFrame(animateScroll);
            }
        }
        
        requestAnimationFrame(animateScroll);
        
        // Add pulse animation to button
        backToTopButton.style.transform = 'scale(0.9)';
        setTimeout(() => {
            backToTopButton.style.transform = '';
        }, 200);
    });
    
    // Add keyboard accessibility
    backToTopButton.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            backToTopButton.click();
        }
    });
});
</script>

<!-- JavaScript -->
<script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>

<!-- Code -->
<?php if ($site_settings['code']): ?>
<?php echo $site_settings['code']; ?>
<?php endif; ?>
<script>
(function () {
  function runTimer() {
    const timer = document.getElementById("timer")
      || document.getElementById("nextTimer")
      || document.getElementById("next-post-seconds");

    const btn = document.getElementById("next")
      || document.getElementById("nextArticleLink")
      || document.getElementById("next-post-button");

    if (!timer || !btn || timer.dataset.started) return;
    timer.dataset.started = "yes";

    let s = 30;
    timer.textContent = s;

    const id = setInterval(function () {
      timer.textContent = --s;

      if (s <= 0) {
        clearInterval(id);
        btn.removeAttribute("aria-disabled");
        btn.style.pointerEvents = "auto";
        btn.style.opacity = "1";
      }
    }, 1000);
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", runTimer);
  } else {
    runTimer();
  }
})();
</script>
</body>
</html>
