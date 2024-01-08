<?php

namespace App\Http\Requests\Admin\BannerMainVisual;

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
            'title'                  => 'required|max:30',
            'link'                   => 'required',
            'attachment'             => 'nullable|file|max:20480|mimes:jpg,png',
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
            'attachment',
            'link',
        ];
    }

    public function messages()
    {
        return [
            'title.required'        => __('messages.CM001_L001'),
            'title.max'             => __('messages.CM_MSG009', ['attr' => 30]),
            'link.required'         => __('messages.CM001_L001'),
            'attachment.file'       => __('messages.BMV001_L001'),
            'attachment.max'        => __('messages.CM001_L004', [ 'attr' => '20MB' ]),
            'attachment.mimes'      => __('messages.BMV001_L001'),
        ];
    }

    public function errors()
    {
        return $this->messages();
    }
}
