<?php


namespace App\Repositories;


use App\Models\OrderDetail;

class OrderDetailRepository extends BaseRepository
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
    return OrderDetail::class;
  }

  /**
   * Search by column
   *
   * @return query builder
   */
  public function search($query, $column, $data)
  {
    switch ($column) {
      case 'order_id':
      case 'product_id':
      case 'status_receiving':
        return $query->where($column, $data);
        break;
      default:
        return $query;
        break;
    }
  }
}
