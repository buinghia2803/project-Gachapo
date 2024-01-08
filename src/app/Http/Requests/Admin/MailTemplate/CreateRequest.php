<?php

namespace App\Http\Requests\Admin\MailTemplate;

use App\Http\Requests\BaseRequest;

class CreateRequest extends BaseRequest
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
            'subject' => 'required|max:255',
            'cc'      => 'nullable|max:255',
            'bcc'      => 'nullable|max:255',
            'content' => 'required',
            'attachment' => 'nullable|file|max:20480',
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
            'subject',
            'cc',
            'bcc',
            'content',
            'attachment',
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => __('messages.CM_MSG001'),
            'subject.max' => __('messages.CM_MSG003'),
            'cc.max' => __('messages.CM_MSG003'),
            'bcc.max' => __('messages.CM_MSG003'),
            'content.required' => __('messages.CM_MSG001'),
            'attachment.max'   => __('messages.MT_MSG001'),
        ];
    }

    public function errors()
    {
        return $this->messages();
    }
}
