<?php

namespace Dev\Base\Http\Controllers;

use Dev\Base\Supports\Breadcrumb;

class BaseSystemController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(
                trans('core/base::base.panel.platform_administration'),
                route('system.index')
            );
    }
}
