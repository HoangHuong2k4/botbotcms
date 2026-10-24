<?php

namespace Dev\LanguageAdvanced\Http\Controllers;

use Dev\DataSynchronize\Http\Controllers\ImportController;
use Dev\DataSynchronize\Http\Requests\DownloadTemplateRequest;
use Dev\DataSynchronize\Http\Requests\ImportRequest;
use Dev\DataSynchronize\Importer\Importer;
use Dev\LanguageAdvanced\Importers\TranslationImporterManager;

class TranslationImportController extends ImportController
{
    protected string $type;

    public function __construct(protected TranslationImporterManager $importerManager)
    {
    }

    protected function getImporter(): Importer
    {
        if ($this->type === 'model') {
            $modelClass = request()->input('class');
            if ($modelClass) {
                return $this->importerManager->getImporter($this->type)->make($modelClass);
            }
        }

        return $this->importerManager->getImporter($this->type);
    }

    public function index()
    {
        $this->type = request()->route('type');

        return parent::index();
    }

    public function validateData(ImportRequest $request)
    {
        $this->type = request()->route('type');

        return parent::validateData($request);
    }

    public function import(ImportRequest $request)
    {
        $this->type = request()->route('type');

        return parent::import($request);
    }

    public function downloadExample(DownloadTemplateRequest $request)
    {
        $this->type = request()->route('type');

        return parent::downloadExample($request);
    }
}
