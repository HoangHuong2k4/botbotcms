<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Telehub\Models\ProductItem;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Tables\ProductItemTable;
use Dev\Telehub\Forms\ProductItemForm;
use Illuminate\Http\Request;

class ProductItemController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/telehub::telehub.product_items.name'), route('telehub.product-items.index'));
    }

    public function index(ProductItemTable $table)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.product_items.name'));

        return $table->renderTable();
    }

    public function apiItems(Request $request)
    {
        $productId = $request->input('product_id');
        $status = $request->input('status', 'all');
        $perPage = $request->input('per_page', 20);
        $page = $request->input('page', 1);

        $query = ProductItem::where('product_id', $productId);

        if ($status !== 'all') {
            $query->where('is_sold', $status);
        }

        $items = $query->with('customer')
            ->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'error' => false,
            'data' => $items,
        ]);
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/telehub::telehub.create'));

        return ProductItemForm::create()->renderForm();
    }

    public function store(Request $request)
    {
        $form = ProductItemForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.product-items.index'))
            ->setNextUrl(route('telehub.product-items.edit', $form->getModel()->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(ProductItem $productItem)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.edit'));

        return ProductItemForm::createFromModel($productItem)->renderForm();
    }

    public function update(ProductItem $productItem, Request $request)
    {
        ProductItemForm::createFromModel($productItem)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.product-items.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(ProductItem $productItem)
    {
        return DeleteResourceAction::make($productItem);
    }

    public function bulkMove(Request $request)
    {
        $ids = $request->input('ids', []);
        $productId = $request->input('product_id');

        \Illuminate\Support\Facades\Log::info('Bulk Move Request:', [
            'ids' => $ids,
            'product_id' => $productId,
            'ip' => $request->ip(),
            'user_id' => $request->user() ? $request->user()->id : 'unauthenticated',
        ]);

        if (empty($ids) || !$productId) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage('Dữ liệu không hợp lệ!');
        }

        $productExists = \Dev\Telehub\Models\Product::where('id', $productId)->exists();
        if (!$productExists) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage('Sản phẩm không hợp lệ!');
        }

        ProductItem::whereIn('id', $ids)->update(['product_id' => $productId]);

        return $this
            ->httpResponse()
            ->setMessage('Chuyển sản phẩm thành công!');
    }
}
