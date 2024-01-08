<?php


namespace App\Repositories;


use App\Models\UserCreditCard;

class UserCreditCardRepository extends BaseRepository
{
  /**
   * Configure the Model
   *
   * @return string
   */
  public function model()
  {
    return UserCreditCard::class;
  }

  public function search($query, $column, $data)
  {
    switch ($column) {
      case 'id':
      case 'user_id':
      case 'card_number':
      case 'security_code':
        return $query->where($column, $data);
        break;
      case 'card_name':
        return $query->where($column, 'like', '%' . $data . '%');
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
}
