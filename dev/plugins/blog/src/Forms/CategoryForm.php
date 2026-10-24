<?php

namespace Dev\Blog\Forms;

use Dev\Base\Forms\FieldOptions\CoreIconFieldOption;
use Dev\Base\Forms\FieldOptions\DescriptionFieldOption;
use Dev\Base\Forms\FieldOptions\HiddenFieldOption;
use Dev\Base\Forms\FieldOptions\IsDefaultFieldOption;
use Dev\Base\Forms\FieldOptions\IsFeaturedFieldOption;
use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\SelectFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\Fields\CoreIconField;
use Dev\Base\Forms\Fields\HiddenField;
use Dev\Base\Forms\Fields\OnOffField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\FormAbstract;
use Dev\Blog\Http\Requests\CategoryRequest;
use Dev\Blog\Models\Category;

class CategoryForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Category::class)
            ->setValidatorClass(CategoryRequest::class)
            ->add(
                'order',
                HiddenField::class,
                HiddenFieldOption::make()
                    ->value(function () {
                        if ($this->getModel()->exists) {
                            return $this->getModel()->order;
                        }

                        return Category::query()
                                ->whereIn('parent_id', [0, null])
                                ->latest('order')
                                ->value('order') + 1;
                    })
            )
            ->add('name', TextField::class, NameFieldOption::make()->required())
            ->add(
                'parent_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('core/base::forms.parent'))
                    ->choices(function () {
                        $modelId = null;

                        if ($this->getModel() && $this->getModel()->exists) {
                            $modelId = $this->getModel()->getKey();
                        }

                        $categories = [];
                        foreach (get_categories(['condition' => []]) as $row) {
                            if ($modelId && ($modelId === $row->id || $modelId === $row->parent_id)) {
                                continue;
                            }

                            $categories[$row->id] = $row->indent_text . ' ' . $row->name;
                        }

                        return [0 => trans('plugins/blog::categories.none')] + $categories;
                    })
                    ->searchable()
            )
            ->add('description', TextareaField::class, DescriptionFieldOption::make())
            ->add('is_default', OnOffField::class, IsDefaultFieldOption::make())
            ->add(
                'icon',
                CoreIconField::class,
                CoreIconFieldOption::make()
            )
            ->add(
                'is_featured',
                OnOffField::class,
                IsFeaturedFieldOption::make()
            )
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->setBreakFieldPoint('status');
    }
}
