<?php

namespace App\Business;

use App\Repositories\OrderDetailRepository;

class OrderDetailBusiness extends BaseBusiness
{
  protected OrderDetailRepository $orderDetailRepository;

  public function __construct(OrderDetailRepository $orderDetailRepository)
  {
    parent::__construct($orderDetailRepository);
    $this->orderDetailRepository = $orderDetailRepository;
  }
}
