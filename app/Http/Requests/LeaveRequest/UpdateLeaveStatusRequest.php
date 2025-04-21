<?php

namespace App\Http\Requests\LeaveRequest;

use App\Constants\LeaveRequestStatus;
use App\Constants\Status;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeaveStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()?->can('updateStatus', LeaveRequest::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'request_id' => ['required','exists:leave_requests,id'],
            'status' => ['required', Rule::in([
                LeaveRequestStatus::ACCEPTED,
                LeaveRequestStatus::REJECTED,
            ])],
            'note' => 'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'request_id' => __('strings.LEAVE_REQUESTS'),
            'status' => __('strings.STATUS'),
            'note' => __('strings.NOTE'),
        ];
    }


}
