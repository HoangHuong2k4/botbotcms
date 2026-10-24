<?php

use Dev\Translation\Manager;

if (!function_exists('get_theme_translations')) {
    /**
     * Lấy theme translations dưới dạng array
     *
     * @param string|null $lo
     * @param bool $withInherit Có lấy translations từ inherit theme khôngcale Locale code (mặc định: locale hiện tại của app)
     * @return array
     */
    function get_theme_translations(?string $locale = null, bool $withInherit = true): array
    {
        $locale = $locale ?: app()->getLocale() ?: 'en';

        try {
            $manager = app(Manager::class);
            return $manager->getThemeTranslations($locale, $withInherit);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error getting theme translations: ' . $e->getMessage());
            return [];
        }
    }
}

if (!function_exists('get_theme_translations_json_response')) {
    /**
     * Lấy theme translations dưới dạng JSON response cho API
     *
     * @param string|null $locale Locale code
     * @return \Illuminate\Http\JsonResponse
     */
    function get_theme_translations_json_response(?string $locale = null): \Illuminate\Http\JsonResponse
    {
        $locale = $locale ?: request()->input('locale')
            ?: request()->header('X-Locale')
            ?: app()->getLocale()
            ?: 'en';

        try {
            $translations = get_theme_translations($locale, true);

            return response()->json([
                'error' => false,
                'data' => $translations,
                'locale' => $locale,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'data' => [],
                'locale' => $locale,
            ], 500);
        }
    }
}

