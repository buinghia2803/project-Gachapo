<?php


namespace App\Repositories;


use App\Models\Contact;

class ContactRepository extends BaseRepository
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
    return Contact::class;
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
      case 'contact_type':
      case 'email':
      case 'inquiry_type':
        return $query->where($column, $data);
      case 'name':
      case 'content':
        return $query->where($column, 'like', '%' . $data . '%');
        break;
      default:
        return $query;
        break;
    }
  }
}
