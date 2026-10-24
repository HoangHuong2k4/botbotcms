<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class PublicController extends BaseController
{
    public function index()
    {
        $tenant = app('tenant');

        // This is a placeholder. In a real scenario, you'd load a view here.
        return response()->json([
            'message' => 'Welcome to ' . $tenant->username . '\'s store!',
            'tenant' => [
                'username' => $tenant->username,
                'email' => $tenant->email,
            ],
            'categories_count' => $tenant->categories()->count(),
            'products_count' => $tenant->products()->count(),
        ]);
    }

    public function products()
    {
        $tenant = app('tenant');
        $products = $tenant->products()->where('status', 'published')->paginate(10);

        return response()->json($products);
    }
}
