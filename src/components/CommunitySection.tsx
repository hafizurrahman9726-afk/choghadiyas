import React from 'react';
import { Users, Send } from 'lucide-react';

export const CommunitySection: React.FC = () => {
  return (
    <section className="my-10 max-w-[1360px] mx-auto px-4 sm:px-6">
      <div className="bg-white rounded-3xl border border-[#DFE6EF] shadow-[0_4px_24px_rgba(10,22,41,0.04)] p-6 sm:p-8 text-center">
        <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-50 text-[#FF7000] text-xs font-bold mb-2 border border-orange-100">
          <Users className="w-3.5 h-3.5" />
          <span>दैनिक पंचांग अपडेट्स</span>
        </div>
        <h2 className="text-xl sm:text-2xl md:text-3xl font-extrabold text-[#0A1629] tracking-tight">
          Join Our Community
        </h2>
        <p className="mt-2 text-xs sm:text-sm text-[#64748B] max-w-xl mx-auto">
          प्रतिदिन प्रातः चौघड़िया, राहुकाल और शुभ मुहूर्त की सूचनाएं सीधे अपने सोशल मीडिया और मैसेजिंग ऐप पर प्राप्त करें।
        </p>

        {/* 3 Horizontal Social Buttons (Exact Screenshot 3 Style) */}
        <div className="flex flex-wrap sm:flex-nowrap items-center justify-center gap-4 mt-6 max-w-xl mx-auto">
          {/* Facebook - Blue Gradient */}
          <a
            href="https://facebook.com"
            target="_blank"
            rel="noopener noreferrer"
            className="w-full sm:w-1/3 py-3 px-4 rounded-2xl bg-gradient-to-r from-[#1877F2] to-[#0D65D9] text-white font-bold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-sm hover:shadow-md hover:scale-[1.02] transition-all cursor-pointer"
          >
            <svg className="w-4 h-4 fill-current" viewBox="0 0 24 24">
              <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
            <span>Facebook</span>
          </a>

          {/* Telegram - Light Blue Gradient */}
          <a
            href="https://t.me"
            target="_blank"
            rel="noopener noreferrer"
            className="w-full sm:w-1/3 py-3 px-4 rounded-2xl bg-gradient-to-r from-[#29B6F6] to-[#0288D1] text-white font-bold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-sm hover:shadow-md hover:scale-[1.02] transition-all cursor-pointer"
          >
            <Send className="w-4 h-4" />
            <span>Telegram</span>
          </a>

          {/* Instagram - Purple / Pink / Orange Gradient */}
          <a
            href="https://instagram.com"
            target="_blank"
            rel="noopener noreferrer"
            className="w-full sm:w-1/3 py-3 px-4 rounded-2xl bg-gradient-to-r from-[#833AB4] via-[#FD1D1D] to-[#FCB045] text-white font-bold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-sm hover:shadow-md hover:scale-[1.02] transition-all cursor-pointer"
          >
            <svg className="w-4 h-4 fill-current" viewBox="0 0 24 24">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
            <span>Instagram</span>
          </a>
        </div>
      </div>
    </section>
  );
};
