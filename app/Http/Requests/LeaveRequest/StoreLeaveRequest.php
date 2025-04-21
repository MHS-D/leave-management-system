<?php

namespace App\Http\Requests\LeaveRequest;

use App\Constants\LeaveRequestStatus;
use App\Constants\Status;
use App\Models\LeaveRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class StoreLeaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->routeIs('leave-requests.store') ? auth()->user()?->can('create', LeaveRequest::class) : auth()->user()?->can('edit', LeaveRequest::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'start_date' => __('strings.START_DATE'),
            'end_date' => __('strings.END_DATE'),
            'reason' => __('strings.REASON'),
        ];
    }

}
