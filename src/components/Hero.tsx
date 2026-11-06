import React from 'react';
import { Search, X, ArrowRight } from 'lucide-react';

interface HeroProps {
  searchQuery: string;
  onSearchChange: (query: string) => void;
  onSearchSubmit: (e: React.FormEvent) => void;
  onClearSearch: () => void;
}

export const Hero: React.FC<HeroProps> = ({
  searchQuery,
  onSearchChange,
  onSearchSubmit,
  onClearSearch,
}) => {
  return (
    <section className="pt-8 sm:pt-12 pb-6 px-4 sm:px-6 text-center max-w-4xl mx-auto bg-white" aria-label="मुख्य परिचय एवं खोज">
      {/* Small label badge (Prompt Adda reference style) */}
      <div className="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-orange-50 border border-orange-200 text-xs font-bold text-[#EA580C] mb-4">
        <span>धार्मिक एवं वैदिक पंचांग मार्गदर्शिका</span>
      </div>

      {/* Main H1 (Single H1 on Homepage) */}
      <h1 className="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-[#0A1629] tracking-tight leading-tight md:leading-snug">
        चौघड़िया, पंचांग, व्रत-त्योहार और{' '}
        <span className="text-[#FF7000] inline-block">
          पूजा विधि
        </span>{' '}
        की जानकारी
      </h1>

      {/* Description */}
      <p className="mt-3.5 text-xs sm:text-sm md:text-base text-[#64748B] max-w-2xl mx-auto leading-relaxed">
        Choghadiyas.in पर जानें चौघड़िया और पंचांग से जुड़ी जानकारी, व्रत-त्योहारों की तिथियाँ, शुभ मुहूर्त, पूजा विधियाँ और आवश्यक सामग्री। हमारे लेख धार्मिक परंपराओं और उपयोगी जानकारियों को सरल हिंदी में समझाते हैं।
      </p>

      {/* Recreated Search Bar (Prompt Adda reference style) */}
      <div className="mt-6 max-w-2xl mx-auto">
        <form
          onSubmit={onSearchSubmit}
          className="relative flex items-center bg-white rounded-full border border-[#DFE6EF] shadow-[0_4px_20px_rgba(10,22,41,0.06)] hover:border-orange-300 focus-within:border-[#FF7000] focus-within:ring-2 focus-within:ring-orange-100 p-1.5 transition-all"
          role="search"
        >
          {/* Search icon */}
          <div className="pl-3.5 pr-2 text-[#64748B] flex items-center pointer-events-none">
            <Search className="w-5 h-5" />
          </div>

          {/* Search input */}
          <input
            type="text"
            value={searchQuery}
            onChange={(e) => onSearchChange(e.target.value)}
            placeholder="लेख, व्रत या पूजा विधि खोजें..."
            className="w-full py-2 text-xs sm:text-sm text-[#0A1629] placeholder-[#94A3B8] bg-transparent outline-none font-medium"
            aria-label="लेख, व्रत या पूजा विधि खोजें"
          />

          {/* Clear button if text entered */}
          {searchQuery && (
            <button
              type="button"
              onClick={onClearSearch}
              className="p-1.5 text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-100 transition-colors mr-1 cursor-pointer"
              title="साफ़ करें"
            >
              <X className="w-4 h-4" />
            </button>
          )}

          {/* Orange Search button with arrow */}
          <button
            type="submit"
            className="bg-[#FF7000] hover:bg-[#EA580C] text-white px-5 sm:px-6 py-2.5 rounded-full text-xs sm:text-sm font-semibold flex items-center gap-1.5 shrink-0 transition-transform active:scale-95 shadow-sm shadow-orange-500/20 cursor-pointer"
          >
            <span>Search</span>
            <ArrowRight className="w-4 h-4" />
          </button>
        </form>
      </div>
    </section>
  );
};
