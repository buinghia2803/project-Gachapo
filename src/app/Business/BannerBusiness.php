<?php

namespace App\Business;

use App\Repositories\BannerRepository;

class BannerBusiness extends BaseBusiness
{
    public function __construct(BannerRepository $bannerRepository)
    {
        $this->repository = $bannerRepository;
    }

    // Banner Main Visual

    public function getlistMainVisual()
    {
        $dataCondition = [
            'type' => BANNER_MAIN_VISUAL,
            'id' => DESC
        ];
        $data = $this->repository->findByCondition($dataCondition);
        return $data->get();
    }

    public function createMainVisual($param)
    {
        if (isset($param['attachment'])) {
            $param['attachment'] = $this->uploadS3Base64($param['attachment']);
        }
        $param['type'] = BANNER_MAIN_VISUAL;
        $data = $this->repository->create($param);
        return $data;
    }

    public function updateMainVisual($id, $param)
    {
        if (isset($param['attachment'])) {
            $param['attachment'] = $this->uploadS3Base64($param['attachment']);
            // Unlink old attachments
            $record = $this->findById($id);
            $this->destroyS3($record->attachment);
        }
        $data = $this->update($id, $param);
        return $data;
    }

    // Banner Normal
    public function getlistNormal()
    {
        $dataCondition = [
            'type' => BANNER_NORMAL,
            'id' => DESC
        ];
        $data = $this->repository->findByCondition($dataCondition);
        return $data->get();
    }

    public function createNormal($param)
    {
        if (isset($param['attachment'])) {
            $param['attachment'] = $this->uploadS3Base64($param['attachment']);
        }
        $param['type'] = BANNER_NORMAL;
        $data = $this->repository->create($param);
        return $data;
    }

    public function updateNormal($id, $param)
    {
        if (isset($param['attachment'])) {
            $param['attachment'] = $this->uploadS3Base64($param['attachment']);
            // Unlink old attachments
            $record = $this->findById($id);
            $this->destroyS3($record->attachment);
        }
        $data = $this->update($id, $param);
        return $data;
    }

    // General

    public function delete($id)
    {
        $banner = $this->findById($id);
        if ($banner != null) {
            if ($banner->attachment) {
                $this->destroyS3($banner->attachment);
            }
            $banner->delete();
            return true;
        } else {
            return false;
        }
    }

    public function getShowType()
    {
        $option = \App\Models\Option::where('key', 'type_show_banner')->first();
        return $option->value ?? 'random';
    }
}
