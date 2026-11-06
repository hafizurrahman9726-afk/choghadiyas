export interface Article {
  id: number;
  slug: string;
  url?: string;
  title: string;
  excerpt: string;
  content?: string;
  category: string;
  categorySlug: string;
  author: string;
  authorRole?: string;
  authorBio?: string;
  authorImage?: string;
  publishDate: string;
  formattedDate: string;
  readingTime?: string;
  featuredImage: string;
  imageAlt?: string;
  isFeatured?: boolean;
  isTrending?: boolean;
  tags?: string[];
  tableOfContents?: { id: string; title: string; level: number }[];
}

export type ChoghadiyaType = 'amrit' | 'shubh' | 'labh' | 'char' | 'rog' | 'kaal' | 'udveg';

export interface ChoghadiyaSlot {
  index: number;
  name: string;
  nameEn: string;
  type: ChoghadiyaType;
  planet: string;
  nature: 'अति शुभ' | 'शुभ' | 'लाभकारी' | 'सामान्य' | 'अशुभ';
  natureColor: 'emerald' | 'blue' | 'rose' | 'amber';
  startTime: string;
  endTime: string;
  isCurrent: boolean;
  description: string;
  suitableFor: string;
}

export interface CityData {
  id: string;
  name: string;
  nameEn: string;
  state: string;
  lat: number;
  lng: number;
}

export interface PanchangInfo {
  date: string;
  dayNameHindi: string;
  dayNameEn: string;
  samvat: string;
  shaka: string;
  ayana: string;
  season: string;
  mas: string;
  paksha: string;
  tithi: string;
  nakshatra: string;
  yoga: string;
  karana: string;
  sunrise: string;
  sunset: string;
  moonrise: string;
  moonset: string;
  rahuKaal: string;
  gulikaKaal: string;
  yamaganda: string;
  abhijitMuhurat: string;
  brahmaMuhurat: string;
  amritKaal: string;
  godhuliMuhurat: string;
  vijayMuhurat: string;
}
