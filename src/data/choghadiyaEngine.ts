import { ChoghadiyaSlot, ChoghadiyaType, CityData, PanchangInfo } from '../types';

export const POPULAR_CITIES: CityData[] = [
  { id: 'delhi', name: 'नई दिल्ली', nameEn: 'New Delhi', state: 'दिल्ली', lat: 28.6139, lng: 77.2090 },
  { id: 'mumbai', name: 'मुंबई', nameEn: 'Mumbai', state: 'महाराष्ट्र', lat: 19.0760, lng: 72.8777 },
  { id: 'varanasi', name: 'वाराणसी', nameEn: 'Varanasi', state: 'उत्तर प्रदेश', lat: 25.3176, lng: 82.9739 },
  { id: 'jaipur', name: 'जयपुर', nameEn: 'Jaipur', state: 'राजस्थान', lat: 26.9124, lng: 75.7873 },
  { id: 'kolkata', name: 'कोलकाता', nameEn: 'Kolkata', state: 'पश्चिम बंगाल', lat: 22.5726, lng: 88.3639 },
  { id: 'bengaluru', name: 'बेंगलुरु', nameEn: 'Bengaluru', state: 'कर्नाटक', lat: 12.9716, lng: 77.5946 },
  { id: 'ahmedabad', name: 'अहमदाबाद', nameEn: 'Ahmedabad', state: 'गुजरात', lat: 23.0225, lng: 72.5714 },
  { id: 'patna', name: 'पटना', nameEn: 'Patna', state: 'बिहार', lat: 25.5941, lng: 85.1376 },
  { id: 'lucknow', name: 'लखनऊ', nameEn: 'Lucknow', state: 'उत्तर प्रदेश', lat: 26.8467, lng: 80.9462 },
  { id: 'pune', name: 'पुणे', nameEn: 'Pune', state: 'महाराष्ट्र', lat: 18.5204, lng: 73.8567 },
  { id: 'hyderabad', name: 'हैदराबाद', nameEn: 'Hyderabad', state: 'तेलंगाना', lat: 17.3850, lng: 78.4867 },
  { id: 'ayodhya', name: 'अयोध्या', nameEn: 'Ayodhya', state: 'उत्तर प्रदेश', lat: 26.7922, lng: 82.1998 },
  { id: 'ujjain', name: 'उज्जैन', nameEn: 'Ujjain', state: 'मध्य प्रदेश', lat: 23.1765, lng: 75.7885 },
  { id: 'haridwar', name: 'हरिद्वार', nameEn: 'Haridwar', state: 'उत्तराखंड', lat: 29.9457, lng: 78.1642 },
  { id: 'bhopal', name: 'भोपाल', nameEn: 'Bhopal', state: 'मध्य प्रदेश', lat: 23.2599, lng: 77.4126 },
  { id: 'chandigarh', name: 'चंडीगढ़', nameEn: 'Chandigarh', state: 'पंजाब/हरियाणा', lat: 30.7333, lng: 76.7794 },
  { id: 'surat', name: 'सूरत', nameEn: 'Surat', state: 'गुजरात', lat: 21.1702, lng: 72.8311 },
  { id: 'prayograj', name: 'प्रयागराज', nameEn: 'Prayagraj', state: 'उत्तर प्रदेश', lat: 25.4358, lng: 81.8463 },
];

export interface ChoghadiyaMeta {
  name: string;
  nameEn: string;
  type: ChoghadiyaType;
  planet: string;
  nature: 'अति शुभ' | 'शुभ' | 'लाभकारी' | 'सामान्य' | 'अशुभ';
  natureColor: 'emerald' | 'blue' | 'rose' | 'amber';
  description: string;
  suitableFor: string;
}

