<?php

namespace App\Repositories;

use App\Models\Image;

class ImageRepository extends BaseRepository
{
    /**
     * Configure the Model
     *
     * @return string
     */
    public function model()
    {
        return Image::class;
    }

    public function getImageByItemIdAndType($itemId, $type, $perPage = DEFAULT_PER_PAGE)
    {
        $query = $this->model->newQuery();

        $query->where('item_id', $itemId)
            ->where('type', $type);

        return $query->paginate($perPage);
    }

    public function getAvatarByUser($userId)
    {
        $query = $this->model->newQuery();

        return $query->where('item_id', $userId)
            ->where('type', USER_IMAGE_TYPE)
            ->where('is_avatar', SET_AS_AVATAR)
            ->first();
    }

    /**
     * Get searchable fields array
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }
}
