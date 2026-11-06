<?php
/**
 * Shared Site-wide Responsive 4-Column Footer
 * Choghadiyas.in - Clean White & Neutral Design
 */
$footer_base_url = defined('SITE_URL') ? SITE_URL : ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'choghadiyas.in'));
?>
<footer class="site-footer" role="contentinfo" style="background:#FFFFFF; border-top:1px solid #E2E8F0; color:#475569; font-family:'Plus Jakarta Sans', 'Noto Sans Devanagari', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin-top:4rem;">
  <div class="footer-main" style="max-width:1200px; margin:0 auto; padding:3.5rem 1.25rem 2.5rem;">
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:2.5rem;">
      
      <!-- Col 1: Brand & Purpose -->
      <div class="footer-col footer-col-brand">
        <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:1rem;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#FF7000" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
          </svg>
          <span style="font-size:1.35rem; font-weight:800; color:#0A1629; letter-spacing:-0.02em;">Choghadiya<span style="color:#FF7000;">s.in</span></span>
        </div>
        <p style="font-size:0.92rem; line-height:1.65; color:#64748B; margin-bottom:1.25rem;">
          धार्मिक मान्यताओं, दैनिक पंचांग, शुभ मुहूर्त, व्रत-त्योहार और पूजा विधि की प्रामाणिक, सरल व उपयोगी जानकारी का समर्पित हिंदी मंच।
        </p>
        <div style="display:inline-flex; align-items:center; gap:0.4rem; padding:0.35rem 0.75rem; background:#F8FAFC; border:1px solid #CBD5E1; border-radius:9999px; font-size:0.8rem; font-weight:600; color:#0A1629;">
          <span style="width:7px; height:7px; border-radius:50%; background:#10B981;"></span>
          भारतीय मानक समय (IST +5:30)
        </div>
      </div>

      <!-- Col 2: Categories -->
      <div class="footer-col">
        <h4 style="font-size:1.05rem; font-weight:700; color:#0A1629; margin-bottom:1.1rem; padding-bottom:0.5rem; border-bottom:2px solid #FF7000; display:inline-block;">
          प्रमुख श्रेणियाँ
        </h4>
        <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.65rem;">
          <li>
            <a href="<?php echo htmlspecialchars($footer_base_url); ?>/category/vrat-tyohar" style="color:#475569; text-decoration:none; font-size:0.92rem; transition:color 0.15s ease; display:inline-flex; align-items:center; gap:0.4rem;">
              <span style="color:#FF7000;">›</span> व्रत और त्योहार
            </a>
          </li>
          <li>
            <a href="<?php echo htmlspecialchars($footer_base_url); ?>/category/shubh-muhurat-guide" style="color:#475569; text-decoration:none; font-size:0.92rem; transition:color 0.15s ease; display:inline-flex; align-items:center; gap:0.4rem;">
              <span style="color:#FF7000;">›</span> शुभ मुहूर्त
            </a>
          </li>
          <li>
            <a href="<?php echo htmlspecialchars($footer_base_url); ?>/category/puja-vidhi-samagri" style="color:#475569; text-decoration:none; font-size:0.92rem; transition:color 0.15s ease; display:inline-flex; align-items:center; gap:0.4rem;">
              <span style="color:#FF7000;">›</span> पूजा विधि और सामग्री
            </a>
          </li>
          <li>
            <a href="<?php echo htmlspecialchars($footer_base_url); ?>/category/vedic-panchang" style="color:#475569; text-decoration:none; font-size:0.92rem; transition:color 0.15s ease; display:inline-flex; align-items:center; gap:0.4rem;">
              <span style="color:#FF7000;">›</span> वैदिक पंचांग
            </a>
          </li>
        </ul>
      </div>

      <!-- Col 3: Important Pages -->
      <div class="footer-col">
        <h4 style="font-size:1.05rem; font-weight:700; color:#0A1629; margin-bottom:1.1rem; padding-bottom:0.5rem; border-bottom:2px solid #FF7000; display:inline-block;">
          महत्वपूर्ण पृष्ठ
        </h4>
        <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.65rem;">
          <li><a href="<?php echo htmlspecialchars($footer_base_url); ?>/about" style="color:#475569; text-decoration:none; font-size:0.92rem;">हमारे बारे में (About Us)</a></li>
          <li><a href="<?php echo htmlspecialchars($footer_base_url); ?>/contact" style="color:#475569; text-decoration:none; font-size:0.92rem;">संपर्क करें (Contact Us)</a></li>
          <li><a href="<?php echo htmlspecialchars($footer_base_url); ?>/privacy-policy" style="color:#475569; text-decoration:none; font-size:0.92rem;">गोपनीयता नीति (Privacy Policy)</a></li>
          <li><a href="<?php echo htmlspecialchars($footer_base_url); ?>/disclaimer" style="color:#475569; text-decoration:none; font-size:0.92rem;">अस्वीकरण (Disclaimer)</a></li>
          <li><a href="<?php echo htmlspecialchars($footer_base_url); ?>/terms" style="color:#475569; text-decoration:none; font-size:0.92rem;">नियम व शर्तें (Terms of Use)</a></li>
          <li><a href="<?php echo htmlspecialchars($footer_base_url); ?>/editorial-policy" style="color:#475569; text-decoration:none; font-size:0.92rem;">संपादकीय नीति (Editorial Policy)</a></li>
        </ul>
      </div>

      <!-- Col 4: Contact & Transparency -->
      <div class="footer-col">
        <h4 style="font-size:1.05rem; font-weight:700; color:#0A1629; margin-bottom:1.1rem; padding-bottom:0.5rem; border-bottom:2px solid #FF7000; display:inline-block;">
          कार्यालय एवं संपर्क
        </h4>
        <p style="font-size:0.86rem; line-height:1.55; color:#64748B; margin-bottom:0.85rem;">
          <strong>कार्यालय:</strong> 5th Floor, Opposite Lane, Abhijeet Court, Office 402-403, 13, Bhandarkar Road, Pune, Maharashtra 411004, India
        </p>
        <div style="margin-bottom:0.85rem;">
          <a href="mailto:contact@choghadiyas.in" style="display:inline-flex; align-items:center; gap:0.5rem; color:#0A1629; font-weight:600; font-size:0.88rem; text-decoration:none; padding:0.4rem 0.75rem; background:#F8FAFC; border:1px solid #CBD5E1; border-radius:8px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FF7000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            contact@choghadiyas.in
          </a>
        </div>
        <p style="font-size:0.8rem; color:#94A3B8; line-height:1.45; margin:0;">
          हम सनातन वैदिक पंचांगों और प्रमाणित संदर्भों के अध्ययन पर आधारित सामग्री प्रस्तुत करते हैं।
        </p>
      </div>

    </div>
  </div>

  <!-- Bottom Legal Bar -->
  <div class="footer-bottom" style="border-top:1px solid #F1F5F9; background:#FAFAFA; padding:1.25rem 1.25rem;">
    <div style="max-width:1200px; margin:0 auto; display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:1rem; font-size:0.85rem; color:#64748B;">
      <div>
        &copy; <?php echo date('Y'); ?> <strong>Choghadiyas.in</strong>. सर्वाधिकार सुरक्षित।
      </div>
      <div style="display:flex; flex-wrap:wrap; gap:1rem;">
        <a href="<?php echo htmlspecialchars($footer_base_url); ?>/privacy-policy" style="color:#64748B; text-decoration:none;">Privacy Policy</a>
        <a href="<?php echo htmlspecialchars($footer_base_url); ?>/disclaimer" style="color:#64748B; text-decoration:none;">Disclaimer</a>
        <a href="<?php echo htmlspecialchars($footer_base_url); ?>/terms" style="color:#64748B; text-decoration:none;">Terms of Use</a>
        <a href="<?php echo htmlspecialchars($footer_base_url); ?>/editorial-policy" style="color:#64748B; text-decoration:none;">Editorial Policy</a>
      </div>
    </div>
  </div>
</footer>
