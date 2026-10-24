"use client";

import { User, Mail, Shield, Key, CreditCard } from "lucide-react";

export default function Profile() {
  return (
    <div className="container mx-auto px-4 py-12 max-w-4xl">
      <h1 className="text-3xl font-bold text-slate-900 mb-8">Tài Khoản Của Tôi</h1>

      <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
        {/* Sidebar */}
        <div className="space-y-4">
          <div className="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col items-center text-center">
            <div className="w-24 h-24 bg-orange-500/20 rounded-full flex items-center justify-center mb-4 border-2 border-orange-500">
              <User className="w-12 h-12 text-blue-600" />
            </div>
            <h2 className="text-xl font-bold text-slate-900">Nguyễn Văn A</h2>
            <p className="text-slate-400 text-sm">Thành viên Bạc</p>
          </div>

          <div className="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <button className="w-full flex items-center gap-3 px-6 py-4 bg-slate-50 border-l-2 border-orange-500 text-slate-900 text-left font-medium">
              <User className="w-5 h-5 text-blue-600" /> Thông tin cá nhân
            </button>
            <button className="w-full flex items-center gap-3 px-6 py-4 hover:bg-slate-50 text-slate-400 hover:text-slate-900 text-left transition-colors">
              <Key className="w-5 h-5" /> Đổi mật khẩu
            </button>
            <button className="w-full flex items-center gap-3 px-6 py-4 hover:bg-slate-50 text-slate-400 hover:text-slate-900 text-left transition-colors">
              <CreditCard className="w-5 h-5" /> Nạp số dư
            </button>
          </div>
        </div>

        {/* Content */}
        <div className="md:col-span-2">
          <div className="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
            <h3 className="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
              <Shield className="w-5 h-5 text-blue-600" /> Thông tin bảo mật
            </h3>

            <div className="space-y-6">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div className="space-y-2">
                  <label className="text-sm font-medium text-slate-600">Họ và Tên</label>
                  <input type="text" defaultValue="Nguyễn Văn A" className="w-full bg-white border border-slate-200 rounded-lg py-3 px-4 text-slate-900 focus:outline-none focus:border-orange-500 transition-colors" />
                </div>
                <div className="space-y-2">
                  <label className="text-sm font-medium text-slate-600">Số điện thoại</label>
                  <input type="text" defaultValue="0987654321" className="w-full bg-white border border-slate-200 rounded-lg py-3 px-4 text-slate-900 focus:outline-none focus:border-orange-500 transition-colors" />
                </div>
              </div>

              <div className="space-y-2">
                <label className="text-sm font-medium text-slate-600">Địa chỉ Email</label>
                <div className="relative">
                  <Mail className="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" />
                  <input type="email" defaultValue="nguyenvana@example.com" disabled className="w-full bg-slate-50 border border-slate-100 rounded-lg py-3 pl-10 pr-4 text-slate-400 cursor-not-allowed" />
                </div>
              </div>

              <div className="pt-4">
                <button className="bg-orange-500 hover:bg-orange-500/90 text-slate-900 font-bold py-3 px-8 rounded-lg transition-colors">
                  Lưu Thay Đổi
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
