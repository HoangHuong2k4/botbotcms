<?php

namespace Dev\Blog\Http\Requests;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Rules\MediaImageRule;
use Dev\Base\Rules\OnOffRule;
use Dev\Blog\Models\Category;
use Dev\Blog\Supports\PostFormat;
use Dev\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PostRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:250'],
            'description' => ['nullable', 'string', 'max:400'],
            'content' => ['nullable', 'string', 'max:300000'],
            'tag' => ['nullable', 'string', 'max:400'],
            'categories' => ['sometimes', 'array'],
            'categories.*' => ['sometimes', Rule::exists((new Category())->getTable(), 'id')],
            'status' => Rule::in(BaseStatusEnum::values()),
            'is_featured' => [new OnOffRule()],
            'image' => ['nullable', 'string', new MediaImageRule()],
        ];

        $postFormats = PostFormat::getPostFormats(true);

        if (count($postFormats) > 1) {
            $rules['format_type'] = Rule::in(array_keys($postFormats));
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'name' => trans('plugins/blog::posts.form.name'),
            'description' => trans('plugins/blog::posts.form.description'),
            'content' => trans('plugins/blog::posts.form.content'),
            'tag' => trans('plugins/blog::posts.form.tags'),
            'categories' => trans('plugins/blog::posts.form.categories'),
            'status' => trans('core/base::tables.status'),
            'is_featured' => trans('plugins/blog::posts.form.is_featured'),
            'image' => trans('core/base::forms.image'),
            'format_type' => trans('plugins/blog::posts.form.format_type'),
        ];
    }
}
