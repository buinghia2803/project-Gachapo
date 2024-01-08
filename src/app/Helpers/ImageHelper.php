<?php

namespace App\Helpers;

class ImageHelper
{
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
}
