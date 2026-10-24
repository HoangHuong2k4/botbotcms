<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Telehub\Models\Product;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Tables\ProductTable;
use Dev\Telehub\Forms\ProductForm;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/telehub::telehub.products.name'), route('telehub.products.index'));
    }

    public function index(ProductTable $table)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.products.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/telehub::telehub.create'));

        return ProductForm::create()->renderForm();
    }

    public function store(\Dev\Telehub\Http\Requests\ProductRequest $request)
    {
        $form = ProductForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.products.index'))
            ->setNextUrl(route('telehub.products.edit', $form->getModel()->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Product $product)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.edit'));

        $form = ProductForm::createFromModel($product);

        $form->addMetaBoxes([
            'product_items' => [
                'title'    => trans('plugins/telehub::telehub.product_items.name'),
                'content'  => view('plugins/telehub::products.items', compact('product'))->render(),
                'priority' => 'low',
            ],
            'product_combos' => [
                'title'    => '🎁 Combo Deals (Ưu đãi mua nhiều)',
                'content'  => view('plugins/telehub::products.combos', compact('product'))->render(),
                'priority' => 'low',
            ],
        ]);

        return $form->renderForm();
    }


    public function update(Product $product, \Dev\Telehub\Http\Requests\ProductRequest $request)
    {
        ProductForm::createFromModel($product)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.products.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Product $product)
    {
        return DeleteResourceAction::make($product);
    }
}
