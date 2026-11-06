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
    <section className="pt-10 pb-6 px-4 sm:px-6 text-center max-w-4xl mx-auto">
      {/* Main Heading (Exact Screenshot 1 typography hierarchy) */}
      <h1 className="text-3xl sm:text-4xl md:text-5xl font-extrabold text-[#0A1629] tracking-tight leading-tight md:leading-snug">
        चौघड़िया, पंचांग और{' '}
        <span className="text-[#FF7000] block sm:inline mt-1 sm:mt-0">
          शुभ मुहूर्त की जानकारी
        </span>
      </h1>

      {/* Description */}
      <p className="mt-4 text-sm sm:text-base text-[#64748B] max-w-2xl mx-auto leading-relaxed">
        Welcome to <strong className="text-[#0A1629] font-semibold">Choghadiyas.in</strong> – भारत का #1 मंच जहां आप आज का चौघड़िया, दैनिक पंचांग, राहुकाल, शुभ मुहूर्त, हिंदू व्रत-त्योहार और वैदिक पूजा विधि की 100% प्रामाणिक और सटीक जानकारी प्राप्त कर सकते हैं।
      </p>

      {/* Recreated Search Bar (Exact Screenshot 1 Style) */}
      <div className="mt-7 max-w-2xl mx-auto">
        <form
          onSubmit={onSearchSubmit}
          className="relative flex items-center bg-white rounded-full border border-[#DFE6EF] shadow-[0_4px_20px_rgba(10,22,41,0.06)] hover:border-orange-300 focus-within:border-[#FF7000] focus-within:ring-2 focus-within:ring-orange-100 p-1.5 transition-all"
        >
          {/* Orange search icon */}
          <div className="pl-4 pr-2 text-[#FF7000] flex items-center pointer-events-none">
            <Search className="w-5 h-5" />
          </div>

          {/* Search input */}
          <input
            type="text"
            value={searchQuery}
            onChange={(e) => onSearchChange(e.target.value)}
            placeholder="चौघड़िया, पंचांग, व्रत, त्योहार और शुभ मुहूर्त खोजें..."
            className="w-full py-2.5 text-xs sm:text-sm text-[#0A1629] placeholder-[#94A3B8] bg-transparent outline-none font-medium"
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
            className="bg-[#FF7000] hover:bg-[#E65100] text-white px-5 sm:px-6 py-2.5 rounded-full text-xs sm:text-sm font-semibold flex items-center gap-1.5 shrink-0 transition-transform active:scale-95 shadow-sm shadow-orange-500/20 cursor-pointer"
          >
            <span>Search</span>
            <ArrowRight className="w-4 h-4" />
          </button>
        </form>
      </div>
    </section>
  );
};
