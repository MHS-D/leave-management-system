<?php

namespace App\Models;

use App\Constants\ProjectStatus;
use App\Constants\Status;
use App\DataTables\Controllers\ProjectsProccessDataTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Spatie\ModelStatus\HasStatuses;


class Project extends Model
{
    use HasFactory, HasStatuses;

    protected $guarded = [];


    public function scopeActive($query)
    {
        return $query->where('active', Status::ACTIVE);
    }

    /**
     * Order by status column as string not integer (ID)
     *
     * @param Builder $query
     * @param string $direction
     * @return void
     */
    public function scopeOrderByStatus(Builder $query, string $direction = 'asc',$column): void
    {
        $statuses =[
            'active' => collect(Status::ALL),
            'status' => collect(ProjectStatus::ALL)
        ][$column];

        $statusesIdsOrdered = [];

        if ($direction == 'desc') {
            $statusesIdsOrdered = $statuses->sortDesc()->keys()->toArray();
        } else {
            $statusesIdsOrdered = $statuses->sort()->keys()->toArray();
        }

        $statusesIdsOrderedString = implode(',', $statusesIdsOrdered);

        $query->orderByRaw("FIELD($column, $statusesIdsOrderedString)");
    }

    /**
     * Order by columns
     *
     * @param Builder $query
     * @param string $direction
     * @return void
     */
    public function ScopeOrderByColumn(Builder $query, string $direction = 'asc', $column): void
    {
        $query->orderBy($column,$direction);
    }


    public function getProjectDays(){

        $start = $this->created_at;
        $end = $this->latestStatus()->created_at;

        $diff = $start->diffInDays($end) +1;
        return $diff;
    }

}
