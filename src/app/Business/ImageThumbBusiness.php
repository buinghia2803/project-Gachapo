<?php
namespace App\Business;

use App\Repositories\ImageThumbRepository;

class ImageThumbBusiness extends BaseBusiness
{
    /**
     * @var ImageThumbRepository
     */
    protected ImageThumbRepository $imageThumbRepository;

    public function __construct(ImageThumbRepository $imageThumbRepository)
    {
        parent::__construct($imageThumbRepository);
        $this->imageThumbRepository = $imageThumbRepository;
    }
    public function getImageThumbByItemIdAndType($itemId, $type, $perPage)
    {
        return $this->imageThumbRepository->getImageThumbByItemIdAndType($itemId, $type, $perPage);
    }
}