export const CHOGHADIYA_DEFINITIONS: Record<ChoghadiyaType, ChoghadiyaMeta> = {
  amrit: {
    name: 'अमृत',
    nameEn: 'Amrit',
    type: 'amrit',
    planet: 'चंद्र (Moon)',
    nature: 'अति शुभ',
    natureColor: 'emerald',
    description: 'सर्वोत्तम और अमृतमय मुहूर्त। सभी शुभ और मांगलिक कार्यों के लिए सर्वश्रेष्ठ।',
    suitableFor: 'विवाह, गृह प्रवेश, नवीन कार्य आरंभ, यात्रा, मांगलिक अनुष्ठान',
  },
  shubh: {
    name: 'शुभ',
    nameEn: 'Shubh',
    type: 'shubh',
    planet: 'गुरु (Jupiter)',
    nature: 'शुभ',
    natureColor: 'emerald',
    description: 'सदा फलदायी और पावन मुहूर्त। धार्मिक एवं पारिवारिक कार्यों के लिए अति उत्तम।',
    suitableFor: 'पूजा-पाठ, यज्ञ, नामकरण, मुंडन, विद्यारंभ, विवाह वार्ता',
  },
  labh: {
    name: 'लाभ',
    nameEn: 'Labh',
    type: 'labh',
    planet: 'बुध (Mercury)',
    nature: 'लाभकारी',
    natureColor: 'emerald',
    description: 'धन, व्यापार और उन्नति प्रदान करने वाला चौघड़िया।',
    suitableFor: 'दुकान का उद्घाटन, व्यवसाय आरंभ, क्रय-विक्रय, शिक्षा, लेखा-जोखा',
  },
  char: {
    name: 'चर',
    nameEn: 'Char',
    type: 'char',
    planet: 'शुक्र (Venus)',
    nature: 'सामान्य',
    natureColor: 'blue',
    description: 'चलायमान और गतिशील मुहूर्त। यात्रा और गतिशील कार्यों में सफलता मिलती है।',
    suitableFor: 'यात्रा, वाहन क्रय व चालन, विदेश गमन, स्थानांतरण, मशीनरी कार्य',
  },
  rog: {
    name: 'रोग',
    nameEn: 'Rog',
    type: 'rog',
    planet: 'मंगल (Mars)',
    nature: 'अशुभ',
    natureColor: 'rose',
    description: 'रोग और विघ्न कारक समय। शुभ कार्य करने से परहेज करें।',
    suitableFor: 'केवल कोर्ट-कचहरी, वाद-विवाद निवारण एवं शत्रु दमन के कार्य',
  },
  kaal: {
    name: 'काल',
    nameEn: 'Kaal',
    type: 'kaal',
    planet: 'शनि (Saturn)',
    nature: 'अशुभ',
    natureColor: 'rose',
    description: 'काल और हानि कारक मुहूर्त। इस समय कोई भी नया शुभ कार्य न करें।',
    suitableFor: 'मशीनरी मरम्मत, विश्राम, केवल नियमित अनिवार्य कार्य',
  },
  udveg: {
    name: 'उद्वेग',
    nameEn: 'Udveg',
    type: 'udveg',
    planet: 'सूर्य (Sun)',
    nature: 'अशुभ',
    natureColor: 'amber',
    description: 'चिंता, तनाव और मानसिक अशांति उत्पन्न करने वाला समय।',
    suitableFor: 'सरकारी कार्य, प्रशासनिक औपचारिकताएं, कर भुगतान',
  },
};

// Weekday Day Choghadiya sequence
// 0: Sunday, 1: Monday, 2: Tuesday, 3: Wednesday, 4: Thursday, 5: Friday, 6: Saturday
export const DAY_SEQUENCE: Record<number, ChoghadiyaType[]> = {
  0: ['udveg', 'char', 'labh', 'amrit', 'kaal', 'shubh', 'rog', 'udveg'], // Sunday
  1: ['amrit', 'kaal', 'shubh', 'rog', 'udveg', 'char', 'labh', 'amrit'], // Monday
  2: ['rog', 'udveg', 'char', 'labh', 'amrit', 'kaal', 'shubh', 'rog'], // Tuesday
  3: ['labh', 'amrit', 'kaal', 'shubh', 'rog', 'udveg', 'char', 'labh'], // Wednesday
  4: ['shubh', 'rog', 'udveg', 'char', 'labh', 'amrit', 'kaal', 'shubh'], // Thursday
  5: ['char', 'labh', 'amrit', 'kaal', 'shubh', 'rog', 'udveg', 'char'], // Friday
  6: ['kaal', 'shubh', 'rog', 'udveg', 'char', 'labh', 'amrit', 'kaal'], // Saturday
};

