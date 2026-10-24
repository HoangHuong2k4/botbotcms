<?php

namespace Dev\DataSynchronize\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Media\Chunks\Exceptions\UploadMissingFileException;
use Dev\Media\Chunks\Handler\DropZoneUploadHandler;
use Dev\Media\Chunks\Receiver\FileReceiver;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadController extends BaseController
{
    public function __invoke(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('UploadController: Received upload request');

        try {
            $request->validate([
                'file' => ['required', 'file', 'max:1024'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Illuminate\Support\Facades\Log::error('UploadController: Validation failed', ['errors' => $e->errors()]);
            throw $e;
        }

        $receiver = new FileReceiver('file', $request, DropZoneUploadHandler::class);

        if ($receiver->isUploaded() === false) {
            \Illuminate\Support\Facades\Log::error('UploadController: File not uploaded');
            throw new UploadMissingFileException();
        }

        $save = $receiver->receive();

        if ($save->isFinished()) {
            \Illuminate\Support\Facades\Log::info('UploadController: Upload finished, saving file');
            return $this->saveFile($save->getFile());
        }

        $handler = $save->handler();

        \Illuminate\Support\Facades\Log::info('UploadController: Chunk uploaded', ['percentage' => $handler->getPercentageDone()]);

        return $this
            ->httpResponse()
            ->setData([
                'done' => $handler->getPercentageDone(),
            ]);
    }

    protected function saveFile(UploadedFile $fileUpload): BaseHttpResponse
    {
        $validator = Validator::make(['file' => $fileUpload], [
            'file' => ['required', 'mimetypes:' . implode(',', config('libs.data-synchronize.data-synchronize.mime_types'))],
        ]);

        if ($validator->fails()) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage($validator->errors()->first());
        }

        $fileName = $this->createFilename($fileUpload);
        $destination = Storage::disk(config('libs.data-synchronize.data-synchronize.storage.disk'))->path(config('libs.data-synchronize.data-synchronize.storage.path'));

        $fileUpload->move($destination, $fileName);

        return $this
            ->httpResponse()
            ->setMessage(trans('libs/data-synchronize::data-synchronize.import.uploaded_message', [
                'file' => $fileUpload->getClientOriginalName(),
            ]))
            ->setData([
                'file_name' => $fileName,
            ]);
    }

    protected function createFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".$extension", '', $file->getClientOriginalName());
        $filename .= sprintf('-%s.%s', md5(uniqid()), $extension);

        return $filename;
    }
}
