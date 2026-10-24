<?php

namespace Dev\Theme\Providers;

use Dev\Base\Facades\AdminAppearance;
use Dev\Base\Facades\BaseHelper;
use Dev\Base\Facades\Html;
use Dev\Base\Forms\FieldOptions\MediaFileFieldOption;
use Dev\Base\Forms\FieldOptions\SelectFieldOption;
use Dev\Base\Forms\FieldOptions\TextareaFieldOption;
use Dev\Base\Forms\Fields\MediaFileField;
use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Forms\Fields\OnOffCheckboxField;
use Dev\Base\Forms\Fields\RadioField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Base\Rules\OnOffRule;
use Dev\Base\Supports\Language;
use Dev\Base\Supports\ServiceProvider;
use Dev\Dashboard\Events\RenderingDashboardWidgets;
use Dev\Dashboard\Supports\DashboardWidgetInstance;
use Dev\Media\Facades\AppMedia;
use Dev\Page\Models\Page;
use Dev\Page\Tables\PageTable;
use Dev\Setting\Forms\AdminAppearanceSettingForm;
use Dev\Setting\Forms\GeneralSettingForm;
use Dev\Setting\Http\Requests\AdminAppearanceRequest;
use Dev\Setting\Http\Requests\GeneralSettingRequest;
use Dev\Shortcode\Compilers\Shortcode;
use Dev\Shortcode\Compilers\ShortcodeCompiler;
use Dev\Shortcode\Forms\ShortcodeForm;
use Dev\Support\Http\Requests\Request;
use Dev\Theme\Events\RenderingThemeOptionSettings;
use Dev\Theme\Facades\AdminBar;
use Dev\Theme\Facades\Theme;
use Dev\Theme\Supports\ThemeSupport;
use Dev\Theme\Supports\Vimeo;
use Dev\Theme\Supports\Youtube;
use Dev\Theme\ThemeOption\Fields\RadioField as ThemeOptionRadioField;
use Dev\Theme\ThemeOption\ThemeOptionSection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        PageTable::beforeRendering(function (): void {
            add_filter(PAGE_FILTER_PAGE_NAME_IN_ADMIN_LIST, function (string $name, Page $page) {
                if (BaseHelper::isHomepage($page->getKey())) {
                    $name .= Html::tag('span', ' — ' . trans('libs/page::pages.front_page'), [
                        'class' => 'additional-page-name',
                    ])->toHtml();
                }

                return $name;
            }, 10, 2);
        });

        $this->app['events']->listen(RenderingDashboardWidgets::class, function (): void {
            if (! config('libs.theme.general.display_theme_manager_in_admin_panel', true)) {
                return;
            }

            add_filter(DASHBOARD_FILTER_ADMIN_LIST, [$this, 'addStatsWidgets'], 4, 2);
        });

        add_filter('get_http_exception_view', function (string $defaultView, HttpExceptionInterface $exception) {
            if (view()->exists($view = Theme::getThemeNamespace('views.' . $exception->getStatusCode()))) {
                return $view;
            }

            return $defaultView;
        }, 10, 2);

        add_filter('core_email_template_site_logo', function (?string $defaultLogo): string {
            if (! $defaultLogo && ($logo = Theme::getLogo())) {
                $defaultLogo = AppMedia::getImageUrl($logo);
            }

            return $defaultLogo;
        });

        add_filter('email_template_logo', fn ($logo) => empty($logo) ? Theme::getLogo() : $logo);
        add_filter('email_template_logo_helper_text', function ($helperText) {
            return trans('libs/theme::theme.email_template_logo_helper_text')
                . '<br />'
                . $helperText;
        });
        add_filter(
            'email_template_copyright_text',
            fn ($copyrightText) => empty($copyrightText) ? Theme::getSiteCopyright() : $copyrightText
        );
        add_filter('email_template_copyright_helper_text', function ($helperText) {
            return $helperText;
        });

        Theme::typography()->renderThemeOptions();

        $this->app['events']->listen(RenderingThemeOptionSettings::class, function (): void {
            theme_option()
                ->setSection(
                    ThemeOptionSection::make('opt-text-subsection-general')
                        ->title(trans('libs/theme::theme.theme_option_general'))
                        ->icon('ti ti-home')
                        ->priority(0)
                        ->fields([
                            [
                                'id' => 'site_title',
                                'type' => 'text',
                                'label' => trans('core/setting::setting.general.site_title'),
                                'attributes' => [
                                    'name' => 'site_title',
                                    'value' => null,
                                    'options' => [
                                        'class' => 'form-control',
                                        'placeholder' => trans('core/setting::setting.general.site_title'),
                                        'data-counter' => 255,
                                    ],
                                ],
                            ],
                            [
                                'id' => 'show_site_name',
                                'section_id' => 'opt-text-subsection-general',
                                'type' => 'customSelect',
                                'label' => trans('core/setting::setting.general.show_site_name'),
                                'attributes' => [
                                    'name' => 'show_site_name',
                                    'list' => [
                                        '0' => trans('libs/theme::theme.common.no'),
                                        '1' => trans('libs/theme::theme.common.yes'),
                                    ],
                                    'value' => '0',
                                ],
                            ],
                            [
                                'id' => 'site_title_separator',
                                'section_id' => 'opt-text-subsection-general',
                                'type' => 'customSelect',
                                'label' => trans('libs/theme::theme.site_title_separator'),
                                'attributes' => [
                                    'name' => 'site_title_separator',
                                    'list' => [
                                        '-' => trans('libs/theme::theme.common.dash'),
                                        '|' => trans('libs/theme::theme.common.pipe'),
                                    ],
                                    'value' => '-',
                                ],
                            ],
                            [
                                'id' => 'seo_title',
                                'type' => 'text',
                                'label' => trans('core/setting::setting.general.seo_title'),
                                'attributes' => [
                                    'name' => 'seo_title',
                                    'value' => null,
                                    'options' => [
                                        'class' => 'form-control',
                                        'placeholder' => trans('core/setting::setting.general.seo_title'),
                                        'data-counter' => 120,
                                    ],
                                ],
                            ],
                            [
                                'id' => 'seo_description',
                                'type' => 'textarea',
                                'label' => trans('core/setting::setting.general.seo_description'),
                                'attributes' => [
                                    'name' => 'seo_description',
                                    'value' => null,
                                    'options' => [
                                        'class' => 'form-control',
                                        'rows' => 4,
                                    ],
                                ],
                            ],
                            [
                                'id' => 'seo_keywords',
                                'type' => 'helper',
                                'label' => false,
                                'attributes' => [
                                    'value' => null,
                                    'content' => view('libs/theme::partials.no-meta-keywords')->render(),
                                ],
                            ],
                            [
                                'id' => 'seo_index',
                                'type' => 'customRadio',
                                'label' => trans('libs/theme::theme.theme_option_seo_index'),
                                'attributes' => [
                                    'name' => 'seo_index',
                                    'values' => [
                                        true => trans('libs/theme::theme.seo_index_options.index'),
                                        false => trans('libs/theme::theme.seo_index_options.no_index'),
                                    ],
                                    'value' => true,
                                ],
                                'helper' => trans('libs/theme::theme.theme_option_seo_index_helper'),
                            ],
                            [
                                'id' => 'seo_og_image',
                                'type' => 'mediaImage',
                                'label' => trans('libs/theme::theme.theme_option_seo_open_graph_image'),
                                'helper' => trans('libs/theme::theme.theme_option_seo_open_graph_image_helper'),
                                'attributes' => [
                                    'name' => 'seo_og_image',
                                    'value' => null,
                                ],
                            ],
                            [
                                'id' => 'term_and_privacy_policy_url',
                                'type' => 'text',
                                'label' => trans('libs/theme::theme.term_and_privacy_policy_url'),
                                'attributes' => [
                                    'name' => 'term_and_privacy_policy_url',
                                    'value' => null,
                                    'options' => [
                                        'class' => 'form-control',
                                        'placeholder' => 'https://example.com/term-and-privacy-policy',
                                    ],
                                ],
                            ],
                        ])
                )
                ->setSection(
                    ThemeOptionSection::make('opt-text-subsection-breadcrumb')
                        ->title(trans('libs/theme::theme.theme_option_breadcrumb'))
                        ->icon('ti ti-directions')
                        ->priority(0)
                        ->fields([
                            ThemeOptionRadioField::make()
                                ->name('theme_breadcrumb_enabled')
                                ->label(trans('libs/theme::theme.breadcrumb_enabled'))
                                ->priority(0)
                                ->defaultValue(true)
                                ->options([
                                    true => trans('libs/theme::theme.common.yes'),
                                    false => trans('libs/theme::theme.common.no'),
                                ]),
                        ])
                )
                ->setSection(
                    ThemeOptionSection::make('opt-text-subsection-logo')
                        ->title(trans('libs/theme::theme.theme_option_logo'))
                        ->icon('ti ti-photo')
                        ->priority(0)
                        ->fields([
                            [
                                'id' => 'favicon',
                                'type' => 'mediaImage',
                                'label' => trans('libs/theme::theme.theme_option_favicon'),
                                'attributes' => [
                                    'name' => 'favicon',
                                    'value' => null,
                                    'attributes' => ['allow_thumb' => false],
                                ],
                            ],
                            [
                                'id' => 'favicon_type',
                                'type' => 'customSelect',
                                'label' => trans('libs/theme::theme.theme_option_favicon_type'),
                                'attributes' => [
                                    'name' => 'favicon_type',
                                    'list' => [
                                        'image/x-icon' => 'ICO',
                                        'image/png' => 'PNG',
                                        'image/svg+xml' => 'SVG',
                                        'image/gif' => 'GIF',
                                        'image/jpeg' => 'JPEG',
                                        'image/webp' => 'WebP',
                                    ],
                                    'value' => 'image/x-icon',
                                    'options' => [
                                        'class' => 'form-control',
                                    ],
                                ],
                            ],
                            [
                                'id' => 'logo',
                                'type' => 'mediaImage',
                                'label' => trans('libs/theme::theme.theme_option_logo'),
                                'attributes' => [
                                    'name' => 'logo',
                                    'value' => null,
                                    'attributes' => ['allow_thumb' => false],
                                ],
                            ],
                        ])
                );
        });

        add_shortcode('media', trans('libs/theme::theme.media_shortcode.title'), trans('libs/theme::theme.media_shortcode.description'), function (Shortcode $shortcode) {
            $url = $shortcode->url;

            if (! $url) {
                return null;
            }

            $url = rtrim($url, '/');

            if (! $url) {
                return null;
            }

            $data = [
                'url' => $url,
            ];

            if ($shortcode->width) {
                $data['width'] = $shortcode->width;
            }

            if ($shortcode->height) {
                $data['height'] = $shortcode->height;
            }

            if ($shortcode->centered && $shortcode->centered === 'yes') {
                $data['centered'] = true;
            }

            if ($shortcode->margin_top || $shortcode->margin_top === '0') {
                $data['margin_top'] = (int) $shortcode->margin_top;
            }

            if ($shortcode->margin_bottom || $shortcode->margin_bottom === '0') {
                $data['margin_bottom'] = (int) $shortcode->margin_bottom;
            }

            if ($shortcode->margin_start || $shortcode->margin_start === '0') {
                $data['margin_start'] = (int) $shortcode->margin_start;
            }

            if ($shortcode->margin_end || $shortcode->margin_end === '0') {
                $data['margin_end'] = (int) $shortcode->margin_end;
            }

            $type = null;

            if (Youtube::isYoutubeURL($url)) {
                $data['url'] = Youtube::getYoutubeVideoEmbedURL($url);

                $type = 'youtube';
            } elseif (Vimeo::isVimeoURL($url)) {
                $videoId = Vimeo::getVimeoID($url);
                if ($videoId) {
                    $data['url'] = 'https://player.vimeo.com/video/' . $videoId;

                    $type = 'vimeo';
                }
            } elseif (preg_match(
                '/^.*https:\/\/(?:m|www|vm)?\.?tiktok\.com\/((?:.*\b(?:(?:usr|v|embed|user|video)\/|\?shareId=|\&item_id=)(\d+))|\w+)/',
                $url
            )) {
                $type = 'tiktok';

                $data['url'] = $url;
                $data['video_id'] = Str::afterLast($url, 'video/');

                Theme::asset()->container('footer')->add(
                    'tiktok-embed',
                    'https://www.tiktok.com/embed.js',
                    attributes: ['async' => true]
                );
            } elseif (preg_match('/^.*https:\/\/twitter\.com\/(?:#!\/)?(\w+)\/status(es)?\/(\d+)/', $url)) {
                $data['url'] = $url;

                $type = 'twitter';

                Theme::asset()->container('footer')->add(
                    'twitter-embed',
                    'https://platform.twitter.com/widgets.js',
                    attributes: ['async' => true, 'charset' => 'utf-8']
                );
            } elseif (in_array(Str::lower(File::extension($url)), ['mp4', 'webm', 'ogg'])) {
                $data['width'] = $shortcode->width ?: '100%';
                $data['height'] = $shortcode->height ?: 400;
                $data['extension'] = File::extension($url) ?: 'mp4';
                $data['url'] = $url;

                $type = 'video';
            }

            return view('libs/theme::shortcodes.media', ['type' => $type, 'data' => $data])->render();
        });

        shortcode()->setPreviewImage('media', asset('vendor/core/libs/theme/images/ui-blocks/media.jpg'));

        shortcode()->setAdminConfig('media', function (array $attributes) {
            return ShortcodeForm::createFromArray($attributes)
                ->add('url', TextField::class, [
                    'label' => trans('libs/theme::theme.media_shortcode.url'),
                    'attr' => [
                        'placeholder' => trans('libs/theme::theme.media_shortcode.url_placeholder'),
                    ],
                ])
                ->add('width', NumberField::class, [
                    'label' => trans('libs/theme::theme.media_shortcode.width'),
                    'default_value' => 420,
                ])
                ->add('height', NumberField::class, [
                    'label' => trans('libs/theme::theme.media_shortcode.height'),
                    'default_value' => 315,
                ])
                ->add('centered', RadioField::class, [
                    'label' => trans('libs/theme::theme.media_shortcode.center'),
                    'values' => [
                        'no' => trans('libs/theme::theme.common.no'),
                        'yes' => trans('libs/theme::theme.common.yes'),
                    ],
                    'default_value' => 'no',
                ])
                ->add('margin_top', NumberField::class, [
                    'label' => trans('libs/theme::theme.media_shortcode.margin_top'),
                    'default_value' => 0,
                ])
                ->add('margin_bottom', NumberField::class, [
                    'label' => trans('libs/theme::theme.media_shortcode.margin_bottom'),
                    'default_value' => 20,
                ])
                ->add('margin_start', NumberField::class, [
                    'label' => trans('libs/theme::theme.media_shortcode.margin_start'),
                    'default_value' => 0,
                    'helper' => trans('libs/theme::theme.media_shortcode.margin_start_helper'),
                ])
                ->add('margin_end', NumberField::class, [
                    'label' => trans('libs/theme::theme.media_shortcode.margin_end'),
                    'default_value' => 0,
                    'helper' => trans('libs/theme::theme.media_shortcode.margin_end_helper'),
                ]);
        });

        add_shortcode('audio', trans('libs/theme::theme.audio_shortcode.title'), trans('libs/theme::theme.audio_shortcode.description'), function (Shortcode $shortcode) {
            $url = $shortcode->url;

            if (! $url) {
                return null;
            }

            $url = rtrim($url, '/');

            if (! $url) {
                return null;
            }

            $data = [
                'url' => $url,
                'type' => $shortcode->type ?: 'audio/mpeg',
            ];

            return view('libs/theme::shortcodes.audio', ['data' => $data])->render();
        });

        shortcode()->setAdminConfig('audio', function (array $attributes) {
            return ShortcodeForm::createFromArray($attributes)
                ->add('url', MediaFileField::class, MediaFileFieldOption::make()->label(trans('libs/theme::theme.audio_shortcode.url')))
                ->add('type', SelectField::class, [
                    'label' => trans('libs/theme::theme.audio_shortcode.type'),
                    'choices' => [
                        'audio/mpeg' => 'audio/mpeg',
                        'audio/ogg' => 'audio/ogg',
                        'audio/wav' => 'audio/wav',
                    ],
                ]);
        });

        shortcode()->ignoreLazyLoading(['media', 'audio']);

        add_filter(THEME_FRONT_HEADER, function (?string $html): ?string {
            $file = Theme::getStyleIntegrationPath();
            if ($this->app['files']->exists($file)) {
                $html .= PHP_EOL . Html::style(Theme::asset()->url('css/style.integration.css?v=' . filectime($file)));
            }

            return $html;
        }, 15);

        if (! BaseHelper::hasDemoModeEnabled()) {
            if (config('libs.theme.general.enable_custom_html_shortcode')) {
                add_shortcode(
                    'custom-html',
                    trans('libs/theme::theme.custom_html_shortcode.title'),
                    trans('libs/theme::theme.custom_html_shortcode.description'),
                    function (Shortcode $shortcode) {
                        return html_entity_decode($shortcode->getContent());
                    }
                );

                shortcode()->setPreviewImage(
                    'custom-html',
                    asset('vendor/core/libs/shortcode/images/placeholder-code.jpg')
                );

                shortcode()->setAdminConfig('custom-html', function (array $attributes, ?string $content) {
                    return ShortcodeForm::createFromArray($attributes)
                        ->add(
                            'content',
                            TextareaField::class,
                            TextareaFieldOption::make()
                                ->label(trans('libs/theme::theme.common.content'))
                                ->placeholder(trans('libs/theme::theme.common.html_code'))
                                ->rows(3)
                                ->addAttribute('data-shortcode-attribute', 'content')
                                ->value($content)
                                ->maxLength(100000)
                        );
                });

                shortcode()->ignoreLazyLoading(['custom-html']);
            }

            if (config('libs.theme.general.enable_custom_js')) {
                if (setting('custom_header_js')) {
                    add_filter(THEME_FRONT_HEADER, function (?string $html): string {
                        return $html . ThemeSupport::getCustomJS('header');
                    }, 15);
                }

                if (setting('custom_body_js')) {
                    add_filter(THEME_FRONT_BODY, function (?string $html): string {
                        return $html . ThemeSupport::getCustomJS('body');
                    }, 15);
                }

                if (setting('custom_footer_js')) {
                    add_filter(THEME_FRONT_FOOTER, function (?string $html): string {
                        return $html . ThemeSupport::getCustomJS('footer');
                    }, 15);
                }
            }

            // Add Google Tag Manager noscript to body
            add_filter(THEME_FRONT_BODY, function (?string $html): string {
                return ThemeSupport::renderGoogleTagManagerNoscript() . $html;
            }, 10);

            if (config('libs.theme.general.enable_custom_html')) {
                if (setting('custom_header_html')) {
                    add_filter(THEME_FRONT_HEADER, function (?string $html): string {
                        return $html . ThemeSupport::getCustomHtml('header');
                    }, 16);
                }

                if (setting('custom_body_html')) {
                    add_filter(THEME_FRONT_BODY, function (?string $html): string {
                        return $html . ThemeSupport::getCustomHtml('body');
                    }, 16);
                }

                if (setting('custom_footer_html')) {
                    add_filter(THEME_FRONT_FOOTER, function (?string $html): string {
                        return $html . ThemeSupport::getCustomHtml('footer');
                    }, 16);
                }
            }
        }

        add_filter(THEME_FRONT_FOOTER, function (?string $html): ?string {
            try {
                if (! Auth::guard()->check() || ! AdminBar::isDisplay() || ! (int) setting('show_admin_bar', 1)) {
                    return $html;
                }

                return $html . Html::style('vendor/core/libs/theme/css/admin-bar.css') . AdminBar::render();
            } catch (Throwable) {
                return $html;
            }
        }, 14);

        add_filter(
            'shortcode_content_compiled',
            function (?string $html, string $name, $callback, ShortcodeCompiler $compiler) {
                $editLink = $compiler->getEditLink();

                if (! $editLink || ! setting('show_theme_guideline_link', false)) {
                    return $html;
                }

                Theme::asset()
                    ->usePath(false)
                    ->add('theme-guideline-css', asset('vendor/core/libs/theme/css/guideline.css'));

                $link = view('libs/theme::guideline-link', [
                    'html' => $html,
                    'editLink' => $editLink . '?shortcode=' . $compiler->getName(),
                    'editLabel' => trans('libs/theme::theme.shortcode_labels.edit_this_shortcode'),
                ])->render();

                return ThemeSupport::insertBlockAfterTopHtmlTags($link, $html);
            },
            9999,
            4
        );

        add_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, function (): void {
            if (BaseHelper::getRichEditor() === 'ckeditor') {
                Theme::asset()
                    ->add('ckeditor-content-styles', 'vendor/core/core/base/libraries/ckeditor/content-styles.css');
            }
        }, 15);

        GeneralSettingForm::extend(function (GeneralSettingForm $form): void {
            $availableLocales = Language::getAvailableLocales();

            $form
                ->when(! empty($availableLocales), function (FormAbstract $form) use ($availableLocales): void {
                    $defaultLocale = setting('locale', App::getLocale());

                    if (
                        BaseHelper::hasDemoModeEnabled()
                        && session('site-locale')
                        && array_key_exists(session('site-locale'), $availableLocales)
                    ) {
                        $defaultLocale = session('site-locale');
                    }

                    $form
                        ->addAfter(
                            'time_zone',
                            'locale',
                            SelectField::class,
                            SelectFieldOption::make()
                                ->label(trans('core/setting::setting.general.locale'))
                                ->choices(collect($availableLocales)
                                    ->pluck('name', 'locale')
                                    ->map(fn ($item, $key) => $item . ' - ' . $key)
                                    ->all())
                                ->selected($defaultLocale)
                                ->searchable()
                        );
                })
                ->addAfter('time_zone', 'locale_direction', RadioField::class, [
                    'label' => trans('core/setting::setting.general.locale_direction'),
                    'value' => setting('locale_direction', 'ltr'),
                    'values' => [
                        'ltr' => trans('core/setting::setting.locale_direction_ltr'),
                        'rtl' => trans('core/setting::setting.locale_direction_rtl'),
                    ],
                ])
                ->addAfter('enable_send_error_reporting_via_email', 'redirect_404_to_homepage', OnOffCheckboxField::class, [
                    'label' => trans('core/setting::setting.general.redirect_404_to_homepage'),
                    'value' => setting('redirect_404_to_homepage', false),
                ]);
        }, 110);

        add_filter('core_request_rules', function ($rules, Request $request) {
            if ($request instanceof GeneralSettingRequest) {
                $rules = [
                    ...$rules,
                    'locale' => ['sometimes', Rule::in(array_keys(Language::getAvailableLocales()))],
                    'locale_direction' => ['sometimes', 'in:ltr,rtl'],
                    'redirect_404_to_homepage' => [new OnOffRule()],
                ];
            }

            return $rules;
        }, 110, 2);

        AdminAppearanceSettingForm::extend(function (AdminAppearanceSettingForm $form): void {
            $form
                ->addAfter(AdminAppearance::getSettingKey('show_menu_item_icon'), 'show_admin_bar', OnOffCheckboxField::class, [
                    'label' => trans('core/setting::setting.admin_appearance.form.show_admin_bar'),
                    'value' => setting('show_admin_bar', true),
                ])
                ->addAfter('show_admin_bar', 'show_theme_guideline_link', OnOffCheckboxField::class, [
                    'label' => trans('core/setting::setting.admin_appearance.form.show_guidelines'),
                    'value' => setting('show_theme_guideline_link', false),
                ]);
        }, 110);

        add_filter('core_request_rules', function ($rules, Request $request) {
            if ($request instanceof AdminAppearanceRequest) {
                $rules = [
                    ...$rules,
                    'show_admin_bar' => $onOffRule = new OnOffRule(),
                    'show_theme_guideline_link' => $onOffRule,
                ];
            }

            return $rules;
        }, 110, 2);
    }

    public function addStatsWidgets(array $widgets, Collection $widgetSettings): array
    {
        $themes = fn () => count(BaseHelper::scanFolder(theme_path()));

        return (new DashboardWidgetInstance())
            ->setType('stats')
            ->setPermission('theme.index')
            ->setTitle($themes === 1 ? trans('libs/theme::theme.theme') : trans('libs/theme::theme.themes'))
            ->setKey('widget_total_themes')
            ->setIcon('ti ti-palette')
            ->setColor('pink')
            ->setStatsTotal($themes)
            ->setRoute(route('theme.index'))
            ->setColumn('col-12 col-md-6 col-lg-3')
            ->init($widgets, $widgetSettings);
    }
}
