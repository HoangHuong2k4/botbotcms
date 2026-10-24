@php
    /**
     * Chuẩn hoá dữ liệu theo slug (dùng cho section_1,2,3...)
     * - Field thường => slug => value
     * - Repeater => slug => [ items đã normalize ]
     */
    if (!function_exists('normalizeSection')) {
        function normalizeSection($data)
        {
            $result = [];

            foreach ((array) $data as $node) {
                // Field có slug
                if (is_array($node) && isset($node['slug'])) {
                    $slug = $node['slug'];
                    $value = $node['value'] ?? null;

                    // Nếu là repeater → xử lý tiếp
                    if (is_array($value)) {
                        $result[$slug] = normalizeSection($value);
                    } else {
                        if ($value !== '' && $value !== null) {
                            // ✅ convert các field ảnh sang FULL URL
                            if (preg_match('/^(anh_theo_level|anh_lay_theo_level|image|banner|hinh|anh)/i', $slug)) {
                                $value = get_object_image($value);
                            }

                            $result[$slug] = $value;
                        }
                    }
                }
                // Group / list lồng
                elseif (is_array($node)) {
                    $result[] = normalizeSection($node);
                }
            }

            return $result;
        }
    }

    $page = Theme::get('page');
    $shopHouseFinal = [];
    $terraceFinal = [];
    $clubHouseFinal = [];

    if (!empty($page)) {
        $layoutData = get_field($page, 'kieu_nha') ?? [];

        // các section cần xử lý giống nhau
        $sectionSlugs = ['section_1', 'section_2', 'section_3'];

        // khởi tạo
        foreach ($sectionSlugs as $s) {
            $shopHouseFinal[$s] = [];
            $terraceFinal[$s] = [];
            $clubHouseFinal[$s] = [];
        }

        // duyệt từng group (mỗi loại nhà)
        foreach ($layoutData as $group) {
            $loaiNha = null;
            $sectionsRaw = [];

            foreach ($group as $item) {
                $slug = $item['slug'] ?? null;
                if (!$slug) {
                    continue;
                }

                // lấy loại nhà
                if ($slug === 'ten_kieu_nha') {
                    $loaiNha = $item['value'] ?? null;
                }

                // lấy dữ liệu section
                if (in_array($slug, $sectionSlugs, true)) {
                    $sectionsRaw[$slug] = $item['value'] ?? [];
                }
            }

            // Xác định loại nhà (Shop House, Terrace House hoặc Club House)
            $isShopHouse = false;
            $isTerrace = false;
            $isClubHouse = false;

            if ($loaiNha) {
                $loaiNhaLower = strtolower($loaiNha);
                $isShopHouse = strpos($loaiNhaLower, 'shop') !== false || strpos($loaiNhaLower, 'shophouse') !== false;
                $isTerrace =
                    strpos($loaiNhaLower, 'terrace') !== false || strpos($loaiNhaLower, 'terracehouse') !== false;
                $isClubHouse = strpos($loaiNhaLower, 'club') !== false || strpos($loaiNhaLower, 'clubhouse') !== false;
            }

            // build section output cho Shop House
            if ($isShopHouse) {
                foreach ($sectionSlugs as $sectionSlug) {
                    if (!empty($sectionsRaw[$sectionSlug])) {
                        $normalized = normalizeSection($sectionsRaw[$sectionSlug]);

                        $shopHouseFinal[$sectionSlug][] = array_merge(
                            ['loai_nha' => $loaiNha],
                            is_array($normalized) ? $normalized : [],
                        );
                    }
                }
            }

            // build section output cho Terrace House
            if ($isTerrace) {
                foreach ($sectionSlugs as $sectionSlug) {
                    if (!empty($sectionsRaw[$sectionSlug])) {
                        $normalized = normalizeSection($sectionsRaw[$sectionSlug]);

                        $terraceFinal[$sectionSlug][] = array_merge(
                            ['loai_nha' => $loaiNha],
                            is_array($normalized) ? $normalized : [],
                        );
                    }
                }
            }

            // build section output cho Club House
            if ($isClubHouse) {
                foreach ($sectionSlugs as $sectionSlug) {
                    if (!empty($sectionsRaw[$sectionSlug])) {
                        $normalized = normalizeSection($sectionsRaw[$sectionSlug]);

                        $clubHouseFinal[$sectionSlug][] = array_merge(
                            ['loai_nha' => $loaiNha],
                            is_array($normalized) ? $normalized : [],
                        );
                    }
                }
            }
        }
    }

    $SliderData = get_field($page, 'slider_phoi_canh') ?? [];
    $SliderDataInfoCustomFields = [];

    foreach ($SliderData as $key => $item) {
        $SliderDataInfoCustomFields[] = [
            'id' => $key,
            'title' => get_sub_field($item, 'title', ''),
            'content' => get_sub_field($item, 'content', ''),
            'image' => get_object_image(get_sub_field($item, 'image', '')),
        ];
    }

    // dd($SliderDataInfoCustomFields);
    // dd("shophouse", $shopHouseFinal, "terrace", $terraceFinal, "clubhouse", $clubHouseFinal);

@endphp

<script>
    window.shopHouseData = @json($shopHouseFinal);
    window.terraceData = @json($terraceFinal);
    window.clubHouseData = @json($clubHouseFinal);
    window.sliderData = @json($SliderDataInfoCustomFields);
</script>
