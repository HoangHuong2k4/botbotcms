"use client";

import Image from "next/image";
import Link from "next/link";
import { motion } from "framer-motion";
import { ShoppingCart, Search, Filter } from "lucide-react";

const products = [
  { id: 1, name: "Tài khoản ChatGPT Plus (1 Tháng)", price: "250,000đ", image: "https://upload.wikimedia.org/wikipedia/commons/0/04/ChatGPT_logo.svg", category: "Công cụ" },
  { id: 2, name: "Canva Pro Bản Quyền (1 Năm)", price: "150,000đ", image: "https://upload.wikimedia.org/wikipedia/commons/0/08/Canva_icon_2021.svg", category: "Thiết kế" },
  { id: 3, name: "Netflix Premium 4K (1 Tháng)", price: "80,000đ", image: "https://upload.wikimedia.org/wikipedia/commons/0/0c/Netflix_2015_N_logo.svg", category: "Giải trí" },
  { id: 4, name: "YouTube Premium (6 Tháng)", price: "220,000đ", image: "https://upload.wikimedia.org/wikipedia/commons/0/09/YouTube_full-color_icon_%282017%29.svg", category: "Giải trí" },
  { id: 5, name: "Spotify Premium (1 Năm)", price: "299,000đ", image: "https://upload.wikimedia.org/wikipedia/commons/1/19/Spotify_logo_without_text.svg", category: "Giải trí" },
  { id: 6, name: "Google Drive 100GB (1 Năm)", price: "199,000đ", image: "https://upload.wikimedia.org/wikipedia/commons/1/12/Google_Drive_icon_%282020%29.svg", category: "Công cụ" },
];

export default function Products() {
  return (
    <div className="container mx-auto px-4 py-12">
      <div className="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
          <h1 className="text-3xl font-bold text-slate-900 mb-2">Tất Cả Sản Phẩm</h1>
          <p className="text-slate-400">Khám phá các dịch vụ số premium với giá tốt nhất.</p>
        </div>
        
        <div className="flex items-center gap-3 w-full md:w-auto">
          <div className="relative flex-1 md:w-64">
            <Search className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
            <input 
              type="text" 
              placeholder="Tìm kiếm dịch vụ..." 
              className="w-full bg-slate-50 border border-slate-200 rounded-lg py-2 pl-9 pr-4 text-sm text-slate-900 focus:outline-none focus:border-orange-500 transition-colors"
            />
          </div>
          <button className="p-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-white/10 transition-colors">
            <Filter className="w-5 h-5" />
          </button>
        </div>
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {products.map((p, i) => (
          <motion.div
            key={p.id}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: i * 0.05 }}
            className="group bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:border-orange-500/50 transition-all duration-300"
          >
            <Link href={`/products/${p.id}`}>
              <div className="relative h-48 bg-slate-50 flex items-center justify-center p-6 cursor-pointer">
                <Image src={p.image} alt={p.name} width={80} height={80} className="group-hover:scale-110 transition-transform duration-500 drop-shadow-2xl" />
              </div>
            </Link>
            <div className="p-5">
              <span className="text-xs font-medium text-blue-600 mb-2 block">{p.category}</span>
              <Link href={`/products/${p.id}`}>
                <h3 className="font-semibold text-slate-900 mb-2 line-clamp-2 hover:text-blue-600 transition-colors cursor-pointer">{p.name}</h3>
              </Link>
              <div className="flex items-center justify-between mt-4">
                <span className="text-xl font-bold text-slate-900">{p.price}</span>
                <button className="p-2 bg-orange-500/10 text-blue-600 hover:bg-orange-500 hover:text-slate-900 rounded-lg transition-colors">
                  <ShoppingCart className="w-5 h-5" />
                </button>
              </div>
            </div>
          </motion.div>
        ))}
      </div>
    </div>
  );
}
