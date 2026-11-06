<?php
/**
 * Shared Site-wide Responsive 4-Column Footer
 * Choghadiyas.in - Clean White & Neutral Design
 */
 = defined('SITE_URL') ? SITE_URL : ((isset(['HTTPS']) && ['HTTPS'] === 'on' ? 'https' : 'http') . '://' . (['HTTP_HOST'] ?? 'choghadiyas.in'));
?>
<footer class="site-footer" role="contentinfo" style="background:#F8FAFC; border-top:1px solid #E2E8F0; color:#475569; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Noto Sans Devanagari', sans-serif; margin-top:4rem;">
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
          <span style="font-size:1.35rem; font-weight:800; color:#0A1629; letter-spacing:-0.02em;">Choghadiyas<span style="color:#FF7000;">.in</span></span>
        </div>
        <p style="font-size:0.92rem; line-height:1.65; color:#64748B; margin-bottom:1.25rem;">
          धार्मिक मान्यताओं, दैनिक पंचांग, शुभ मुहूर्त, व्रत-त्योहार और पूजा विधि की सरल व उपयोगी जानकारी का समर्पित हिंदी पोर्टल।
        </p>
        <div style="display:inline-flex; align-items:center; gap:0.4rem; padding:0.35rem 0.75rem; background:#FFF; border:1px solid #CBD5E1; border-radius:9999px; font-size:0.8rem; font-weight:600; color:#0A1629;">
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
            <a href="<?php echo ; ?>/category/vrat-tyohar" style="color:#475569; text-decoration:none; font-size:0.92rem; transition:color 0.15s ease; display:inline-flex; align-items:center; gap:0.4rem;">
              <span style="color:#FF7000;">›</span> व्रत और त्योहार
            </a>
          </li>
          <li>
            <a href="<?php echo ; ?>/category/shubh-muhurat-guide" style="color:#475569; text-decoration:none; font-size:0.92rem; transition:color 0.15s ease; display:inline-flex; align-items:center; gap:0.4rem;">
              <span style="color:#FF7000;">›</span> शुभ मुहूर्त
            </a>
          </li>
          <li>
            <a href="<?php echo ; ?>/category/puja-vidhi-samagri" style="color:#475569; text-decoration:none; font-size:0.92rem; transition:color 0.15s ease; display:inline-flex; align-items:center; gap:0.4rem;">
              <span style="color:#FF7000;">›</span> पूजा विधि और सामग्री
            </a>
          </li>
          <li>
            <a href="<?php echo ; ?>/category/vedic-panchang" style="color:#475569; text-decoration:none; font-size:0.92rem; transition:color 0.15s ease; display:inline-flex; align-items:center; gap:0.4rem;">
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
          <li><a href="<?php echo ; ?>/about" style="color:#475569; text-decoration:none; font-size:0.92rem;">हमारे बारे में (About Us)</a></li>
          <li><a href="<?php echo ; ?>/contact" style="color:#475569; text-decoration:none; font-size:0.92rem;">संपर्क करें (Contact Us)</a></li>
          <li><a href="<?php echo ; ?>/privacy-policy" style="color:#475569; text-decoration:none; font-size:0.92rem;">गोपनीयता नीति (Privacy Policy)</a></li>
          <li><a href="<?php echo ; ?>/disclaimer" style="color:#475569; text-decoration:none; font-size:0.92rem;">अस्वीकरण (Disclaimer)</a></li>
          <li><a href="<?php echo ; ?>/terms" style="color:#475569; text-decoration:none; font-size:0.92rem;">नियम व शर्तें (Terms of Use)</a></li>
          <li><a href="<?php echo ; ?>/editorial-policy" style="color:#475569; text-decoration:none; font-size:0.92rem;">संपादकीय नीति (Editorial Policy)</a></li>
        </ul>
      </div>

      <!-- Col 4: Contact & Transparency -->
      <div class="footer-col">
        <h4 style="font-size:1.05rem; font-weight:700; color:#0A1629; margin-bottom:1.1rem; padding-bottom:0.5rem; border-bottom:2px solid #FF7000; display:inline-block;">
          पारदर्शिता एवं संपर्क
        </h4>
        <p style="font-size:0.9rem; line-height:1.6; color:#64748B; margin-bottom:1rem;">
          किसी भी सुझाव, प्रतिक्रिया या त्रुटि सुधार हेतु हमारे संपादकीय दल से संपर्क करें:
        </p>
        <div style="margin-bottom:1rem;">
          <a href="mailto:contact@choghadiyas.in" style="display:inline-flex; align-items:center; gap:0.5rem; color:#0A1629; font-weight:600; font-size:0.92rem; text-decoration:none; padding:0.45rem 0.85rem; background:#FFF; border:1px solid #CBD5E1; border-radius:8px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FF7000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            contact@choghadiyas.in
          </a>
        </div>
        <p style="font-size:0.82rem; color:#94A3B8; line-height:1.5;">
          हम पारंपरिक पंचांगों और प्रमाणित संदर्भों के आधार पर सामग्री प्रस्तुत करते हैं।
        </p>
      </div>

    </div>
  </div>

  <!-- Bottom Bar with Legal Disclaimer -->
  <div class="footer-bottom" style="background:#F1F5F9; border-top:1px solid #E2E8F0; padding:1.5rem 1.25rem;">
    <div style="max-width:1200px; margin:0 auto; display:flex; flex-direction:column; gap:0.75rem; text-align:center; font-size:0.82rem; color:#64748B;">
      <p style="margin:0; line-height:1.6;">
        <strong>महत्वपूर्ण अस्वीकरण:</strong> Choghadiyas.in पर उपलब्ध पंचांग, चौघड़िया, व्रत-त्योहार और मुहूर्त संबंधी सामग्री सामान्य धार्मिक व सांस्कृतिक जानकारी के उद्देश्य से प्रस्तुत की गई है। किसी भी विशेष मांगलिक कार्य, अनुष्ठान या महत्वपूर्ण निर्णय से पूर्व अपने स्थानीय पुरोहित, ज्योतिषाचार्य या प्रामाणिक पंचांग से परामर्श अवश्य लें।
      </p>
      <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.5rem; margin-top:0.5rem; padding-top:0.75rem; border-top:1px solid #E2E8F0;">
        <div>© 2026 Choghadiyas.in. सर्वाधिकार सुरक्षित (All Rights Reserved).</div>
        <div>
          <a href="<?php echo ; ?>/privacy-policy" style="color:#64748B; text-decoration:none; margin-right:1rem;">Privacy Policy</a>
          <a href="<?php echo ; ?>/disclaimer" style="color:#64748B; text-decoration:none; margin-right:1rem;">Disclaimer</a>
          <a href="<?php echo ; ?>/terms" style="color:#64748B; text-decoration:none;">Terms</a>
        </div>
      </div>
    </div>
  </div>
</footer>
