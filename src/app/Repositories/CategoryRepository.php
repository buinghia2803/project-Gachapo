<?php


namespace App\Repositories;


use App\Models\Category;

class CategoryRepository extends BaseRepository
{

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
        return Category::class;
    }

    /**
     * Search by column
     *
     * @return query builder
     */
    public function search($query, $column, $data)
    {
        switch ($column) {
            case 'id':
                return $query->where($column, $data);
                break;
            case 'name':
                return $query->where($column, 'like', '%' . $data . '%');
                break;
            default:
                return $query;
                break;
        }
    }
}
