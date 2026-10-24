"use client";

import Link from "next/link";
import { motion } from "framer-motion";
import { Mail, Lock, ArrowRight, User as UserIcon } from "lucide-react";

export default function Login() {
  return (
    <div className="flex-1 flex items-center justify-center py-20 px-4 relative">
      {/* Background glow */}
      <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] bg-orange-500/20 rounded-full blur-[100px] opacity-50" />
      
      <motion.div 
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        className="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 w-full max-w-md relative z-10"
      >
        <div className="text-center mb-8">
          <div className="w-16 h-16 bg-orange-500/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-orange-500/30">
            <UserIcon className="w-8 h-8 text-blue-600" />
          </div>
          <h1 className="text-3xl font-bold text-slate-900 mb-2">Đăng Nhập</h1>
          <p className="text-slate-400">Chào mừng bạn quay trở lại CataiShop</p>
        </div>

        <form className="space-y-4">
          <div className="space-y-2">
            <label className="text-sm font-medium text-slate-600">Email</label>
            <div className="relative">
              <Mail className="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" />
              <input 
                type="email" 
                placeholder="name@example.com" 
                className="w-full bg-white border border-slate-200 rounded-lg py-3 pl-10 pr-4 text-slate-900 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all"
              />
            </div>
          </div>

          <div className="space-y-2">
            <div className="flex justify-between items-center">
              <label className="text-sm font-medium text-slate-600">Mật khẩu</label>
              <Link href="#" className="text-xs text-blue-600 hover:underline">Quên mật khẩu?</Link>
            </div>
            <div className="relative">
              <Lock className="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" />
              <input 
                type="password" 
                placeholder="••••••••" 
                className="w-full bg-white border border-slate-200 rounded-lg py-3 pl-10 pr-4 text-slate-900 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all"
              />
            </div>
          </div>

          <button className="w-full bg-orange-500 hover:bg-orange-500/90 text-slate-900 font-bold py-3 rounded-lg mt-6 flex items-center justify-center gap-2 transition-all shadow-[0_0_20px_-5px_rgba(59,130,246,0.5)]">
            Đăng Nhập Ngay <ArrowRight className="w-5 h-5" />
          </button>
        </form>

        <p className="mt-6 text-center text-sm text-slate-400">
          Chưa có tài khoản? <Link href="/register" className="text-blue-600 hover:underline font-medium">Đăng ký ngay</Link>
        </p>
      </motion.div>
    </div>
  );
}
