<?php


namespace App\Repositories;


use App\Models\Page;

class PageRepository extends BaseRepository
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
     * Configure the Model
     *
     * @return string
     */
    public function model()
    {
        return Page::class;
    }

    public function getStatusList()
    {
        return [
            PUBLISH_POST =>   __('labels.NML001_L0010'),
            UNPUBLISH_POST => __('labels.NML001_L0011'),
            DRAFT_POST => __('labels.APM001_L003'),
        ];
    }

    public function getUnusedTypeList()
    {
        $query = $this->model->newQuery();
        $listTypeUsed = $query->pluck('type')->all();

        return array_except($this->getTypeList(), $listTypeUsed);
    }

    public function getTypeList()
    {
        return [
            PRIVACY_POLICY_REGISTRATION => __('labels.APM001_L004'),
            NOTATION_REGISTRATION_COMMERCIAL => __('labels.APM001_L005'),
            TERMS_OF_USE_REGISTRATION => __('labels.APM001_L006'),
            NOTATION_REGISTRATION_SETTLEMENT => __('labels.APM001_L007'),
            COMPLIANCE_POLICY_REGISTRATION => __('labels.APM001_L008'),
            OPERATOR_INFORMATION => __('labels.APM001_L012'),
            USAGE_GUIDE => __('labels.APM001_L013'),
            SHIPPING_CHARGES_INFO => __('labels.APM001_L014'),
        ];
    }

    public function search($query, $column, $data)
    {
        switch ($column) {
            case 'id':
            case 'status':
                return $query->where($column, $data);
                break;
            case 'title':
                return $query->where($column, 'like', '%' . $data . '%');
                break;
            default:
                return $query;
                break;
        }
    }
}
