<?php

namespace App\Repositories;

use App\Models\ImageThumb;

class ImageThumbRepository extends BaseRepository
{
    /**
     * Configure the Model
     *
     * @return string
     */
    public function model()
    {
        return ImageThumb::class;
    }

    public function getImageThumbByItemIdAndType($itemId, $type, $perPage = DEFAULT_PER_PAGE)
    {
        $query = $this->model->newQuery();

        $query->where('item_id', $itemId)
            ->where('type', $type);

        return $query->paginate($perPage);
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
