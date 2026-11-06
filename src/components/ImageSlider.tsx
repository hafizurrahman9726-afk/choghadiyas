import React from 'react';
import { Article } from '../types';

interface ImageSliderProps {
  articles: Article[];
  onSelectArticle: (article: Article) => void;
}

export const ImageSlider: React.FC<ImageSliderProps> = ({ articles, onSelectArticle }) => {
  // Top 12 real published articles duplicated for continuous 0-jump seamless marquee
  const sliderItems = articles.slice(0, 12);
  const duplicatedItems = [...sliderItems, ...sliderItems];

  return (
    <section className="pt-3 pb-4 sm:py-5 bg-white border-b border-slate-100 overflow-hidden relative select-none" aria-label="लोकप्रिय लेख स्लाइडर">
      {/* Subtle edge fades */}
      <div className="absolute left-0 top-0 bottom-0 w-8 sm:w-16 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none" />
      <div className="absolute right-0 top-0 bottom-0 w-8 sm:w-16 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none" />

      {/* Marquee Track */}
      <div className="flex animate-marquee gap-3 sm:gap-4 px-2 sm:px-4 items-center">
        {duplicatedItems.map((article, idx) => {
          const isClone = idx >= sliderItems.length;
          const isPriority = idx < 4;
          return (
            <div
              key={`${article.id}-${idx}`}
              onClick={() => onSelectArticle(article)}
              onKeyDown={(e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                  e.preventDefault();
                  onSelectArticle(article);
                }
              }}
              role="button"
              tabIndex={isClone ? -1 : 0}
              aria-hidden={isClone ? 'true' : undefined}
              aria-label={article.title}
              className="w-36 sm:w-44 md:w-48 h-52 sm:h-64 md:h-72 shrink-0 rounded-2xl overflow-hidden relative group cursor-pointer shadow-[0_4px_16px_rgba(10,22,41,0.08)] hover:shadow-[0_12px_28px_rgba(10,22,41,0.16)] transition-all duration-300 border border-slate-200/80 bg-slate-50 transform hover:-translate-y-1"
            >
              <img
                src={article.featuredImage}
                alt={article.title}
                loading={isPriority ? 'eager' : 'lazy'}
                decoding="async"
                referrerPolicy="no-referrer"
                className="w-full h-full object-cover group-hover:scale-106 transition-transform duration-500"
              />

              {/* Bottom gradient overlay */}
              <div className="absolute inset-0 bg-gradient-to-t from-[#0A1629]/95 via-[#0A1629]/45 to-transparent flex flex-col justify-end p-2.5 sm:p-3.5 text-white pointer-events-none">
                <span className="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-orange-200 mb-1 drop-shadow-sm">
                  {article.category}
                </span>
                <h3 className="text-xs sm:text-sm font-bold text-white line-clamp-2 leading-snug drop-shadow-md group-hover:text-orange-300 transition-colors">
                  {article.title}
                </h3>
              </div>
            </div>
          );
        })}
      </div>
    </section>
  );
};
