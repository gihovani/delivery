<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (intval(auth()->user()->id) > 0);
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
            'category_id' => ['required', 'string', 'exists:categories,id'],
            'price' => ['required', 'string'],
            'pieces' => ['required', 'integer'],
            'description' => ['nullable', 'string']
        ];
    }
}
