import type { Metadata } from "next";
import { Inter } from "next/font/google";
import "./globals.css";
import { Toaster } from "sonner";
import Link from "next/link";
import Image from "next/image";
import Header from "@/components/Header";
import RecentPurchasesTicker from "@/components/RecentPurchasesTicker";
import FloatingContact from "@/components/FloatingContact";

const inter = Inter({ subsets: ["latin", "vietnamese"] });

export const metadata: Metadata = {
  title: "CataiShop - Mua Bán Tài Khoản Dịch Vụ Cao Cấp",
  description: "Cung cấp tài khoản dịch vụ số cao cấp: ChatGPT, Canva, Netflix...",
  icons: {
    icon: "/avt.png",
  }
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="vi">
      <body className={`${inter.className} bg-slate-50 text-slate-900 min-h-screen flex flex-col`}>
        <Header />
        <RecentPurchasesTicker />

        <main className="flex-1">
          {children}
        </main>

        <footer className="border-t border-slate-200 bg-white py-12 mt-20 relative overflow-hidden">
          <div className="absolute inset-0 bg-[url('/grid.svg')] bg-center opacity-[0.03]" />
          <div className="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8 relative z-10">
            <div>
              <div className="flex items-center gap-3 mb-4">
                <Image src="/avt.png" alt="Logo" width={32} height={32} className="rounded-full shadow-sm" />
                <span className="font-bold text-lg text-blue-700">Catai<span className="text-orange-500">Shop</span></span>
              </div>
              <p className="text-slate-500 text-sm leading-relaxed">
                Nền tảng mua bán tài khoản số, dịch vụ premium chất lượng cao, tự động 24/7.
              </p>
            </div>
            <div>
              <h3 className="font-bold text-slate-900 mb-4 uppercase text-xs tracking-wider">Danh Mục</h3>
              <ul className="space-y-2 text-sm text-slate-500 font-medium">
                <li><Link href="/products" className="hover:text-orange-500">Tài khoản Giải Trí</Link></li>
                <li><Link href="/products" className="hover:text-orange-500">Công cụ Làm Việc</Link></li>
                <li><Link href="/products" className="hover:text-orange-500">Phần mềm Đồ Họa</Link></li>
              </ul>
            </div>
            <div>
              <h3 className="font-semibold text-slate-800 mb-4">Hỗ Trợ</h3>
              <ul className="space-y-2 text-sm text-slate-500">
                <li><Link href="/policy" className="hover:text-orange-500">Chính sách & Điều khoản</Link></li>
                <li><Link href="/policy" className="hover:text-orange-500">Quy định bảo hành</Link></li>
                <li><Link href="#" className="hover:text-orange-500">Liên hệ Admin</Link></li>
              </ul>
            </div>
            <div>
              <h3 className="font-semibold text-slate-800 mb-4">Chứng Nhận</h3>
              <div className="w-32 h-10 bg-slate-100 rounded border border-slate-200 flex items-center justify-center text-xs text-slate-500">
                DMCA Protected
              </div>
            </div>
          </div>
        </footer>
        <FloatingContact />
        <Toaster position="top-right" richColors />
      </body>
    </html>
  );
}
