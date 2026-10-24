<?php

namespace Dev\LanguageAdvanced\Http\Controllers;

use Dev\DataSynchronize\Exporter\Exporter;
use Dev\DataSynchronize\Http\Controllers\ExportController;
use Dev\LanguageAdvanced\Exporters\TranslationExporterManager;

class TranslationExportController extends ExportController
{
    protected TranslationExporterManager $exporterManager;

    protected ?string $type;

    public function __construct(TranslationExporterManager $exporterManager)
    {
        $this->exporterManager = $exporterManager;
        $this->type = request()->route('type');
    }

    protected function getExporter(): Exporter
    {
        return $this->exporterManager->getExporter($this->type);
    }
}
