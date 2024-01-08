<?php


namespace App\Repositories;


use App\Models\Notification;

class NotificationRepository extends BaseRepository
{

    public function search($query, $column, $data)
    {
        switch ($column) {
            case 'id':
            case 'status':
            case 'type':
                return $query->where($column, $data);
            case 'start_time':
                return $query->where($column, 'like', '%' . $data . '%');
                break;
            case 'is_published':
                return $query->where('status', $data);
            default:
                return $query;
                break;
        }
    }

    /**
     * Get searchable fields array
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    public function model()
    {
        return Notification::class;
    }

    public function getListStatus()
    {
        return [
            PUBLISH =>   __('labels.NML001_L0010'),
            UNPUBLISH => __('labels.NML001_L0011'),
        ];
    }

    public function getListType()
    {
        return [
            USER =>   __('labels.NML001_L008'),
            COMPANY => __('labels.NML001_L009'),
        ];
    }

    public function store($data)
    {
        $query = $this->model->newQuery();

        return $query->create($data);
    }

    /*
    * Get detail notifity of company
    */
    public function getNotifyDetail($id)
    {
        $query = $this->model->newQuery();

        $notify = $query->findOrFail($id);

        return $notify;
    }

    /*
    * Get 5 notifies
    */
    public function getFiveNotifies()
    {
        $query = $this->model->newQuery();
        $limit = COMPANY_DASHBOARD_PER_PAGE ;
        $notifies = $query->where('status', PUBLISH)->orderByDesc('created_at')->take($limit)->get();

        return $notifies;
    }
}
