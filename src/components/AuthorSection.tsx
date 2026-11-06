import React from 'react';
import { AUTHOR_SHIV_KUMAR } from '../data/articles';
import { Award, ArrowRight } from 'lucide-react';

interface AuthorSectionProps {
  onViewAuthorProfile?: () => void;
}

export const AuthorSection: React.FC<AuthorSectionProps> = ({ onViewAuthorProfile }) => {
  return (
    <section className="my-10 max-w-[1360px] mx-auto px-4 sm:px-6">
      <div className="bg-white rounded-3xl border border-[#DFE6EF] shadow-[0_4px_24px_rgba(10,22,41,0.04)] p-8 sm:p-10 text-center max-w-2xl mx-auto">
        {/* Circular Profile Image */}
        <div className="relative inline-block mb-4">
          <div className="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-4 border-orange-100 shadow-md mx-auto">
            <img
              src={AUTHOR_SHIV_KUMAR.image}
              alt={AUTHOR_SHIV_KUMAR.name}
              className="w-full h-full object-cover"
            />
          </div>
          <div className="absolute -bottom-1 right-1/2 translate-x-1/2 bg-[#FF7000] text-white p-1 rounded-full shadow-sm">
            <Award className="w-4 h-4" />
          </div>
        </div>

        {/* Small Author Badge */}
        <div className="mb-2">
          <span className="bg-orange-50 text-[#FF7000] border border-orange-100 text-[11px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full">
            Founder & Content Contributor
          </span>
        </div>

        {/* Author Name */}
        <h3 className="text-xl sm:text-2xl font-black text-[#0A1629]">
          {AUTHOR_SHIV_KUMAR.name}
        </h3>
        <p className="text-xs font-semibold text-[#FF7000] mt-0.5">
          {AUTHOR_SHIV_KUMAR.role}
        </p>

        {/* Short Biography */}
        <p className="mt-3 text-xs sm:text-sm text-[#64748B] leading-relaxed max-w-lg mx-auto">
          {AUTHOR_SHIV_KUMAR.bio}
        </p>

        {/* View Author Profile Button */}
        <div className="mt-6">
          <button
            onClick={onViewAuthorProfile}
            className="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#0A1629] text-white text-xs sm:text-sm font-bold hover:bg-[#FF7000] transition-all duration-200 shadow-sm cursor-pointer"
          >
            <span>View Author Profile</span>
            <ArrowRight className="w-4 h-4" />
          </button>
        </div>
      </div>
    </section>
  );
};
