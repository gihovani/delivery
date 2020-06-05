<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    private $userId;
    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->userId = intval(auth()->user()->id);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ($this->userId > 0);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $entityId = request()->post('entity_id');
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$entityId],
            'telephone' => ['required', 'string', 'celular_com_ddd', 'unique:users,telephone,'.$entityId],
        ];
        if (empty($entityId)) {
            $rules['zipcode'] = ['required', 'string', 'size:9'];
            $rules['street'] = ['required', 'string'];
            $rules['number'] = ['required', 'string'];
            $rules['city'] = ['required', 'string'];
            $rules['state'] = ['required', 'size:2'];
            $rules['neighborhood'] = ['required', 'string'];
            $rules['complement'] = ['string', 'nullable'];
        }
        return $rules;
    }
}
