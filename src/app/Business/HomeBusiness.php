<?php

namespace App\Business;

use App\Repositories\BannerRepository;
use App\Repositories\GachaRepository;
use App\Models\Option;
// use App\Repositories\HomeRepository;

class HomeBusiness extends BaseBusiness
{

  public function __construct(BannerRepository $bannerRepository, GachaRepository $gachaRepository)
  {
    parent::__construct($bannerRepository);
    $this->bannerRepository = $bannerRepository;
    $this->gachaRepository = $gachaRepository;
  }

  /**
   * Get information home page.
   *
   */
  public function getInfoHomePage($conditions)
  {
    try {
      $data = [];
      $banners = $this->bannerRepository->findByCondition([])->get()->groupBy('type');
      $option = Option::where('key', 'type_show_banner')->first();
      foreach ($banners as $key => $banner) {
        if (isset($option) && $option['value'] == SHOW_TYPE_RANDOM && $key == BANNER_TYPES['banner']) {
          // Random of banner
          $data[BANNER_TYPES_INVERS[$key]] = $banner->shuffle()->take(LIMIT_BANNER);
        } else {
          $data[BANNER_TYPES_INVERS[$key]] = $banner;
        }
      }
      $selectable = ['id', 'name', 'selling_price', 'description'];
      $prodSelectable = ['id', 'quantity', 'gacha_id', 'reward_status'];
      $imageSelectable = ['id', 'gacha_id', 'attachment'];

      // 10 gacha with created_at is newest.
      $newArrival = $this->gachaRepository->findByCondition([
        'period_start' => RANGE_DAY_ARRIVAL_GACHA,
        'status' => GACHA_APPROVED,
        'sort_field' => 'period_start',
        'sort_type' => DESC
      ], [
        'products' => function ($query) use ($prodSelectable) {
          return $query->select($prodSelectable);
        },
        'images' => function ($query) use ($imageSelectable) {
          return $query->select($imageSelectable)->orderBy('updated_at', DESC)->limit(1);
        },
      ], $selectable)
        ->limit(HOME_GACHA_LIMIT)->get();

      // 10 gacha with sell is newest.
      $favorites = $this->gachaRepository->list([
        'sort_field' => 'orders_count',
        'status' => GACHA_APPROVED,
        'sort_type' => DESC,
        'limit' => 10
      ], [
        'products' => function ($query) use ($prodSelectable) {
          return $query->select($prodSelectable);
        },
        'images' => function ($query) use ($imageSelectable) {
          return $query->select($imageSelectable)->orderBy('updated_at', DESC)->limit(1);
        },
      ], $selectable, ['orders']);

      // 10 gacha with created_at and recomendation.
      $recommends = $this->gachaRepository->findByCondition([
        'status' => GACHA_APPROVED,
        'recommend' => RECOMMEND_TYPE,
        'sort_field' => 'created_at',
        'sort_type' => DESC
      ], [
        'products' => function ($query) use ($prodSelectable) {
          return $query->select($prodSelectable);
        },
        'images' => function ($query) use ($imageSelectable) {
          return $query->select($imageSelectable)->orderBy('updated_at', DESC)->limit(1);
        },
      ], $selectable)->limit(HOME_GACHA_LIMIT)->get();

      $data['new_arrivals'] = $newArrival;
      $data['favorites'] = $favorites;
      $data['recommends'] = $recommends;

      return $data;
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }
}
