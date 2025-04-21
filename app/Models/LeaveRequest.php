<?php

namespace App\Models;

use App\Constants\LeaveRequestStatus;
use App\Constants\Status;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Spatie\ModelStatus\HasStatuses;


class LeaveRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }




}
