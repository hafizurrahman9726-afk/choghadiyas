import React, { useId } from 'react';
import { X, ShieldCheck, Mail, MapPin, Phone, Award, CheckCircle2 } from 'lucide-react';
import { AUTHOR_SHIV_KUMAR } from '../data/articles';

interface StaticPagesModalProps {
  type: 'about' | 'contact' | 'privacy-policy' | 'disclaimer' | 'terms' | 'editorial-policy' | null;
  onClose: () => void;
}

export const StaticPagesModal: React.FC<StaticPagesModalProps> = ({ type, onClose }) => {
  const contactNameId = useId();
  const contactEmailId = useId();
  const contactSubjectId = useId();
  const contactMessageId = useId();

  if (!type) return null;

  return (
    <div className="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6 animate-in fade-in">
      <div className="bg-white w-full max-w-3xl rounded-3xl shadow-2xl border border-[#DFE6EF] max-h-[85vh] flex flex-col overflow-hidden">
        {/* Header */}
        <div className="p-5 sm:p-6 border-b border-[#DFE6EF] flex items-center justify-between bg-[#F8FAFC]">
          <div>
            <span className="text-[10px] font-extrabold uppercase tracking-wider text-[#FF7000]">
              Choghadiyas.in
            </span>
            <h3 className="text-xl font-black text-[#0A1629]">
              {type === 'about' && 'About Us — हमारे बारे में'}
              {type === 'contact' && 'Contact Us — संपर्क करें'}
              {type === 'privacy-policy' && 'Privacy Policy — गोपनीयता नीति'}
              {type === 'disclaimer' && 'Disclaimer — अस्वीकरण'}
              {type === 'terms' && 'Terms and Conditions — नियम व शर्तें'}
              {type === 'editorial-policy' && 'Editorial Policy — संपादकीय नीति'}
            </h3>
          </div>
          <button
            onClick={onClose}
            className="w-9 h-9 rounded-full bg-white border border-[#DFE6EF] hover:bg-slate-100 flex items-center justify-center text-slate-600 transition-colors cursor-pointer"
          >
            <X className="w-5 h-5" />
          </button>
        </div>

        {/* Content */}
        <div className="p-6 sm:p-8 overflow-y-auto space-y-4 text-xs sm:text-sm text-[#0A1629] leading-relaxed">
          {type === 'about' && (
            <div className="space-y-4">
              <div className="flex items-center gap-4 p-4 rounded-2xl bg-orange-50 border border-orange-200">
                <img
                  src={AUTHOR_SHIV_KUMAR.image}
                  alt={AUTHOR_SHIV_KUMAR.name}
                  className="w-16 h-16 rounded-full object-cover border-2 border-[#FF7000]"
                />
                <div>
                  <h4 className="text-base font-extrabold text-[#0A1629]">{AUTHOR_SHIV_KUMAR.name}</h4>
                  <p className="text-xs font-semibold text-[#FF7000]">{AUTHOR_SHIV_KUMAR.role}</p>
                  <p className="text-xs text-[#64748B] mt-1">18+ वर्षों का ज्योतिषीय एवं पंचांग शोध अनुभव</p>
                </div>
              </div>

              <h4 className="text-base font-bold text-[#0A1629]">हमारा लक्ष्य (Our Mission)</h4>
              <p>
                <strong>Choghadiyas.in</strong> का निर्माण सनातन धर्म की अमूल्य काल-गणना धरोहर को प्रत्येक व्यक्ति तक सुलभ, वैज्ञानिक और 100% निःशुल्क पहुंचाने के पावन उद्देश्य से किया गया है।
              </p>
              <p>
                हमारा मंच सूर्योदय और सूर्यास्त के वास्तविक खगोलीय सिद्धांतों पर आधारित आठ-आठ प्रहर के दिन व रात के चौघड़िया, राहुकाल, यमगंड, अभिजित मुहूर्त और दैनिक पंचांग (तिथि, नक्षत्र, योग, करण) की सटीक गणना उपलब्ध कराता है।
              </p>

              <h4 className="text-base font-bold text-[#0A1629] pt-2">हमारी विशेषताएँ</h4>
              <ul className="list-disc pl-5 space-y-1 text-[#64748B]">
                <li>100% निःशुल्क एवं खुली जानकारी (No Hidden Subscriptions)</li>
                <li>भारत के 20+ प्रमुख नगरों के लिए स्थानीय सूर्योदय-सूर्यास्त आधारित गणना</li>
                <li>प्रमाणिक वैदिक स्रोतों और पंचांगों द्वारा परीक्षित लेख व मार्गदर्शिका</li>
                <li>विवाह, गृह प्रवेश, वाहन खरीद और पूजन विधि पर अनुभवी ज्योतिषाचार्यों का मार्गदर्शन</li>
              </ul>
            </div>
          )}

          {type === 'contact' && (
            <div className="space-y-4">
              <p className="text-[#64748B]">
                यदि आपके पास चौघड़िया गणना, पंचांग अथवा किसी लेख से संबंधित कोई प्रश्न, सुझाव या प्रतिक्रिया है, तो कृपया नीचे दिए गए माध्यमों से हमसे संपर्क करें:
              </p>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 my-4">
                <div className="p-4 rounded-2xl bg-[#F8FAFC] border border-[#DFE6EF] flex items-center gap-3">
                  <Mail className="w-5 h-5 text-[#FF7000]" />
                  <div>
                    <span className="text-[11px] text-[#64748B] block font-medium">ईमेल (Email)</span>
                    <strong className="text-xs text-[#0A1629]">contact@choghadiyas.in</strong>
                  </div>
                </div>
                <div className="p-4 rounded-2xl bg-[#F8FAFC] border border-[#DFE6EF] flex items-center gap-3">
                  <MapPin className="w-5 h-5 text-[#FF7000]" />
                  <div>
                    <span className="text-[11px] text-[#64748B] block font-medium">मुख्यालय (Location)</span>
                    <strong className="text-xs text-[#0A1629]">वाराणसी / नई दिल्ली, भारत</strong>
                  </div>
                </div>
              </div>

              <form
                onSubmit={(e) => {
                  e.preventDefault();
                  alert('धन्यवाद! आपका संदेश सफलतापूर्वक भेज दिया गया है। हम शीघ्र ही आपसे संपर्क करेंगे।');
                  onClose();
                }}
                className="space-y-3 pt-2"
              >
                <div>
                  <label htmlFor={contactNameId} className="block text-xs font-bold text-[#0A1629] mb-1">आपका नाम</label>
                  <input
                    id={contactNameId}
                    type="text"
                    required
                    placeholder="अपना पूरा नाम दर्ज करें"
                    className="w-full p-2.5 rounded-xl border border-[#DFE6EF] text-xs outline-none focus:border-[#FF7000]"
                  />
                </div>
                <div>
                  <label htmlFor={contactEmailId} className="block text-xs font-bold text-[#0A1629] mb-1">ईमेल पता</label>
                  <input
                    id={contactEmailId}
                    type="email"
                    required
                    placeholder="name@example.com"
                    className="w-full p-2.5 rounded-xl border border-[#DFE6EF] text-xs outline-none focus:border-[#FF7000]"
                  />
                </div>
                <div>
                  <label htmlFor={contactSubjectId} className="block text-xs font-bold text-[#0A1629] mb-1">विषय</label>
                  <input
                    id={contactSubjectId}
                    type="text"
                    placeholder="मुहूर्त / पंचांग / सामान्य प्रश्न"
                    className="w-full p-2.5 rounded-xl border border-[#DFE6EF] text-xs outline-none focus:border-[#FF7000]"
                  />
                </div>
                <div>
                  <label htmlFor={contactMessageId} className="block text-xs font-bold text-[#0A1629] mb-1">संदेश</label>
                  <textarea
                    id={contactMessageId}
                    rows={3}
                    required
                    placeholder="अपना संदेश यहाँ लिखें..."
                    className="w-full p-2.5 rounded-xl border border-[#DFE6EF] text-xs outline-none focus:border-[#FF7000]"
                  />
                </div>
                <button
                  type="submit"
                  className="w-full py-2.5 rounded-xl bg-[#FF7000] text-white font-bold text-xs hover:bg-[#E65100] transition-colors cursor-pointer shadow-sm"
                >
                  संदेश भेजें (Send Message)
                </button>
              </form>
            </div>
          )}

          {type === 'privacy-policy' && (
            <div className="space-y-3">
              <h4 className="text-sm font-bold text-[#0A1629]">गोपनीयता नीति (Privacy Policy)</h4>
              <p>
                Choghadiyas.in पर हम अपने आगंतुकों की गोपनीयता का पूरा सम्मान करते हैं। यह दस्तावेज़ स्पष्ट करता है कि हमारी वेबसाइट पर किस प्रकार की जानकारी एकत्रित की जाती है और उसका उपयोग कैसे होता है।
              </p>
              <h5 className="font-bold text-[#0A1629]">लॉग फाइल्स एवं कुकीज़</h5>
              <p>
                अधिकांश मानक वेबसाइटों की तरह, हम इंटरनेट प्रोटोकॉल (IP) पते, ब्राउज़र का प्रकार, विज़िट किए गए पृष्ठ और विज़िट का समय एकत्रित कर सकते हैं ताकि वेबसाइट के प्रदर्शन को बेहतर बनाया जा सके।
              </p>
              <h5 className="font-bold text-[#0A1629]">तृतीय-पक्ष विज्ञापन (Google AdSense)</h5>
              <p>
                हम विज्ञापन प्रदर्शित करने के लिए Google AdSense जैसे तृतीय-पक्ष विज्ञापनदाताओं का उपयोग कर सकते हैं। ये नेटवर्क उपयोगकर्ताओं की रुचि के अनुसार विज्ञापन दिखाने के लिए कुकीज़ का उपयोग कर सकते हैं।
              </p>
            </div>
          )}

          {type === 'disclaimer' && (
            <div className="space-y-3">
              <h4 className="text-sm font-bold text-[#0A1629]">अस्वीकरण (Disclaimer)</h4>
              <p>
                Choghadiyas.in पर प्रदान की जाने वाली सभी चौघड़िया गणनाएं, पंचांग विवरण, शुभ मुहूर्त और ज्योतिषीय लेख शास्त्रीय एवं खगोलीय सूत्रों पर आधारित हैं और केवल सामान्य ज्ञान, धार्मिक मार्गदर्शन एवं संदर्भ के उद्देश्य से प्रस्तुत किए गए हैं।
              </p>
              <p>
                विवाह, गृह प्रवेश अथवा बड़े व्यावसायिक निर्णयों के लिए अपने स्थानीय कुलगुरु अथवा व्यक्तिगत ज्योतिषाचार्य से अपनी जन्मकुंडली का परीक्षण कराना सदैव उत्तम रहता है।
              </p>
            </div>
          )}

          {type === 'terms' && (
            <div className="space-y-3">
              <h4 className="text-sm font-bold text-[#0A1629]">नियम व शर्तें (Terms & Conditions)</h4>
              <p>
                इस वेबसाइट का उपयोग करके आप हमारी नियमों और शर्तों से सहमत होते हैं। इस वेबसाइट पर प्रकाशित सभी लेख, सामग्री, डेटा और गणनाएं Choghadiyas.in की बौद्धिक संपदा हैं और बिना पूर्व लिखित अनुमति के व्यावसायिक रूप से इनका पुनरुत्पादन निषिद्ध है।
              </p>
            </div>
          )}

          {type === 'editorial-policy' && (
            <div className="space-y-3">
              <h4 className="text-sm font-bold text-[#0A1629]">संपादकीय नीति (Editorial Policy)</h4>
              <p>
                Choghadiyas.in की सामग्री प्रमाणिक सनातन ग्रंथों (जैसे नारद संहिता, मुहूर्त चिंतामणि, निर्णय सिंधु, सूर्य सिद्धांत) और आधुनिक खगोलीय गणनाओं के सामंजस्य से तैयार की जाती है। प्रत्येक लेख विशेषज्ञ समीक्षकों द्वारा सत्यापित किए जाने के उपरांत ही प्रकाशित किया जाता है।
              </p>
            </div>
          )}
        </div>

        {/* Footer */}
        <div className="p-4 border-t border-[#DFE6EF] bg-[#F8FAFC] text-right">
          <button
            onClick={onClose}
            className="px-5 py-2 rounded-xl bg-[#0A1629] text-white font-bold text-xs hover:bg-[#FF7000] transition-colors cursor-pointer"
          >
            बंद करें (Close)
          </button>
        </div>
      </div>
    </div>
  );
};
