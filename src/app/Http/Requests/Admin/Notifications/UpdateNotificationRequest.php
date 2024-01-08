<?php

namespace App\Http\Requests\Admin\Notifications;

use App\Http\Requests\BaseRequest;

class UpdateNotificationRequest extends BaseRequest
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
            'content' => 'required',
            'start_time'      => 'required',
            'type' => 'required',
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
            'content',
            'start_time',
            'end_time',
            'status',
            'type',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('messages.CM001_L001'),
            'title.max'    => __('messages.CM001_L011', ['attr' => '255']),
            'content.required' => __('messages.CM001_L001'),
            'start_time.required' => __('messages.CM001_L001'),
            'type.required' => __('messages.CM001_L001')
        ];
    }

    public function errors()
    {
        return $this->messages();
    }
}