// Weekday Night Choghadiya sequence
export const NIGHT_SEQUENCE: Record<number, ChoghadiyaType[]> = {
  0: ['shubh', 'amrit', 'char', 'rog', 'kaal', 'labh', 'udveg', 'shubh'], // Sunday Night
  1: ['char', 'rog', 'kaal', 'labh', 'udveg', 'shubh', 'amrit', 'char'], // Monday Night
  2: ['kaal', 'labh', 'udveg', 'shubh', 'amrit', 'char', 'rog', 'kaal'], // Tuesday Night
  3: ['udveg', 'shubh', 'amrit', 'char', 'rog', 'kaal', 'labh', 'udveg'], // Wednesday Night
  4: ['amrit', 'char', 'rog', 'kaal', 'labh', 'udveg', 'shubh', 'amrit'], // Thursday Night
  5: ['rog', 'kaal', 'labh', 'udveg', 'shubh', 'amrit', 'char', 'rog'], // Friday Night
  6: ['labh', 'udveg', 'shubh', 'amrit', 'char', 'rog', 'kaal', 'labh'], // Saturday Night
};

// Calculate Solar Times based on Lat/Lng and Date
export function calculateSunTimes(date: Date, lat: number, lng: number): { sunrise: Date; sunset: Date; nextSunrise: Date } {
  // Approximate solar calculation for Indian Standard Time (UTC+5.5)
  const startOfYear = new Date(date.getFullYear(), 0, 1);
  const dayOfYear = Math.floor((date.getTime() - startOfYear.getTime()) / (24 * 60 * 60 * 1000));
  
  // Declination of Sun
  const declination = 23.45 * Math.sin(((284 + dayOfYear) / 365.25) * 2 * Math.PI);
  const latRad = (lat * Math.PI) / 180;
  const decRad = (declination * Math.PI) / 180;
  
  // Hour angle
  const cosHourAngle = -Math.tan(latRad) * Math.tan(decRad);
  const hourAngle = (Math.acos(Math.max(-1, Math.min(1, cosHourAngle))) * 180) / Math.PI;
  
  // Solar noon in IST (longitude correction: 82.5 E is standard meridian for UTC+5.5)
  const timeOffsetMinutes = (82.5 - lng) * 4;
  const equationOfTime = 9.87 * Math.sin(2 * ((dayOfYear - 81) * 2 * Math.PI) / 365) - 7.53 * Math.cos(((dayOfYear - 81) * 2 * Math.PI) / 365) - 1.5 * Math.sin(((dayOfYear - 81) * 2 * Math.PI) / 365);
  
  const solarNoonMinutes = 12 * 60 + timeOffsetMinutes - equationOfTime;
  const halfDayMinutes = (hourAngle / 15) * 60;
  
  const sunriseMinutes = solarNoonMinutes - halfDayMinutes;
  const sunsetMinutes = solarNoonMinutes + halfDayMinutes;
  
  const sunrise = new Date(date);
  sunrise.setHours(Math.floor(sunriseMinutes / 60), Math.floor(sunriseMinutes % 60), 0, 0);
  
  const sunset = new Date(date);
  sunset.setHours(Math.floor(sunsetMinutes / 60), Math.floor(sunsetMinutes % 60), 0, 0);
  
  const nextSunrise = new Date(sunrise);
  nextSunrise.setDate(nextSunrise.getDate() + 1);
  
  return { sunrise, sunset, nextSunrise };
}

export function formatTimeAmPm(date: Date): string {
  let hours = date.getHours();
  const minutes = date.getMinutes();
  const ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12; // 0 should be 12
  const strMinutes = minutes < 10 ? '0' + minutes : minutes;
  const strHours = hours < 10 ? '0' + hours : hours;
  return `${strHours}:${strMinutes} ${ampm}`;
}

