<?php


namespace App\Repositories;


use App\Models\Banner;

class BannerRepository extends BaseRepository
{

    public function search($query, $column, $data)
    {
        switch ($column) {
            case 'type':
                return $query->where($column, $data);
                break;
            case 'id':
                return $query->orderBy($column, $data);
                break;
            default:
                return $query;
                break;
        }
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

    /**
     * Configure the Model
     *
     * @return string
     */
    public function model()
    {
        return Banner::class;
    }
}
