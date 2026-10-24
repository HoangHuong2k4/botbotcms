"use client";

import { motion } from "framer-motion";
import { ShoppingBag } from "lucide-react";

const RECENT_PURCHASES = [
  "Nguyễn V*** vừa mua Tài khoản ChatGPT Plus (1 Tháng)",
  "Trần T*** vừa mua Netflix Premium 4K",
  "Lê H*** vừa mua Canva Pro (1 Năm)",
  "Phạm D*** vừa mua Spotify Premium (3 Tháng)",
  "Hoàng M*** vừa mua Tài khoản ChatGPT Plus (1 Tháng)",
];

export default function RecentPurchasesTicker() {
  return (
    <div className="bg-gradient-to-r from-orange-500 to-blue-600 text-white py-2 overflow-hidden flex items-center shadow-md z-40 relative">
      <div className="container mx-auto px-4 flex items-center relative">
        <div className="flex-shrink-0 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold mr-4 z-10 flex items-center gap-1.5 shadow-sm border border-white/30">
          <ShoppingBag className="w-3.5 h-3.5" /> Mới Nhất
        </div>
        
        {/* Ticker Animation */}
        <div className="flex-1 overflow-hidden relative mask-image-gradient">
          <motion.div
            className="flex whitespace-nowrap gap-12"
            animate={{ x: ["0%", "-50%"] }}
            transition={{ repeat: Infinity, ease: "linear", duration: 25 }}
          >
            {/* We duplicate the array to make the infinite loop seamless */}
            {[...RECENT_PURCHASES, ...RECENT_PURCHASES].map((text, i) => (
              <div key={i} className="text-sm font-medium flex items-center gap-2">
                <span className="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse" />
                {text}
              </div>
            ))}
          </motion.div>
        </div>
      </div>
      
      <style dangerouslySetInnerHTML={{__html: `
        .mask-image-gradient {
          mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
          -webkit-mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
        }
      `}} />
    </div>
  );
}
