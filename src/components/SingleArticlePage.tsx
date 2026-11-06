import React, { useState } from 'react';
import { Article } from '../types';
import { CATEGORIES } from '../data/articles';
import {
  Calendar,
  Clock,
  List,
  ChevronRight,
  Share2,
  ArrowLeft,
  CheckCircle2,
  ChevronDown,
  ChevronUp,
  Bookmark,
} from 'lucide-react';

interface SingleArticlePageProps {
  article: Article;
  allArticles: Article[];
  onBack: () => void;
  onSelectArticle: (article: Article) => void;
  onSelectCategory: (categorySlug: string) => void;
}

export const SingleArticlePage: React.FC<SingleArticlePageProps> = ({
  article,
  allArticles,
  onBack,
  onSelectArticle,
  onSelectCategory,
}) => {
  const [tocOpen, setTocOpen] = useState(true);

  // Trending articles for Widget 2 (excluding current)
  const trendingArticles = allArticles
    .filter((a) => a.id !== article.id)
    .slice(0, 4);

  const scrollToHeading = (id: string) => {
    const el = document.getElementById(id);
    if (el) {
      el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  };

  const handleShare = () => {
    if (navigator.share) {
      navigator.share({
        title: article.title,
        url: window.location.href,
      }).catch(() => {});
    } else {
      navigator.clipboard.writeText(window.location.href);
      alert('लेख का लिंक कॉपी कर लिया गया है!');
    }
  };

  return (
    <div className="bg-[#F7F9FC] py-8 sm:py-12">
      <div className="max-w-[1240px] mx-auto px-4 sm:px-6">
        {/* Breadcrumb & Back button */}
        <div className="flex items-center justify-between mb-6 text-xs text-[#64748B]">
          <button
            onClick={onBack}
            className="inline-flex items-center gap-1.5 font-bold text-[#0A1629] hover:text-[#FF7000] transition-colors cursor-pointer"
          >
            <ArrowLeft className="w-4 h-4" />
            <span>वापस मुख्य पृष्ठ पर जाएं (Back to Home)</span>
          </button>

          <div className="hidden sm:flex items-center gap-2">
            <span onClick={onBack} className="hover:underline cursor-pointer">Home</span>
            <span>/</span>
            <span
              onClick={() => onSelectCategory(article.categorySlug)}
              className="hover:underline cursor-pointer text-[#FF7000] font-medium"
            >
              {article.category}
            </span>
          </div>
        </div>

        {/* 2-Column Layout (Matching Screenshot 4: ~70% Left Article, ~30% Right Sidebar) */}
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
          {/* LEFT COLUMN: Main Article (col-span-8) */}
          <main className="lg:col-span-8 bg-white rounded-3xl border border-[#DFE6EF] shadow-[0_2px_16px_rgba(10,22,41,0.04)] p-6 sm:p-10">
            {/* Article Title: Large Bold Navy H1 (Exact Screenshot 4 Style) */}
            <h1 className="text-2xl sm:text-3xl md:text-4xl font-extrabold text-[#0A1629] leading-tight tracking-tight">
              {article.title}
            </h1>

            {/* Author Metadata Row Immediately Below H1 */}
            <div className="mt-5 pb-5 border-b border-[#DFE6EF] flex flex-wrap items-center justify-between gap-4">
              <div className="flex items-center gap-3">
                <img
                  src={article.authorImage}
                  alt={article.author}
                  className="w-11 h-11 rounded-full object-cover border-2 border-orange-100"
                />
                <div>
                  <div className="flex items-center gap-1.5">
                    <span className="text-xs text-[#64748B]">By</span>
                    <strong className="text-sm font-bold text-[#0A1629]">{article.author}</strong>
                  </div>
                  <p className="text-[11px] text-[#64748B]">{article.authorRole}</p>
                </div>
              </div>

              <div className="flex items-center gap-4 text-xs text-[#64748B]">
                <span className="flex items-center gap-1">
                  <Calendar className="w-3.5 h-3.5 text-[#94A3B8]" />
                  <span>Published: <strong>{article.formattedDate}</strong></span>
                </span>
                <span>•</span>
                <span className="flex items-center gap-1">
                  <Clock className="w-3.5 h-3.5 text-[#94A3B8]" />
                  <span>Read time: <strong>{article.readingTime}</strong></span>
                </span>
                <button
                  onClick={handleShare}
                  title="शेयर करें"
                  className="p-1.5 rounded-full hover:bg-slate-100 text-[#0A1629] hover:text-[#FF7000] transition-colors cursor-pointer"
                >
                  <Share2 className="w-4 h-4" />
                </button>
              </div>
            </div>

            {/* Featured Image (Full width within article column, rounded corners) */}
            <div className="my-7 rounded-2xl overflow-hidden aspect-[16/9] bg-slate-100 shadow-sm border border-[#DFE6EF]/60">
              <img
                src={article.featuredImage}
                alt={article.imageAlt || article.title}
                className="w-full h-full object-cover"
              />
            </div>

            {/* Excerpt Lead */}
            <div className="p-4 sm:p-5 rounded-2xl bg-orange-50/50 border border-orange-100 text-sm sm:text-base font-medium text-[#0A1629] leading-relaxed mb-6">
              {article.excerpt}
            </div>

            {/* Table of Contents (Matching Screenshot 4 collapsible box) */}
            {article.tableOfContents && article.tableOfContents.length > 0 && (
              <div className="my-6 rounded-2xl border border-[#DFE6EF] bg-[#F8FAFC] p-4 sm:p-5">
                <div className="flex items-center justify-between pb-2 border-b border-[#DFE6EF]/70">
                  <div className="flex items-center gap-2 font-bold text-sm sm:text-base text-[#0A1629]">
                    <List className="w-4 h-4 text-[#FF7000]" />
                    <span>Table of Contents</span>
                  </div>
                  <button
                    onClick={() => setTocOpen(!tocOpen)}
                    className="text-xs font-bold text-[#64748B] hover:text-[#0A1629] px-2.5 py-1 rounded-md bg-white border border-[#DFE6EF] transition-colors cursor-pointer"
                  >
                    {tocOpen ? 'Hide' : 'Show'}
                  </button>
                </div>

                {tocOpen && (
                  <ul className="mt-3 space-y-2 text-xs sm:text-sm text-[#0A1629]">
                    {article.tableOfContents.map((item) => (
                      <li key={item.id}>
                        <button
                          onClick={() => scrollToHeading(item.id)}
                          className="hover:text-[#FF7000] hover:underline text-left transition-colors cursor-pointer flex items-center gap-1.5"
                        >
                          <span className="text-[#FF7000]">•</span>
                          <span>{item.title}</span>
                        </button>
                      </li>
                    ))}
                  </ul>
                )}
              </div>
            )}

            {/* Article Body Content */}
            <div
              className="prose prose-slate max-w-none text-sm sm:text-base text-[#0A1629] leading-relaxed space-y-4 pt-2"
              dangerouslySetInnerHTML={{ __html: article.content || article.excerpt }}
            />

            {/* Tags strip */}
            {article.tags && article.tags.length > 0 && (
              <div className="mt-10 pt-6 border-t border-[#DFE6EF] flex flex-wrap items-center gap-2">
                <span className="text-xs font-bold text-[#64748B] mr-1">टैग्स (Tags):</span>
                {article.tags.map((tag) => (
                  <span
                    key={tag}
                    className="text-xs font-semibold px-3 py-1 rounded-full bg-slate-100 text-[#0A1629] hover:bg-orange-50 hover:text-[#FF7000] cursor-pointer transition-colors"
                  >
                    #{tag}
                  </span>
                ))}
              </div>
            )}
          </main>

          {/* RIGHT COLUMN: Sidebar (col-span-4) (Exact Screenshot 4 Layout) */}
          <aside className="lg:col-span-4 space-y-6">
            {/* Widget 1 — Post Author (Matching Screenshot 4) */}
            <div className="bg-white rounded-3xl border border-[#DFE6EF] shadow-[0_2px_16px_rgba(10,22,41,0.04)] p-6 text-center">
              <div className="text-left pb-3 mb-4 border-b border-[#DFE6EF] flex items-center justify-between">
                <h3 className="text-sm font-extrabold text-[#0A1629] uppercase tracking-wider">
                  Post Author
                </h3>
                <span className="w-8 h-0.5 bg-[#FF7000] rounded-full" />
              </div>

              {/* Author Avatar */}
              <div className="w-20 h-20 rounded-full overflow-hidden border-2 border-orange-100 mx-auto mb-3 shadow-sm">
                <img
                  src={article.authorImage}
                  alt={article.author}
                  className="w-full h-full object-cover"
                />
              </div>

              <h4 className="text-base font-extrabold text-[#0A1629]">
                {article.author}
              </h4>
              <p className="text-xs font-medium text-[#64748B] mt-0.5">
                {article.authorRole}
              </p>

              <p className="text-xs text-[#64748B] leading-relaxed mt-3 px-1 text-center">
                {article.authorBio}
              </p>

              <button
                onClick={onBack}
                className="mt-5 w-full py-2.5 rounded-full bg-slate-50 border border-[#DFE6EF] text-xs font-bold text-[#0A1629] hover:bg-[#FF7000] hover:text-white hover:border-[#FF7000] transition-all cursor-pointer"
              >
                View All Guides →
              </button>
            </div>

            {/* Widget 2 — Trending Articles (Matching Screenshot 4) */}
            <div className="bg-white rounded-3xl border border-[#DFE6EF] shadow-[0_2px_16px_rgba(10,22,41,0.04)] p-6">
              <div className="pb-3 mb-4 border-b border-[#DFE6EF] flex items-center justify-between">
                <h3 className="text-sm font-extrabold text-[#0A1629] uppercase tracking-wider">
                  Trending Articles
                </h3>
                <span className="w-8 h-0.5 bg-[#FF7000] rounded-full" />
              </div>

              <div className="space-y-4">
                {trendingArticles.map((tArticle) => (
                  <div
                    key={tArticle.id}
                    onClick={() => {
                      onSelectArticle(tArticle);
                      window.scrollTo({ top: 0, behavior: 'smooth' });
                    }}
                    className="flex items-center gap-3 group cursor-pointer"
                  >
                    <div className="w-16 h-16 rounded-xl overflow-hidden shrink-0 bg-slate-100 border border-[#DFE6EF]/70">
                      <img
                        src={tArticle.featuredImage}
                        alt={tArticle.title}
                        className="w-full h-full object-cover group-hover:scale-105 transition-transform"
                      />
                    </div>
                    <div className="min-w-0">
                      <h5 className="text-xs sm:text-sm font-bold text-[#0A1629] group-hover:text-[#FF7000] transition-colors line-clamp-2 leading-snug">
                        {tArticle.title}
                      </h5>
                      <span className="text-[10px] text-[#94A3B8] block mt-1">
                        {tArticle.formattedDate}
                      </span>
                    </div>
                  </div>
                ))}
              </div>
            </div>

            {/* Widget 3 — Categories (Matching Screenshot 4) */}
            <div className="bg-white rounded-3xl border border-[#DFE6EF] shadow-[0_2px_16px_rgba(10,22,41,0.04)] p-6">
              <div className="pb-3 mb-4 border-b border-[#DFE6EF] flex items-center justify-between">
                <h3 className="text-sm font-extrabold text-[#0A1629] uppercase tracking-wider">
                  Categories
                </h3>
                <span className="w-8 h-0.5 bg-[#FF7000] rounded-full" />
              </div>

              <div className="space-y-2">
                {CATEGORIES.filter((c) => c.slug !== 'all').map((cat) => (
                  <button
                    key={cat.slug}
                    onClick={() => onSelectCategory(cat.slug)}
                    className="w-full flex items-center justify-between p-3 rounded-xl bg-[#F8FAFC] hover:bg-orange-50 border border-[#DFE6EF] text-xs font-bold text-[#0A1629] hover:text-[#FF7000] hover:border-orange-200 transition-all cursor-pointer group"
                  >
                    <span>{cat.name}</span>
                    <ChevronRight className="w-4 h-4 text-[#94A3B8] group-hover:text-[#FF7000] group-hover:translate-x-0.5 transition-transform" />
                  </button>
                ))}
              </div>
            </div>
          </aside>
        </div>
      </div>
    </div>
  );
};
