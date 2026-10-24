<?php

namespace Dev\SeoHelper\Forms;

use Dev\Base\Forms\FieldOptions\HtmlFieldOption;
use Dev\Base\Forms\FieldOptions\MediaImageFieldOption;
use Dev\Base\Forms\FieldOptions\RadioFieldOption;
use Dev\Base\Forms\FieldOptions\TextareaFieldOption;
use Dev\Base\Forms\FieldOptions\TextFieldOption;
use Dev\Base\Forms\Fields\HtmlField;
use Dev\Base\Forms\Fields\MediaImageField;
use Dev\Base\Forms\Fields\RadioField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;

class SeoForm extends FormAbstract
{
    public function setup(): void
    {
        $meta = $this->getModel();

        $this
            ->contentOnly()
            ->add(
                'seo_meta[seo_title]',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('libs/seo-helper::seo-helper.seo_title'))
                    ->placeholder(trans('libs/seo-helper::seo-helper.seo_title'))
                    ->helperText(trans('libs/seo-helper::seo-helper.seo_title_helper'))
                    ->maxLength(70)
                    ->allowOverLimit()
                    ->value(old('seo_meta.seo_title', $meta['seo_title']))
            )
            ->add(
                'seo_meta[seo_description]',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(trans('libs/seo-helper::seo-helper.seo_description'))
                    ->placeholder(trans('libs/seo-helper::seo-helper.seo_description'))
                    ->helperText(trans('libs/seo-helper::seo-helper.seo_description_helper'))
                    ->rows(3)
                    ->maxLength(160)
                    ->allowOverLimit()
                    ->value(old('seo_meta.seo_description', $meta['seo_description']))
            )
            ->add(
                'meta_keywords',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->content(view('libs/theme::partials.no-meta-keywords')->render())
            )
            ->add(
                'seo_meta_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(trans('libs/seo-helper::seo-helper.seo_image'))
                    ->helperText(trans('libs/seo-helper::seo-helper.seo_image_helper'))
                    ->value(old('seo_meta_image', $meta['seo_image']))
            )
            ->add(
                'seo_meta[index]',
                RadioField::class,
                RadioFieldOption::make()
                    ->label(trans('libs/seo-helper::seo-helper.index'))
                    ->helperText(trans('libs/seo-helper::seo-helper.index_helper'))
                    ->selected(old('seo_meta.index', $meta['index']))
                    ->choices([
                        'index' => trans('libs/seo-helper::seo-helper.index'),
                        'noindex' => trans('libs/seo-helper::seo-helper.noindex'),
                    ])
            );
    }
}
