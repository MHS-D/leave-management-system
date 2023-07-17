<?php

namespace App\Http\Requests\Project;

use App\Constants\ProjectStatus;
use App\Constants\Status;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectStatusRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $users_ids = request()->department_id ? User::whereHas('roles', function ($query) {
            $query->whereIn('name', config('settings.roles.chosen_departments'));
        })->pluck('id')->toArray() : [];

        return [
            'project_id' => [
                'required',
                Rule::exists('projects', 'id')->where(function ($query) {
                    $query->whereIn('status', getAllowedStatuses('view'));
                })
            ],
            'action_id' => ['required', Rule::in(getAllowedStatuses('actions'))],
            'department_id' => [Rule::when(request()->action_id == ProjectStatus::ONE_DONE,
            ['required',   Rule::in($users_ids)])],
            'note' => 'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'project_id' => __('strings.PROJECT'),
            'action_id' => __('strings.PROCESS'),
            'department_id' => __('strings.DEPARTMENT'),
            'note' => __('strings.NOTE'),
        ];
    }


}
