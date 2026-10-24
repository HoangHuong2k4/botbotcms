export interface ProductMock {
  id: number;
  slug_web: string;
  name_web: string;
  image_web: string;
  description_web: string;
  price_web: number;
  badge?: string;
  features?: string[];
}

export const MOCK_PRODUCTS: ProductMock[] = [
  {
    id: 1,
    slug_web: 'chatgpt-plus-1-thang',
    name_web: 'Tài khoản ChatGPT Plus (1 Tháng)',
    image_web: 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&w=800&q=80',
    description_web: 'Truy cập GPT-4, DALL-E 3, lướt web và phân tích dữ liệu nâng cao. Tốc độ phản hồi cực nhanh.',
    price_web: 390000,
    badge: 'Bán chạy',
    features: ['GPT-4 & DALL-E 3', 'Tài khoản chính chủ', 'Bảo hành 1 đổi 1']
  },
  {
    id: 2,
    slug_web: 'canva-pro-vinh-vien',
    name_web: 'Canva Pro Nâng Cấp Chính Chủ',
    image_web: 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?auto=format&fit=crop&w=800&q=80',
    description_web: 'Mở khóa toàn bộ tính năng Canva Pro. Nâng cấp trực tiếp trên email cá nhân của bạn.',
    price_web: 150000,
    features: ['Nâng cấp email chính chủ', 'Hàng ngàn Template', 'Bảo hành vĩnh viễn']
  },
  {
    id: 3,
    slug_web: 'capcut-pro-1-nam',
    name_web: 'Tài khoản CapCut Pro (1 Năm)',
    image_web: 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?auto=format&fit=crop&w=800&q=80',
    description_web: 'Sử dụng mọi hiệu ứng, template, tính năng AI độc quyền của CapCut Pro.',
    price_web: 450000,
    badge: 'Hot',
    features: ['Full tính năng AI', 'Đăng nhập đa thiết bị', 'Bảo hành 1 năm']
  },
  {
    id: 4,
    slug_web: 'netflix-premium-1-thang',
    name_web: 'Netflix Premium (Profile Riêng)',
    image_web: 'https://images.unsplash.com/photo-1522869635100-9f4c5e86aa37?auto=format&fit=crop&w=800&q=80',
    description_web: 'Xem phim độ phân giải 4K Ultra HD. Profile riêng tư có mã PIN bảo mật.',
    price_web: 65000,
    features: ['4K Ultra HD', 'Profile cá nhân', 'Không chung đụng']
  }
];
