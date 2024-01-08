<?php

namespace App\Http\Requests\Admin\Page;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
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
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:pages,slug,' . $this->request->get('id') . ',id,deleted_at,NULL',
            'content' => 'required',
            'status' => 'required',
            'type' => 'required|unique:pages,type,'. $this->request->get('id') . ',id,deleted_at,NULL',
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
            'title',
            'slug',
            'content',
            'status',
            'type',
        ];
    }

    /**
     * Get the message that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required'            => __('messages.CM001_L001'),
            'title.max'                 => __('messages.CM001_L011', ['attr' => '255']),
            'slug.required'             => __('messages.CM001_L001'),
            'slug.max'                  => __('messages.CM001_L011', ['attr' => '255']),
            'slug.unique'               => __('messages.CM001_L030'),
            'content.required'          => __('messages.CM001_L001'),
            'status.required'           => __('messages.CM001_L001'),
            'type.required'             => __('messages.CM001_L001'),
            'type.unique'               => __('messages.CM001_L030'),
        ];
    }

    /**
     * Get the errors that apply to the request.
     *
     * @return array
     */
    public function errors()
    {
        return $this->messages();
    }
}
