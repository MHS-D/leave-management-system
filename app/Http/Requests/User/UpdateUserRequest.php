<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()?->can('update', $this->user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username,' . $this->user->id,
            'password' => 'nullable|min:8|confirmed',
            'status' => 'required',
            // 'role' => Rule::requiredIf(fn () => $this->permissions_by_role == 1 || $this->permissions_by_role === null),
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => __('strings.FIRST_NAME'),
            'last_name' => __('strings.LAST_NAME'),
            'username' => __('strings.USERNMAE'),
            'password' => __('strings.PASSWORD'),
            'status' => __('strings.STATUS'),
            'role' => __('strings.ROLE'),
        ];
    }

}
