"use client";

import { useState } from "react";
import Image from "next/image";
import Link from "next/link";
import { ArrowLeft, CheckCircle2, Shield, Zap, ShoppingCart, Minus, Plus } from "lucide-react";
import QRModal from "@/components/QRModal";

export default function ProductDetail({ params }: { params: { slug: string } }) {
  const [showQR, setShowQR] = useState(false);
  const [quantity, setQuantity] = useState(1);
  
  const basePriceNum = 250000;
  const totalPriceNum = basePriceNum * quantity;
  const formattedTotal = new Intl.NumberFormat('vi-VN').format(totalPriceNum) + "đ";

  return (
    <div className="container mx-auto px-4 py-12 max-w-6xl">
      <Link href="/products" className="inline-flex items-center gap-2 text-slate-500 hover:text-orange-500 transition-colors mb-8 font-medium">
        <ArrowLeft className="w-4 h-4" /> Quay lại danh sách
      </Link>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 bg-white p-6 lg:p-12 rounded-3xl shadow-sm border border-slate-100">
        {/* Product Image */}
        <div className="bg-slate-50 rounded-2xl flex items-center justify-center relative overflow-hidden h-[300px] sm:h-[400px]">
          <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] bg-orange-100 rounded-full blur-[80px] opacity-70" />
          <Image 
            src="https://upload.wikimedia.org/wikipedia/commons/0/04/ChatGPT_logo.svg" 
            alt="Product Image" 
            width={200} 
            height={200} 
            className="relative z-10 drop-shadow-xl hover:scale-105 transition-transform duration-500" 
          />
        </div>

        {/* Product Info */}
        <div className="flex flex-col justify-center mt-4 lg:mt-0">
          <div className="mb-6">
            <span className="inline-block px-4 py-1.5 bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider rounded-full mb-4">Công cụ</span>
            <h1 className="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 mb-4 leading-tight">Tài khoản ChatGPT Plus (1 Tháng)</h1>
            <p className="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-orange-400">250,000đ</p>
          </div>

          <p className="text-slate-600 mb-8 leading-relaxed text-base sm:text-lg">
            Nâng cấp tài khoản ChatGPT Plus chính chủ trên email của bạn. Trải nghiệm sức mạnh của GPT-4, DALL-E 3, và phân tích dữ liệu nâng cao không giới hạn.
          </p>

          <div className="space-y-4 mb-8 bg-slate-50 p-6 rounded-2xl border border-slate-100">
            {[
              "Bảo hành 1 đổi 1 trong 30 ngày",
              "Giao tài khoản tự động lập tức",
              "Sử dụng full tính năng GPT-4",
              "Nâng cấp trực tiếp trên Email cá nhân"
            ].map((feature, idx) => (
              <div key={idx} className="flex items-center gap-3 text-slate-700 font-medium">
                <CheckCircle2 className="w-5 h-5 text-green-500 flex-shrink-0" />
                <span>{feature}</span>
              </div>
            ))}
          </div>
          
          {/* Quantity and Form Email */}
          <div className="mb-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-bold text-slate-700 mb-2">Số Lượng</label>
              <div className="flex items-center gap-4 bg-white border border-slate-300 rounded-xl p-1 shadow-sm w-fit">
                <button 
                  onClick={() => setQuantity(Math.max(1, quantity - 1))}
                  className="w-10 h-10 flex items-center justify-center text-slate-600 hover:bg-slate-50 hover:text-orange-500 rounded-lg transition-all cursor-pointer"
                >
                  <Minus className="w-4 h-4 cursor-pointer" />
                </button>
                <span className="w-8 text-center font-bold text-slate-900">{quantity}</span>
                <button 
                  onClick={() => setQuantity(quantity + 1)}
                  className="w-10 h-10 flex items-center justify-center text-slate-600 hover:bg-slate-50 hover:text-orange-500 rounded-lg transition-all cursor-pointer"
                >
                  <Plus className="w-4 h-4 cursor-pointer" />
                </button>
              </div>
            </div>

            <div>
              <label className="block text-sm font-bold text-slate-700 mb-2">Email đăng ký / Nhận tài khoản</label>
              <input type="email" placeholder="Nhập email của bạn..." className="w-full bg-white border border-slate-300 rounded-xl py-3 px-4 text-slate-900 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all shadow-sm h-12" />
            </div>
          </div>
          
          <div className="mb-4">
             <p className="text-xs text-slate-500 flex items-center gap-1"><Shield className="w-3 h-3"/> Bảo mật thông tin tuyệt đối</p>
          </div>

          <div className="flex flex-col gap-4 pt-6 border-t border-slate-200">
            <button 
              onClick={() => setShowQR(true)}
              className="w-full bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2 transition-all shadow-lg shadow-orange-500/30 text-base sm:text-lg cursor-pointer"
            >
              Mua Ngay - {formattedTotal}
            </button>
            <button className="w-full py-4 bg-blue-50 hover:bg-blue-100 border border-blue-100 text-blue-600 font-bold rounded-xl flex items-center justify-center transition-colors">
              <ShoppingCart className="w-6 h-6 mr-2" /> Thêm Vào Giỏ
            </button>
          </div>
        </div>
      </div>

      <QRModal 
        isOpen={showQR} 
        onClose={() => setShowQR(false)} 
        total={formattedTotal} 
        orderId="CATAI 92837" 
      />
    </div>
  );
}
