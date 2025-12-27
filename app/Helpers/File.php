<?php

use App\Models\FileSystem\FileStorage;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

if (!function_exists('file_upload_file'))
{
    function file_upload_file($dto)
    {
        $file = $dto['file'];
        $file_extension = $file->getClientOriginalExtension();
        $file_name = '';
        $original_file_name = '';

        do {
            $file_name = generate_random_string(25);
            $original_file_name = pathinfo($dto['file']->getClientOriginalName(), PATHINFO_FILENAME);
            $check = FileStorage::where('name',$file_name)->first();
        } while(!empty($check));

        $file_size = $file->getSize();

        $stored = Storage::disk($dto['filesystem'])->put(
            $dto['location'].'/'.$file_name .'.'.$file_extension, file_get_contents($file->getRealPath())
        );

        return [
            "file_name" => $file_name,
            "original_file_name" => $original_file_name,
            "file_extension" => $file_extension,
            "file_size" => $file_size,
            "location" => $dto['location'],
            "stored" => $stored,
            "filesystem" => $dto['filesystem']
        ];
    }
}

if (!function_exists('file_compress_before_upload_file'))
{
    function file_compress_before_upload_file($dto)
    {
        $file = $dto['file'];
        $file_extension = $file->getClientOriginalExtension();
        $file_name = '';
        $original_file_name = '';

        do {
            $file_name = generate_random_string(25);
            $original_file_name = pathinfo($dto['file']->getClientOriginalName(), PATHINFO_FILENAME);
            $check = FileStorage::where('name',$file_name)->first();
        } while(!empty($check));

        $file_size = $file->getSize();
        $image = Image::read($file)->scale(2000, 2000)->encodeByExtension('jpg', quality: 75);

        $stored = Storage::disk($dto['filesystem'])->put($dto['location'].'/'.$file_name .'.'.$file_extension, (string) $image);

        return [
            "file_name" => $file_name,
            "original_file_name" => $original_file_name,
            "file_extension" => $file_extension,
            "file_size" => $file_size,
            "location" => $dto['location'],
            "stored" => $stored,
            "filesystem" => $dto['filesystem']
        ];
    }
}
