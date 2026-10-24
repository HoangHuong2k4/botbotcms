"use client";

import { useState } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { MessageCircle, Phone, Send, X, Globe, Mail } from "lucide-react";

export default function FloatingContact() {
  const [isOpen, setIsOpen] = useState(false);

  const CONTACTS = [
    { name: "Zalo Hỗ Trợ", icon: Phone, color: "bg-blue-500", url: "#" },
    { name: "Telegram Group", icon: Send, color: "bg-sky-500", url: "#" },
    { name: "Fanpage Facebook", icon: Globe, color: "bg-blue-600", url: "#" },
    { name: "Email Admin", icon: Mail, color: "bg-orange-500", url: "#" }
  ];

  return (
    <div className="fixed bottom-6 right-6 z-50 flex flex-col items-end">
      <AnimatePresence>
        {isOpen && (
          <motion.div
            initial={{ opacity: 0, y: 20, scale: 0.9 }}
            animate={{ opacity: 1, y: 0, scale: 1 }}
            exit={{ opacity: 0, y: 20, scale: 0.9 }}
            className="mb-4 bg-white rounded-2xl shadow-2xl border border-slate-100 w-64 overflow-hidden origin-bottom-right"
          >
            <div className="bg-gradient-to-r from-orange-500 to-blue-600 p-4 text-white">
              <h3 className="font-bold text-lg">Cần hỗ trợ?</h3>
              <p className="text-xs opacity-90">Chúng tôi luôn online 24/7 để giúp bạn.</p>
            </div>
            
            <div className="p-2">
              {CONTACTS.map((contact, i) => (
                <a 
                  key={i} 
                  href={contact.url}
                  className="flex items-center gap-3 p-3 hover:bg-slate-50 rounded-xl transition-colors group"
                >
                  <div className={`w-10 h-10 ${contact.color} rounded-full flex items-center justify-center text-white shadow-sm group-hover:scale-110 transition-transform`}>
                    <contact.icon className="w-5 h-5" />
                  </div>
                  <span className="font-bold text-slate-700 group-hover:text-blue-600 transition-colors text-sm">{contact.name}</span>
                </a>
              ))}
            </div>
          </motion.div>
        )}
      </AnimatePresence>

      <button
        onClick={() => setIsOpen(!isOpen)}
        className="w-14 h-14 bg-gradient-to-tr from-orange-500 to-blue-600 text-white rounded-full flex items-center justify-center shadow-lg hover:shadow-orange-500/50 hover:scale-110 transition-all duration-300 relative group"
      >
        {/* Pulsing ring */}
        <span className="absolute inset-0 rounded-full bg-orange-500 opacity-50 animate-ping group-hover:hidden" />
        
        {isOpen ? <X className="w-6 h-6 relative z-10" /> : <MessageCircle className="w-6 h-6 relative z-10" />}
      </button>
    </div>
  );
}
