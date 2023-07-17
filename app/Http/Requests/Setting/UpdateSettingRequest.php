<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
        return [
            'offers_default_minimum_days' => 'nullable|numeric|min:0',
            'offers_default_minimum_balance' => 'nullable|numeric|min:0',
            'offers_dynamic_minimum_days' => 'nullable|numeric|min:0',
            'offers_dynamic_minimum_balance' => 'nullable|numeric|min:0',
            'transactions_system_percentage' => 'nullable|numeric|between:0,100',

            'invitations_first_level_max_number' => 'nullable|numeric|min:0',
            'invitations_second_level_max_number' => 'nullable|numeric|min:0',
            'invitations_first_level_commission_amount' => 'nullable|numeric|min:0',
            'invitations_second_level_commission_amount' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'offers_default_minimum_days' => str_replace(',', '', $this->offers_default_minimum_days),
            'offers_default_minimum_balance' => str_replace(',', '', $this->offers_default_minimum_balance),
            'offers_dynamic_minimum_days' => str_replace(',', '', $this->offers_dynamic_minimum_days),
            'offers_dynamic_minimum_balance' => str_replace(',', '', $this->offers_dynamic_minimum_balance),

            'invitations_first_level_max_number' => str_replace(',', '', $this->invitations_first_level_max_number),
            'invitations_second_level_max_number' => str_replace(',', '', $this->invitations_second_level_max_number),
            'invitations_first_level_commission_amount' => str_replace(',', '', $this->invitations_first_level_commission_amount),
            'invitations_second_level_commission_amount' => str_replace(',', '', $this->invitations_second_level_commission_amount),
        ]);
    }
}
