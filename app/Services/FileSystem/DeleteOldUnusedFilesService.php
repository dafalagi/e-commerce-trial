<?php
namespace App\Services\FileSystem;

use App\Services\DefaultService;
use App\Services\ServiceInterface;
use App\Models\FileSystem\FileStorage;

class DeleteOldUnusedFilesService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        foreach ($dto['files'] as $file) {
            $base_path = storage_path('app/public/');
            $file_path = $base_path . $file->location . '/' . $file->name . '.' . $file->extension;

            if (file_exists($file_path)) {
                unlink($file_path);
            }

            app('DeleteFileStorageService')->execute([
                'file_storage_id' => $file->id,
                'version' => $file->version
            ], true);
        }

        $this->results['data'] = [];
        $this->results['message'] = "Old unused files deleted successfully";

    }

    public function prepare($dto)
    {
        $dto['files'] = FileStorage::where('created_at', '<', now()->format('U'))
            ->where('is_used', false)
            ->get();

        return $dto;
    }
}
