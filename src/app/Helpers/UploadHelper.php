<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class UploadHelper
{
    public static function doUpload($file, $public_path = 'uploads/', $dataImage = [])
    {
        if (is_array($file)) {
            $fileName = [];
            foreach ($file as $f) {
                $fileName[] = self::saveFile($f, $public_path, $dataImage);
            }
            return $fileName;
        } else {
            return array(self::saveFile($file, $public_path, $dataImage));
        }
    }

    /**
     * Create directory, optimize and save image
     * @param $file
     * @param string $public_path
     * @param array $dataImage
     * @return false|string[]
     */
    private static function saveFile($file, $public_path = 'uploads/', $dataImage = [])
    {
        // Save data into both two tables images and image_thumbs
        $tableNames = ['images', 'image_thumbs'];
        if (!empty($file)) {

            $results = [];
            $fileExtension = explode('/', mime_content_type($file))[1];
            foreach ($tableNames as $table) {
                // save thumb image into directory uploads/thumbs/
                if ($table == 'image_thumbs') {
                    $dirPath = public_path($public_path . 'thumbs/');
                    $fileName = time() . '_' . uniqid(md5(time()), true) . '_thumb';
                    $results['image_thumbs'] = $public_path . 'thumbs/' . $fileName . '.' . $fileExtension;
                } else {
                    $dirPath = public_path($public_path);
                    $fileName = time() . '_' . uniqid(md5(time()), true);
                    $results['images'] = $public_path . $fileName . '.' . $fileExtension;
                }
                //Check if the directory already exists.
                if (!is_dir($dirPath)) {
                    //Directory does not exist, so lets create it.
                    mkdir($dirPath, 0755, true);
                }

                self::processImage($file, $dirPath, $fileName, $table);
            }

            foreach ($results as $key => $val) {
                $inputImage = [
                    'item_id' => $dataImage['item_id'],
                    'image' => $val,
                    'type' => $dataImage['type'],
                    'is_avatar' => isset($dataImage['is_avatar']) ?? 0,
                ];
                //Store image
                self::storeImage($key, $inputImage);
            }

            return $results;
        }
        return false;
    }

    /**
     * Handle optimization and save image in to directory
     *
     * @param $file
     * @param $dirPath
     * @param $fileName
     * @param $table
     * @return array|string|string[]
     */
    public static function processImage($file, $dirPath, $fileName, $table)
    {
        if ($file instanceof UploadedFile) {
            $fileName = $fileName . '.' . $file->getClientOriginalExtension();

            $imageResize = Image::make($file->getRealPath());
            $imageResize->resize(
                $table == 'image_thumbs' ? DEFAULT_THUMB_WIDTH : DEFAULT_WIDTH,
                $table == 'image_thumbs' ? DEFAULT_THUMB_HEIGHT : DEFAULT_HEIGHT,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );
            $imageResize->save($dirPath . $fileName);
        } elseif (count(explode(',', $file)) > 1) {
            $fileExtension = explode('/', mime_content_type($file))[1];
            $fileName = $fileName . '.' . $fileExtension;
            file_put_contents($dirPath . $fileName, base64_decode(explode(',', $file)[1]));
            $imageResize = Image::make($dirPath . $fileName);
            $imageResize->resize(
                $table == 'image_thumbs' ? DEFAULT_THUMB_WIDTH : DEFAULT_WIDTH,
                $table == 'image_thumbs' ? DEFAULT_THUMB_HEIGHT : DEFAULT_HEIGHT,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );
            $imageResize->save($dirPath . $fileName);
        } else {
            //File dont change
            return str_replace($_SERVER['APP_URL'] . '/', '', $file);
        }
    }

    /**
     * Store image into database
     *
     * @param $tableName
     * @param $inputArr
     * @return bool
     */
    public static function storeImage($tableName, $inputArr)
    {
        if ($inputArr['type'] == USER_IMAGE_TYPE && $inputArr['is_avatar'] == SET_AS_AVATAR) {
            DB::table($tableName)
                ->where('item_id', $inputArr['item_id'])
                ->where('type', USER_IMAGE_TYPE)
                ->where('is_avatar', SET_AS_AVATAR)
                ->update(['is_avatar' => SET_NOT_AVATAR]);
        }
        return DB::table($tableName)->insert([
            'item_id' => $inputArr['item_id'],
            'image' => $inputArr['image'],
            'type' => $inputArr['type'],
            'is_avatar' => $inputArr['is_avatar'],
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }

    public static function doUploadS3($file)
    {
        if ($file) {
            $name = time() . $file->getClientOriginalName();
            $filePath = 'images/' . $name;
            Storage::disk(env('FILE_STORAGE_DISK', 's3'))->put($filePath, file_get_contents($file), 'public');

            return $filePath;
        }

        return false;
    }


    /**
     * Upload file to S3
     *
     * @param base64_encode
     *
     * @return file url
     */
    public static function doUploadS3Base64($fileBase64)
    {
        if ($fileBase64) {
            $ext = explode(';', $fileBase64)[0];
            $ext = explode('/', $ext)[1];
            $name = uniqid() . '.' . $ext;
            $imageContent = str_replace('data:image/'. $ext .';base64,', '', $fileBase64);
            $imageContent = str_replace(' ', '+', $imageContent);

            $filePath = 'images/' . $name;
            Storage::disk(env('FILE_STORAGE_DISK', 's3'))->put($filePath, base64_decode($imageContent), 'public');

            return $filePath;
        }

        return false;
    }

    public static function resizeImageS3($image): string
    {
        $image_resize = Image::make($image)->fit(150, 150);
        $name = time() . $image->getClientOriginalName();
        $filePath = 'thumbs/' . $name;
        Storage::disk(env('FILE_STORAGE_DISK', 's3'))->put($filePath, $image_resize->stream()->detach(), 'public');

        return $filePath;
    }

    public static function destroyS3($path)
    {
        return Storage::disk(env('FILE_STORAGE_DISK', 's3'))->delete($path);
    }

    public static function getUrlImage($path)
    {
        $cloudService = config('filesystems.cloud_service');
        $path = Storage::disk($cloudService)->url($path);
        if ($path) {
            return str_replace(config('filesystems.disks.' . $cloudService . '.endpoint'), config('filesystems.disks.' . $cloudService . '.url'), $path);
        }
        return null;
    }
}
