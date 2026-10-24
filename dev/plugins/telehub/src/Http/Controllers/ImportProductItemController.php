<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\DataSynchronize\Http\Controllers\ImportController;
use Dev\DataSynchronize\Importer\Importer;
use Dev\Telehub\Importers\ProductItemImporter;

class ImportProductItemController extends ImportController
{
    protected function getImporter(): Importer
    {
        return ProductItemImporter::make();
    }
}
