<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\ApiKeyRule;
use Illuminate\Foundation\Http\FormRequest;

class ImageStoreRequest extends FormRequest
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
            'type' => 'required|in:url,file',
            'key' => [new ApiKeyRule(), 'required'],
            'url' => ['required_if:type,url','url'],
            'file' => ['required_if:type,file','image','max:10000'],
        ];
    }
}
