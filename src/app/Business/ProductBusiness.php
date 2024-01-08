<?php

namespace App\Business;

use App\Helpers\UploadHelper;
use App\Repositories\ProductRepository;

class ProductBusiness extends BaseBusiness
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct($productRepository);
        $this->productRepository = $productRepository;
    }

    public function create($gachaID, $params = [])
    {
        if (empty($params['reward_type']) || empty($params['name'])) {
            return null;
        }
        $productOfGacha = $this->productRepository->model()::where('gacha_id', $gachaID)->get();
        // Check RewardType
        $hasRewardType = $productOfGacha->where('reward_type', $params['reward_type'])->first();
        if ($hasRewardType != null) {
            return [
                'status' => STATUS_ERROR,
                'status_type' => 'reward_type',
                'messages' => __('messages.GAC001_L001')
            ];
        }
        // Check Total Reward Percent
        $totalPercent = $productOfGacha->sum('reward_percent')+$params['reward_percent'];
        if ($totalPercent > 100) {
            return [
                'status' => STATUS_ERROR,
                'status_type' => 'reward_percent',
                'messages' => __('messages.GAC001_L002')
            ];
        }

        // Upload File attachment
        if (!empty($params['attachment']) && !empty($params['attachment_base64'])) {
            $imageUrl = UploadHelper::doUploadS3Base64($params['attachment_base64']);
            $params['attachment'] = $imageUrl;
        }

        $params['gacha_id'] = $gachaID;
        return $this->productRepository->create($params);
    }

    public function update($id, $gachaID, $params = [])
    {
        $product = $this->findById($id);

        $productOfGacha = $this->productRepository->model()::where('gacha_id', $gachaID)->get();

        // Check RewardType
        $hasRewardType = $productOfGacha->where('reward_type', $params['reward_type'])->first();
        if ($hasRewardType != null && $product->id != $hasRewardType->id) {
            return [
                'status' => STATUS_ERROR,
                'status_type' => REWARD_TYPE,
                'messages' => __('messages.GAC001_L001')
            ];
        }

        // Check Total Reward Percent
        $totalPercent = $productOfGacha->sum('reward_percent')+$params['reward_percent']-$product->reward_percent;
        if ($totalPercent > 100) {
            return [
                'status' => STATUS_ERROR,
                'status_type' => REWARD_PERCENT,
                'messages' => __('messages.GAC001_L002')
            ];
        }

        // Upload new attachment and Delete old attachment
        if (!empty($params['attachment']) && !empty($params['attachment_base64'])) {
            UploadHelper::destroyS3($product->attachment);

            $imageUrl = UploadHelper::doUploadS3Base64($params['attachment_base64']);
            $params['attachment'] = $imageUrl;
        }

        return $this->productRepository->update($params, $id);
    }
}
