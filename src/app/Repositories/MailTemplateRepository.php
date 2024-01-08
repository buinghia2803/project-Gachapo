<?php

namespace App\Repositories;

use App\Models\MailTemplate;

/**
 * Class MailTemplateRepository.
 */
class MailTemplateRepository extends BaseRepository
{

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
     * @return string
     *  Return the model
     */
    public function model()
    {
        return MailTemplate::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getListMailTemplate()
    {
        $query = $this->model->newQuery();
        $query->whereNull('deleted_at');
        $data = $query->get();
        foreach ($data as $email) {
            $email->cc = $email->cc ? explode(",", $email->cc) : [];
            $email->bcc = $email->bcc ? explode(",", $email->bcc) : [];
        }
        
        return $data;
    }

    public function store($dataMailTemplate)
    {
        $query = $this->model->newQuery();

        return $query->updateOrCreate(
            [
                'type' => $dataMailTemplate['type'],
            ],
            $dataMailTemplate
        );
    }

    public function findDataByType($type)
    {
        $query = $this->model->newQuery();
        $query->where('type', $type)
            ->whereNull('deleted_at');

        return $query->first();
    }

    public function getMailTemplateByType($type)
    {
        $mailTemplate = $this->model->newQuery()
            ->where('type', $type)
            ->whereNull('deleted_at')
            ->first();

        return $mailTemplate;
    }
}
