"use client";

import { useState } from "react";
import Image from "next/image";
import Link from "next/link";
import { ArrowLeft, Trash2, ShieldCheck, ChevronRight, CreditCard } from "lucide-react";
import { toast } from "sonner";
import QRModal from "@/components/QRModal";

export default function Cart() {
  const [showQR, setShowQR] = useState(false);
  const total = "250,000đ";

  return (
    <div className="container mx-auto px-4 py-12 max-w-6xl">
      <div className="mb-8 flex items-center gap-4">
        <Link href="/products" className="p-2 bg-white border border-slate-200 rounded-full text-slate-500 hover:text-orange-500 hover:border-orange-200 transition-colors">
          <ArrowLeft className="w-5 h-5" />
        </Link>
        <div>
          <h1 className="text-3xl font-bold text-slate-900 mb-1">Giỏ Hàng Của Bạn</h1>
          <p className="text-slate-500">Xem lại các dịch vụ bạn đã chọn trước khi thanh toán.</p>
        </div>
      </div>

      <div className="flex flex-col lg:flex-row gap-8">
        {/* Cart Items */}
        <div className="flex-1 space-y-6">
          <div className="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-6">
            <div className="w-24 h-24 bg-slate-50 rounded-2xl flex items-center justify-center p-4 border border-slate-100 flex-shrink-0">
              <Image src="https://upload.wikimedia.org/wikipedia/commons/0/04/ChatGPT_logo.svg" alt="ChatGPT" width={60} height={60} className="drop-shadow-sm" />
            </div>
            <div className="flex-1">
              <span className="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">Công cụ</span>
              <h3 className="text-xl font-bold text-slate-900 mb-1">Tài khoản ChatGPT Plus (1 Tháng)</h3>
              <p className="text-slate-500 text-sm">Giao hàng tự động qua Email</p>
            </div>
            <div className="text-right flex flex-col items-end gap-3">
              <p className="font-black text-xl text-orange-500">250,000đ</p>
              <button className="text-sm font-semibold text-red-500 flex items-center gap-1 hover:text-red-600 hover:underline">
                <Trash2 className="w-4 h-4" /> Xóa
              </button>
            </div>
          </div>
          
          <div className="bg-blue-50/50 border border-blue-100 rounded-2xl p-4 flex items-start gap-3">
            <ShieldCheck className="w-6 h-6 text-blue-600 flex-shrink-0" />
            <p className="text-sm text-slate-700 leading-relaxed font-medium">
              Bạn đang được bảo vệ bởi chính sách <b>Bảo hành 1 đổi 1</b>. Hoàn tiền 100% nếu có lỗi phát sinh không thể khắc phục.
            </p>
          </div>
        </div>

        {/* Order Summary */}
        <div className="w-full lg:w-[400px]">
          <div className="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm sticky top-24">
            <h2 className="text-xl font-bold text-slate-900 mb-6">Tổng Đơn Hàng</h2>
            
            <div className="space-y-4 text-slate-600 font-medium mb-6">
              <div className="flex justify-between">
                <span>Tạm tính (1 sản phẩm)</span>
                <span>250,000đ</span>
              </div>
              <div className="flex justify-between">
                <span>Khuyến mãi</span>
                <span className="text-green-600">-0đ</span>
              </div>
              <div className="flex justify-between">
                <span>Phí giao dịch</span>
                <span>0đ</span>
              </div>
            </div>

            <div className="pt-6 border-t border-slate-200 mb-8">
              <div className="flex justify-between items-end mb-2">
                <span className="font-bold text-slate-900">Tổng thanh toán</span>
                <span className="text-3xl font-black text-orange-500">250,000đ</span>
              </div>
              <p className="text-xs text-right text-slate-500">Đã bao gồm VAT</p>
            </div>

            <button 
              onClick={() => setShowQR(true)}
              className="w-full bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2 transition-all shadow-lg shadow-orange-500/30 text-lg mb-4"
            >
              Thanh Toán Ngay <ChevronRight className="w-5 h-5" />
            </button>
            <div className="flex items-center justify-center gap-2 text-slate-400 text-sm">
              <CreditCard className="w-4 h-4" /> Hỗ trợ quét mã QR các Ngân hàng
            </div>
          </div>
        </div>
      </div>

      {/* QR Code Modal Popup */}
      <QRModal 
        isOpen={showQR} 
        onClose={() => setShowQR(false)} 
        total={total} 
        orderId="CATAI 92837" 
      />
    </div>
  );
}