export function getChoghadiyaSlots(date: Date, city: CityData): { daySlots: ChoghadiyaSlot[]; nightSlots: ChoghadiyaSlot[]; currentSlot: ChoghadiyaSlot | null } {
  const { sunrise, sunset, nextSunrise } = calculateSunTimes(date, city.lat, city.lng);
  
  const dayDurationMs = sunset.getTime() - sunrise.getTime();
  const slotDayMs = dayDurationMs / 8;
  
  const nightDurationMs = nextSunrise.getTime() - sunset.getTime();
  const slotNightMs = nightDurationMs / 8;
  
  const dayOfWeek = date.getDay(); // 0 is Sunday
  const dayTypes = DAY_SEQUENCE[dayOfWeek];
  const nightTypes = NIGHT_SEQUENCE[dayOfWeek];
  
  const now = new Date();
  const nowMs = now.getTime();
  let currentSlot: ChoghadiyaSlot | null = null;
  
  const daySlots: ChoghadiyaSlot[] = dayTypes.map((type, i) => {
    const slotStart = new Date(sunrise.getTime() + i * slotDayMs);
    const slotEnd = new Date(sunrise.getTime() + (i + 1) * slotDayMs);
    const isCurrent = nowMs >= slotStart.getTime() && nowMs < slotEnd.getTime();
    
    const def = CHOGHADIYA_DEFINITIONS[type];
    const slot: ChoghadiyaSlot = {
      index: i + 1,
      name: def.name,
      nameEn: def.nameEn,
      type: def.type,
      planet: def.planet,
      nature: def.nature,
      natureColor: def.natureColor,
      startTime: formatTimeAmPm(slotStart),
      endTime: formatTimeAmPm(slotEnd),
      isCurrent,
      description: def.description,
      suitableFor: def.suitableFor,
    };
    
    if (isCurrent) currentSlot = slot;
    return slot;
  });
  
  const nightSlots: ChoghadiyaSlot[] = nightTypes.map((type, i) => {
    const slotStart = new Date(sunset.getTime() + i * slotNightMs);
    const slotEnd = new Date(sunset.getTime() + (i + 1) * slotNightMs);
    const isCurrent = nowMs >= slotStart.getTime() && nowMs < slotEnd.getTime();
    
    const def = CHOGHADIYA_DEFINITIONS[type];
    const slot: ChoghadiyaSlot = {
      index: i + 1,
      name: def.name,
      nameEn: def.nameEn,
      type: def.type,
      planet: def.planet,
      nature: def.nature,
      natureColor: def.natureColor,
      startTime: formatTimeAmPm(slotStart),
      endTime: formatTimeAmPm(slotEnd),
      isCurrent,
      description: def.description,
      suitableFor: def.suitableFor,
    };
    
    if (isCurrent) currentSlot = slot;
    return slot;
  });
  
  return { daySlots, nightSlots, currentSlot };
}

