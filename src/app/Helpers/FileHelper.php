<?php

namespace App\Helpers;

use Closure;
use Image;
use Intervention\Image\Constraint;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileHelper
{
    public static function saveImageThumb(UploadedFile $file, $maxWidth = 150, $path = null, Closure $callback = null) {

        if (!$path) {
            $path = '/uploads/';
        }
        if (!is_dir(pathinfo($path)['basename'])) {
            mkdir(pathinfo($path)['basename'], 0777, true);
        }
        if ($callback) {
            $fileName = $callback();
        } else {
            $fileName = self::getFileName($file);
        }
        $img = self::makeImage($file);
        $img = self::resizeImage($img, $maxWidth);
        self::uploadImage($img, $fileName, $path);
        return $fileName;
    }

    public static function saveImage(UploadedFile $file, $maxWidth = 500, $path = null, Closure $callback = null) {

        if (!$path) {
            $path = '/imagesfull/';
        }
        if (!is_dir(pathinfo($path)['basename'])) {
            mkdir(pathinfo($path)['basename'], 0777, true);
        }
        if ($callback) {
            $fileName = $callback();
        } else {
            $fileName = self::getFileName($file);
        }
        $img = self::makeImage($file);
        $img = self::resizeImage($img, $maxWidth);
        self::uploadImage($img, $fileName, $path);
        return $fileName;
    }


    protected static function getFileName(UploadedFile $file)
    {
        $filename = $file->getClientOriginalName();
        $filename = date('Ymd_His') . '_' . strtolower(pathinfo($filename, PATHINFO_FILENAME)) . '.' . pathinfo($filename, PATHINFO_EXTENSION);

        return $filename;
    }

    protected static function makeImage(UploadedFile $file)
    {
        return Image::make($file);
    }

    protected static function resizeImage(\Intervention\Image\Image $img, $maxWidth = 150)
    {
        $img->resize($maxWidth, null, function (Constraint $constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        return $img;
    }

    protected static function uploadImage($img, $fileName, $path)
    {
        $img->save(public_path($path . $fileName));
    }


    public static function imageSourceEncode(string $filePath)
    {
        // Read image path, convert to base64 encoding
        if (is_file($filePath) && file_exists($filePath)) {
            $data = base64_encode(file_get_contents($filePath));

            // Format the image source :  data:{mime};base64,{data};
            $src = 'data: ' . mime_content_type($filePath) . ';base64,' . $data;

            return $src;
        }
        return '';
    }

    public static function unlink(string $filePath)
    {
        if (is_file($filePath) && file_exists($filePath)) {
            unlink($filePath);
            return true;
        }
        return false;
    }

    public static function unlinkImages(array $images)
    {
        if (is_array($images)) {
            foreach ($images as $image) {
                if (is_array($image)) {
                    self::unlinkImages($image);
                } else {
                    ImageHelper::unlink(public_path('/') . $image);
                }
            }
        }
    }

    public static function doUpload($file)
    {
        if (is_array($file)) {
            $fileName = [];

            foreach ($file as $itemFile) {
                $fileName[] = self::saveFile($itemFile);
            }

            return $fileName;
        } else {
            return array(self::saveFile($file));
        }
    }

    private static function saveFile($file, $path = null, Closure $callback = null)
    {
        if (!$path) {
            $path = 'uploads/';
        }

        if (!is_dir(pathinfo($path)['basename'])) {
            mkdir(pathinfo($path)['basename'], 0777, true);
        }
        if ($callback) {
            $fileName = $callback();
        } else {
            $fileName = self::getFileName($file);
        }
        self::uploadFile($file, $fileName, $path);

        return $path . $fileName;
    }

    protected static function uploadFile($file, $fileName, $path)
    {
        $file->move(public_path($path), $fileName);
    }

    public static function deleteFile($fileName)
    {
        unlink("uploads/".$fileName);
        return true;
    }

    public static function uploadBase64($base64, $filename = null, $path = 'uploads')
    {
        $ext = explode(';', $base64)[0];
        $ext = explode('/', $ext)[1];
        if ($filename == null) {
            $filename = date('Ymd').'_'.time().'.'.$ext;
        }
        $fullPath = $path. '/' . $filename;

        $image = $base64;
        $image = str_replace('data:image/'.$ext.';base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        \File::put($fullPath, base64_decode($image));

        return $fullPath;
    }
}
