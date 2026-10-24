<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Telehub\Models\ProductCombo;
use Dev\Telehub\Models\Product;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Tables\ProductComboTable;
use Dev\Telehub\Forms\ProductComboForm;
use Illuminate\Http\Request;

class ProductComboController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/telehub::telehub.products.name'), route('telehub.products.index'))
            ->add('Combo Deals', route('telehub.product-combos.index'));
    }

    public function index(ProductComboTable $table)
    {
        $this->pageTitle('Quản lý Combo Deals');
        return $table->renderTable();
    }

    public function create(Request $request)
    {
        $this->pageTitle('Tạo Combo mới');

        $form = ProductComboForm::create();

        // Pre-fill product_id nếu đến từ trang sản phẩm
        if ($productId = $request->get('product_id')) {
            $form->getModel()->product_id = $productId;
        }

        return $form->renderForm();
    }

    public function store(\Dev\Telehub\Http\Requests\ProductComboRequest $request)
    {
        // Gán tenant_id nếu không phải super admin
        if (!\Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
            if ($tenant = \Dev\Telehub\Models\Tenant::current()) {
                $request->merge(['tenant_id' => $tenant->id]);
            }
        } else {
            // Lấy tenant từ product
            $product = Product::find($request->product_id);
            if ($product) {
                $request->merge(['tenant_id' => $product->tenant_id]);
            }
        }

        $form = ProductComboForm::create()->setRequest($request);
        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.product-combos.index'))
            ->setNextUrl(route('telehub.products.edit', $form->getModel()->product_id))
            ->setMessage('Tạo combo thành công!');
    }

    public function edit(ProductCombo $productCombo)
    {
        $this->pageTitle('Sửa Combo');
        return ProductComboForm::createFromModel($productCombo)->renderForm();
    }

    public function update(ProductCombo $productCombo, \Dev\Telehub\Http\Requests\ProductComboRequest $request)
    {
        ProductComboForm::createFromModel($productCombo)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.products.edit', $productCombo->product_id))
            ->setMessage('Cập nhật combo thành công!');
    }

    public function destroy(ProductCombo $productCombo)
    {
        return DeleteResourceAction::make($productCombo);
    }

    /**
     * API endpoint: trả danh sách combo của 1 sản phẩm (dùng cho metabox AJAX)
     */
    public function apiByProduct(Request $request, int $productId)
    {
        $combos = ProductCombo::where('product_id', $productId)
            ->orderBy('min_quantity')
            ->orderBy('sort_order')
            ->get()
            ->map(function ($c) {
                return [
                    'id'               => $c->id,
                    'min_quantity'     => $c->min_quantity,
                    'type'             => $c->type,
                    'discount_percent' => $c->discount_percent,
                    'discount_amount'  => $c->discount_amount,
                    'bonus_qty'        => $c->bonus_qty,
                    'label'            => $c->label,
                    'is_active'        => $c->is_active,
                    'description'      => $c->description,
                    'edit_url'         => route('telehub.product-combos.edit', $c->id),
                    'delete_url'       => route('telehub.product-combos.destroy', $c->id),
                ];
            });

        return response()->json(['data' => $combos]);
    }
}
