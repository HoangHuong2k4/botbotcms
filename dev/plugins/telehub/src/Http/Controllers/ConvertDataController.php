<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Models\Product;
use Illuminate\Http\Request;

class ConvertDataController extends BaseController
{
    public function __construct()
    {
        $this->breadcrumb()
            ->add(trans('plugins/telehub::telehub.name'), route('telehub.products.index'))
            ->add('Convert Data', route('telehub.convert-data.index'));
    }

    public function index(Request $request)
    {
        $this->pageTitle('Convert Data to Excel');

        $products = Product::where('status', \Dev\Base\Enums\BaseStatusEnum::PUBLISHED)
            ->get(['id', 'name']);

        return view('plugins/telehub::convert-data', compact('products'));
    }
}
