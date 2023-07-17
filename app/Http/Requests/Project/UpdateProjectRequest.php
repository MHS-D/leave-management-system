<?php

namespace App\Http\Requests\Project;

use App\Constants\ProjectStatus;
use App\Constants\Status;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    protected $rules = [];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()?->can('update', new Project());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if(auth()->user()?->hasRole(config('settings.roles.names.adminRole')) || auth()->user()?->hasRole(config('settings.roles.names.subAdminRole'))){
            $this->mainRules();
        }
        $this->additionalInfoRules();

        return $this->rules;

    }

    private function mainRules()
    {
        $this->mergeWithRules([
            'name' => 'required',
            'company' => 'required',
            'number_of_book' => 'required',
            'date_of_book' => 'required|date',
            'status' => 'required|in:' . implode(',', array_keys(ProjectStatus::ALL)),
            'active' => 'required|in:' . implode(',', array_keys(Status::ALL)),
            'budget' => 'required|numeric',
            'invitation_date' => 'required|date',
            'project_position' => 'required',
        ]);
    }

    private function additionalInfoRules()
    {
        $rule = Rule::when(request()->status == ProjectStatus::FOUR_DONE, 'required','nullable');
        $this->mergeWithRules([
            'assignment_book_number' =>['numeric', $rule],
            'assignment_book_date' => ['date', $rule],
            'assignment_book_submition_day' => ['date', $rule],
            'contract_book_number' => ['numeric', $rule],
            'contract_book_date' =>  ['date', $rule],
            'signature_date' =>  ['date', $rule],
            'work_starting_date' =>  ['date', $rule],
        ]);
    }

    private function mergeWithRules($additionalRules): void
    {
        $this->rules = array_merge($this->rules, $additionalRules);
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
            'assignment_book_number' =>  __('strings.ASSIGNMENT_BOOK_NUMBER'),
            'assignment_book_date' =>  __('strings.ASSIGNMENT_BOOK_DATE'),
            'assignment_book_submition_day' =>  __('strings.ASSIGNMENT_BOOK_SUBMITION_DATE'),
            'contract_book_number' =>  __('strings.CONTRACT_BOOK_NUMBER'),
            'contract_book_date' =>  __('strings.CONTRACT_BOOK_DATE'),
            'signature_date' =>  __('strings.SIGNATURE_RECEIPT_DATE'),
            'work_starting_date' =>  __('strings.WORK_STARTING_DATE'),
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'number_of_book' =>$this->number_of_book ? str_replace(',', '', $this->number_of_book) : null,
            'budget' => $this->budget ? str_replace(',', '', $this->budget) : null,
            'assignment_book_number' => $this->assignment_book_number ? str_replace(',', '', $this->assignment_book_number) : null,
            'contract_book_number' =>$this->contract_book_number ? str_replace(',', '', $this->contract_book_number) : null,
        ]);
    }




}
