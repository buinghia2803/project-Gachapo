<?php


namespace App\Repositories;


use App\Models\Admin;

class AdminUserRepository extends BaseRepository
{

    public function search($query, $column, $data)
    {
        switch ($column) {
            case 'id':
            case 'role_id':
            case 'status':
                return $query->orWhere($column, $data);
                break;
            case 'name':
                return $query->orWhere($column, 'like', '%' . $data . '%');
                break;
            case 'order_by':
                return $query->orderBy($data['fields'], $data['sort_type']);
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
        return Admin::class;
    }
}
