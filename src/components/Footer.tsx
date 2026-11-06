import React from 'react';
import { Sun, Heart, ExternalLink, ShieldCheck } from 'lucide-react';

interface FooterProps {
  onNavigate: (view: string, param?: string) => void;
}

export const Footer: React.FC<FooterProps> = ({ onNavigate }) => {
  const currentYear = new Date().getFullYear();

  const popularGuides = [
    { title: 'विवाह शुभ मुहूर्त 2026', slug: 'vivah-shubh-muhurat-2026' },
    { title: 'गृह प्रवेश मुहूर्त एवं विधि', slug: 'griha-pravesh-muhurat-2026-vidhi' },
    { title: 'वाहन खरीद शुभ मुहूर्त', slug: 'vahan-kharid-shubh-muhurat-2026' },
    { title: 'छठ पूजा संध्या व उषा अर्घ्य', slug: 'chhath-puja-sandhya-usha-arghya-time' },
    { title: 'रुद्राभिषेक पूजा सामग्री व विधि', slug: 'rudrabhishek-puja-vidhi-aur-samagri' },
    { title: 'श्री सत्यनारायण कथा व पूजा', slug: 'satyanarayan-puja-vidhi-aur-katha' },
  ];

  const quickLinks = [
    { label: 'Home', id: 'home' },
    { label: 'आज का चौघड़िया', id: 'choghadiya' },
    { label: 'दैनिक पंचांग', id: 'panchang' },
    { label: 'About Us', id: 'about' },
    { label: 'Contact Us', id: 'contact' },
    { label: 'Privacy Policy', id: 'privacy-policy' },
    { label: 'Disclaimer', id: 'disclaimer' },
    { label: 'Terms & Conditions', id: 'terms' },
    { label: 'Editorial Policy', id: 'editorial-policy' },
  ];

  return (
    <footer className="bg-[#0B101B] text-white pt-14 pb-8 border-t border-slate-800">
      <div className="max-w-[1360px] mx-auto px-4 sm:px-6">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-slate-800/80">
          {/* Column 1 — About Choghadiyas */}
          <div className="lg:col-span-2">
            <div 
              onClick={() => onNavigate('home')}
              className="flex items-center gap-3 cursor-pointer group mb-4 select-none"
            >
              <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-[#FF7000] to-[#E65100] flex items-center justify-center text-white shadow-md shadow-orange-500/20">
                <Sun className="w-6 h-6" />
              </div>
              <div>
                <span className="text-2xl font-black text-white tracking-tight">Choghadiya</span>
                <span className="text-2xl font-black text-[#FF7000] tracking-tight">s.in</span>
              </div>
            </div>
            <p className="text-xs sm:text-sm text-slate-400 leading-relaxed max-w-md">
              Choghadiyas.in भारत का अग्रणी सनातन पंचांग, दैनिक चौघड़िया और शुभ मुहूर्त पोर्टल है। यहाँ आप प्रत्येक दिन के अमृत, शुभ, लाभ, चर, रोग, काल और उद्वेग मुहूर्त की सटीक गणना देख सकते हैं। हमारी सभी गणनाएं सूर्य के स्पष्ट देशांतर-अक्षांश पर आधारित हैं।
            </p>
            <div className="mt-5 flex items-center gap-2 text-xs text-slate-400">
              <ShieldCheck className="w-4 h-4 text-[#FF7000]" />
              <span>100% प्रामाणिक वैदिक काल गणना एवं शोध</span>
            </div>
          </div>

          {/* Column 2 — Popular Guides */}
          <div>
            <h4 className="text-sm font-extrabold uppercase tracking-wider text-white mb-4 flex items-center gap-2">
              <span className="w-2 h-2 rounded-full bg-[#FF7000]" />
              Popular Guides
            </h4>
            <ul className="space-y-2.5 text-xs sm:text-sm text-slate-400">
              {popularGuides.map((guide) => (
                <li key={guide.slug}>
                  <button
                    onClick={() => onNavigate('article', guide.slug)}
                    className="hover:text-white transition-colors text-left flex items-center gap-1.5 cursor-pointer"
                  >
                    <span className="text-slate-600">›</span>
                    <span className="hover:underline">{guide.title}</span>
                  </button>
                </li>
              ))}
            </ul>
          </div>

          {/* Column 3 — Quick Links */}
          <div>
            <h4 className="text-sm font-extrabold uppercase tracking-wider text-white mb-4 flex items-center gap-2">
              <span className="w-2 h-2 rounded-full bg-[#FF7000]" />
              Quick Links
            </h4>
            <ul className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-2.5 text-xs sm:text-sm text-slate-400">
              {quickLinks.map((link) => (
                <li key={link.id}>
                  <button
                    onClick={() => onNavigate(link.id)}
                    className="hover:text-[#FF7000] transition-colors cursor-pointer text-left"
                  >
                    {link.label}
                  </button>
                </li>
              ))}
            </ul>
          </div>
        </div>

        {/* Bottom Footer (Copyright & Attribution) */}
        <div className="pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-3">
          <p>© {currentYear} Choghadiyas.in. All Rights Reserved. सर्वस्वत्व सुरक्षित।</p>
          <p className="flex items-center gap-1">
            <span>Designed with</span>
            <Heart className="w-3.5 h-3.5 text-rose-500 fill-current" />
            <span>for Vedic Wisdom & Sanatan Dharma</span>
          </p>
        </div>
      </div>
    </footer>
  );
};
