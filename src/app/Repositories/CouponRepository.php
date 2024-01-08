<?php


namespace App\Repositories;


use App\Models\Coupon;

class CouponRepository extends BaseRepository
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
        return Coupon::class;
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
            case 'code':
                return $query->where($column, $data);
                break;
            case 'period_start':
                return $query->where($column, '>=', \Carbon\Carbon::createFromFormat('Y-m-d', $data)->startOfDay());
                break;
            case 'period_end':
                return $query->where($column, '<=', \Carbon\Carbon::createFromFormat('Y-m-d', $data)->endOfDay());
                break;
            default:
                return $query;
                break;
        }
    }
}
