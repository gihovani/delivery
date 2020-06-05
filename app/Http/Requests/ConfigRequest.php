<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
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
            'image' => ['mimes:png'],
            'zipcode' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:255'],
            'is_open' => ['boolean'],
            'waiting_time' => ['required', 'integer'],
            'store' => ['required', 'string', 'max:255'],
            'google_maps' => ['nullable', 'url'],
            'address' => ['nullable', 'string']
        ];
    }
}