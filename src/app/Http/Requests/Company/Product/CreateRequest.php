<?php

namespace App\Http\Requests\Company\Product;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

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
        $data = $this->request->all();
        return [
            'reward_type' => 'required|max:30',
            'name' => 'required|max:30',
            'reward_percent' => 'required|min:1|max:100',
            'quantity' => 'required|min:1',
            'attachment' => 'required|file|mimes:jpeg,png|max:20480',
        ];
    }

    /**
     * Set request parameters.
     *
     * @return array
     */
    protected function fields()
    {
        return [];
    }

    public function messages()
    {
        $errorMessageRequired = __('messages.CM001_L001');
        $errorMessageMaxLength30 = __('messages.CM001_L011', ['attr' => 30]);
        $errorMessageRewardPercentRange = __('messages.GAC001_L004');
        $errorMessagePositive = __('messages.CM001_L036');

        $errorMessageRequiredImage = __('messages.CM001_L001');
        $errorMessageFormatImage = __('messages.BMV001_L001');
        $errorMessageFilesizeImage = __('messages.CM001_L004', [ 'attr' => '20MB' ]);

        return [
            'reward_type.required'          => $errorMessageRequired,
            'reward_type.max'               => $errorMessageMaxLength30,

            'name.required'                 => $errorMessageRequired,
            'name.max'                      => $errorMessageMaxLength30,

            'reward_percent.required'       => $errorMessageRequired,
            'reward_percent.min'            => $errorMessageRewardPercentRange,
            'reward_percent.max'            => $errorMessageRewardPercentRange,

            'quantity.required'             => $errorMessageRequired,
            'quantity.min'                  => $errorMessagePositive,

            'attachment.required'           => $errorMessageRequiredImage,
            'attachment.file'               => $errorMessageFormatImage,
            'attachment.mimes'              => $errorMessageFormatImage,
            'attachment.max'                => $errorMessageFilesizeImage,
        ];
    }

    public function errors()
    {
        return $this->messages();
    }
}
