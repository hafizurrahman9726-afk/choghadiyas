import React from 'react';
import { Article } from '../types';
import { CATEGORIES } from '../data/articles';
import { ArrowRight, ChevronLeft, ChevronRight, Calendar, User } from 'lucide-react';

interface ArticleGridProps {
  articles: Article[];
  selectedCategory: string;
  onSelectCategory: (categorySlug: string) => void;
  onSelectArticle: (article: Article) => void;
  currentPage: number;
  onPageChange: (page: number) => void;
  articlesPerPage?: number;
}

export const ArticleGrid: React.FC<ArticleGridProps> = ({
  articles,
  selectedCategory,
  onSelectCategory,
  onSelectArticle,
  currentPage,
  onPageChange,
  articlesPerPage = 30, // Mandatory: Exactly 30 articles per page on homepage!
}) => {
  // Filter by category if not 'all'
  const filteredArticles = selectedCategory === 'all'
    ? articles
    : articles.filter((a) => a.categorySlug === selectedCategory);

  // Pagination calculation
  const totalPages = Math.ceil(filteredArticles.length / articlesPerPage) || 1;
  const startIndex = (currentPage - 1) * articlesPerPage;
  const currentArticles = filteredArticles.slice(startIndex, startIndex + articlesPerPage);

  const handleCategoryClick = (slug: string) => {
    onSelectCategory(slug);
    onPageChange(1); // reset to page 1 on category switch
  };

  return (
    <section className="my-10 max-w-[1360px] mx-auto px-4 sm:px-6">
      {/* Category Filter Pills (Exact Screenshot 2 Style) */}
      <div className="flex items-center gap-2.5 overflow-x-auto pb-4 pt-1 no-scrollbar justify-start sm:justify-center">
        {CATEGORIES.map((cat) => {
          const isActive = selectedCategory === cat.slug;
          return (
            <button
              key={cat.slug}
              onClick={() => handleCategoryClick(cat.slug)}
              className={`px-4 sm:px-5 py-2 rounded-full text-xs sm:text-sm font-bold whitespace-nowrap transition-all duration-200 cursor-pointer shadow-xs ${
                isActive
                  ? 'bg-[#0A1629] text-white shadow-sm ring-2 ring-[#0A1629]/10'
                  : 'bg-white text-[#0A1629] border border-[#DFE6EF] hover:border-slate-300 hover:bg-slate-50'
              }`}
            >
              {cat.name}
            </button>
          );
        })}
      </div>

      {/* Grid Subtitle & Count info */}
      <div className="flex items-center justify-between mt-4 mb-6">
        <h2 className="text-xl sm:text-2xl font-black text-[#0A1629] tracking-tight">
          {selectedCategory === 'all'
            ? 'नवीनतम प्रकाशित लेख (30 लेख प्रति पृष्ठ)'
            : `${CATEGORIES.find((c) => c.slug === selectedCategory)?.name || 'श्रेणी'} लेख`}
        </h2>
        <span className="text-xs font-semibold text-[#64748B] bg-slate-100 px-3 py-1 rounded-full">
          कुल {filteredArticles.length} लेख (पृष्ठ {currentPage}/{totalPages})
        </span>
      </div>

      {/* Articles Grid (Screenshot 2: 3 Columns Desktop, 2 Columns Tablet, 1 Column Mobile) */}
      {currentArticles.length > 0 ? (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
          {currentArticles.map((article) => (
            <article
              key={article.id}
              onClick={() => onSelectArticle(article)}
              className="bg-white rounded-3xl border border-[#DFE6EF] overflow-hidden shadow-[0_2px_12px_rgba(10,22,41,0.03)] hover:shadow-[0_12px_30px_rgba(10,22,41,0.08)] hover:-translate-y-1 transition-all duration-300 flex flex-col cursor-pointer group"
            >
              {/* Featured Image with rounded top corners */}
              <div className="relative aspect-[16/10] overflow-hidden bg-slate-100">
                <img
                  src={article.featuredImage}
                  alt={article.imageAlt || article.title}
                  loading="lazy"
                  referrerPolicy="no-referrer"
                  className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
              </div>

              {/* Card Body */}
              <div className="p-5 sm:p-6 flex-1 flex flex-col justify-between">
                <div>
                  {/* Category Badge (Exact soft peach background + orange text like Screenshot 2) */}
                  <div className="flex items-center gap-2 mb-3">
                    <span className="bg-orange-50 text-[#FF7000] border border-orange-100/80 text-[11px] font-bold px-3 py-1 rounded-full">
                      {article.category}
                    </span>
                    {article.isTrending && (
                      <span className="text-[10px] font-semibold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full">
                        Trending
                      </span>
                    )}
                  </div>

                  {/* Article Title */}
                  <h3 className="text-base sm:text-lg font-bold text-[#0A1629] leading-snug group-hover:text-[#FF7000] transition-colors line-clamp-2">
                    {article.title}
                  </h3>

                  {/* Short Excerpt */}
                  <p className="mt-2 text-xs sm:text-sm text-[#64748B] line-clamp-3 leading-relaxed">
                    {article.excerpt}
                  </p>
                </div>

                {/* Card Footer (Author, Date, Read Article Link) */}
                <div className="mt-5 pt-4 border-t border-[#DFE6EF]/70 flex items-center justify-between text-xs text-[#64748B]">
                  <div className="flex items-center gap-1.5 truncate max-w-[65%]">
                    <User className="w-3.5 h-3.5 text-[#94A3B8] shrink-0" />
                    <span className="truncate font-medium">{article.author}</span>
                    <span>•</span>
                    <span className="shrink-0">{article.formattedDate}</span>
                  </div>

                  <span className="inline-flex items-center gap-1 font-bold text-[#0A1629] group-hover:text-[#FF7000] shrink-0 transition-colors">
                    <span>लेख पढ़ें</span>
                    <ArrowRight className="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" />
                  </span>
                </div>
              </div>
            </article>
          ))}
        </div>
      ) : (
        <div className="bg-white rounded-3xl border border-[#DFE6EF] p-12 text-center text-[#64748B]">
          <p className="text-base font-semibold">इस श्रेणी में कोई लेख नहीं मिला।</p>
          <button
            onClick={() => handleCategoryClick('all')}
            className="mt-4 px-5 py-2 bg-[#0A1629] text-white rounded-full text-xs font-bold hover:bg-[#FF7000] transition-colors"
          >
            सभी लेख देखें
          </button>
        </div>
      )}

      {/* Pagination (Screenshot 3 Style: 1, 2, 3, 4, Next →) */}
      {totalPages > 1 && (
        <div className="mt-10 flex items-center justify-center gap-2">
          {/* Prev Button */}
          {currentPage > 1 && (
            <button
              onClick={() => {
                onPageChange(currentPage - 1);
                window.scrollTo({ top: 700, behavior: 'smooth' });
              }}
              className="px-3.5 py-2 rounded-xl bg-white border border-[#DFE6EF] text-xs font-bold text-[#0A1629] hover:bg-slate-50 flex items-center gap-1 cursor-pointer transition-colors"
            >
              <ChevronLeft className="w-4 h-4" />
              <span>Prev</span>
            </button>
          )}

          {/* Numbered Page Buttons */}
          {Array.from({ length: totalPages }, (_, i) => i + 1).map((pageNum) => {
            const isActive = currentPage === pageNum;
            return (
              <button
                key={pageNum}
                onClick={() => {
                  onPageChange(pageNum);
                  window.scrollTo({ top: 700, behavior: 'smooth' });
                }}
                className={`w-9 h-9 sm:w-10 sm:h-10 rounded-xl text-xs sm:text-sm font-bold flex items-center justify-center transition-all cursor-pointer ${
                  isActive
                    ? 'bg-[#FF7000] text-white shadow-md shadow-orange-500/20'
                    : 'bg-white border border-[#DFE6EF] text-[#0A1629] hover:bg-slate-50'
                }`}
              >
                {pageNum}
              </button>
            );
          })}

          {/* Next Button */}
          {currentPage < totalPages && (
            <button
              onClick={() => {
                onPageChange(currentPage + 1);
                window.scrollTo({ top: 700, behavior: 'smooth' });
              }}
              className="px-3.5 py-2 rounded-xl bg-white border border-[#DFE6EF] text-xs font-bold text-[#0A1629] hover:bg-slate-50 flex items-center gap-1 cursor-pointer transition-colors"
            >
              <span>Next</span>
              <ArrowRight className="w-4 h-4" />
            </button>
          )}
        </div>
      )}
    </section>
  );
};
