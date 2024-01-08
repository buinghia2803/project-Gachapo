<?php

namespace App\Http\Requests\Admin\Category;

use App\Http\Requests\BaseRequest;

class UpdateCategoryRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required|max:255|unique:categories,name,'. $this->category .',id',
            'slug'  => 'required|max:255|unique:categories,slug,'. $this->category .',id',
        ];
    }

    /**
     * Set request parameters.
     *
     * @return array
     */
    protected function fields()
    {
        return [
            'name',
            'slug',
        ];
    }

    public function messages()
    {
        return [
            'name.required'                  => __('messages.CM_MSG001'),
            'name.max'                       => __('messages.CM_MSG003'),
            'name.unique'                    => __('messages.CT_MSG005'),
            'slug.required'                  => __('messages.CM_MSG001'),
            'slug.max'                       => __('messages.CM_MSG003'),
            'slug.unique'                   => __('messages.CT_MSG006'),
        ];
    }

    public function errors()
    {
        return $this->messages();
    }
}
