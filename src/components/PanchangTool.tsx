import React from 'react';
import { PanchangInfo } from '../types';
import { Calendar, Moon, Sun, Compass, Sparkles, Star } from 'lucide-react';

interface PanchangToolProps {
  panchang: PanchangInfo;
  cityName: string;
}

export const PanchangTool: React.FC<PanchangToolProps> = ({ panchang, cityName }) => {
  return (
    <section className="my-8 max-w-[1360px] mx-auto px-4 sm:px-6">
      <div className="bg-white rounded-3xl border border-[#DFE6EF] shadow-[0_4px_24px_rgba(10,22,41,0.05)] p-6 sm:p-8">
        <div className="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-[#DFE6EF] gap-3">
          <div>
            <div className="flex items-center gap-2 mb-1">
              <span className="bg-orange-50 text-[#FF7000] text-[10px] uppercase font-bold tracking-wider px-2.5 py-0.5 rounded-full border border-orange-200">
                वैदिक पंचांग
              </span>
              <span className="text-xs text-[#64748B]">{panchang.date}</span>
            </div>
            <h2 className="text-xl sm:text-2xl font-black text-[#0A1629] tracking-tight">
              दैनिक पंचांग विवरण ({cityName})
            </h2>
          </div>
          <div className="flex items-center gap-3 text-xs text-[#64748B]">
            <span className="bg-[#F1F5F9] px-3 py-1.5 rounded-xl font-semibold text-[#0A1629]">
              {panchang.samvat}
            </span>
            <span className="bg-[#F1F5F9] px-3 py-1.5 rounded-xl font-semibold text-[#0A1629]">
              {panchang.shaka}
            </span>
          </div>
        </div>

        {/* Panchang Grid */}
        <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mt-6">
          <div className="p-4 rounded-2xl bg-[#F8FAFC] border border-[#DFE6EF]">
            <span className="text-[11px] font-semibold text-[#64748B] uppercase tracking-wider block">वार (Day)</span>
            <p className="text-base font-extrabold text-[#0A1629] mt-1">{panchang.dayNameHindi}</p>
            <span className="text-xs text-[#64748B]">{panchang.dayNameEn}</span>
          </div>

          <div className="p-4 rounded-2xl bg-[#F8FAFC] border border-[#DFE6EF]">
            <span className="text-[11px] font-semibold text-[#64748B] uppercase tracking-wider block">तिथि (Tithi)</span>
            <p className="text-base font-extrabold text-[#0A1629] mt-1">{panchang.tithi}</p>
            <span className="text-xs text-[#64748B]">{panchang.paksha}</span>
          </div>

          <div className="p-4 rounded-2xl bg-[#F8FAFC] border border-[#DFE6EF]">
            <span className="text-[11px] font-semibold text-[#64748B] uppercase tracking-wider block">नक्षत्र (Nakshatra)</span>
            <p className="text-base font-extrabold text-[#0A1629] mt-1 flex items-center gap-1.5">
              <Star className="w-4 h-4 text-amber-500 shrink-0" />
              {panchang.nakshatra}
            </p>
            <span className="text-xs text-[#64748B]">चंद्र नक्षत्र</span>
          </div>

          <div className="p-4 rounded-2xl bg-[#F8FAFC] border border-[#DFE6EF]">
            <span className="text-[11px] font-semibold text-[#64748B] uppercase tracking-wider block">योग (Yoga)</span>
            <p className="text-base font-extrabold text-[#0A1629] mt-1 flex items-center gap-1.5">
              <Sparkles className="w-4 h-4 text-indigo-500 shrink-0" />
              {panchang.yoga}
            </p>
            <span className="text-xs text-[#64748B]">सूर्य-चंद्र भोगांश</span>
          </div>

          <div className="p-4 rounded-2xl bg-[#F8FAFC] border border-[#DFE6EF]">
            <span className="text-[11px] font-semibold text-[#64748B] uppercase tracking-wider block">करण (Karana)</span>
            <p className="text-base font-extrabold text-[#0A1629] mt-1">{panchang.karana}</p>
            <span className="text-xs text-[#64748B]">तिथि अर्ध भाग</span>
          </div>

          <div className="p-4 rounded-2xl bg-[#F8FAFC] border border-[#DFE6EF]">
            <span className="text-[11px] font-semibold text-[#64748B] uppercase tracking-wider block">मास एवं पक्ष</span>
            <p className="text-base font-extrabold text-[#0A1629] mt-1">{panchang.mas}</p>
            <span className="text-xs text-[#64748B]">{panchang.paksha} • {panchang.season}</span>
          </div>

          <div className="p-4 rounded-2xl bg-[#F8FAFC] border border-[#DFE6EF]">
            <span className="text-[11px] font-semibold text-[#64748B] uppercase tracking-wider block">सूर्योदय एवं सूर्यास्त</span>
            <p className="text-sm font-extrabold text-[#0A1629] mt-1 flex items-center gap-2">
              <span className="flex items-center gap-1 text-amber-600">
                <Sun className="w-3.5 h-3.5" /> {panchang.sunrise}
              </span>
              <span>•</span>
              <span className="flex items-center gap-1 text-indigo-600">
                <Moon className="w-3.5 h-3.5" /> {panchang.sunset}
              </span>
            </p>
            <span className="text-xs text-[#64748B]">{panchang.ayana}</span>
          </div>

          <div className="p-4 rounded-2xl bg-[#F8FAFC] border border-[#DFE6EF]">
            <span className="text-[11px] font-semibold text-[#64748B] uppercase tracking-wider block">चंद्रोदय एवं चंद्रास्त</span>
            <p className="text-sm font-extrabold text-[#0A1629] mt-1 tabular-nums">
              {panchang.moonrise} / {panchang.moonset}
            </p>
            <span className="text-xs text-[#64748B]">चंद्र समय</span>
          </div>
        </div>
      </div>
    </section>
  );
};
