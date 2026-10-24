"use client";

import { useState } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { X, Minus, Plus, ShoppingCart } from "lucide-react";
import Image from "next/image";
import QRModal from "./QRModal";

interface Product {
  id: string;
  name: string;
  price: string;
  originalPrice?: string;
  image: string;
}

interface QuickBuyModalProps {
  isOpen: boolean;
  onClose: () => void;
  product: Product | null;
}

export default function QuickBuyModal({ isOpen, onClose, product }: QuickBuyModalProps) {
  const [quantity, setQuantity] = useState(1);
  const [showQR, setShowQR] = useState(false);

  if (!product) return null;

  // Simple number parser for demo (e.g., "250,000đ" -> 250000)
  const basePriceNum = parseInt(product.price.replace(/[^\d]/g, "")) || 0;
  const totalPriceNum = basePriceNum * quantity;
  const formattedTotal = new Intl.NumberFormat('vi-VN').format(totalPriceNum) + "đ";

  return (
    <AnimatePresence>
      {isOpen && !showQR && (
        <div className="fixed inset-0 z-[90] flex items-center justify-center p-4">
          <motion.div 
            initial={{ opacity: 0 }} 
            animate={{ opacity: 1 }} 
            exit={{ opacity: 0 }}
            className="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
            onClick={onClose}
          />
          
          <motion.div 
            initial={{ opacity: 0, scale: 0.95, y: 20 }}
            animate={{ opacity: 1, scale: 1, y: 0 }}
            exit={{ opacity: 0, scale: 0.95, y: 20 }}
            className="bg-white rounded-3xl w-full max-w-lg relative z-[91] overflow-hidden shadow-2xl border border-slate-100 flex flex-col max-h-[90vh]"
          >
            <div className="flex items-center justify-between p-4 md:p-6 border-b border-slate-100">
              <h2 className="text-xl font-bold text-slate-800">Tùy Chọn Mua Hàng</h2>
              <button 
                onClick={onClose}
                className="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-full transition-colors"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            <div className="p-4 md:p-6 overflow-y-auto">
              {/* Product Info */}
              <div className="flex items-start gap-4 mb-8">
                <div className="w-24 h-24 bg-slate-50 rounded-2xl flex items-center justify-center p-3 border border-slate-100 flex-shrink-0">
                  <Image src={product.image} alt={product.name} width={70} height={70} className="drop-shadow-sm object-contain" />
                </div>
                <div>
                  <h3 className="text-lg font-bold text-slate-900 mb-2 leading-tight">{product.name}</h3>
                  <div className="flex items-center gap-2">
                    <span className="text-2xl font-black text-orange-500">{product.price}</span>
                    {product.originalPrice && (
                      <span className="text-sm text-slate-400 line-through">{product.originalPrice}</span>
                    )}
                  </div>
                </div>
              </div>

              {/* Quantity Selector */}
              <div className="mb-8">
                <label className="block text-sm font-bold text-slate-700 mb-3">Số Lượng</label>
                <div className="flex items-center gap-4">
                  <div className="flex items-center bg-slate-50 border border-slate-200 rounded-xl p-1">
                    <button 
                      onClick={() => setQuantity(Math.max(1, quantity - 1))}
                      className="w-10 h-10 flex items-center justify-center text-slate-600 hover:bg-white hover:shadow-sm rounded-lg transition-all"
                    >
                      <Minus className="w-4 h-4" />
                    </button>
                    <span className="w-12 text-center font-bold text-slate-900">{quantity}</span>
                    <button 
                      onClick={() => setQuantity(quantity + 1)}
                      className="w-10 h-10 flex items-center justify-center text-slate-600 hover:bg-white hover:shadow-sm rounded-lg transition-all"
                    >
                      <Plus className="w-4 h-4" />
                    </button>
                  </div>
                  <span className="text-sm text-slate-500">Tháng / Gói</span>
                </div>
              </div>
              
              {/* Note input */}
              <div className="mb-4">
                <label className="block text-sm font-bold text-slate-700 mb-3">Ghi chú (Tùy chọn)</label>
                <textarea 
                  className="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                  rows={2}
                  placeholder="Email nhận tài khoản, yêu cầu riêng..."
                ></textarea>
              </div>
            </div>

            {/* Footer / Summary */}
            <div className="p-4 md:p-6 bg-slate-50 border-t border-slate-100 mt-auto">
              <div className="flex items-center justify-between mb-4">
                <span className="text-slate-600 font-medium">Tổng thanh toán:</span>
                <span className="text-2xl font-black text-orange-600">{formattedTotal}</span>
              </div>
              
              <div className="flex gap-3">
                <button 
                  onClick={() => setShowQR(true)}
                  className="flex-1 bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white font-bold py-3.5 rounded-xl flex items-center justify-center gap-2 transition-all shadow-lg shadow-orange-500/30"
                >
                  Thanh Toán Ngay
                </button>
                <button 
                  onClick={() => {
                     // Add to cart logic here (demo)
                     onClose();
                  }}
                  className="w-14 bg-white border border-slate-200 text-blue-600 hover:bg-blue-50 hover:border-blue-100 rounded-xl flex items-center justify-center transition-all shadow-sm"
                >
                  <ShoppingCart className="w-5 h-5" />
                </button>
              </div>
            </div>
          </motion.div>
        </div>
      )}
      
      {/* If showQR is true, show QRModal instead */}
      <QRModal 
        isOpen={showQR} 
        onClose={() => {
          setShowQR(false);
          onClose(); // Close both when QR is closed
        }} 
        total={formattedTotal} 
        orderId="CATAI 92837" 
      />
    </AnimatePresence>
  );
}
