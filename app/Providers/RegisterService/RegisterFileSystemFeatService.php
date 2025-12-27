<?php

namespace App\Providers\RegisterService;

use App\Providers\AppServiceProvider;

class RegisterFileSystemFeatService extends AppServiceProvider
{
    public function register(): void
    {
        /** File Storage */
        $this->registerService('StoreFileStorageService', \App\Services\FileSystem\StoreFileStorageService::class);
        $this->registerService('DeleteFileStorageService', \App\Services\FileSystem\DeleteFileStorageService::class);
        $this->registerService('DeleteOldUnusedFilesService', \App\Services\FileSystem\DeleteOldUnusedFilesService::class);
    }
}