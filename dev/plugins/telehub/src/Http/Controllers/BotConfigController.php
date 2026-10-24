<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Telehub\Models\BotConfig;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Tables\BotConfigTable;
use Dev\Telehub\Forms\BotConfigForm;
use Illuminate\Http\Request;

class BotConfigController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/telehub::telehub.bot_configs.name'), route('telehub.bot-configs.index'));
    }

    public function index(BotConfigTable $table)
    {
        if (! \Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
            $botConfig = BotConfig::query()->first();

            if ($botConfig) {
                return redirect()->route('telehub.bot-configs.edit', $botConfig->id);
            }

            return redirect()->route('telehub.bot-configs.create');
        }

        $this->pageTitle(trans('plugins/telehub::telehub.bot_configs.name'));

        return $table->renderTable();
    }

    public function create()
    {
        if (! \Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
            $botConfig = BotConfig::query()->first();

            if ($botConfig) {
                return redirect()->route('telehub.bot-configs.edit', $botConfig->id);
            }
        }

        $this->pageTitle(trans('plugins/telehub::telehub.create'));

        return BotConfigForm::create()->renderForm();
    }

    public function store(Request $request)
    {
        if (! \Illuminate\Support\Facades\Auth::user()?->isSuperUser()) {
            $botConfig = BotConfig::query()->first();

            if ($botConfig) {
                return $this
                    ->httpResponse()
                    ->setError()
                    ->setMessage(trans('plugins/telehub::telehub.bot_configs.already_exists'));
            }
        }

        $form = BotConfigForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.bot-configs.index'))
            ->setNextUrl(route('telehub.bot-configs.edit', $form->getModel()->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(BotConfig $botConfig)
    {
        $this->pageTitle(trans('plugins/telehub::telehub.edit'));

        return BotConfigForm::createFromModel($botConfig)->renderForm();
    }

    public function update(BotConfig $botConfig, Request $request)
    {
        BotConfigForm::createFromModel($botConfig)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('telehub.bot-configs.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(BotConfig $botConfig)
    {
        return DeleteResourceAction::make($botConfig);
    }

    public function restartApi(Request $request, \Dev\Base\Http\Responses\BaseHttpResponse $response)
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            
            // Restart API by calling internal endpoint
            $ch = curl_init('http://127.0.0.1:3030/api/v1/internal/restart');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_exec($ch);
            curl_close($ch);

            return $response->setMessage('Đã xóa Cache và Khởi động lại Bot thành công!');
        } catch (\Exception $e) {
            return $response->setError()->setMessage($e->getMessage());
        }
    }
}
