<?php

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Facades\MetaBox;
use Dev\Base\Supports\RepositoryHelper;
use Dev\Media\Facades\AppMedia;
use Dev\Menu\Facades\Menu;
use Dev\Menu\Models\Menu as MenuModel;
use Dev\News\Models\News;
use Dev\Slug\Facades\SlugHelper;
use Illuminate\Support\Facades\Log;

if (!function_exists('get_latest_news_data')) {
    /**
     * Lấy dữ liệu tin tức mới nhất cho React component
     *
     * @param int $limit Số lượng tin tức cần lấy (mặc định: 4)
     * @return array
     */
    function get_latest_news_data(int $limit = 4): array
    {
        try {
            $news = News::query()
                ->with('slugable')
                ->where('status', BaseStatusEnum::PUBLISHED)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get()
                ->map(function ($item) {
                    // Sử dụng SlugHelper để tạo URL cho bài news
                    $slug = SlugHelper::getSlug($item->slugable->key, null, News::class);
                    $url = $slug ? route('public.news.detail', ['slug' => $slug->key]) : '#';

                    // Sử dụng AppMedia để lấy URL đầy đủ của hình ảnh với size medium
                    $imageUrl = $item->image ? AppMedia::getImageUrl($item->image, 'medium') : '/ui/master/images/home/news-1.jpg';

                    return [
                        'id' => $item->id,
                        'name' => (string) $item->name,
                        'image' => $imageUrl,
                        'url' => $url,
                    ];
                })
                ->toArray();

            return $news;
        } catch (\Exception $e) {
            Log::error('Error getting latest news data: ' . $e->getMessage());
            return [];
        }
    }
}

if (!function_exists('get_news_paginated_data')) {
    /**
     * Lấy dữ liệu tin tức có phân trang cho trang news
     *
     * @param int $page Trang hiện tại (bắt đầu từ 1)
     * @param int $perPage Số tin tức mỗi trang (mặc định: 9)
     * @param int|null $categoryId ID của category để lọc (null = tất cả)
     * @return array
     */
    function get_news_paginated_data(int $page = 1, int $perPage = 9, ?int $categoryId = null): array
    {
        try {
            $offset = ($page - 1) * $perPage;

            $query = News::query()
                ->with('slugable')
                ->where('status', BaseStatusEnum::PUBLISHED);

            // Lọc theo category nếu có
            if ($categoryId) {
                $query->whereHas('categories', function ($q) use ($categoryId) {
                    $q->where('news_categories.id', $categoryId);
                });
            }

            $news = $query
                ->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($perPage)
                ->get()
                ->map(function ($item) {
                    // Sử dụng SlugHelper để tạo URL cho bài news
                    $slug = SlugHelper::getSlug($item->slugable->key, null, News::class);
                    $url = $slug ? route('public.news.detail', ['slug' => $slug->key]) : '#';

                    // Sử dụng AppMedia để lấy URL đầy đủ của hình ảnh với size medium
                    $imageUrl = $item->image ? AppMedia::getImageUrl($item->image, 'medium') : '/ui/master/images/home/news-1.jpg';

                    return [
                        'id' => $item->id,
                        'name' => (string) $item->name,
                        'image' => $imageUrl,
                        'url' => $url,
                    ];
                })
                ->toArray();

            // Đếm tổng số tin tức (có lọc theo category nếu có)
            $totalQuery = News::query()->where('status', BaseStatusEnum::PUBLISHED);
            if ($categoryId) {
                $totalQuery->whereHas('categories', function ($q) use ($categoryId) {
                    $q->where('news_categories.id', $categoryId);
                });
            }
            $totalNews = $totalQuery->count();

            // Kiểm tra xem còn tin tức không
            $hasMore = ($offset + $perPage) < $totalNews;

            return [
                'data' => $news,
                'currentPage' => $page,
                'perPage' => $perPage,
                'total' => $totalNews,
                'hasMore' => $hasMore,
                'nextPage' => $hasMore ? $page + 1 : null,
            ];
        } catch (\Exception $e) {
            Log::error('Error getting paginated news data: ' . $e->getMessage());
            return [
                'data' => [],
                'currentPage' => 1,
                'perPage' => $perPage,
                'total' => 0,
                'hasMore' => false,
                'nextPage' => null,
            ];
        }
    }
}

if (!function_exists('get_news_categories')) {
    /**
     * Lấy danh sách categories cho news
     *
     * @return array
     */
    function get_news_categories(): array
    {
        try {
            $categories = \Dev\News\Models\NewsCategories::query()
                ->where('status', BaseStatusEnum::PUBLISHED)
                ->withCount([
                    'news' => function ($query) {
                        $query->where('status', BaseStatusEnum::PUBLISHED);
                    }
                ])
                ->orderBy('id', 'asc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => (string) $item->name,
                        'news_count' => $item->news_count,
                    ];
                })
                ->toArray();

            return $categories;
        } catch (\Exception $e) {
            Log::error('Error getting news categories: ' . $e->getMessage());
            return [];
        }
    }
}

