<?php

namespace App\Business;

use App\Repositories\PageRepository;

class PageBusiness extends BaseBusiness
{
    protected PageRepository $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        parent::__construct($pageRepository);
        $this->pageRepository = $pageRepository;
    }

    public function getStatusList()
    {
        return $this->pageRepository->getStatusList();
    }

    public function getUnusedTypeList()
    {
        return $this->pageRepository->getUnusedTypeList();
    }

    public function getTypeList()
    {
        return $this->pageRepository->getTypeList();
    }
}
