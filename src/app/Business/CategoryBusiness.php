<?php

namespace App\Business;

use App\Repositories\CategoryRepository;

class CategoryBusiness extends BaseBusiness
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        parent::__construct($categoryRepository);
        $this->categoryRepository = $categoryRepository;
    }
}
