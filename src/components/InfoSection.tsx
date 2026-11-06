import React from 'react';
import { Gift, CalendarDays, BookCheck, ShieldCheck, Sparkles, Compass } from 'lucide-react';

export const InfoSection: React.FC = () => {
  return (
    <section className="my-12 max-w-[1360px] mx-auto px-4 sm:px-6">
      <div className="bg-white rounded-3xl border border-[#DFE6EF] shadow-[0_4px_24px_rgba(10,22,41,0.04)] p-6 sm:p-10 text-center">
        {/* Main Information Header (Matching Screenshot 3) */}
        <div className="max-w-3xl mx-auto">
          <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-50 text-[#FF7000] text-xs font-bold mb-3 border border-orange-100">
            <Sparkles className="w-3.5 h-3.5" />
            <span>सनातन काल गणना व मार्गदर्शन</span>
          </div>
          <h2 className="text-2xl sm:text-3xl md:text-4xl font-extrabold text-[#0A1629] tracking-tight">
            Choghadiyas.in — चौघड़िया, पंचांग और शुभ मुहूर्त की जानकारी
          </h2>
          <p className="mt-3 text-sm sm:text-base text-[#64748B] leading-relaxed">
            Choghadiyas.in भारत का अग्रणी सनातन पंचांग और मुहूर्त पोर्टल है। हमारा उद्देश्य प्राचीन वैदिक ज्योतिष की अमूल्य काल-गणना पद्धतियों को आधुनिक, सरल और सटीक रूप में जन-जन तक निःशुल्क पहुंचाना है। यहाँ उपलब्ध सभी गणनाएं सूर्य के स्पष्ट अक्षांश-देशांतर और खगोलीय सूत्रों पर आधारित हैं।
          </p>
        </div>

        {/* Three Feature Cards (Matching Screenshot 3) */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10 text-left">
          {/* Card 1: 100% Free Information */}
          <div className="bg-[#F8FAFC] rounded-2xl p-6 border border-[#DFE6EF] hover:border-orange-200 hover:shadow-md transition-all group">
            <div className="w-12 h-12 rounded-xl bg-orange-100 text-[#FF7000] flex items-center justify-center mb-4 group-hover:bg-[#FF7000] group-hover:text-white transition-colors">
              <Gift className="w-6 h-6" />
            </div>
            <h3 className="text-lg font-bold text-[#0A1629] mb-2">
              100% Free Information
            </h3>
            <p className="text-xs sm:text-sm text-[#64748B] leading-relaxed">
              सभी चौघड़िया मुहूर्त, दैनिक पंचांग, राहुकाल और त्योहारों की जानकारी बिना किसी सदस्यता या शुल्क के पूर्णतः निःशुल्क और खुली उपलब्ध है।
            </p>
          </div>

          {/* Card 2: Daily Panchang and Choghadiya */}
          <div className="bg-[#F8FAFC] rounded-2xl p-6 border border-[#DFE6EF] hover:border-orange-200 hover:shadow-md transition-all group">
            <div className="w-12 h-12 rounded-xl bg-orange-100 text-[#FF7000] flex items-center justify-center mb-4 group-hover:bg-[#FF7000] group-hover:text-white transition-colors">
              <CalendarDays className="w-6 h-6" />
            </div>
            <h3 className="text-lg font-bold text-[#0A1629] mb-2">
              Daily Panchang & Choghadiya
            </h3>
            <p className="text-xs sm:text-sm text-[#64748B] leading-relaxed">
              प्रत्येक दिन और रात का आठ-आठ पहर का चौघड़िया, सूर्योदय-सूर्यास्त आधारित वास्तविक गणना, शहर चयन और तिथि-नक्षत्र की सटीक जानकारी।
            </p>
          </div>

          {/* Card 3: Simple Hindi Guides */}
          <div className="bg-[#F8FAFC] rounded-2xl p-6 border border-[#DFE6EF] hover:border-orange-200 hover:shadow-md transition-all group">
            <div className="w-12 h-12 rounded-xl bg-orange-100 text-[#FF7000] flex items-center justify-center mb-4 group-hover:bg-[#FF7000] group-hover:text-white transition-colors">
              <BookCheck className="w-6 h-6" />
            </div>
            <h3 className="text-lg font-bold text-[#0A1629] mb-2">
              Simple Hindi Guides
            </h3>
            <p className="text-xs sm:text-sm text-[#64748B] leading-relaxed">
              विवाह, गृह प्रवेश, वाहन खरीद, सत्यनारायण कथा और सभी प्रमुख सनातन त्योहारों की पूजा विधि पर सरल हिंदी में प्रमाणिक लेख और मार्गदर्शिका।
            </p>
          </div>
        </div>
      </div>
    </section>
  );
};
