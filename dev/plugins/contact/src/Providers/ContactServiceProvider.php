<?php

namespace Dev\Contact\Providers;

use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Facades\EmailHandler;
use Dev\Base\Facades\PanelSectionManager;
use Dev\Base\PanelSections\PanelSectionItem;
use Dev\Base\Supports\DashboardMenuItem;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Contact\Models\Contact;
use Dev\Contact\Models\ContactReply;
use Dev\Contact\Models\CustomField;
use Dev\Contact\Models\CustomFieldOption;
use Dev\Contact\Repositories\Eloquent\ContactReplyRepository;
use Dev\Contact\Repositories\Eloquent\ContactRepository;
use Dev\Contact\Repositories\Interfaces\ContactInterface;
use Dev\Contact\Repositories\Interfaces\ContactReplyInterface;
use Dev\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Dev\Setting\PanelSections\SettingOthersPanelSection;
use Illuminate\Http\Request;

class ContactServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(ContactInterface::class, function () {
            return new ContactRepository(new Contact());
        });

        $this->app->bind(ContactReplyInterface::class, function () {
            return new ContactReplyRepository(new ContactReply());
        });
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/contact')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['email'])
            ->loadAndPublishConfigurations(['permissions'])
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        if (class_exists('ApiHelper')) {
            $this->loadRoutes(['api']);
        }

        $this->app->register(EventServiceProvider::class);

        DashboardMenu::default()->beforeRetrieving(function (): void {
            DashboardMenu::make()
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-plugins-contact')
                        ->priority(120)
                        ->name('plugins/contact::contact.menu')
                        ->icon('ti ti-mail')
                )
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-plugins-contact-list')
                        ->parentId('cms-plugins-contact')
                        ->priority(120)
                        ->name('plugins/contact::contact.name')
                        ->icon('ti ti-cube')
                        ->route('contacts.index')
                )
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-plugins-contact-custom-fields')
                        ->parentId('cms-plugins-contact')
                        ->priority(130)
                        ->name('plugins/contact::contact.custom_field.name')
                        ->icon('ti ti-cube-plus')
                        ->route('contacts.custom-fields.index')
                        ->permissions('contact.custom-fields')
                );
        });

        PanelSectionManager::default()->beforeRendering(function (): void {
            PanelSectionManager::registerItem(
                SettingOthersPanelSection::class,
                fn () => PanelSectionItem::make('contact')
                    ->setTitle(trans('plugins/contact::contact.settings.title'))
                    ->withIcon('ti ti-mail-cog')
                    ->withPriority(140)
                    ->withDescription(trans('plugins/contact::contact.settings.description'))
                    ->withRoute('contact.settings')
            );
        });

        $this->app->booted(function (): void {
            EmailHandler::addTemplateSettings(CONTACT_MODULE_SCREEN_NAME, config('plugins.contact.email', []));

            $this->app->register(HookServiceProvider::class);
        });

        if (defined('LANGUAGE_MODULE_SCREEN_NAME') && defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            LanguageAdvancedManager::registerModule(CustomField::class, [
                'name',
                'placeholder',
            ]);

            LanguageAdvancedManager::registerModule(CustomFieldOption::class, [
                'label',
            ]);

            LanguageAdvancedManager::addTranslatableMetaBox('contact-custom-field-options');

            add_action(LANGUAGE_ADVANCED_ACTION_SAVED, function ($data, $request): void {
                if ($data::class == CustomField::class) {
                    $customFieldOptions = $request->input('options', []) ?: [];

                    if (! $customFieldOptions) {
                        return;
                    }

                    $newRequest = new Request();

                    $newRequest->replace([
                        'language' => $request->input('language'),
                        'ref_lang' => $request->input('ref_lang'),
                    ]);

                    foreach ($customFieldOptions as $option) {
                        if (empty($option['id'])) {
                            continue;
                        }

                        $customFieldOption = CustomFieldOption::query()->find($option['id']);

                        if ($customFieldOption) {
                            $newRequest->merge([
                                'label' => $option['label'],
                                'value' => null,
                            ]);

                            LanguageAdvancedManager::save($customFieldOption, $newRequest);
                        }
                    }
                }
            }, 1234, 2);
        }
    }
}
