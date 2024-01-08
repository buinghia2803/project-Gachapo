<?php

namespace App\Repositories;

use App\Models\Review;

class ReviewRepository extends BaseRepository
{

    public function search($query, $column, $data)
    {
        switch ($column) {
            case 'id':
                return $query->where('id', $data);
                break;
            case 'order_id':
            case 'start_time':
                return $query->where($column, $data);
                break;
            case 'order_ids':
                return $query->whereIn('order_id', $data);
            case 'rating_from':
                return $query->where('rating', '>=', $data);
            case 'rating_to':
                return $query->where('rating', '<=', $data);
                break;
            case 'start_time_review':
                return $query->whereDate('created_at', '>=', $data);
                break;
            case 'end_time_review':
                return $query->whereDate('created_at', '<=', $data);
                break;
            default:
                return $query;
                break;
        }
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    public function model()
    {
        return Review::class;
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
     * Get newest review
     */
    public function getReviewByOrder($orderIds)
    {
        $reviews = Review::whereIn('order_id', $orderIds)
            ->whereNull('content_reply')
            ->whereNull('deleted_at')
            ->orderBy('created_at', DESC)
            ->take(MAX_LASTEST_REVIEW)
            ->get();
        $reviews->load('order.user:id,name');

        return $reviews;
    }

    /**
     * Get detail review
     */

    public function getReviewDetail($id)
    {
        $reviews = $this->model->join('orders', 'orders.id', 'reviews.order_id')
            ->join('users', 'users.id', 'orders.user_id')
            ->join('order_details', 'orders.id', 'order_details.order_id')
            ->join('products', 'products.id', 'order_details.product_id')
            ->select('reviews.*', 'users.name', 'products.name as product_name', 'products.attachment')
            ->find($id);
        dd($reviews);
        return $reviews;
    }

    public function updateReview($id, $data)
    {
        $review = $this->model->updateOrCreate(['id' => $id], $data);

        return $review;
    }
    /**
     * get Order by user id
     *
     * @param Integer $user_id
     *
     * @return mixed
     */
    public function getOrderByUserId($user_id)
    {
        return $this->model->where('user_id', $user_id)->first();
    }
}