export function getPanchangDetails(date: Date, city: CityData): PanchangInfo {
  const { sunrise, sunset } = calculateSunTimes(date, city.lat, city.lng);
  const dayOfWeek = date.getDay();
  
  const daysHindi = ['रविवार', 'सोमवार', 'मंगलवार', 'बुधवार', 'गुरुवार', 'शुक्रवार', 'शनिवार'];
  const daysEn = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  
  // Rahu Kaal slot order by weekday:
  // Sun: 8th, Mon: 2nd, Tue: 7th, Wed: 5th, Thu: 6th, Fri: 4th, Sat: 3rd
  const rahuKaalPart = [8, 2, 7, 5, 6, 4, 3][dayOfWeek];
  const gulikaKaalPart = [7, 6, 5, 4, 3, 2, 1][dayOfWeek];
  const yamagandaPart = [5, 4, 3, 2, 1, 7, 6][dayOfWeek];
  
  const dayMs = sunset.getTime() - sunrise.getTime();
  const partMs = dayMs / 8;
  
  const rahuStart = new Date(sunrise.getTime() + (rahuKaalPart - 1) * partMs);
  const rahuEnd = new Date(sunrise.getTime() + rahuKaalPart * partMs);
  
  const gulikaStart = new Date(sunrise.getTime() + (gulikaKaalPart - 1) * partMs);
  const gulikaEnd = new Date(sunrise.getTime() + gulikaKaalPart * partMs);
  
  const yamaStart = new Date(sunrise.getTime() + (yamagandaPart - 1) * partMs);
  const yamaEnd = new Date(sunrise.getTime() + yamagandaPart * partMs);
  
  // Abhijit Muhurat: approx 24 mins before and after solar noon
  const solarNoonMs = (sunrise.getTime() + sunset.getTime()) / 2;
  const abhijitStart = new Date(solarNoonMs - 24 * 60 * 1000);
  const abhijitEnd = new Date(solarNoonMs + 24 * 60 * 1000);
  
  // Brahma Muhurat: approx 1h 36m to 48m before sunrise
  const brahmaStart = new Date(sunrise.getTime() - 96 * 60 * 1000);
  const brahmaEnd = new Date(sunrise.getTime() - 48 * 60 * 1000);
  
  // Godhuli Muhurat: approx 15 mins before to 15 mins after sunset
  const godhuliStart = new Date(sunset.getTime() - 15 * 60 * 1000);
  const godhuliEnd = new Date(sunset.getTime() + 15 * 60 * 1000);
  
  // Amrit Kaal & Vijay Muhurat
  const vijayStart = new Date(solarNoonMs + 70 * 60 * 1000);
  const vijayEnd = new Date(solarNoonMs + 118 * 60 * 1000);
  
  // Lunar calculations (approx for date)
  const tithis = [
    'प्रतिपदा', 'द्वितीया', 'तृतीया', 'चतुर्थी', 'पंचमी', 'षष्ठी', 'सप्तमी',
    'अष्टमी', 'नवमी', 'दशमी', 'एकादशी', 'द्वादशी', 'त्रयोदशी', 'चतुर्दशी', 'पूर्णिमा / अमावस्या'
  ];
  const nakshatras = [
    'अश्विनी', 'भरणी', 'कृत्तिका', 'रोहिणी', 'मृगशिरा', 'आर्द्रा', 'पुनर्वसु',
    'पुष्य', 'आश्लेषा', 'मघा', 'पूर्वाफाल्गुनी', 'उत्तराफाल्गुनी', 'हस्त', 'चित्रा',
    'स्वाति', 'विशाखा', 'अनुराधा', 'ज्येष्ठा', 'मूल', 'पूर्वाषाढ़ा', 'उत्तराषाढ़ा',
    'श्रवण', 'धनिष्ठा', 'शतभिषा', 'पूर्वाभाद्रपद', 'उत्तराभाद्रपद', 'रेवती'
  ];
  const yogas = [
    'विष्कुम्भ', 'प्रीति', 'आयुष्मान', 'सौभाग्य', 'शोभन', 'अतिगण्ड', 'सुकर्मा',
    'धृति', 'शूल', 'गण्ड', 'वृद्धि', 'ध्रुव', 'व्याघात', 'हर्षण', 'वज्र', 'सिद्धि',
    'व्यतीपात', 'वरीयान्', 'परिघ', 'शिव', 'सिद्ध', 'साध्य', 'शुभ', 'शुक्ल', 'ब्रह्म', 'इन्द्र', 'वैधृति'
  ];
  
  const dayIndex = Math.floor(date.getTime() / (24 * 60 * 60 * 1000)) % 15;
  const nakshatraIndex = Math.floor(date.getTime() / (24 * 60 * 60 * 1000)) % 27;
  const yogaIndex = Math.floor(date.getTime() / (24 * 60 * 60 * 1000)) % 27;
  
  return {
    date: date.toLocaleDateString('hi-IN', { day: 'numeric', month: 'long', year: 'numeric' }),
    dayNameHindi: daysHindi[dayOfWeek],
    dayNameEn: daysEn[dayOfWeek],
    samvat: 'विक्रम संवत 2083 (कालयुक्त)',
    shaka: 'शक संवत 1948',
    ayana: 'दक्षिणायन',
    season: 'शरद ऋतु',
    mas: 'कार्तिक मास',
    paksha: 'शुक्ल पक्ष',
    tithi: `${tithis[Math.abs(dayIndex)]} (उदय व्यापिनी)`,
    nakshatra: `${nakshatras[Math.abs(nakshatraIndex)]}`,
    yoga: `${yogas[Math.abs(yogaIndex)]}`,
    karana: 'बव उपरांत बालव',
    sunrise: formatTimeAmPm(sunrise),
    sunset: formatTimeAmPm(sunset),
    moonrise: formatTimeAmPm(new Date(sunset.getTime() - 45 * 60 * 1000)),
    moonset: formatTimeAmPm(new Date(sunrise.getTime() + 65 * 60 * 1000)),
    rahuKaal: `${formatTimeAmPm(rahuStart)} से ${formatTimeAmPm(rahuEnd)}`,
    gulikaKaal: `${formatTimeAmPm(gulikaStart)} से ${formatTimeAmPm(gulikaEnd)}`,
    yamaganda: `${formatTimeAmPm(yamaStart)} से ${formatTimeAmPm(yamaEnd)}`,
    abhijitMuhurat: `${formatTimeAmPm(abhijitStart)} से ${formatTimeAmPm(abhijitEnd)}`,
    brahmaMuhurat: `${formatTimeAmPm(brahmaStart)} से ${formatTimeAmPm(brahmaEnd)}`,
    amritKaal: `${formatTimeAmPm(new Date(solarNoonMs - 120 * 60 * 1000))} से ${formatTimeAmPm(new Date(solarNoonMs - 40 * 60 * 1000))}`,
    godhuliMuhurat: `${formatTimeAmPm(godhuliStart)} से ${formatTimeAmPm(godhuliEnd)}`,
    vijayMuhurat: `${formatTimeAmPm(vijayStart)} से ${formatTimeAmPm(vijayEnd)}`,
  };
}