if (!function_exists('get_page_config')) {
    /**
     * Lấy config cho từng page template
     *
     * @param string $template Template name
     * @return array
     */
    function get_page_config(string $template): array
    {
        $configs = [
            'default' => [
                'layout' => 'default',
                'pageType' => 'default',
                'needsHeroData' => true,
                'needsNewsData' => true,
                'needsAppMedia' => true,
                'needsContentSectionData' => true, // Cần dữ liệu cho ContentSection
                'needsGalleryData' => true, // Cần dữ liệu cho GallerySection
                'needsLocationData' => true, // Cần dữ liệu cho LocationSection
                'needsInvestorsData' => true, // Cần dữ liệu cho DevelopersSection
                'needsTranslations' => false,
                'needsThemeOptions' => true,
            ],
            'about' => [
                'layout' => 'about',
                'pageType' => 'about',
                'needsHeroData' => false,
                'needsAboutData' => true,
                'needsAppMedia' => false,
                'needsTranslations' => true, // Cần translations cho footer
                'needsThemeOptions' => true, // Cần theme options cho footer
            ],
            'developer' => [
                'layout' => 'developer',
                'pageType' => 'developer',
                'needsHeroData' => false,
                'needsDeveloperData' => true,
                'needsAppMedia' => false,
                'needsTranslations' => false,
                'needsThemeOptions' => true,
            ],
            'projects' => [
                'layout' => 'projects',
                'pageType' => 'projects',
                'needsHeroData' => false,
                'needsProjectsData' => true,
                'needsAppMedia' => false,
                'needsTranslations' => false,
                'needsThemeOptions' => true,
            ],
            'develops' => [
                'layout' => 'develops',
                'pageType' => 'develops',
                'needsHeroData' => false,
                'needsNewsData' => false,
                'needsAppMedia' => false,
                'needsTranslations' => false,
                'needsThemeOptions' => true,
            ],
            'news' => [
                'layout' => 'news',
                'pageType' => 'news',
                'needsHeroData' => false,
                'needsNewsData' => true,
                'needsAppMedia' => true,
                'needsTranslations' => false,
                'needsThemeOptions' => true,
            ],
            'contact' => [
                'layout' => 'contact',
                'pageType' => 'contact',
                'needsHeroData' => false,
                'needsNewsData' => false,
                'needsAppMedia' => false,
                'needsContactData' => true,
                'needsTranslations' => false,
                'needsThemeOptions' => true,
            ],
            'facilities' => [
                'layout' => 'facilities',
                'pageType' => 'facilities',
                'needsHeroData' => false,
                'needsFacilitiesData' => true,
                'needsAppMedia' => true,
                'needsTranslations' => false,
                'needsThemeOptions' => true,
            ],
            'gallery' => [
                'layout' => 'gallery',
                'pageType' => 'gallery',
                'needsHeroData' => false,
                'needsGalleryData' => true,
                'needsAppMedia' => true,
                'needsTranslations' => false,
                'needsThemeOptions' => true,
            ],
            'layout' => [
                'layout' => 'layout',
                'pageType' => 'layout',
                'needsHeroData' => false,
                'needsLayoutData' => true,
                'needsAppMedia' => false,
                'needsTranslations' => false,
                'needsThemeOptions' => true,
            ],
            'realtime-collection' => [
                'layout' => 'realtime-collection',
                'pageType' => 'realtime-collection',
            ],
        ];
        return $configs[$template] ?? $configs['default'];
    }
}

if (!function_exists('get_meta_data')) {
    /**
     * @param Model $object
     * @param string $key
     * @param boolean $single
     * @param array $select
     * @return mixed
     */
    function get_meta_data($object, $key, $single = false, $select = ['meta_value'])
    {
        return MetaBox::getMetaData($object, $key, $single, $select);
    }
}

if (!function_exists('get_banner_image')) {
    /**
     * @param Model $object
     * @return string
     */
    function get_banner_image($object)
    {
        return AppMedia::getImageUrl(get_meta_data($object, 'banner_image', true));
    }
}

if (!function_exists('get_menu_data_as_array')) {
    /**
     * Lấy menu data dưới dạng array cho React/JSON
     *
     * @param string $location Menu location slug (ví dụ: 'footer-menu', 'footer-policies-menu')
     * @return array
     */
    function get_menu_data_as_array(string $location): array
    {
        try {
            // Get menu model for the location với RepositoryHelper để apply filters
            $query = MenuModel::query()
                ->wherePublished()
                ->whereHas('locations', function ($query) use ($location) {
                    $query->where('location', $location);
                })
                ->with([
                    'menuNodes' => function ($query) {
                        $query->orderBy('position');
                    },
                    'menuNodes.child' => function ($query) {
                        $query->orderBy('position');
                    },
                ]);

            // Apply before execute query filters (theo best practices Botble CMS)
            $menuModel = RepositoryHelper::applyBeforeExecuteQuery($query, new MenuModel(), true)->first();

            if (!$menuModel) {
                return [];
            }

            // Get root menu nodes (parent_id = 0)
            $menuNodes = $menuModel->menuNodes->where('parent_id', 0)->sortBy('position');

            // Convert to array recursively
            return convert_menu_nodes_to_array($menuNodes);
        } catch (\Exception $e) {
            Log::error('Error getting menu data as array: ' . $e->getMessage());
            return [];
        }
    }
}

if (!function_exists('convert_menu_nodes_to_array')) {
    /**
     * Convert menu nodes collection to array recursively
     *
     * @param \Illuminate\Support\Collection $menuNodes
     * @return array
     */
    function convert_menu_nodes_to_array($menuNodes): array
    {
        $result = [];

        foreach ($menuNodes as $node) {
            $item = [
                'id' => $node->id,
                'title' => $node->title,
                'url' => $node->url,
                'target' => $node->target ?: '_self',
                'css_class' => $node->css_class,
                'icon_font' => $node->icon_font,
                'position' => $node->position,
            ];

            // Add icon_html if available
            if ($node->icon_html) {
                $item['icon_html'] = (string) $node->icon_html;
            }

            // Recursively add children
            if ($node->child && $node->child->isNotEmpty()) {
                $item['children'] = convert_menu_nodes_to_array($node->child);
            }

            $result[] = $item;
        }

        return $result;
    }
}
