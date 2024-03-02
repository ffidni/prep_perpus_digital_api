<?php
// app/Library/Helpers.php

namespace App\Library;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class HelperLib
{

    public static function getValidatorErrorMessages($validator)
    {
        $message = implode("\n", $validator->errors()->all());
        return $message;
    }

    public static function uploadFile(UploadedFile $file, $targetPath, $prefixName, $name = null, $existingPath = null)
    {
        if (!$file) {
            Log::info("no image");
            return;
        }

        $imageName = $name ?? $prefixName . "_" . uniqid() . '.' . $file->extension();
        $publicPath = public_path($targetPath);
        $file->move($publicPath, $imageName);

        if ($existingPath) {
            HelperLib::deleteFile($existingPath);
        }

        return $targetPath . '/' . $imageName;

    }

    public static function deleteFile($path)
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
            return true;
        }
        return false;
    }



}
