import React, { useState } from 'react';
import { HelpCircle } from 'lucide-react';

interface FaqItem {
  q: string;
  a: string;
}

export const FaqSection: React.FC = () => {
  const [openIndex, setOpenIndex] = useState<number | null>(0); // First open by default

  const faqs: FaqItem[] = [
    {
      q: 'चौघड़िया क्या है और इसका क्या महत्व है?',
      a: 'चौघड़िया हिंदू पंचांग में समय के विभाजन की एक पारंपरिक पद्धति है। इसमें दिन और रात को अलग-अलग आठ भागों में बाँटा जाता है। प्रत्येक भाग का संबंध शुभ, लाभ, अमृत, चर, रोग, काल या उद्वेग जैसे चौघड़िया से होता है। लोग परंपरागत मान्यताओं के अनुसार नए कार्यों की शुरुआत के लिए अनुकूल समय देखने में इसका उपयोग करते हैं।',
    },
    {
      q: 'दिन और रात के चौघड़िया में क्या अंतर होता है?',
      a: 'दिन का चौघड़िया सामान्यतः सूर्योदय से सूर्यास्त तक और रात का चौघड़िया सूर्यास्त से अगले सूर्योदय तक निर्धारित किया जाता है। दोनों की गणना स्थानीय सूर्योदय और सूर्यास्त के समय पर निर्भर करती है। इसलिए अलग-अलग शहरों और मौसमों में चौघड़िया की अवधि बदल सकती है।',
    },
    {
      q: 'राहुकाल में कौन से कार्य नहीं करने चाहिए?',
      a: 'पारंपरिक ज्योतिषीय मान्यताओं के अनुसार राहुकाल में विवाह, गृह प्रवेश, नया व्यवसाय शुरू करना और कुछ अन्य मांगलिक कार्य आरंभ करने से बचने की सलाह दी जाती है। हालांकि पहले से चल रहे आवश्यक या दैनिक कार्यों के संबंध में परंपराएँ अलग हो सकती हैं।',
    },
    {
      q: 'अभिजीत मुहूर्त का क्या महत्व है?',
      a: 'अभिजीत मुहूर्त दिन के मध्य भाग के आसपास आने वाला एक पारंपरिक शुभ समय माना जाता है। कुछ धार्मिक परंपराओं में इसे महत्वपूर्ण कार्यों की शुरुआत के लिए अनुकूल माना जाता है। इसका सटीक समय स्थानीय सूर्योदय और सूर्यास्त तथा पंचांग गणना के अनुसार निर्धारित किया जाता है।',
    },
    {
      q: 'पंचांग के पाँच अंग कौन-कौन से हैं?',
      a: 'हिंदू पंचांग के पाँच प्रमुख अंग तिथि, वार, नक्षत्र, योग और करण हैं। इनका उपयोग धार्मिक पर्वों, व्रतों और पारंपरिक मुहूर्त गणना में किया जाता है। पंचांग की जानकारी स्थान और गणना-पद्धति के अनुसार भिन्न हो सकती है।',
    },
    {
      q: 'व्रत और त्योहारों की सही तिथि कैसे पता करें?',
      a: 'व्रत और त्योहारों की तिथि जानने के लिए संबंधित तिथि का आरंभ और समाप्ति समय, सूर्योदय, स्थानीय पंचांग तथा उस पर्व के विशेष नियम देखे जाते हैं। कुछ पर्वों में प्रदोषकाल, चंद्रोदय या अन्य निर्धारित समय का विशेष महत्व होता है।',
    },
    {
      q: 'पूजा विधि और सामग्री की जानकारी कहाँ मिलेगी?',
      a: 'Choghadiyas.in की पूजा विधि और सामग्री श्रेणी में विभिन्न धार्मिक अनुष्ठानों से संबंधित पूजा की सामान्य प्रक्रिया, आवश्यक सामग्री और पारंपरिक जानकारी पढ़ी जा सकती है। स्थानीय रीति-रिवाज और पारिवारिक परंपराएँ अलग हो सकती हैं।',
    },
  ];

  const toggleFaq = (index: number) => {
    setOpenIndex(openIndex === index ? null : index);
  };

  return (
    <section className="my-10 max-w-[1100px] mx-auto px-4 sm:px-6" aria-label="अक्सर पूछे जाने वाले प्रश्न">
      <div className="bg-white rounded-3xl border border-[#E2E8F0] shadow-[0_4px_24px_rgba(10,22,41,0.04)] p-6 sm:p-10">
        <div className="text-center max-w-2xl mx-auto mb-8">
          <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-50 text-[#FF7000] text-xs font-bold mb-2 border border-orange-100">
            <HelpCircle className="w-3.5 h-3.5" />
            <span>सहायक मार्गदर्शन</span>
          </div>
          <h2 className="text-2xl sm:text-3xl font-extrabold text-[#0A1629] tracking-tight">
            चौघड़िया एवं पंचांग से जुड़े मुख्य प्रश्न
          </h2>
          <p className="mt-2 text-xs sm:text-sm text-[#64748B]">
            मुहूर्त गणना, पंचांग देखने के नियम और दैनिक उपयोग से जुड़े महत्वपूर्ण प्रश्नों के प्रामाणिक उत्तर।
          </p>
        </div>

        {/* 7 Accordion Cards with Clean Typography and Saffron Accents */}
        <div className="space-y-3 max-w-3xl mx-auto">
          {faqs.map((faq, index) => {
            const isOpen = openIndex === index;
            return (
              <div
                key={index}
                className={`rounded-2xl border transition-all duration-200 bg-white ${
                  isOpen
                    ? 'border-[#FDBA74] shadow-[0_4px_16px_rgba(255,112,0,0.07)]'
                    : 'border-[#E2E8F0] hover:border-slate-300'
                }`}
              >
                <button
                  type="button"
                  onClick={() => toggleFaq(index)}
                  aria-expanded={isOpen}
                  className="w-full flex items-center justify-between p-4 sm:p-5 text-left cursor-pointer transition-colors outline-none focus:outline-none select-none"
                  style={{ WebkitTapHighlightColor: 'transparent' }}
                >
                  <span className="text-sm sm:text-base font-bold text-[#0A1629] pr-4 leading-snug">
                    {faq.q}
                  </span>
                  <div
                    className={`w-7 h-7 rounded-full flex items-center justify-center shrink-0 transition-all ${
                      isOpen
                        ? 'bg-[#FF7000] text-white rotate-90'
                        : 'bg-slate-100 text-slate-600'
                    }`}
                  >
                    <svg
                      width="16"
                      height="16"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      strokeWidth="2.5"
                      strokeLinecap="round"
                      strokeLinejoin="round"
                    >
                      {!isOpen && <line x1="12" y1="5" x2="12" y2="19"></line>}
                      <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                  </div>
                </button>

                {isOpen && (
                  <div className="px-4 sm:px-5 pb-5 text-xs sm:text-sm text-[#475569] leading-relaxed border-t border-slate-100 pt-3">
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
