import React, { useState } from 'react';
import { ChevronDown, HelpCircle } from 'lucide-react';

interface FaqItem {
  q: string;
  a: string;
}

export const FaqSection: React.FC = () => {
  const [openIndex, setOpenIndex] = useState<number | null>(0); // first open by default

  const faqs: FaqItem[] = [
    {
      q: 'चौघड़िया क्या है?',
      a: 'चौघड़िया प्राचीन भारतीय वैदिक ज्योतिष की एक काल-गणना पद्धति है। इसमें सूर्योदय से सूर्यास्त तक (दिन) और सूर्यास्त से अगले सूर्योदय तक (रात) के समय को 8-8 बराबर भागों (लगभग 1.5 घंटे प्रति पहर) में बांटा जाता है। यह सात प्रकार का होता है: अमृत, शुभ, लाभ, चर, रोग, काल और उद्वेग।',
    },
    {
      q: 'आज का चौघड़िया कैसे देखें?',
      a: 'आज का चौघड़िया देखने के लिए Choghadiyas.in के शीर्ष टूल में अपना शहर चुनें। दिन के समय के लिए "दिन का चौघड़िया" और रात के समय के लिए "रात का चौघड़िया" टैब पर क्लिक करें। तालिका में वर्तमान समय के अनुसार सक्रिय चौघड़िया को "NOW" अथवा हाइलाइटेड रंग में देख सकते हैं।',
    },
    {
      q: 'दिन और रात के चौघड़िया में क्या अंतर है?',
      a: 'दिन का चौघड़िया सूर्योदय से आरंभ होता है और उस दिन के वार के स्वामी ग्रह से शुरू होता है (जैसे रविवार को सूर्य का उद्वेग)। रात का चौघड़िया सूर्यास्त से आरंभ होता है और उस दिन के पांचवें चौघड़िया के स्वामी ग्रह से शुरू होता है (जैसे रविवार रात को शुभ चौघड़िया से शुरुआत होती है)।',
    },
    {
      q: 'पंचांग के पाँच अंग कौन-कौन से हैं?',
      a: 'पंचांग के पाँच प्रमुख अंग हैं: 1. तिथि (चंद्रमा और सूर्य का कोणीय अंतर), 2. वार (दिन का नाम), 3. नक्षत्र (चंद्रमा का नक्षत्र), 4. योग (सूर्य-चंद्र का संयुक्त भोगांश), और 5. करण (एक तिथि का आधा भाग)। इन पांचों के संतुलन से किसी भी क्षण की शुभता तय होती है।',
    },
    {
      q: 'राहुकाल क्या होता है?',
      a: 'राहुकाल प्रत्येक दिन लगभग 90 मिनट की वह अवधि है जिसमें राहु ग्रह का प्रभाव सर्वाधिक होता है। इस समय कोई भी नया शुभ कार्य, पूजा, निवेश या यात्रा प्रारंभ करना अशुभ माना जाता है। पहले से चल रहे नियमित कार्य किए जा सकते हैं।',
    },
    {
      q: 'शुभ मुहूर्त कैसे देखें?',
      a: 'किसी भी कार्य के लिए शुभ मुहूर्त देखते समय चौघड़िया में "अमृत", "शुभ" या "लाभ" मुहूर्त चुनें और सुनिश्चित करें कि उस समय राहुकाल या भद्रा न हो। दिन में दोपहर लगभग 12 बजे के आसपास आने वाला "अभिजित मुहूर्त" भी अत्यंत शुभ और दोषमुक्त माना जाता है।',
    },
    {
      q: 'शहर बदलने से चौघड़िया का समय क्यों बदलता है?',
      a: 'चौघड़िया का समय पूरी तरह से स्थानीय सूर्योदय (Sunrise) और सूर्यास्त (Sunset) पर निर्भर करता है। भारत के अलग-अलग शहरों के अक्षांश और देशांतर भिन्न होने के कारण सूर्योदय के समय में कई मिनटों का अंतर होता है, इसलिए शहर बदलने से चौघड़िया का समय बदल जाता है।',
    },
    {
      q: 'व्रत और त्योहार की जानकारी कहाँ मिलेगी?',
      a: 'Choghadiyas.in के मुख्य मेनू में "व्रत और त्योहार" श्रेणी पर क्लिक करके आप एकादशी, प्रदोष, महाशिवरात्रि, नवरात्रि, करवा चौथ, छठ पूजा, दीपावली आदि सभी प्रमुख व्रतों की सही तिथि, मुहूर्त और पूजा विधि पढ़ सकते हैं।',
    },
  ];

  const toggleFaq = (index: number) => {
    setOpenIndex(openIndex === index ? null : index);
  };

  return (
    <section className="my-12 max-w-[1360px] mx-auto px-4 sm:px-6">
      <div className="bg-white rounded-3xl border border-[#DFE6EF] shadow-[0_4px_24px_rgba(10,22,41,0.04)] p-6 sm:p-10">
        <div className="text-center max-w-2xl mx-auto mb-8">
          <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-50 text-[#FF7000] text-xs font-bold mb-2 border border-orange-100">
            <HelpCircle className="w-3.5 h-3.5" />
            <span>अक्सर पूछे जाने वाले प्रश्न</span>
          </div>
          <h2 className="text-2xl sm:text-3xl font-extrabold text-[#0A1629] tracking-tight">
            चौघड़िया और पंचांग से जुड़े सामान्य प्रश्न (FAQ)
          </h2>
          <p className="mt-2 text-xs sm:text-sm text-[#64748B]">
            चौघड़िया मुहूर्त, राहुकाल और पंचांग की गणना से संबंधित आपके सभी प्रश्नों के प्रामाणिक उत्तर।
          </p>
        </div>

        {/* Accordion Cards (Screenshot 3 Style) */}
        <div className="space-y-3 max-w-3xl mx-auto">
          {faqs.map((faq, index) => {
            const isOpen = openIndex === index;
            return (
              <div
                key={index}
                className="rounded-2xl border border-[#DFE6EF] overflow-hidden transition-all duration-200 bg-white hover:border-slate-300"
              >
                <button
                  onClick={() => toggleFaq(index)}
                  className="w-full flex items-center justify-between p-4 sm:p-5 text-left cursor-pointer transition-colors"
                >
                  <span className="text-sm sm:text-base font-bold text-[#0A1629] pr-4">
                    {faq.q}
                  </span>
                  <div
                    className={`w-7 h-7 rounded-full flex items-center justify-center shrink-0 transition-all ${
                      isOpen
                        ? 'bg-[#FF7000] text-white rotate-180'
                        : 'bg-slate-100 text-slate-600'
                    }`}
                  >
                    <ChevronDown className="w-4 h-4" />
                  </div>
                </button>

                {isOpen && (
                  <div className="px-4 sm:px-5 pb-5 text-xs sm:text-sm text-[#64748B] leading-relaxed border-t border-[#DFE6EF]/60 pt-3 animate-in fade-in duration-200">
                    {faq.a}
                  </div>
                )}
              </div>
            );
          })}
        </div>
      </div>
    </section>
  );
};
