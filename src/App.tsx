import React, { useState, useEffect } from 'react';
import { Header } from './components/Header';
import { Hero } from './components/Hero';
import { ImageSlider } from './components/ImageSlider';
import { ChoghadiyaTool } from './components/ChoghadiyaTool';
import { PanchangTool } from './components/PanchangTool';
import { ArticleGrid } from './components/ArticleGrid';
import { InfoSection } from './components/InfoSection';
import { FaqSection } from './components/FaqSection';
import { CommunitySection } from './components/CommunitySection';
import { AuthorSection } from './components/AuthorSection';
import { Footer } from './components/Footer';
import { SingleArticlePage } from './components/SingleArticlePage';
import { SearchModal } from './components/SearchModal';
import { StaticPagesModal } from './components/StaticPagesModal';
import { ARTICLES_DATA, AUTHOR_SHIV_KUMAR } from './data/articles';
import { Article } from './types';
import { POPULAR_CITIES, getPanchangDetails } from './data/choghadiyaEngine';

export default function App() {
  const [activeNav, setActiveNav] = useState<string>('home');
  const [selectedArticle, setSelectedArticle] = useState<Article | null>(null);
  const [selectedCategory, setSelectedCategory] = useState<string>('all');
  const [currentPage, setCurrentPage] = useState<number>(1);
  const [searchQuery, setSearchQuery] = useState<string>('');
  const [searchModalOpen, setSearchModalOpen] = useState<boolean>(false);
  const [staticPageType, setStaticPageType] = useState<
    'about' | 'contact' | 'privacy-policy' | 'disclaimer' | 'terms' | 'editorial-policy' | null
  >(null);

  // Panchang details for default city (Delhi)
  const todayPanchang = getPanchangDetails(new Date(), POPULAR_CITIES[0]);

  // Handle URL hash or path sync if needed
  useEffect(() => {
    const handlePopState = () => {
      const hash = window.location.hash.replace('#', '');
      if (hash.startsWith('article/')) {
        const slug = hash.replace('article/', '');
        const found = ARTICLES_DATA.find((a) => a.slug === slug);
        if (found) {
          setSelectedArticle(found);
          window.scrollTo(0, 0);
          return;
        }
      }
      if (hash === 'about' || hash === 'contact') {
        setStaticPageType(hash as any);
        return;
      }
      setSelectedArticle(null);
    };

    window.addEventListener('popstate', handlePopState);
    return () => window.removeEventListener('popstate', handlePopState);
  }, []);

  const handleSelectArticle = (article: Article) => {
    setSelectedArticle(article);
    window.location.hash = `article/${article.slug}`;
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  const handleBackToHome = () => {
    setSelectedArticle(null);
    window.location.hash = '';
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  const handleNavigate = (view: string, param?: string) => {
    if (view === 'article' && param) {
      const found = ARTICLES_DATA.find((a) => a.slug === param);
      if (found) {
        handleSelectArticle(found);
        return;
      }
    }

    if (view === 'about' || view === 'contact' || view === 'privacy-policy' || view === 'disclaimer' || view === 'terms' || view === 'editorial-policy') {
      setStaticPageType(view as any);
      return;
    }

    setSelectedArticle(null);
    setActiveNav(view);

    if (view === 'choghadiya') {
      window.scrollTo({ top: 380, behavior: 'smooth' });
    } else if (view === 'panchang') {
      window.scrollTo({ top: 780, behavior: 'smooth' });
    } else if (view === 'festivals' || view === 'muhurat' || view === 'puja-vidhi') {
      setSelectedCategory(view);
      setCurrentPage(1);
      const gridEl = document.getElementById('articles-section');
      if (gridEl) {
        gridEl.scrollIntoView({ behavior: 'smooth' });
      }
    } else {
      setSelectedCategory('all');
      setCurrentPage(1);
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  };

  const handleHeroSearchSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (searchQuery.trim()) {
      setSearchModalOpen(true);
    }
  };

  const handleClearSearch = () => {
    setSearchQuery('');
  };

  return (
    <div className="min-h-screen flex flex-col bg-[#F7F9FC] text-[#0A1629]">
      {/* 1. HEADER (Matching Screenshot 1) */}
      <Header
        activeNav={activeNav}
        onNavigate={handleNavigate}
        onOpenSearch={() => setSearchModalOpen(true)}
      />

      {/* Main Content Area */}
      {selectedArticle ? (
        /* 2. SINGLE ARTICLE PAGE (Matching Screenshot 4) */
        <SingleArticlePage
          article={selectedArticle}
          allArticles={ARTICLES_DATA}
          onBack={handleBackToHome}
          onSelectArticle={handleSelectArticle}
          onSelectCategory={(catSlug) => {
            setSelectedArticle(null);
            setSelectedCategory(catSlug);
            setCurrentPage(1);
            window.location.hash = '';
            setTimeout(() => {
              const el = document.getElementById('articles-section');
              if (el) el.scrollIntoView({ behavior: 'smooth' });
            }, 100);
          }}
        />
      ) : (
        /* HOMEPAGE VIEW (Matching Screenshots 1, 2, 3) */
        <main className="flex-1 bg-white">
          {/* 1. HERO SECTION (Placed Immediately Below Header - Prompt Adda Style) */}
          <Hero
            searchQuery={searchQuery}
            onSearchChange={setSearchQuery}
            onSearchSubmit={handleHeroSearchSubmit}
            onClearSearch={handleClearSearch}
          />

          {/* 2. TOP AUTOMATIC CONTINUOUS IMAGE SLIDER (Placed Immediately Below Hero) */}
          <ImageSlider
            articles={ARTICLES_DATA}
            onSelectArticle={handleSelectArticle}
          />

          {/* PRESERVED LIVE CHOGHADIYA TOOL (CRITICAL REQUIREMENT - Section 6) */}
          <div id="choghadiya-tool-section">
            <ChoghadiyaTool
              onLearnMore={() => {
                const article = ARTICLES_DATA.find((a) => a.slug === 'choghadiya-kya-hai-kaise-dekhein');
                if (article) handleSelectArticle(article);
              }}
            />
          </div>

          {/* DEDICATED PANCHANG DETAIL COMPONENT */}
          <PanchangTool
            panchang={todayPanchang}
            cityName={POPULAR_CITIES[0].name}
          />

          {/* ARTICLE LISTING SECTION (Screenshot 2: 30 Articles Per Page + Numbered Pagination) */}
          <div id="articles-section">
            <ArticleGrid
              articles={ARTICLES_DATA}
              selectedCategory={selectedCategory}
              onSelectCategory={setSelectedCategory}
              onSelectArticle={handleSelectArticle}
              currentPage={currentPage}
              onPageChange={setCurrentPage}
              articlesPerPage={30}
            />
          </div>

          {/* HOMEPAGE INFORMATION SECTION (Screenshot 3) */}
          <InfoSection />

          {/* FAQ SECTION (Screenshot 3) */}
          <FaqSection />

          {/* COMMUNITY SECTION (Screenshot 3) */}
          <CommunitySection />

          {/* AUTHOR SECTION (Screenshot 3) */}
          <AuthorSection
            onViewAuthorProfile={() => setStaticPageType('about')}
          />
        </main>
      )}

      {/* FOOTER (Screenshot 3) */}
      <Footer onNavigate={handleNavigate} />

      {/* SEARCH MODAL */}
      <SearchModal
        isOpen={searchModalOpen}
        onClose={() => setSearchModalOpen(false)}
        articles={ARTICLES_DATA}
        onSelectArticle={handleSelectArticle}
        initialQuery={searchQuery}
      />

      {/* STATIC & LEGAL PAGES MODAL (About, Contact, Privacy, Disclaimer, etc.) */}
      <StaticPagesModal
        type={staticPageType}
        onClose={() => setStaticPageType(null)}
      />
    </div>
  );
}
