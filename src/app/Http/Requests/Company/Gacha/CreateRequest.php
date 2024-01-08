<?php

namespace App\Http\Requests\Company\Gacha;

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
            'name' => 'required|max:20',
            'selling_price' => 'required|min:0',
            'discounted_price' => 'required',
            'description' => 'required|max:500',
            'period_start' => 'required',
            'period_end' => 'required',
            'images' => 'required',
            'images.*' => 'file|mimes:jpeg,png|max:20480',
            'product_xlsx' => 'required|file|mimes:xlsx|max:20480',
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
        $errorMessageNameMaxLength = __('messages.CM001_L011', ['attr' => 20]);
        $errorMessageSellingPriceMin = __('messages.CM001_L032', ['attr' => 0]);
        $errorMessageDescriptionMax = __('messages.CM001_L025', ['attr' => 500]);

        $errorMessageRequiredImage = __('messages.CM001_L001');
        $errorMessageFormatImage = __('messages.BMV001_L001');
        $errorMessageFilesizeImage = __('messages.CM001_L004', [ 'attr' => '20MB' ]);

        $errorMessageFormatFile = __('messages.CM001_L034', ['attr' => 'xlsx']);

        return [
            'name.required'                 => $errorMessageRequired,
            'name.max'                      => $errorMessageNameMaxLength,

            'selling_price.required'        => $errorMessageRequired,
            'selling_price.max'             => $errorMessageSellingPriceMin,

            'discounted_price.required'     => $errorMessageRequired,

            'description.required'          => $errorMessageRequired,
            'description.max'               => $errorMessageDescriptionMax,

            'period_start.required'         => $errorMessageRequired,
            'period_end.required'           => $errorMessageRequired,

            'images.required'               => $errorMessageRequiredImage,
            'images.file'                   => $errorMessageFormatImage,
            'images.mimes'                  => $errorMessageFormatImage,
            'images.max'                    => $errorMessageFilesizeImage,

            'product_xlsx.required'         => $errorMessageRequired,
            'product_xlsx.file'             => $errorMessageFormatFile,
            'product_xlsx.mimes'            => $errorMessageFormatFile,
            'product_xlsx.max'              => $errorMessageFilesizeImage,
        ];
    }

    public function errors()
    {
        return $this->messages();
    }
}
