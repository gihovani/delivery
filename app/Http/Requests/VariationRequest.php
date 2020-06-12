<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VariationRequest extends FormRequest
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
        $entityId = request()->post('entity_id');
        $imageRules = ['mimes:png'];
        if (!$entityId) {
            $imageRules[] = ['required'];
        }
        return [
            'image' => $imageRules,
            'name' => ['required', 'string', 'max:255', 'unique:variations,name,'.$entityId],
            'description' => ['nullable', 'string']
        ];
    }
}
