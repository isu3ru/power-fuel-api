<?php

namespace App\Http\Requests;

use App\Enums\UserLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'telephone' => [
                'required', 'numeric',
                'regex:/^((0)|7{1}[0-9]{1}[0-9]{7})|(\+947{1}[0-9]{1}[0-9]{7})$/'
            ],
            'password' => 'required',
            'status' => 'nullable',
            'user_level' => ['required', Rule::in(UserLevel::getValues())],
        ];
    }
}
