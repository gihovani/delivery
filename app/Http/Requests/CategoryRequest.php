<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,'.$entityId],
        ];
    }
}
