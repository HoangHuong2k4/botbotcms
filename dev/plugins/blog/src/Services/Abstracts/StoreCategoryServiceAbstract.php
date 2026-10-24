<?php

namespace Dev\Blog\Services\Abstracts;

use Dev\Blog\Models\Post;
use Illuminate\Http\Request;

abstract class StoreCategoryServiceAbstract
{
    abstract public function execute(Request $request, Post $post): void;
}
