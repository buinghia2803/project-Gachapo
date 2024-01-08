<?php

namespace App\Business;

use App\Repositories\NotificationRepository;

class NotificationBusiness extends BaseBusiness
{
    protected NotificationRepository $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        parent::__construct($notificationRepository);
        $this->notificationRepository = $notificationRepository;
    }

    public function getListStatus()
    {
        return $this->notificationRepository->getListStatus();
    }

    public function getListType()
    {
        return $this->notificationRepository->getListType();
    }

    public function store($request)
    {
        $data = [
            'content' => $request->content,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
            'type' => $request->type,
        ];
        if ($request->attachment) {
            $data['attachment'] = $request->attachment;
        }
        $this->notificationRepository->store($data);
    }

    public function getConfirmData($data)
    {
        if (!isset($data['status'])) {
            $data['status'] = 2;
        } elseif (isset($data['status']) && $data['status'] == 'on') {
            $data['status'] = 1;
        }

        return $data;
    }

    /*
    * Get detail notifity of company
    */
    public function getNotifyDetail($id)
    {
        return $this->notificationRepository->getNotifyDetail($id);
    }

    /*
    * Get 5 notifies
    */
    public function getFiveNotifies()
    {
        return $this->notificationRepository->getFiveNotifies();
    }
}
