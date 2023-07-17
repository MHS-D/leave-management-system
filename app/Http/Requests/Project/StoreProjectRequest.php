<?php

namespace App\Http\Requests\Project;

use App\Constants\ProjectStatus;
use App\Constants\Status;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()?->hasRole(config('settings.roles.names.adminRole')) || auth()->user()?->hasRole(config('settings.roles.names.subAdminRole')) ? true : false;
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
            'company' => 'required',
            'number_of_book' => 'required',
            'date_of_book' => 'required|date',
            'status' => 'required|in:' . implode(',', array_keys(ProjectStatus::ALL)),
            'active' => 'required|in:' . implode(',', array_keys(Status::ALL)),
            'budget' => 'required|numeric',
            'invitation_date' => 'required|date',
            'project_position' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('strings.PROJECT_NAME'),
            'company' => __('strings.COMPANY'),
            'number_of_book' =>  __('strings.NUMBER_OF_BOOK'),
            'date_of_book' =>  __('strings.DATE_OF_BOOK'),
            'status' =>  __('strings.STATUS'),
            'active' =>  __('strings.ACTIVE'),
            'budget' =>  __('strings.BUDGET'),
            'invitation_date' =>  __('strings.INVITATION_DATE'),
            'project_position' =>  __('strings.PROJECT_POSITION'),
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'number_of_book' => str_replace(',', '', $this->number_of_book),
            'budget' => str_replace(',', '', $this->budget),
        ]);
    }

}
