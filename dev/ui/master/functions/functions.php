<?php

use Dev\Base\Forms\FieldOptions\MediaImageFieldOption;
use Dev\Base\Forms\Fields\MediaImageField;
use Dev\Base\Forms\FormAbstract;
use Dev\Blog\Models\Post;
use Dev\Media\Facades\AppMedia;
use Dev\Page\Models\Page;
use Dev\Theme\Facades\Theme;
use Dev\Theme\Supports\ThemeSupport;
use Dev\Theme\Typography\TypographyItem;
use Dev\Widget\Events\RenderingWidgetSettings;

app()->booted(function (): void {
    // Load helper functions
    require_once __DIR__ . '/helper.php';
    require_once __DIR__ . '/translation-helpers.php';

    AppMedia::addSize('featured', 565, 375)
        ->addSize('medium', 630, 510)
        ->addSize('small', 375, 250)
        ->addSize('home-hero-1920x1080', 1920, 1080)
        ->addSize('home-hero-1680', 1680, 945);

    Theme::typography()
        ->registerFontFamilies([
            new TypographyItem('primary', __('Primary'), theme_option('primary_font', 'Roboto')),
        ])
        ->registerFontSizes([
            new TypographyItem('h1', __('Heading 1'), 28),
            new TypographyItem('h2', __('Heading 2'), 24),
            new TypographyItem('h3', __('Heading 3'), 22),
            new TypographyItem('h4', __('Heading 4'), 20),
            new TypographyItem('h5', __('Heading 5'), 18),
            new TypographyItem('h6', __('Heading 6'), 16),
            new TypographyItem('body', __('Body'), 14),
        ]);

    ThemeSupport::registerSocialLinks();
    ThemeSupport::registerToastNotification();
    ThemeSupport::registerPreloader();
    ThemeSupport::registerSiteCopyright();
    ThemeSupport::registerDateFormatOption();
    ThemeSupport::registerLazyLoadImages();
    ThemeSupport::registerSocialSharing();
    ThemeSupport::registerSiteLogoHeight();

    register_page_template([
        'default' => __('Home'),
        'about' => __('About'),
        'contact' => __('Contact'),
        'news' => __('News'),
        'facilities' => __('Facilities'),
        'gallery' => __('Gallery'),
        'layout' => __('Layout'),
        'no-sidebar' => __('No sidebar'),
        'realtime-collection' => __('Realtime collection'),
    ]);

    app('events')->listen(RenderingWidgetSettings::class, function (): void {
        register_sidebar([
            'id' => 'top_sidebar',
            'name' => __('Top sidebar'),
            'description' => __('Area for widgets on the top sidebar'),
        ]);

        register_sidebar([
            'id' => 'footer_sidebar',
            'name' => __('Footer sidebar'),
            'description' => __('Area for footer widgets'),
        ]);
    });

    // FormAbstract::extend(function (FormAbstract $form): void {
    //     $model = $form->getModel();

    //     if (!$model instanceof Post && !$model instanceof Page) {
    //         return;
    //     }

    //     $form
    //         ->addAfter(
    //             'image',
    //             'banner_image',
    //             MediaImageField::class,
    //             MediaImageFieldOption::make()->label(__('Banner image (1920x600px)'))->metadata()
    //         );
    // }, 124);

    // FormAbstract::afterSaving(function (FormAbstract $form): void {
    //     if (! $form instanceof MemberPostForm) {
    //         return;
    //     }

    //     $request = $form->getRequest();

    //     $request->validate([
    //         'banner_image_input' => ['nullable', new MediaImageRule()],
    //     ]);

    //     /**
    //      * @var Post $model
    //      */
    //     $model = $form->getModel();

    //     $model->saveMetaDataFromFormRequest('banner_image', $request);
    // }, 175);
});
