import React, { useState } from 'react';
import { Search, Menu, X, Sun, Compass, Calendar, Moon, BookOpen, Info, Phone, ArrowRight } from 'lucide-react';

interface HeaderProps {
  activeNav: string;
  onNavigate: (view: string, param?: string) => void;
  onOpenSearch: () => void;
}

export const Header: React.FC<HeaderProps> = ({ activeNav, onNavigate, onOpenSearch }) => {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  const navItems = [
    { id: 'home', label: 'Home', icon: Sun },
    { id: 'choghadiya', label: 'आज का चौघड़िया', icon: Compass },
    { id: 'panchang', label: 'पंचांग', icon: Moon },
    { id: 'festivals', label: 'व्रत और त्योहार', icon: Calendar },
    { id: 'muhurat', label: 'शुभ मुहूर्त', icon: ArrowRight },
    { id: 'puja-vidhi', label: 'पूजा विधि', icon: BookOpen },
    { id: 'about', label: 'About Us', icon: Info },
    { id: 'contact', label: 'Contact Us', icon: Phone },
  ];

  const handleNavClick = (id: string) => {
    setMobileMenuOpen(false);
    onNavigate(id);
  };

  return (
    <header className="sticky top-0 z-40 bg-white border-b border-[#DFE6EF] shadow-[0_1px_3px_rgba(0,0,0,0.03)]">
      <div className="max-w-[1360px] mx-auto px-4 sm:px-6 h-18 flex items-center justify-between gap-4">
        {/* Left: Choghadiyas Logo & Branding */}
        <div 
          onClick={() => onNavigate('home')} 
          className="flex items-center gap-3 cursor-pointer shrink-0 select-none group"
        >
          <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-[#FF7000] to-[#E65100] flex items-center justify-center text-white shadow-md shadow-orange-500/20 group-hover:scale-105 transition-transform">
            <Sun className="w-6 h-6 animate-[spin_20s_linear_infinite]" />
          </div>
          <div>
            <div className="flex items-center">
              <span className="text-xl sm:text-2xl font-black text-[#0A1629] tracking-tight">Choghadiyas</span>
              <span className="text-xl sm:text-2xl font-black text-[#FF7000] tracking-tight">.in</span>
            </div>
            <p className="text-[10px] font-medium text-[#64748B] tracking-wider uppercase -mt-0.5">
              वैदिक चौघड़िया एवं पंचांग
            </p>
          </div>
        </div>

        {/* Center: Desktop Navigation Pills (Exact Screenshot 1 Style) */}
        <nav className="hidden lg:flex items-center gap-1.5 flex-wrap justify-center">
          {navItems.map((item) => {
            const isActive = activeNav === item.id;
            return (
              <button
                key={item.id}
                onClick={() => handleNavClick(item.id)}
                className={`px-3.5 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all duration-200 cursor-pointer ${
                  isActive
                    ? 'bg-[#0A1629] text-white shadow-sm'
                    : 'bg-[#F1F5F9] text-[#0A1629] hover:bg-[#FFE8D6] hover:text-[#FF7000]'
                }`}
              >
                {item.label}
              </button>
            );
          })}
        </nav>

        {/* Right: Circular Search Icon & Mobile Menu Toggle */}
        <div className="flex items-center gap-2 shrink-0">
          <button
            onClick={onOpenSearch}
            aria-label="खोजें"
            className="w-10 h-10 rounded-full bg-[#F1F5F9] hover:bg-[#FFE8D6] hover:text-[#FF7000] text-[#0A1629] flex items-center justify-center transition-colors cursor-pointer border border-[#DFE6EF]/60 shadow-sm"
          >
            <Search className="w-4 h-4" />
          </button>

          {/* Mobile Menu Hamburger */}
          <button
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            aria-label="Menu"
            className="lg:hidden w-10 h-10 rounded-full bg-[#F1F5F9] hover:bg-slate-200 text-[#0A1629] flex items-center justify-center transition-colors cursor-pointer"
          >
            {mobileMenuOpen ? <X className="w-5 h-5" /> : <Menu className="w-5 h-5" />}
          </button>
        </div>
      </div>

      {/* Mobile Drawer Navigation */}
      {mobileMenuOpen && (
        <div className="lg:hidden bg-white border-b border-[#DFE6EF] px-4 py-4 space-y-1.5 animate-in slide-in-from-top-2 duration-200 shadow-lg">
          {navItems.map((item) => {
            const Icon = item.icon;
            const isActive = activeNav === item.id;
            return (
              <button
                key={item.id}
                onClick={() => handleNavClick(item.id)}
                className={`w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all text-left ${
                  isActive
                    ? 'bg-[#0A1629] text-white'
                    : 'bg-[#F8FAFC] text-[#0A1629] hover:bg-[#FFE8D6] hover:text-[#FF7000]'
                }`}
              >
                <Icon className={`w-4 h-4 ${isActive ? 'text-[#FF7000]' : 'text-[#64748B]'}`} />
                <span>{item.label}</span>
              </button>
            );
          })}
        </div>
      )}
    </header>
  );
};
