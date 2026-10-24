"use client";

import { motion, AnimatePresence } from "framer-motion";
import { QrCode, X } from "lucide-react";
import Image from "next/image";
import { toast } from "sonner";

interface QRModalProps {
  isOpen: boolean;
  onClose: () => void;
  total: string;
  orderId: string;
}

export default function QRModal({ isOpen, onClose, total, orderId }: QRModalProps) {
  return (
    <AnimatePresence>
      {isOpen && (
        <div className="fixed inset-0 z-[100] flex items-center justify-center p-4">
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
            className="bg-white rounded-3xl w-full max-w-md relative z-10 overflow-hidden shadow-2xl border border-slate-100"
          >
            <button 
              onClick={onClose}
              className="absolute top-4 right-4 p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-full transition-colors z-20"
            >
              <X className="w-5 h-5" />
            </button>

            <div className="p-8 text-center bg-gradient-to-b from-blue-50 to-white">
              <div className="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <QrCode className="w-8 h-8" />
              </div>
              <h2 className="text-2xl font-bold text-slate-900 mb-2">Thanh Toán Đơn Hàng</h2>
              <p className="text-slate-600 mb-6">Sử dụng App Ngân Hàng hoặc Momo để quét mã QR dưới đây.</p>
              
              {/* Fake QR Image placeholder */}
              <div className="w-64 h-64 bg-white border-2 border-slate-200 rounded-2xl mx-auto p-4 flex items-center justify-center shadow-sm relative overflow-hidden mb-6">
                <Image src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="QR Code" width={240} height={240} className="rounded-xl" />
                
                {/* Scanning Animation */}
                <div className="absolute top-0 left-0 right-0 h-1 bg-green-500 shadow-[0_0_20px_5px_rgba(34,197,94,0.5)] animate-[scan_2s_ease-in-out_infinite]" />
              </div>

              <div className="bg-orange-50 border border-orange-100 rounded-xl p-4 text-left">
                <p className="text-sm text-slate-600 mb-1">Số tiền cần thanh toán:</p>
                <p className="text-2xl font-black text-orange-600 mb-3">{total}</p>
                <p className="text-sm text-slate-600 mb-1">Nội dung chuyển khoản:</p>
                <div className="flex items-center justify-between bg-white px-3 py-2 border border-orange-200 rounded-lg">
                  <span className="font-mono font-bold text-slate-900">{orderId}</span>
                  <button 
                    onClick={() => {
                      navigator.clipboard.writeText(orderId);
                      toast.success("Đã copy nội dung!");
                    }} 
                    className="text-orange-600 font-bold text-xs uppercase hover:underline cursor-pointer"
                  >
                    Copy
                  </button>
                </div>
              </div>
            </div>
            
            <div className="p-4 bg-slate-50 border-t border-slate-100 text-center">
              <p className="text-xs text-slate-500 font-medium">Hệ thống sẽ tự động xác nhận đơn hàng sau khi nhận được thanh toán (khoảng 10-30s).</p>
            </div>
          </motion.div>
        </div>
      )}
    </AnimatePresence>
  );
}
