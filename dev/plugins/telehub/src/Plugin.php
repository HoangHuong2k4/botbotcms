<?php

namespace Dev\Telehub;

use Illuminate\Support\Facades\Schema;
use Dev\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('Telehubs');
        Schema::dropIfExists('Telehubs_translations');
    }
}
