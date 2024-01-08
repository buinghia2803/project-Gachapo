<?php

namespace App\Business;

use App\Repositories\CouponRepository;

class CouponBusiness extends BaseBusiness
{
    protected CouponRepository $couponRepository;

    public function __construct(CouponRepository $couponRepository)
    {
        parent::__construct($couponRepository);
        $this->couponRepository = $couponRepository;
    }

    /*
    * return discount type of coupon
    */
    public function generateCouponCode()
    {
        $length = 8;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8}$/', $randomString)) {
            $randomString = $this->generateCouponCode();
        }

        $exist = $this->findByCondition(['code' => $randomString])->first();
        if ($exist) {
            $randomString = $this->generateCouponCode();
        }

        return $randomString;
    }
}
