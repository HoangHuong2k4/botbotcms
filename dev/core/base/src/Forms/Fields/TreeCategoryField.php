<?php

namespace Dev\Base\Forms\Fields;

use Dev\Base\Forms\FieldOptions\TreeCategoryFieldOption;
use Dev\Base\Forms\FormField;

class TreeCategoryField extends FormField
{
    public function getFieldOption(): string
    {
        return TreeCategoryFieldOption::class;
    }

    protected function getTemplate(): string
    {
        return 'core/base::forms.fields.tree-categories';
    }
}
