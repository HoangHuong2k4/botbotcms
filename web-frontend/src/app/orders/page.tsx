"use client";

import Link from "next/link";
import { Package, Clock, CheckCircle2, Search, Calendar as CalendarIcon, ChevronLeft, ChevronRight } from "lucide-react";

export default function Orders() {
  return (
    <div className="container mx-auto px-4 py-12 max-w-6xl">
      <div className="mb-8">
        <h1 className="text-3xl font-bold text-slate-900 mb-2">Lịch Sử Đơn Hàng</h1>
        <p className="text-slate-500">Theo dõi và quản lý các dịch vụ bạn đã mua.</p>
      </div>

      {/* Filters */}
      <div className="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-end">
        <div className="flex-1 w-full">
          <label className="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tìm kiếm đơn hàng</label>
          <div className="relative w-full">
            <Search className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
            <input 
              type="text" 
              placeholder="Nhập mã đơn, tên sản phẩm..." 
              className="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-9 pr-4 text-sm text-slate-900 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors"
            />
          </div>
        </div>
        <div className="w-full md:w-48">
          <label className="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Từ ngày</label>
          <div className="relative w-full">
            <CalendarIcon className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
            <input 
              type="date" 
              className="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-9 pr-4 text-sm text-slate-900 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors"
            />
          </div>
        </div>
        <div className="w-full md:w-48">
          <label className="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Đến ngày</label>
          <div className="relative w-full">
            <CalendarIcon className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
            <input 
              type="date" 
              className="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-9 pr-4 text-sm text-slate-900 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors"
            />
          </div>
        </div>
        <button className="w-full md:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors">Lọc</button>
      </div>

      {/* Table */}
      <div className="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full text-left border-collapse">
            <thead>
              <tr className="bg-slate-50 border-b border-slate-200 text-slate-600 text-sm">
                <th className="p-5 font-bold uppercase tracking-wider text-xs">Mã Đơn</th>
                <th className="p-5 font-bold uppercase tracking-wider text-xs">Sản Phẩm</th>
                <th className="p-5 font-bold uppercase tracking-wider text-xs">Ngày Mua</th>
                <th className="p-5 font-bold uppercase tracking-wider text-xs">Tổng Tiền</th>
                <th className="p-5 font-bold uppercase tracking-wider text-xs">Trạng Thái</th>
                <th className="p-5 font-bold uppercase tracking-wider text-xs text-right">Thao Tác</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 text-sm">
              {[
                { id: "ORD-92837", name: "Tài khoản ChatGPT Plus", date: "26/09/2026", price: "250,000đ", status: "Hoàn thành", color: "text-green-600", bg: "bg-green-100", icon: CheckCircle2 },
                { id: "ORD-92836", name: "Canva Pro (1 Năm)", date: "25/09/2026", price: "150,000đ", status: "Hoàn thành", color: "text-green-600", bg: "bg-green-100", icon: CheckCircle2 },
                { id: "ORD-92835", name: "Netflix Premium 4K", date: "24/09/2026", price: "80,000đ", status: "Đang xử lý", color: "text-orange-600", bg: "bg-orange-100", icon: Clock },
              ].map((order, i) => (
                <tr key={i} className="hover:bg-slate-50 transition-colors">
                  <td className="p-5 font-mono text-slate-900 font-bold">{order.id}</td>
                  <td className="p-5 font-medium text-slate-900 flex items-center gap-3">
                    <div className="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                      <Package className="w-5 h-5 text-blue-600" />
                    </div>
                    {order.name}
                  </td>
                  <td className="p-5 text-slate-500">{order.date}</td>
                  <td className="p-5 font-bold text-orange-500">{order.price}</td>
                  <td className="p-5">
                    <span className={`inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold ${order.bg} ${order.color}`}>
                      <order.icon className="w-3.5 h-3.5" /> {order.status}
                    </span>
                  </td>
                  <td className="p-5 text-right">
                    <Link href={`/orders/${order.id}`} className="inline-flex px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition-colors">
                      Chi tiết
                    </Link>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
        
        {/* Pagination */}
        <div className="p-5 border-t border-slate-200 flex items-center justify-between">
          <span className="text-sm text-slate-500">Hiển thị 1 - 3 của 3 đơn hàng</span>
          <div className="flex items-center gap-2">
            <button className="p-2 border border-slate-200 rounded-lg text-slate-400 hover:text-slate-700 disabled:opacity-50"><ChevronLeft className="w-4 h-4"/></button>
            <button className="w-8 h-8 rounded-lg bg-orange-500 text-white font-bold flex items-center justify-center">1</button>
            <button className="p-2 border border-slate-200 rounded-lg text-slate-400 hover:text-slate-700 disabled:opacity-50"><ChevronRight className="w-4 h-4"/></button>
          </div>
        </div>
      </div>
    </div>
  );
}
