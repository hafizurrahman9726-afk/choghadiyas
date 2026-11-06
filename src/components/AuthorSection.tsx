import React from 'react';
import { AUTHOR_SHIV_KUMAR } from '../data/articles';
import { Award, ArrowRight } from 'lucide-react';

interface AuthorSectionProps {
  onViewAuthorProfile?: () => void;
}

export const AuthorSection: React.FC<AuthorSectionProps> = ({ onViewAuthorProfile }) => {
  return (
    <section className="my-14 max-w-[1360px] mx-auto px-4 sm:px-6" aria-label="लेखक के बारे में" id="author">
      {/* Section Header */}
      <div className="text-center mb-8">
        <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-50 text-[#FF7000] border border-orange-200 text-xs font-bold uppercase tracking-wider mb-2">
          प्रामाणिक मार्गदर्शन
        </span>
        <h2 className="text-2xl sm:text-3xl font-black text-[#0A1629]">
          लेखक के बारे में
        </h2>
        <div className="w-12 h-1 bg-[#FF7000] rounded-full mx-auto mt-2"></div>
      </div>

      <div className="bg-[#F8FAFC] rounded-3xl border border-[#DFE6EF] shadow-[0_4px_24px_rgba(10,22,41,0.04)] p-6 sm:p-10 max-w-3xl mx-auto flex flex-col md:flex-row items-center gap-6 sm:gap-8">
        {/* Circular Profile Image (Mandatory: 6a0a995eb34a7.webp) */}
        <div className="relative shrink-0">
          <div className="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-4 border-white shadow-lg">
            <img
              src="https://choghadiyas.in/uploads/profiles/6a0a995eb34a7.webp"
              alt={AUTHOR_SHIV_KUMAR.name}
              className="w-full h-full object-cover"
              width={112}
              height={112}
              loading="lazy"
            />
          </div>
          <div className="absolute -bottom-1 right-1/2 translate-x-1/2 md:right-0 md:translate-x-0 bg-[#0D9488] text-white p-1 rounded-full shadow-sm" title="सत्यापित लेखक">
            <Award className="w-4 h-4" />
          </div>
        </div>

        {/* Author Info */}
        <div className="flex-1 text-center md:text-left">
          <div className="flex items-center justify-center md:justify-start gap-2 flex-wrap mb-1">
            <h3 className="text-xl sm:text-2xl font-black text-[#0A1629]">
              {AUTHOR_SHIV_KUMAR.name}
            </h3>
            <span className="inline-flex items-center gap-1 text-[11px] font-bold text-[#0D9488] bg-teal-50 border border-teal-200 px-2 py-0.5 rounded-full">
              सत्यापित लेखक
            </span>
          </div>

          <p className="text-xs font-bold text-[#FF7000] uppercase tracking-wider mb-2">
            संस्थापक एवं वरिष्ठ कंटेंट रिसर्चर (Co-Founder & Senior Researcher)
          </p>

          <p className="text-xs sm:text-sm text-[#475569] leading-relaxed mb-4">
            मैं, शिव कुमार पंडित, इस प्लेटफ़ॉर्म का Co-Founder और वरिष्ठ कंटेंट रिसर्चर हूं। मुझे भारतीय संस्कृति, शुभ मुहूर्त, चोघड़िया, पंचांग और पारंपरिक ज्ञान से जुड़े विषयों पर रिसर्च करना और सरल भाषा में जानकारी साझा करना पसंद है, ताकि हर पाठक आसानी से सही जानकारी समझ सके।
          </p>

          <div className="flex items-center justify-center md:justify-start gap-4 flex-wrap">
            <button
              onClick={onViewAuthorProfile}
              className="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-[#FF7000] hover:text-[#C2410C] transition-colors cursor-pointer"
            >
              <span>लेखक का संपूर्ण परिचय पढ़ें</span>
              <ArrowRight className="w-4 h-4" />
            </button>
          </div>
        </div>
      </div>
    </section>
  );
};
