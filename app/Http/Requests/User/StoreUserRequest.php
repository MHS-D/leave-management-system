<?php

namespace App\Http\Requests\User;

use App\Constants\Status;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()?->can('create', User::class);
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
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8|confirmed',
            'status' => 'required|in:' . implode(',', array_keys(Status::ALL)),
            'role' => 'required',
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
