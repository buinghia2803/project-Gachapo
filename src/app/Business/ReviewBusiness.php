<?php

namespace App\Business;

use App\Repositories\ReviewRepository;

class ReviewBusiness extends BaseBusiness
{
    protected ReviewRepository $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        parent::__construct($reviewRepository);
        $this->reviewRepository = $reviewRepository;
    }

    /*
    * Load 3 review
    * @param $page
    */
    public function loadMore($page)
    {
        return $this->reviewRepository->list(['page' => $page, 'limit' => 3]);
    }

    /**
     * Get newest review
     */
    public function getReviewByOrder($orderIds)
    {
        return $this->reviewRepository->getReviewByOrder($orderIds);
    }

    /**
     * Get newest review
     */
    public function getReviewDetail($id)
    {
        return $this->reviewRepository->getReviewDetail($id);
    }

    public function updateReview($id, $data)
    {
        return $this->reviewRepository->updateReview($id, $data);
    }
}
