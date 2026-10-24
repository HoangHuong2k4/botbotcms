"use client";

import { useState } from "react";
import Image from "next/image";
import Link from "next/link";
import { motion } from "framer-motion";
import { ArrowRight, Star, Shield, Zap, CheckCircle2, ChevronRight, ShoppingCart } from "lucide-react";
import { toast } from "sonner";
import QuickBuyModal from "@/components/QuickBuyModal";

// Fake Data for UI showcase
const products = [
  { id: 1, name: "Tài khoản ChatGPT Plus (1 Tháng)", price: "250,000đ", image: "https://upload.wikimedia.org/wikipedia/commons/0/04/ChatGPT_logo.svg", tag: "Hot" },
  { id: 2, name: "Canva Pro Bản Quyền (1 Năm)", price: "150,000đ", image: "https://upload.wikimedia.org/wikipedia/commons/0/08/Canva_icon_2021.svg", tag: "Sale" },
  { id: 3, name: "Netflix Premium 4K (1 Tháng)", price: "80,000đ", image: "https://upload.wikimedia.org/wikipedia/commons/0/0c/Netflix_2015_N_logo.svg", tag: "Bestseller" },
  { id: 4, name: "YouTube Premium (6 Tháng)", price: "220,000đ", image: "https://upload.wikimedia.org/wikipedia/commons/0/09/YouTube_full-color_icon_%282017%29.svg", tag: "" },
];

export default function Home() {
  const [showQuickBuy, setShowQuickBuy] = useState(false);
  const [selectedProduct, setSelectedProduct] = useState<any>(null);

  return (
    <div className="flex flex-col min-h-screen">
      {/* Hero Section */}
      <section className="relative pt-24 md:pt-32 pb-16 md:pb-20 overflow-hidden bg-white">
        <div className="absolute inset-0 bg-[url('/grid.svg')] bg-center [mask-image:linear-gradient(180deg,rgba(0,0,0,0.05),rgba(255,255,255,0))]" />
        
        {/* Glow Effects */}
        <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-100 rounded-full blur-[120px] opacity-70" />
        <div className="absolute top-0 right-0 w-[400px] h-[400px] bg-orange-100 rounded-full blur-[100px] opacity-70" />

        <div className="container mx-auto px-4 relative z-10 text-center">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5 }}
          >
            <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 border border-blue-100 text-sm font-medium text-blue-700 mb-6">
              <span className="w-2 h-2 rounded-full bg-green-500 animate-pulse" />
              Hệ thống tự động 24/7
            </div>
            
            <h1 className="text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-tight mb-4 sm:mb-6 text-slate-900 leading-tight">
              Nâng Tầm Trải Nghiệm <br className="hidden sm:block" />
              Với <span className="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-orange-400">Dịch Vụ Premium</span>
            </h1>
            
            <p className="text-base sm:text-lg md:text-xl text-slate-600 mb-8 sm:mb-10 max-w-2xl mx-auto px-4 sm:px-0">
              Cung cấp tài khoản bản quyền, phần mềm chính hãng với mức giá tốt nhất thị trường. Giao hàng tự động trong 3 giây.
            </p>

            <div className="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 px-4 sm:px-0">
              <Link href="/products" className="w-full sm:w-auto px-6 sm:px-8 py-3.5 sm:py-4 bg-orange-500 hover:bg-orange-600 text-white rounded-full font-bold transition-all shadow-lg shadow-orange-500/30 flex items-center justify-center gap-2">
                Khám Phá Ngay <ArrowRight className="w-5 h-5" />
              </Link>
              <button 
                onClick={() => toast.success("Hỗ trợ đang online. Vui lòng nhắn tin Zalo: 0932507102")}
                className="w-full sm:w-auto px-6 sm:px-8 py-3.5 sm:py-4 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 rounded-full font-bold transition-colors flex items-center justify-center gap-2 shadow-sm">
                Liên Hệ Hỗ Trợ
              </button>
            </div>
          </motion.div>
        </div>
      </section>

      {/* Features */}
      <section className="py-12 md:py-20 bg-slate-50 border-y border-slate-200">
        <div className="container mx-auto px-4">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
            {[
              { icon: Zap, title: "Tự Động 100%", desc: "Thanh toán xong có ngay tài khoản. Không cần chờ đợi admin phản hồi." },
              { icon: Shield, title: "Bảo Hành Uy Tín", desc: "Cam kết 1 đổi 1 trong suốt thời gian sử dụng nếu có lỗi phát sinh." },
              { icon: Star, title: "Chất Lượng Cao", desc: "Tài khoản private, không dùng chung lậu, đảm bảo trải nghiệm tốt nhất." }
            ].map((f, i) => (
              <motion.div 
                key={i}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.1 }}
                className="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center text-center hover:shadow-md transition-shadow"
              >
                <div className="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                  <f.icon className="w-8 h-8" />
                </div>
                <h3 className="text-xl font-bold text-slate-900 mb-3">{f.title}</h3>
                <p className="text-slate-600">{f.desc}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Featured Products */}
      <section className="py-16 md:py-24 bg-white">
        <div className="container mx-auto px-4">
          <div className="flex flex-col sm:flex-row items-start sm:items-end justify-between mb-8 md:mb-12 gap-4">
            <div>
              <h2 className="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 mb-2 md:mb-4">Sản Phẩm Nổi Bật</h2>
              <p className="text-sm md:text-base text-slate-500">Các dịch vụ được khách hàng mua nhiều nhất</p>
            </div>
            <Link href="/products" className="hidden sm:flex items-center gap-2 text-orange-500 hover:text-orange-600 font-medium">
              Xem tất cả <ChevronRight className="w-5 h-5" />
            </Link>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {products.map((p, i) => (
              <motion.div
                key={p.id}
                initial={{ opacity: 0, scale: 0.95 }}
                whileInView={{ opacity: 1, scale: 1 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.1 }}
                className="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:border-orange-300 hover:shadow-xl transition-all duration-300"
              >
                <Link href={`/products/${p.id}`}>
                  <div className="relative h-48 bg-slate-50 flex items-center justify-center p-6 border-b border-slate-100 cursor-pointer">
                    {p.tag && (
                      <span className="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-sm z-10">
                        {p.tag}
                      </span>
                    )}
                    <Image src={p.image} alt={p.name} width={80} height={80} className="group-hover:scale-110 transition-transform duration-500 drop-shadow-md" />
                  </div>
                </Link>
                <div className="p-5">
                  <Link href={`/products/${p.id}`}>
                    <h3 className="font-semibold text-slate-900 mb-2 line-clamp-1 group-hover:text-orange-500 transition-colors cursor-pointer">{p.name}</h3>
                  </Link>
                  <div className="flex flex-wrap items-center justify-between mt-4 gap-2">
                    <span className="text-lg font-bold text-blue-600 truncate">{p.price}</span>
                    <button 
                      onClick={() => {
                        setSelectedProduct(p);
                        setShowQuickBuy(true);
                      }}
                      className="px-3 sm:px-4 py-1.5 sm:py-2 bg-orange-50 text-orange-500 hover:bg-orange-500 hover:text-white rounded-lg transition-colors font-bold text-xs sm:text-sm cursor-pointer whitespace-nowrap flex-shrink-0"
                    >
                      Mua Ngay
                    </button>
                  </div>
                </div>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      <QuickBuyModal 
        isOpen={showQuickBuy} 
        onClose={() => setShowQuickBuy(false)} 
        product={selectedProduct}
      />
    </div>
  );
}
