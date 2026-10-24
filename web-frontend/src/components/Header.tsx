"use client";

import { useState } from "react";
import Link from "next/link";
import Image from "next/image";
import { ShoppingCart, LogIn, Menu, X } from "lucide-react";
import { motion, AnimatePresence } from "framer-motion";

export default function Header() {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  return (
    <>
      <nav className="sticky top-0 z-50 w-full border-b border-white/50 bg-white/60 backdrop-blur-xl shadow-sm transition-all duration-300">
        <div className="container mx-auto px-4 h-16 flex items-center justify-between">
          <Link href="/" className="flex items-center gap-3 cursor-pointer">
            <div className="relative w-9 h-9 rounded-full p-[2px] bg-gradient-to-tr from-orange-500 to-blue-600">
              <Image src="/avt.png" alt="Logo" fill className="rounded-full object-cover border-2 border-white" />
            </div>
            <span className="font-bold text-xl tracking-tight text-blue-700">Catai<span className="text-orange-500">Shop</span></span>
          </Link>
          
          <div className="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
            <Link href="/products" className="hover:text-orange-500 transition-colors cursor-pointer">Sản Phẩm</Link>
            <Link href="/orders" className="hover:text-orange-500 transition-colors cursor-pointer">Tra Cứu Đơn</Link>
            <Link href="/policy" className="hover:text-orange-500 transition-colors cursor-pointer">Chính Sách</Link>
          </div>

          <div className="flex items-center gap-3">
            <Link href="/cart" className="relative p-2 text-slate-600 hover:bg-slate-100 rounded-full transition-colors cursor-pointer">
              <ShoppingCart className="w-5 h-5" />
              <span className="absolute top-0 right-0 w-4 h-4 bg-orange-500 text-white text-[10px] font-bold flex items-center justify-center rounded-full">
                0
              </span>
            </Link>
            
            <Link href="/login" className="hidden sm:flex items-center gap-2 bg-blue-50 text-blue-600 hover:bg-blue-100 px-4 py-2 rounded-full transition-colors text-sm font-medium cursor-pointer">
              <LogIn className="w-4 h-4" />
              <span>Đăng Nhập</span>
            </Link>

            {/* Mobile Menu Toggle */}
            <button 
              className="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg cursor-pointer"
              onClick={() => setMobileMenuOpen(true)}
            >
              <Menu className="w-6 h-6" />
            </button>
          </div>
        </div>
      </nav>

      {/* Mobile Menu Overlay */}
      <AnimatePresence>
        {mobileMenuOpen && (
          <div className="fixed inset-0 z-[100] md:hidden">
            <motion.div 
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              className="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
              onClick={() => setMobileMenuOpen(false)}
            />
            <motion.div 
              initial={{ x: "100%" }}
              animate={{ x: 0 }}
              exit={{ x: "100%" }}
              transition={{ type: "spring", bounce: 0, duration: 0.3 }}
              className="absolute top-0 right-0 bottom-0 w-[80%] max-w-sm bg-white shadow-2xl flex flex-col"
            >
              <div className="flex items-center justify-between p-4 border-b border-slate-100">
                <span className="font-bold text-xl text-blue-700">Catai<span className="text-orange-500">Shop</span></span>
                <button 
                  onClick={() => setMobileMenuOpen(false)}
                  className="p-2 text-slate-500 hover:bg-slate-100 rounded-full cursor-pointer transition-colors"
                >
                  <X className="w-6 h-6" />
                </button>
              </div>

              <div className="flex-1 py-6 px-4 space-y-4">
                <Link onClick={() => setMobileMenuOpen(false)} href="/" className="block p-4 font-bold text-slate-700 hover:bg-orange-50 hover:text-orange-500 rounded-xl transition-colors cursor-pointer">
                  Trang Chủ
                </Link>
                <Link onClick={() => setMobileMenuOpen(false)} href="/products" className="block p-4 font-bold text-slate-700 hover:bg-orange-50 hover:text-orange-500 rounded-xl transition-colors cursor-pointer">
                  Sản Phẩm
                </Link>
                <Link onClick={() => setMobileMenuOpen(false)} href="/orders" className="block p-4 font-bold text-slate-700 hover:bg-orange-50 hover:text-orange-500 rounded-xl transition-colors cursor-pointer">
                  Tra Cứu Đơn
                </Link>
                <Link onClick={() => setMobileMenuOpen(false)} href="/policy" className="block p-4 font-bold text-slate-700 hover:bg-orange-50 hover:text-orange-500 rounded-xl transition-colors cursor-pointer">
                  Chính Sách
                </Link>
              </div>
              
              <div className="p-4 border-t border-slate-100">
                <Link onClick={() => setMobileMenuOpen(false)} href="/login" className="flex items-center justify-center gap-2 w-full bg-blue-600 text-white hover:bg-blue-700 py-4 rounded-xl transition-colors font-bold cursor-pointer">
                  <LogIn className="w-5 h-5" />
                  Đăng Nhập
                </Link>
              </div>
            </motion.div>
          </div>
        )}
      </AnimatePresence>
    </>
  );
}
