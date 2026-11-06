// Choghadiyas.in — Vedic Astronomical Engine
// Client-side Choghadiya, Panchang, and Rahu Kaal Calculator

(function (window) {
  'use strict';

  var CITIES = [
    { id: 'delhi', name: 'नई दिल्ली', nameEn: 'New Delhi', lat: 28.6139, lng: 77.2090 },
    { id: 'mumbai', name: 'मुंबई', nameEn: 'Mumbai', lat: 19.0760, lng: 72.8777 },
    { id: 'varanasi', name: 'वाराणसी', nameEn: 'Varanasi', lat: 25.3176, lng: 82.9739 },
    { id: 'jaipur', name: 'जयपुर', nameEn: 'Jaipur', lat: 26.9124, lng: 75.7873 },
    { id: 'kolkata', name: 'कोलकाता', nameEn: 'Kolkata', lat: 22.5726, lng: 88.3639 },
    { id: 'bengaluru', name: 'बेंगलुरु', nameEn: 'Bengaluru', lat: 12.9716, lng: 77.5946 },
    { id: 'ahmedabad', name: 'अहमदाबाद', nameEn: 'Ahmedabad', lat: 23.0225, lng: 72.5714 },
    { id: 'patna', name: 'पटना', nameEn: 'Patna', lat: 25.5941, lng: 85.1376 },
    { id: 'lucknow', name: 'लखनऊ', nameEn: 'Lucknow', lat: 26.8467, lng: 80.9462 },
    { id: 'pune', name: 'पुणे', nameEn: 'Pune', lat: 18.5204, lng: 73.8567 },
    { id: 'hyderabad', name: 'हैदराबाद', nameEn: 'Hyderabad', lat: 17.3850, lng: 78.4867 },
    { id: 'ayodhya', name: 'अयोध्या', nameEn: 'Ayodhya', lat: 26.7922, lng: 82.1998 },
    { id: 'ujjain', name: 'उज्जैन', nameEn: 'Ujjain', lat: 23.1765, lng: 75.7885 },
    { id: 'haridwar', name: 'हरिद्वार', nameEn: 'Haridwar', lat: 29.9457, lng: 78.1642 },
    { id: 'bhopal', name: 'भोपाल', nameEn: 'Bhopal', lat: 23.2599, lng: 77.4126 },
    { id: 'chandigarh', name: 'चंडीगढ़', nameEn: 'Chandigarh', lat: 30.7333, lng: 76.7794 },
    { id: 'surat', name: 'सूरत', nameEn: 'Surat', lat: 21.1702, lng: 72.8311 },
    { id: 'prayograj', name: 'प्रयागराज', nameEn: 'Prayagraj', lat: 25.4358, lng: 81.8463 }
  ];

  var CHOGHADIYA_INFO = {
    amrit: { name: 'अमृत', nameEn: 'Amrit', planet: 'चंद्र (Moon)', nature: 'अति शुभ', color: 'emerald', suitableFor: 'सर्वोत्तम, मांगलिक कार्य, यात्रा, विवाह, गृह प्रवेश' },
    shubh: { name: 'शुभ', nameEn: 'Shubh', planet: 'गुरु (Jupiter)', nature: 'शुभ', color: 'emerald', suitableFor: 'धार्मिक कार्य, पूजा, यज्ञ, विद्यारंभ, विवाह वार्ता' },
    labh: { name: 'लाभ', nameEn: 'Labh', planet: 'बुध (Mercury)', nature: 'लाभकारी', color: 'emerald', suitableFor: 'व्यापार आरंभ, धन निवेश, दुकान उद्घाटन, शिक्षा' },
    char: { name: 'चर', nameEn: 'Char', planet: 'शुक्र (Venus)', nature: 'सामान्य शुभ', color: 'blue', suitableFor: 'यात्रा, वाहन क्रय व चालन, गतिशील कार्य, स्थानांतरण' },
    rog: { name: 'रोग', nameEn: 'Rog', planet: 'मंगल (Mars)', nature: 'अशुभ', color: 'rose', suitableFor: 'कलह व रोग कारक; नए कार्य से बचें, केवल वाद-विवाद निवारण' },
    kaal: { name: 'काल', nameEn: 'Kaal', planet: 'शनि (Saturn)', nature: 'अशुभ', color: 'rose', suitableFor: 'हानि व संकट कारक; नए शुभ कार्य न करें, नियमित काम करें' },
    udveg: { name: 'उद्वेग', nameEn: 'Udveg', planet: 'सूर्य (Sun)', nature: 'अशुभ', color: 'amber', suitableFor: 'चिंता व विघ्न कारक; सरकारी कार्यों को छोड़कर अन्य से बचें' }
  };

  var DAY_ORDER = {
    0: ['udveg', 'char', 'labh', 'amrit', 'kaal', 'shubh', 'rog', 'udveg'], // Sunday
    1: ['amrit', 'kaal', 'shubh', 'rog', 'udveg', 'char', 'labh', 'amrit'], // Monday
    2: ['rog', 'udveg', 'char', 'labh', 'amrit', 'kaal', 'shubh', 'rog'], // Tuesday
    3: ['labh', 'amrit', 'kaal', 'shubh', 'rog', 'udveg', 'char', 'labh'], // Wednesday
    4: ['shubh', 'rog', 'udveg', 'char', 'labh', 'amrit', 'kaal', 'shubh'], // Thursday
    5: ['char', 'labh', 'amrit', 'kaal', 'shubh', 'rog', 'udveg', 'char'], // Friday
    6: ['kaal', 'shubh', 'rog', 'udveg', 'char', 'labh', 'amrit', 'kaal']  // Saturday
  };

  var NIGHT_ORDER = {
    0: ['shubh', 'amrit', 'char', 'rog', 'kaal', 'labh', 'udveg', 'shubh'],
    1: ['char', 'rog', 'kaal', 'labh', 'udveg', 'shubh', 'amrit', 'char'],
    2: ['kaal', 'labh', 'udveg', 'shubh', 'amrit', 'char', 'rog', 'kaal'],
    3: ['udveg', 'shubh', 'amrit', 'char', 'rog', 'kaal', 'labh', 'udveg'],
    4: ['amrit', 'char', 'rog', 'kaal', 'labh', 'udveg', 'shubh', 'amrit'],
    5: ['rog', 'kaal', 'labh', 'udveg', 'shubh', 'amrit', 'char', 'rog'],
    6: ['labh', 'udveg', 'shubh', 'amrit', 'char', 'rog', 'kaal', 'labh']
  };

  function calculateSun(date, lat, lng) {
    var startOfYear = new Date(date.getFullYear(), 0, 1);
    var dayOfYear = Math.floor((date.getTime() - startOfYear.getTime()) / (24 * 60 * 60 * 1000));
    var declination = 23.45 * Math.sin(((284 + dayOfYear) / 365.25) * 2 * Math.PI);
    var latRad = (lat * Math.PI) / 180;
    var decRad = (declination * Math.PI) / 180;
    var cosHA = -Math.tan(latRad) * Math.tan(decRad);
    var hourAngle = (Math.acos(Math.max(-1, Math.min(1, cosHA))) * 180) / Math.PI;

    var timeOffsetMinutes = (82.5 - lng) * 4;
    var eqTime = 9.87 * Math.sin(2 * ((dayOfYear - 81) * 2 * Math.PI) / 365) - 7.53 * Math.cos(((dayOfYear - 81) * 2 * Math.PI) / 365) - 1.5 * Math.sin(((dayOfYear - 81) * 2 * Math.PI) / 365);
    var solarNoonMinutes = 12 * 60 + timeOffsetMinutes - eqTime;
    var halfDayMinutes = (hourAngle / 15) * 60;

    var sunriseMin = solarNoonMinutes - halfDayMinutes;
    var sunsetMin = solarNoonMinutes + halfDayMinutes;

    var sunrise = new Date(date);
    sunrise.setHours(Math.floor(sunriseMin / 60), Math.floor(sunriseMin % 60), 0, 0);

    var sunset = new Date(date);
    sunset.setHours(Math.floor(sunsetMin / 60), Math.floor(sunsetMin % 60), 0, 0);

    var nextSunrise = new Date(sunrise);
    nextSunrise.setDate(nextSunrise.getDate() + 1);

    return { sunrise: sunrise, sunset: sunset, nextSunrise: nextSunrise };
  }

  function formatTime(d) {
    var h = d.getHours();
    var m = d.getMinutes();
    var ampm = h >= 12 ? 'PM' : 'AM';
    h = h % 12;
    h = h ? h : 12;
    var strH = h < 10 ? '0' + h : h;
    var strM = m < 10 ? '0' + m : m;
    return strH + ':' + strM + ' ' + ampm;
  }

  function getChoghadiyaData(date, cityId) {
    var city = CITIES.find(function (c) { return c.id === cityId; }) || CITIES[0];
    var sun = calculateSun(date, city.lat, city.lng);
    var dayDuration = sun.sunset.getTime() - sun.sunrise.getTime();
    var slotDayMs = dayDuration / 8;
    var nightDuration = sun.nextSunrise.getTime() - sun.sunset.getTime();
    var slotNightMs = nightDuration / 8;

    var dow = date.getDay();
    var daySeq = DAY_ORDER[dow];
    var nightSeq = NIGHT_ORDER[dow];

    var now = new Date().getTime();
    var currentSlot = null;

    var daySlots = daySeq.map(function (type, i) {
      var s = new Date(sun.sunrise.getTime() + i * slotDayMs);
      var e = new Date(sun.sunrise.getTime() + (i + 1) * slotDayMs);
      var isCur = now >= s.getTime() && now < e.getTime();
      var info = CHOGHADIYA_INFO[type];
      var slot = {
        index: i + 1,
        name: info.name,
        nameEn: info.nameEn,
        type: type,
        planet: info.planet,
        nature: info.nature,
        color: info.color,
        startTime: formatTime(s),
        endTime: formatTime(e),
        isCurrent: isCur,
        suitableFor: info.suitableFor
      };
      if (isCur) currentSlot = slot;
      return slot;
    });

    var nightSlots = nightSeq.map(function (type, i) {
      var s = new Date(sun.sunset.getTime() + i * slotNightMs);
      var e = new Date(sun.sunset.getTime() + (i + 1) * slotNightMs);
      var isCur = now >= s.getTime() && now < e.getTime();
      var info = CHOGHADIYA_INFO[type];
      var slot = {
        index: i + 1,
        name: info.name,
        nameEn: info.nameEn,
        type: type,
        planet: info.planet,
        nature: info.nature,
        color: info.color,
        startTime: formatTime(s),
        endTime: formatTime(e),
        isCurrent: isCur,
        suitableFor: info.suitableFor
      };
      if (isCur) currentSlot = slot;
      return slot;
    });

    // Special Muhurats
    var rahuPart = [8, 2, 7, 5, 6, 4, 3][dow];
    var rahuStart = new Date(sun.sunrise.getTime() + (rahuPart - 1) * slotDayMs);
    var rahuEnd = new Date(sun.sunrise.getTime() + rahuPart * slotDayMs);

    var solarNoon = (sun.sunrise.getTime() + sun.sunset.getTime()) / 2;
    var abhijitStart = new Date(solarNoon - 24 * 60 * 1000);
    var abhijitEnd = new Date(solarNoon + 24 * 60 * 1000);

    return {
      city: city,
      sunrise: formatTime(sun.sunrise),
      sunset: formatTime(sun.sunset),
      daySlots: daySlots,
      nightSlots: nightSlots,
      currentSlot: currentSlot,
      rahuKaal: formatTime(rahuStart) + ' से ' + formatTime(rahuEnd),
      abhijitMuhurat: formatTime(abhijitStart) + ' से ' + formatTime(abhijitEnd)
    };
  }

  window.ChoghadiyaEngine = {
    cities: CITIES,
    getData: getChoghadiyaData
  };
})(window);
