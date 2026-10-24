"use client";

import Link from "next/link";
import { ArrowLeft, Package, CheckCircle2, Copy, DownloadCloud } from "lucide-react";
import { toast } from "sonner";

export default function OrderDetail({ params }: { params: { id: string } }) {
  const handleCopy = (text: string, title: string) => {
    navigator.clipboard.writeText(text);
    toast.success(`Đã copy ${title} vào bộ nhớ tạm!`, { icon: '📋' });
  };

  const handleDownload = () => {
    const content = `Mã Đơn: ${params.id}\nSản Phẩm: Tài khoản ChatGPT Plus (1 Tháng)\n-------------------------\nTài Khoản: user_chatgpt_premium_123\nMật Khẩu: P@ssw0rd_SeCrEt!`;
    const blob = new Blob([content], { type: "text/plain" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = `DonHang_${params.id}.txt`;
    a.click();
    toast.success("Đã tải xuống file TXT!");
  };

  return (
    <div className="container mx-auto px-4 py-12 max-w-5xl">
      <Link href="/orders" className="inline-flex items-center gap-2 text-slate-500 hover:text-orange-500 font-medium transition-colors mb-8">
        <ArrowLeft className="w-4 h-4" /> Quay lại danh sách
      </Link>

      <div className="flex flex-col md:flex-row gap-8">
        {/* Main Details */}
        <div className="flex-1 space-y-6">
          <div className="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm relative overflow-hidden">
            <div className="absolute top-0 right-0 p-8 opacity-5 pointer-events-none text-blue-600">
              <Package className="w-40 h-40" />
            </div>

            <div className="flex items-center gap-3 mb-6 relative z-10">
              <span className="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-700 shadow-sm border border-green-200">
                <CheckCircle2 className="w-5 h-5" /> Giao dịch thành công
              </span>
            </div>

            <h1 className="text-3xl font-bold text-slate-900 mb-2 relative z-10">Đơn Hàng: <span className="text-blue-600">{params.id}</span></h1>
            <p className="text-slate-500 mb-8 relative z-10 font-medium">Hoàn thành lúc: 26/09/2026 - 15:30</p>

            <div className="space-y-4 relative z-10">
              <h3 className="font-bold text-slate-800 uppercase tracking-wider text-sm">Sản phẩm đã mua</h3>
              <div className="flex flex-col sm:flex-row items-start sm:items-center gap-4 bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-100 shadow-sm">
                <div className="flex items-center gap-4 w-full sm:w-auto flex-1">
                  <div className="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <Package className="w-8 h-8 text-blue-600" />
                  </div>
                  <div>
                    <h4 className="font-bold text-slate-900 text-base sm:text-lg">Tài khoản ChatGPT Plus (1 Tháng)</h4>
                    <p className="text-slate-500 text-sm font-medium">Số lượng: 1</p>
                  </div>
                </div>
                <div className="text-left sm:text-right w-full sm:w-auto mt-2 sm:mt-0 pt-2 sm:pt-0 border-t border-slate-200 sm:border-0">
                  <p className="font-black text-orange-500 text-xl sm:text-2xl">250,000đ</p>
                </div>
              </div>
            </div>
          </div>

          <div className="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
            <div className="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
              <h3 className="font-bold text-slate-800 uppercase tracking-wider text-sm">Thông Tin Nhận Hàng</h3>
              <button onClick={handleDownload} className="w-full sm:w-auto flex items-center justify-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 font-bold rounded-xl hover:bg-blue-100 transition-colors">
                <DownloadCloud className="w-5 h-5"/> Tải File TXT
              </button>
            </div>
            
            <div className="space-y-4">
              <div className="bg-slate-50 p-4 sm:p-5 rounded-xl border border-slate-200 flex flex-row justify-between items-center group gap-4">
                <div className="overflow-hidden">
                  <p className="text-[10px] sm:text-xs text-slate-400 uppercase tracking-wider font-bold mb-1">Tài Khoản / Username</p>
                  <p className="text-slate-900 font-mono text-base sm:text-xl font-bold truncate">user_chatgpt_premium_123</p>
                </div>
                <button onClick={() => handleCopy("user_chatgpt_premium_123", "Tài khoản")} className="flex-shrink-0 p-2 sm:p-3 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100 cursor-pointer">
                  <Copy className="w-4 h-4 sm:w-5 sm:h-5 cursor-pointer" />
                </button>
              </div>

              <div className="bg-slate-50 p-4 sm:p-5 rounded-xl border border-slate-200 flex flex-row justify-between items-center group gap-4">
                <div className="overflow-hidden">
                  <p className="text-[10px] sm:text-xs text-slate-400 uppercase tracking-wider font-bold mb-1">Mật Khẩu / Password</p>
                  <p className="text-slate-900 font-mono text-base sm:text-xl font-bold truncate">P@ssw0rd_SeCrEt!</p>
                </div>
                <button onClick={() => handleCopy("P@ssw0rd_SeCrEt!", "Mật khẩu")} className="flex-shrink-0 p-2 sm:p-3 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100 cursor-pointer">
                  <Copy className="w-4 h-4 sm:w-5 sm:h-5 cursor-pointer" />
                </button>
              </div>
              
              <div className="mt-6 p-4 bg-orange-50 border border-orange-200 rounded-xl text-sm text-orange-700 font-medium">
                💡 <b>Lưu ý bảo hành:</b> Vui lòng KHÔNG thay đổi mật khẩu và thông tin tài khoản để duy trì quyền lợi bảo hành.
              </div>
            </div>
          </div>
        </div>

        {/* Sidebar Summary */}
        <div className="w-full md:w-80 space-y-6">
          <div className="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm sticky top-24">
            <h3 className="font-bold text-slate-800 uppercase tracking-wider text-sm mb-4">Tổng Kết Thanh Toán</h3>
            <div className="space-y-4 text-sm text-slate-600 mb-6 font-medium">
              <div className="flex justify-between">
                <span>Tạm tính</span>
                <span>250,000đ</span>
              </div>
              <div className="flex justify-between">
                <span>Giảm giá</span>
                <span className="text-green-600">-0đ</span>
              </div>
              <div className="pt-4 border-t border-slate-200 flex justify-between font-black text-slate-900 text-lg">
                <span>Tổng cộng</span>
                <span className="text-orange-500 text-2xl">250,000đ</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
