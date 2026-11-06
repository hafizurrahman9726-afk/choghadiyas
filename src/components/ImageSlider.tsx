import React from 'react';
import { Article } from '../types';

interface ImageSliderProps {
  articles: Article[];
  onSelectArticle: (article: Article) => void;
}

export const ImageSlider: React.FC<ImageSliderProps> = ({ articles, onSelectArticle }) => {
  // Take top 8-10 featured items and duplicate for infinite continuous loop
  const sliderItems = articles.slice(0, 10);
  const duplicatedItems = [...sliderItems, ...sliderItems];

  return (
    <section className="py-6 overflow-hidden relative select-none">
      {/* Subtle fade edges for smooth entrance/exit */}
      <div className="absolute left-0 top-0 bottom-0 w-12 sm:w-20 bg-gradient-to-r from-[#F7F9FC] to-transparent z-10 pointer-events-none" />
      <div className="absolute right-0 top-0 bottom-0 w-12 sm:w-20 bg-gradient-to-l from-[#F7F9FC] to-transparent z-10 pointer-events-none" />

      {/* Marquee Track */}
      <div className="flex animate-marquee gap-4 px-4 items-center">
        {duplicatedItems.map((article, idx) => (
          <div
            key={`${article.id}-${idx}`}
            onClick={() => onSelectArticle(article)}
            className="w-44 sm:w-48 md:w-52 h-60 sm:h-68 md:h-72 shrink-0 rounded-2xl overflow-hidden relative group cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300 border border-[#DFE6EF] bg-white transform hover:-translate-y-1"
          >
            {/* Image */}
            <img
              src={article.featuredImage}
              alt={article.title}
              loading="lazy"
              referrerPolicy="no-referrer"
              className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            />

            {/* Gradient Scrim for readable title overlay */}
            <div className="absolute inset-0 bg-gradient-to-t from-[#0A1629]/90 via-[#0A1629]/30 to-transparent flex flex-col justify-end p-3.5 text-white">
              <span className="text-[10px] font-semibold uppercase tracking-wider text-[#FF7000] bg-white/95 px-2 py-0.5 rounded-full w-fit mb-1 shadow-sm">
                {article.category}
              </span>
              <h3 className="text-xs sm:text-sm font-bold text-white line-clamp-2 leading-tight drop-shadow-sm group-hover:text-orange-200 transition-colors">
                {article.title}
              </h3>
            </div>
          </div>
        ))}
      </div>
    </section>
  );
};
