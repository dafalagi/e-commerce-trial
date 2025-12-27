<?php
namespace App\Services\FileSystem;

use App\Models\FileSystem\FileStorage;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;
use Illuminate\Support\Facades\Storage;

class DeleteFileStorageService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);
        $model = FileStorage::find($dto['file_storage_id']);

        if ($model->filesystem == 's3')
            Storage::disk('s3')->delete("file_storage/".$model['name'].".".$model['extension']);

        $this->validateVersion($model, $dto['version']);
        $this->activeAndRemoveData($model, $dto);

        $this->results['data'] = [];
        $this->results['message'] = "File successfully deleted";
    }

    public function prepare($dto)
    {
        if(isset($dto['file_storage_uuid']))
            $dto['file_storage_id'] = $this->findIdByUuid(FileStorage::query(), $dto['file_storage_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'file_storage_id' => ['nullable', 'integer', new ExistsId(new FileStorage)],
            'file_storage_uuid' => ['required_without:file_storage_id', 'uuid', new ExistsUuid(new FileStorage)],

            'version' => ['required', 'integer'],
        ];
    }
}



