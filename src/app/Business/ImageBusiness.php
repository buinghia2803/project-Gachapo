<?php
namespace App\Business;

use App\Repositories\ImageRepository;

class ImageBusiness extends BaseBusiness
{
    /**
     * @var ImageRepository
     */
    protected ImageRepository $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        parent::__construct($imageRepository);
        $this->imageRepository = $imageRepository;
    }

    public function getImageByItemIdAndType($itemId, $type, $perPage)
    {
        return $this->imageRepository->getImageByItemIdAndType($itemId, $type, $perPage);
    }

    public function getAvatarByUser($userId)
    {
        return $this->imageRepository->getAvatarByUser($userId);
    }
}
