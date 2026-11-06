import React, { useState, useId } from 'react';
import {
  Sun,
  Moon,
  MapPin,
  Calendar,
  Clock,
  Sparkles,
  Info,
  CheckCircle2,
  AlertCircle,
  HelpCircle,
} from 'lucide-react';
import {
  POPULAR_CITIES,
  getChoghadiyaSlots,
  getPanchangDetails,
} from '../data/choghadiyaEngine';
import { CityData } from '../types';

interface ChoghadiyaToolProps {
  onLearnMore?: () => void;
}

export const ChoghadiyaTool: React.FC<ChoghadiyaToolProps> = ({ onLearnMore }) => {
  const citySelectId = useId();
  const dateInputId = useId();

  const [selectedCity, setSelectedCity] = useState<CityData>(POPULAR_CITIES[0]); // New Delhi
  const [selectedDate, setSelectedDate] = useState<Date>(new Date());
  const [activeTab, setActiveTab] = useState<'day' | 'night'>('day');
  const [showExplanation, setShowExplanation] = useState(false);

  // Calculations
  const { daySlots, nightSlots, currentSlot } = getChoghadiyaSlots(selectedDate, selectedCity);
  const panchang = getPanchangDetails(selectedDate, selectedCity);

  const handleCityChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    const city = POPULAR_CITIES.find((c) => c.id === e.target.value) || POPULAR_CITIES[0];
    setSelectedCity(city);
  };

  const handleDateChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (e.target.value) {
      setSelectedDate(new Date(e.target.value));
    }
  };

  const getNatureBadge = (nature: string, natureColor: string) => {
    switch (natureColor) {
      case 'emerald':
        return (
          <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
            <CheckCircle2 className="w-3 h-3 text-emerald-600" />
            {nature}
          </span>
        );
      case 'blue':
        return (
          <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
            <Sparkles className="w-3 h-3 text-blue-500" />
            {nature}
          </span>
        );
      case 'amber':
        return (
          <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
            <AlertCircle className="w-3 h-3 text-amber-600" />
            {nature}
          </span>
        );
      case 'rose':
      default:
        return (
          <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
            <AlertCircle className="w-3 h-3 text-rose-500" />
            {nature}
          </span>
        );
    }
  };

  return (
    <section className="my-8 max-w-[1360px] mx-auto px-4 sm:px-6">
      {/* Container Card */}
      <div className="bg-white rounded-3xl border border-[#DFE6EF] shadow-[0_4px_24px_rgba(10,22,41,0.05)] overflow-hidden">
        {/* Top Control Bar: Title, City Selector, Date Picker */}
        <div className="bg-gradient-to-r from-[#0A1629] via-[#102347] to-[#0A1629] p-5 sm:p-7 text-white">
          <div className="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
            <div>
              <div className="flex items-center gap-2 mb-1.5">
                <span className="bg-[#FF7000] text-white text-[10px] uppercase tracking-wider font-extrabold px-2.5 py-0.5 rounded-full">
                  दैनिक पंचांग व चौघड़िया
                </span>
                <span className="text-slate-300 text-xs hidden sm:inline">
                  • {selectedDate.toLocaleDateString('hi-IN', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })}
                </span>
              </div>
              <h2 className="text-xl sm:text-2xl md:text-3xl font-extrabold text-white tracking-tight flex items-center gap-2">
                आज का चौघड़िया ({selectedCity.name})
              </h2>
              <p className="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                सूर्योदय एवं सूर्यास्त आधारित वास्तविक वैदिक काल गणना। अपने शुभ कार्य के लिए अमृत, शुभ, लाभ व चर मुहूर्त चुनें।
              </p>
            </div>

            {/* City & Date Selectors */}
            <div className="flex flex-wrap sm:flex-nowrap items-center gap-3">
              {/* City selector */}
              <div className="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl px-3.5 py-2 flex items-center gap-2 text-white hover:bg-white/15 transition-all w-full sm:w-auto">
                <MapPin className="w-4 h-4 text-[#FF7000] shrink-0" />
                <div className="flex flex-col text-left">
                  <label htmlFor={citySelectId} className="text-[10px] text-slate-300 uppercase tracking-wider font-medium">स्थान (City)</label>
                  <select
                    id={citySelectId}
                    value={selectedCity.id}
                    onChange={handleCityChange}
                    className="bg-transparent text-white text-xs sm:text-sm font-semibold outline-none cursor-pointer pr-4"
                  >
                    {POPULAR_CITIES.map((c) => (
                      <option key={c.id} value={c.id} className="text-[#0A1629] bg-white">
                        {c.name} ({c.nameEn})
                      </option>
                    ))}
                  </select>
                </div>
              </div>

              {/* Date selector */}
              <div className="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl px-3.5 py-2 flex items-center gap-2 text-white hover:bg-white/15 transition-all w-full sm:w-auto">
                <Calendar className="w-4 h-4 text-[#FF7000] shrink-0" />
                <div className="flex flex-col text-left">
                  <label htmlFor={dateInputId} className="text-[10px] text-slate-300 uppercase tracking-wider font-medium">दिनांक (Date)</label>
                  <input
                    id={dateInputId}
                    type="date"
                    value={selectedDate.toISOString().split('T')[0]}
                    onChange={handleDateChange}
                    className="bg-transparent text-white text-xs sm:text-sm font-semibold outline-none cursor-pointer"
                  />
                </div>
              </div>
            </div>
          </div>

          {/* Current Active Choghadiya Banner */}
          {currentSlot && (
            <div className="mt-5 p-3.5 sm:p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 animate-in fade-in">
              <div className="flex items-center gap-3">
                <div className="w-3 h-3 rounded-full bg-emerald-400 animate-ping shrink-0" />
                <div>
                  <span className="text-[11px] font-bold uppercase tracking-wider text-orange-300">
                    वर्तमान में सक्रिय चौघड़िया (Current Time)
                  </span>
                  <div className="flex items-center gap-2 mt-0.5">
                    <span className="text-base sm:text-lg font-black text-white">
                      {currentSlot.name} ({currentSlot.nameEn})
                    </span>
                    <span className="text-xs text-slate-200">
                      • {currentSlot.startTime} - {currentSlot.endTime}
                    </span>
                  </div>
                </div>
              </div>
              <div className="flex items-center gap-2">
                <span className={`px-3 py-1 rounded-full text-xs font-bold text-white shadow-sm ${
                  currentSlot.type === 'amrit' || currentSlot.type === 'shubh' || currentSlot.type === 'labh'
                    ? 'bg-emerald-600'
                    : currentSlot.type === 'char'
                    ? 'bg-blue-600'
                    : 'bg-rose-600'
                }`}>
                  {currentSlot.nature}
                </span>
                <span className="text-xs text-slate-200 hidden md:inline">
                  {currentSlot.suitableFor}
                </span>
              </div>
            </div>
          )}
        </div>

        {/* Day & Night Tabs */}
        <div className="border-b border-[#DFE6EF] px-5 sm:px-7 py-3 flex items-center justify-between bg-[#F8FAFC]">
          <div className="flex items-center gap-2 p-1 bg-[#EEF2F6] rounded-xl">
            <button
              onClick={() => setActiveTab('day')}
              className={`flex items-center gap-2 px-4 py-2 rounded-lg text-xs sm:text-sm font-bold transition-all cursor-pointer ${
                activeTab === 'day'
                  ? 'bg-white text-[#0A1629] shadow-sm'
                  : 'text-[#64748B] hover:text-[#0A1629]'
              }`}
            >
              <Sun className={`w-4 h-4 ${activeTab === 'day' ? 'text-amber-500' : 'text-[#64748B]'}`} />
              <span>दिन का चौघड़िया (Day)</span>
            </button>
            <button
              onClick={() => setActiveTab('night')}
              className={`flex items-center gap-2 px-4 py-2 rounded-lg text-xs sm:text-sm font-bold transition-all cursor-pointer ${
                activeTab === 'night'
                  ? 'bg-[#0A1629] text-white shadow-sm'
                  : 'text-[#64748B] hover:text-[#0A1629]'
              }`}
            >
              <Moon className={`w-4 h-4 ${activeTab === 'night' ? 'text-blue-300' : 'text-[#64748B]'}`} />
              <span>रात का चौघड़िया (Night)</span>
            </button>
          </div>

          <div className="hidden sm:flex items-center gap-4 text-xs text-[#64748B]">
            <span className="flex items-center gap-1 font-medium">
              <Sun className="w-3.5 h-3.5 text-amber-500" />
              सूर्योदय: <strong className="text-[#0A1629]">{panchang.sunrise}</strong>
            </span>
            <span className="flex items-center gap-1 font-medium">
              <Moon className="w-3.5 h-3.5 text-indigo-500" />
              सूर्यास्त: <strong className="text-[#0A1629]">{panchang.sunset}</strong>
            </span>
          </div>
        </div>

        {/* Choghadiya Table */}
        <div className="p-4 sm:p-7 overflow-x-auto">
          <table className="w-full text-left text-xs sm:text-sm border-collapse min-w-[650px]">
            <thead>
              <tr className="border-b border-[#DFE6EF] text-[#64748B] text-xs uppercase tracking-wider font-semibold">
                <th className="py-3 px-3">पहर #</th>
                <th className="py-3 px-3">चौघड़िया मुहूर्त</th>
                <th className="py-3 px-3">अधिष्ठाता ग्रह</th>
                <th className="py-3 px-3">समय (Timing)</th>
                <th className="py-3 px-3">प्रकृति / फल</th>
                <th className="py-3 px-3">उपयुक्त कार्य (Best For)</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium">
              {(activeTab === 'day' ? daySlots : nightSlots).map((slot) => {
                const isCurrent = slot.isCurrent;
                return (
                  <tr
                    key={slot.index}
                    className={`transition-colors ${
                      isCurrent
                        ? 'bg-amber-50/80 font-bold border-l-4 border-l-[#FF7000]'
                        : 'hover:bg-slate-50/70'
                    }`}
                  >
                    <td className="py-3.5 px-3 text-[#64748B] tabular-nums">
                      {isCurrent ? (
                        <span className="bg-[#FF7000] text-white text-[10px] font-extrabold px-1.5 py-0.5 rounded">
                          NOW
                        </span>
                      ) : (
                        `0${slot.index}`
                      )}
                    </td>
                    <td className="py-3.5 px-3">
                      <div className="flex items-center gap-2">
                        <span className="font-extrabold text-[#0A1629] text-base">{slot.name}</span>
                        <span className="text-xs text-[#64748B]">({slot.nameEn})</span>
                      </div>
                    </td>
                    <td className="py-3.5 px-3 text-[#64748B]">{slot.planet}</td>
                    <td className="py-3.5 px-3 font-semibold text-[#0A1629] tabular-nums whitespace-nowrap">
                      {slot.startTime} – {slot.endTime}
                    </td>
                    <td className="py-3.5 px-3">{getNatureBadge(slot.nature, slot.natureColor)}</td>
                    <td className="py-3.5 px-3 text-xs text-[#64748B] max-w-xs">{slot.suitableFor}</td>
                  </tr>
                );
              })}
            </tbody>
          </table>
        </div>

        {/* Auspicious & Inauspicious Muhurat Strip (Rahu Kaal, Abhijit, Gulika, etc.) */}
        <div className="bg-[#F8FAFC] border-t border-[#DFE6EF] p-5 sm:p-7">
          <div className="flex items-center justify-between mb-4">
            <h3 className="text-sm font-extrabold text-[#0A1629] uppercase tracking-wider flex items-center gap-2">
              <Clock className="w-4 h-4 text-[#FF7000]" />
              आज के मुख्य शुभ व अशुभ काल ({selectedCity.name})
            </h3>
            <button
              onClick={() => setShowExplanation(!showExplanation)}
              className="text-xs text-[#FF7000] hover:underline font-semibold flex items-center gap-1 cursor-pointer"
            >
              <HelpCircle className="w-3.5 h-3.5" />
              <span>{showExplanation ? 'नियम छुपाएं' : 'चौघड़िया नियम समझें'}</span>
            </button>
          </div>

          <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            {/* Rahu Kaal (Inauspicious) */}
            <div className="bg-white p-3.5 rounded-2xl border border-rose-200 shadow-sm">
              <span className="text-[10px] font-bold uppercase tracking-wider text-rose-600 block">
                राहुकाल (वर्जित)
              </span>
              <p className="text-xs sm:text-sm font-extrabold text-[#0A1629] mt-1 tabular-nums">
                {panchang.rahuKaal}
              </p>
              <span className="text-[10px] text-[#64748B]">शुभ कार्य न करें</span>
            </div>

            {/* Abhijit Muhurat (Auspicious) */}
            <div className="bg-white p-3.5 rounded-2xl border border-emerald-200 shadow-sm">
              <span className="text-[10px] font-bold uppercase tracking-wider text-emerald-600 block">
                अभिजित मुहूर्त
              </span>
              <p className="text-xs sm:text-sm font-extrabold text-[#0A1629] mt-1 tabular-nums">
                {panchang.abhijitMuhurat}
              </p>
              <span className="text-[10px] text-emerald-700 font-medium">सर्वकार्य सिद्धि</span>
            </div>

            {/* Yamaganda Kaal */}
            <div className="bg-white p-3.5 rounded-2xl border border-rose-200 shadow-sm">
              <span className="text-[10px] font-bold uppercase tracking-wider text-rose-600 block">
                यमगण्ड काल
              </span>
              <p className="text-xs sm:text-sm font-extrabold text-[#0A1629] mt-1 tabular-nums">
                {panchang.yamaganda}
              </p>
              <span className="text-[10px] text-[#64748B]">कष्टकारी समय</span>
            </div>

            {/* Gulika Kaal */}
            <div className="bg-white p-3.5 rounded-2xl border border-[#DFE6EF] shadow-sm">
              <span className="text-[10px] font-bold uppercase tracking-wider text-blue-600 block">
                गुलिक काल
              </span>
              <p className="text-xs sm:text-sm font-extrabold text-[#0A1629] mt-1 tabular-nums">
                {panchang.gulikaKaal}
              </p>
              <span className="text-[10px] text-[#64748B]">सामान्य कार्य</span>
            </div>

            {/* Brahma Muhurat */}
            <div className="bg-white p-3.5 rounded-2xl border border-indigo-200 shadow-sm">
              <span className="text-[10px] font-bold uppercase tracking-wider text-indigo-600 block">
                ब्रह्म मुहूर्त
              </span>
              <p className="text-xs sm:text-sm font-extrabold text-[#0A1629] mt-1 tabular-nums">
                {panchang.brahmaMuhurat}
              </p>
              <span className="text-[10px] text-indigo-700 font-medium">पूजा व अध्ययन</span>
            </div>

            {/* Amrit Kaal */}
            <div className="bg-white p-3.5 rounded-2xl border border-emerald-200 shadow-sm">
              <span className="text-[10px] font-bold uppercase tracking-wider text-emerald-600 block">
                अमृत काल
              </span>
              <p className="text-xs sm:text-sm font-extrabold text-[#0A1629] mt-1 tabular-nums">
                {panchang.amritKaal}
              </p>
              <span className="text-[10px] text-emerald-700 font-medium">मांगलिक कार्य</span>
            </div>
          </div>

          {/* Collapsible Explanation Box */}
          {showExplanation && (
            <div className="mt-4 p-4 rounded-2xl bg-orange-50/70 border border-orange-200 text-xs text-[#0A1629] leading-relaxed animate-in fade-in">
              <h4 className="font-bold text-[#FF7000] text-sm mb-1.5 flex items-center gap-1.5">
                <Info className="w-4 h-4" />
                चौघड़िया देखने का शास्त्रीय नियम:
              </h4>
              <p>
                1. <strong>अमृत, शुभ और लाभ</strong> चौघड़िया किसी भी नए कार्य, व्यापार, वाहन क्रय, गृह प्रवेश और मांगलिक कार्यों के लिए सर्वश्रेष्ठ हैं।<br />
                2. <strong>चर</strong> चौघड़िया गतिशील कार्यों, यात्रा, विदेश जाने और वाहन चलाने के लिए अनुकूल है।<br />
                3. <strong>रोग, काल और उद्वेग</strong> चौघड़िया में शुभ कार्य करने से बचना चाहिए।<br />
                4. यदि चौघड़िया अमृत या शुभ हो, लेकिन उसी समय <strong>राहुकाल</strong> चल रहा हो, तो नया कार्य आरंभ न करें।
              </p>
              {onLearnMore && (
                <button
                  onClick={onLearnMore}
                  className="mt-2 text-xs font-bold text-[#FF7000] hover:underline cursor-pointer"
                >
                  विस्तृत मार्गदर्शिका पढ़ें →
                </button>
              )}
            </div>
          )}
        </div>
      </div>
    </section>
  );
};
