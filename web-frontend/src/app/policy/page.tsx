"use client";

import { Shield, AlertTriangle, Scale, Lock, Info } from "lucide-react";
import Link from "next/link";
import { ArrowLeft } from "lucide-react";

export default function Policy() {
  return (
    <div className="container mx-auto px-4 py-12 max-w-4xl">
      <div className="mb-8">
        <Link href="/" className="inline-flex items-center gap-2 text-slate-500 hover:text-orange-500 transition-colors font-medium mb-6">
          <ArrowLeft className="w-4 h-4" /> Về Trang Chủ
        </Link>
        <h1 className="text-4xl font-black text-slate-900 mb-4">Chính Sách & Điều Khoản Sử Dụng</h1>
        <p className="text-slate-600 text-lg">Vui lòng đọc kỹ các điều khoản dưới đây trước khi sử dụng dịch vụ tại CataiShop.</p>
      </div>

      <div className="space-y-8 bg-white p-8 md:p-12 rounded-3xl border border-slate-200 shadow-sm">
        {/* Section 1 */}
        <section>
          <div className="flex items-center gap-3 mb-4 text-blue-600">
            <Info className="w-6 h-6" />
            <h2 className="text-2xl font-bold text-slate-900">1. Quy định chung</h2>
          </div>
          <p className="text-slate-600 leading-relaxed">
            Bằng việc đăng ký tài khoản và mua hàng tại hệ thống CataiShop, bạn đồng ý tuân thủ tuyệt đối các quy định và chính sách của chúng tôi. Chúng tôi bảo lưu quyền từ chối phục vụ hoặc khóa tài khoản vĩnh viễn nếu phát hiện có hành vi vi phạm.
          </p>
        </section>

        {/* Section 2 (Highlighted) */}
        <section className="bg-red-50 p-6 rounded-2xl border border-red-100">
          <div className="flex items-center gap-3 mb-4 text-red-600">
            <AlertTriangle className="w-6 h-6" />
            <h2 className="text-2xl font-bold text-red-700">2. Cấm Mua Tài Khoản Để Lừa Đảo Hoặc Vi Phạm Pháp Luật</h2>
          </div>
          <div className="text-slate-700 leading-relaxed space-y-3 font-medium">
            <p>Tuyệt đối nghiêm cấm việc sử dụng tài khoản, dịch vụ được cung cấp bởi CataiShop vào các mục đích:</p>
            <ul className="list-disc pl-5 space-y-2 text-red-600">
              <li>Thực hiện các hành vi lừa đảo chiếm đoạt tài sản.</li>
              <li>Phát tán phần mềm độc hại, vi-rút, hoặc spam tin nhắn rác.</li>
              <li>Chứa đựng, truyền tải các nội dung chống phá nhà nước, tuyên truyền văn hóa phẩm đồi trụy hoặc vi phạm pháp luật hiện hành.</li>
              <li>Mạo danh người khác hoặc tổ chức khác để gây ảnh hưởng xấu.</li>
            </ul>
            <p className="text-sm mt-4 italic text-red-500 font-bold">
              * Nếu phát hiện vi phạm, chúng tôi sẽ lập tức khóa tài khoản không hoàn tiền và cung cấp thông tin cho cơ quan chức năng khi được yêu cầu.
            </p>
          </div>
        </section>

        {/* Section 3 */}
        <section>
          <div className="flex items-center gap-3 mb-4 text-orange-500">
            <Shield className="w-6 h-6" />
            <h2 className="text-2xl font-bold text-slate-900">3. Chính sách Bảo hành</h2>
          </div>
          <ul className="list-disc pl-5 space-y-3 text-slate-600 leading-relaxed">
            <li>Cam kết bảo hành 1 đổi 1 trong suốt thời gian sử dụng dịch vụ đối với lỗi phát sinh từ phía nhà cung cấp.</li>
            <li>Từ chối bảo hành đối với các trường hợp: Tự ý thay đổi thông tin (Email/Password), chia sẻ tài khoản cho nhiều người sử dụng vượt quá giới hạn cho phép, hoặc vi phạm chính sách của nền tảng gốc (Netflix, OpenAI, Canva...).</li>
            <li>Thời gian xử lý bảo hành tối đa trong vòng 24 giờ làm việc.</li>
          </ul>
        </section>

        {/* Section 4 */}
        <section>
          <div className="flex items-center gap-3 mb-4 text-blue-600">
            <Lock className="w-6 h-6" />
            <h2 className="text-2xl font-bold text-slate-900">4. Bảo mật thông tin khách hàng</h2>
          </div>
          <p className="text-slate-600 leading-relaxed">
            CataiShop cam kết bảo vệ tuyệt đối thông tin cá nhân của khách hàng. Mọi dữ liệu về Email, Số điện thoại và Lịch sử giao dịch đều được mã hóa. Chúng tôi không chia sẻ hoặc mua bán dữ liệu cho bất kỳ bên thứ ba nào vì mục đích thương mại.
          </p>
        </section>
        
        {/* Section 5 (Reinforced point) */}
        <section className="bg-slate-50 p-6 rounded-2xl border border-slate-200">
          <div className="flex items-center gap-3 mb-4 text-slate-800">
            <Scale className="w-6 h-6 text-slate-600" />
            <h2 className="text-xl font-bold text-slate-900">5. Trách nhiệm pháp lý của người dùng</h2>
          </div>
          <p className="text-slate-600 leading-relaxed">
            Người dùng phải tự chịu hoàn toàn trách nhiệm trước pháp luật về mọi hành vi diễn ra trên hoặc thông qua tài khoản/dịch vụ mua từ hệ thống của chúng tôi. Việc cố tình phớt lờ điều khoản <strong>"Cấm sử dụng cho mục đích lừa đảo hoặc vi phạm pháp luật"</strong> đồng nghĩa với việc bạn từ bỏ mọi quyền được hệ thống bảo vệ.
          </p>
        </section>

      </div>
    </div>
  );
}
