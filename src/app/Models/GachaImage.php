<?php

namespace App\Models;

use App\Helpers\UploadHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GachaImage extends Model
{
    use HasFactory;

    protected $table = 'gacha_images';

    protected $softDelete = true;

    protected $fillable = [
        'gacha_id',
        'attachment'
    ];

    public $sortable = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function deleteRecord()
    {
        UploadHelper::destroyS3($this->attachment);
        $this->delete();
    }

    public function getImage()
    {
        if ($this->attachment != null) {
            if (str_contains($this->attachment, 'http') == false) {
                return asset(UploadHelper::getUrlImage($this->attachment));
            } else {
                return asset($this->attachment);
            }
        }
        return asset('images/image-default.png');
    }
}
