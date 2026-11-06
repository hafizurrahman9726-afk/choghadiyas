import React, { useState, useEffect, useId } from 'react';
import { Article } from '../types';
import { Search, X, ArrowRight, Calendar } from 'lucide-react';

interface SearchModalProps {
  isOpen: boolean;
  onClose: () => void;
  articles: Article[];
  onSelectArticle: (article: Article) => void;
  initialQuery?: string;
}

export const SearchModal: React.FC<SearchModalProps> = ({
  isOpen,
  onClose,
  articles,
  onSelectArticle,
  initialQuery = '',
}) => {
  const searchInputId = useId();
  const [query, setQuery] = useState(initialQuery);

  useEffect(() => {
    setQuery(initialQuery);
  }, [initialQuery]);

  if (!isOpen) return null;

  const filtered = query.trim()
    ? articles.filter(
        (a) =>
          a.title.toLowerCase().includes(query.toLowerCase()) ||
          a.excerpt.toLowerCase().includes(query.toLowerCase()) ||
          a.category.toLowerCase().includes(query.toLowerCase()) ||
          (a.tags && a.tags.some((t) => t.toLowerCase().includes(query.toLowerCase())))
      )
    : articles.slice(0, 6);

  return (
    <div className="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs flex items-start justify-center p-4 sm:p-6 pt-16 sm:pt-24 animate-in fade-in">
      <div className="bg-white w-full max-w-2xl rounded-3xl shadow-2xl border border-[#DFE6EF] overflow-hidden flex flex-col max-h-[80vh]">
        {/* Search Input Box */}
        <div className="p-4 sm:p-5 border-b border-[#DFE6EF] flex items-center gap-3">
          <Search className="w-5 h-5 text-[#FF7000] shrink-0" />
          <label htmlFor={searchInputId} className="sr-only">खोजें</label>
          <input
            id={searchInputId}
            type="text"
            autoFocus
            value={query}
            onChange={(e) => setQuery(e.target.value)}
            placeholder="चौघड़िया, पंचांग, मुहूर्त या पूजा विधि खोजें..."
            className="w-full text-sm sm:text-base text-[#0A1629] placeholder-[#94A3B8] outline-none font-medium"
          />
          {query && (
            <button
              onClick={() => setQuery('')}
              className="p-1.5 text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-100 transition-colors"
            >
              <X className="w-4 h-4" />
            </button>
          )}
          <button
            onClick={onClose}
            className="p-1.5 rounded-full hover:bg-slate-100 text-slate-500 hover:text-slate-700 transition-colors cursor-pointer"
          >
            <X className="w-5 h-5" />
          </button>
        </div>

        {/* Results List */}
        <div className="overflow-y-auto p-4 sm:p-5 space-y-3 divide-y divide-slate-100">
          <div className="text-xs font-bold uppercase tracking-wider text-[#64748B] pb-1">
            {query.trim() ? `खोज परिणाम (${filtered.length})` : 'लोकप्रिय लेख एवं मार्गदर्शिका'}
          </div>

          {filtered.length > 0 ? (
            filtered.map((article) => (
              <div
                key={article.id}
                onClick={() => {
                  onSelectArticle(article);
                  onClose();
                }}
                className="pt-3 flex items-center gap-3 group cursor-pointer hover:bg-slate-50 p-2 rounded-xl transition-colors"
              >
                <img
                  src={article.featuredImage}
                  alt={article.title}
                  className="w-14 h-14 rounded-lg object-cover shrink-0 bg-slate-100"
                />
                <div className="min-w-0 flex-1">
                  <span className="text-[10px] font-bold text-[#FF7000] uppercase tracking-wider block">
                    {article.category}
                  </span>
                  <h4 className="text-xs sm:text-sm font-bold text-[#0A1629] group-hover:text-[#FF7000] line-clamp-1">
                    {article.title}
                  </h4>
                  <p className="text-[11px] text-[#64748B] line-clamp-1 mt-0.5">
                    {article.excerpt}
                  </p>
                </div>
                <ArrowRight className="w-4 h-4 text-[#94A3B8] group-hover:text-[#FF7000] group-hover:translate-x-1 transition-all shrink-0" />
              </div>
            ))
          ) : (
            <div className="py-8 text-center text-xs text-[#64748B]">
              "{query}" से संबंधित कोई लेख नहीं मिला। कृपया अन्य शब्द लिखकर खोजें।
            </div>
          )}
        </div>
      </div>
    </div>
  );
};
