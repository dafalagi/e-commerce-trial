<?php
namespace App\Services\FileSystem;

use App\Services\DefaultService;
use App\Services\ServiceInterface;
use App\Models\FileSystem\FileStorage;

class StoreFileStorageService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $file = $dto['compress'] ? file_compress_before_upload_file($dto) : file_upload_file($dto);
        $dto = $this->prepare($file);

        $model = new FileStorage;

        $model->size = $dto['size'] ?? null;
        $model->extension = $dto['extension'] ?? null;
        $model->name = $dto['name'] ?? null;
        $model->original_name = $dto['original_name'] ?? null;
        $model->location = $dto['location'] ?? null;
        $model->remark = $dto['remark'] ?? null;
        $model->filesystem = $dto['filesystem'] ?? null;

        $this->prepareAuditActive($model);
        $this->prepareAuditInsert($model);
        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.file_system.file_storage.stored');

    }

    public function prepare($dto)
    {
        return [
            'size' => $dto['file_size'],
            'extension' => $dto['file_extension'],
            'name' => $dto['file_name'],
            'original_name' => $dto['original_file_name'] ?? null,
            'location' => $dto['location'],
            'filesystem' => $dto['filesystem'],
            'remark' => '',
            'segment' => ''
        ];
    }

    public function rules($dto)
    {
        return [
            'file' => ['required', 'file', 'max:20000', 'mimes:jpeg,jpg,png,pdf'],
            'location' => ['required', 'string'],
            'filesystem' => ['required', 'string'],
            'compress' => ['required', 'boolean'],
        ];
    }
}
