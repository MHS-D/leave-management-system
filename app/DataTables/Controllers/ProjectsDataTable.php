<?php

namespace App\DataTables\Controllers;

use App\Constants\ProjectStatus;
use App\Constants\Status;
use App\DataTables\Html\Badge;
use App\DataTables\Html\Buttons\Button as DataTableButton;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProjectsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn(__('strings.STATUS'), function ($project) {
                return Badge::make()
                    ->text(__('strings')[ProjectStatus::ALL[$project->status]] ?? 'Not Found')
                    ->bootstrapColor(ProjectStatus::BOOTSTRAP_COLORS[$project->status] ?? 'danger')
                    ->render();
            })
            ->orderColumn(__('strings.STATUS'), fn ($query, $direction) => $query->orderByStatus($direction,'status'))

            ->editColumn('active', function ($project) {
                return Badge::make()
                    ->text(__('strings')[Status::ALL[$project->active]] ?? 'Not Found')
                    ->bootstrapColor(Status::BAGDE_MAP[Status::ALL[$project->active]] ?? 'danger')
                    ->render();
            })
            ->editColumn(__('id'), function ($project) {return $project->id;})

            ->editColumn(__('strings.NUMBER_OF_BOOK'), function ($project) {return $project->number_of_book;})
            ->orderColumn(__('strings.NUMBER_OF_BOOK'), fn ($query, $direction) => $query->orderByColumn($direction, 'number_of_book'))

            ->editColumn(__('strings.BUDGET'), function ($project) {return number_format($project->budget);})
            ->orderColumn(__('strings.BUDGET'), fn ($query, $direction) => $query->orderByColumn($direction, 'budget'))

            ->editColumn(__('strings.PROJECT_NAME'), function ($project) {return $project->name;})
            ->orderColumn(__('strings.PROJECT_NAME'), fn ($query, $direction) => $query->orderByColumn($direction, 'name'))

            ->editColumn(__('strings.COMPANY'), function ($project) {return $project->company;})
            ->orderColumn(__('strings.COMPANY'), fn ($query, $direction) => $query->orderByColumn($direction, 'company'))

            ->editColumn(__('strings.DATE_OF_BOOK'), function ($project) {return $project->date_of_book;})
            ->orderColumn(__('strings.DATE_OF_BOOK'), fn ($query, $direction) => $query->orderByColumn($direction, 'date_of_book'))

            ->editColumn(__('strings.PROJECT_CREATED_DATE'), function ($project) {return $project->created_at->format('Y-m-d H:i:s');})
            ->orderColumn(__('strings.PROJECT_CREATED_DATE'), fn ($query, $direction) => $query->orderByColumn($direction, 'created_at'))

            ->editColumn(__('strings.LATEST_STATUS_DATE'), function ($project) {return $project->latestStatus()->created_at->format('Y-m-d H:i:s');})
            ->orderColumn(__('strings.LATEST_STATUS_DATE'), fn ($query, $direction) => $query->orderByColumn($direction, 'updated_at'))

            ->editColumn(__('strings.NOTE'), function ($project) {return $project->latestStatus()->reason;})
            ->orderColumn(__('strings.NOTE'), fn ($query, $direction) => $query->orderByStatus($direction,'status'))

            ->editColumn(__('strings.PROJECT_DAYS_NUMBER'), function ($project) {return $project->getProjectDays();})
            ->orderColumn(__('strings.PROJECT_DAYS_NUMBER'), fn ($query, $direction) => $query->orderByStatus($direction,'status'))

            ->addColumn('action', fn ($project) => $this->getActionButtonsHtml($project))
            ->rawColumns([__('strings.STATUS'), 'action', 'active'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Project $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Project $model): QueryBuilder
    {
        $searchValue = request('search.value');
        // $projectStatusesOrdered = implode(',', [ProjectStatus::UNDER_REVIEW, ProjectStatus::ACTIVE, ProjectStatus::INACTIVE]); // This line is for customize ordering of project status column if needed

        $user = auth()->user();
        $is_admin = $user->hasRole(config('settings.roles.names.adminRole'));
        $allowed_statuses = !$is_admin ? getAllowedStatuses('view') : [];

        $chosen_department = self::checkDepartment($user->role);

        // filter on department
        $departments_ids = request()->role ? (User::whereHas('roles', fn ($query) => $query->where('name', request()->role))->pluck('id')->toArray() ?? []) : [];

        //filter by empty column
        $column = request()->column ?? false;

        return $model->newQuery()
            // ->when(request('order.0.column') == 0, fn ($query) => $query->orderByRaw("FIELD(status, $projectStatusesOrdered)"))
            ->when($searchValue !== null, function ($query) use ($searchValue) {
                $query->orWhere('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('company', 'like', '%' . $searchValue . '%')
                    ->orWhere('number_of_book', 'like', '%' . $searchValue . '%')
                    ->orWhere('date_of_book', 'like', '%' . $searchValue . '%')
                    ->orWhereIn('status', getKeysWhereValues(ProjectStatus::ALL, $searchValue))
                    ->orWhereIn('active', getKeysWhereValues(Status::ALL, $searchValue));
            })->when(!$is_admin, fn ($query) => $query->active()->whereIn('status', $allowed_statuses))
            ->when($chosen_department, fn ($query) => $query->whereChosenDepartmentId($user->id))
            ->when(request()->active, fn ($query) => $query->where('active', request()->active))
            ->when(request()->status, fn ($query) => $query->whereIn('status', request()->status))
            ->when(count($departments_ids), fn ($query) => $query->whereIn('status',[ProjectStatus::ONE_DONE,ProjectStatus::TWO_INPROGRESS])
            ->whereIn('chosen_department_id', $departments_ids))
            ->when($column, fn ($query) => $query->whereNotNull($column));
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        $total_budget = $this->query(new Project())->sum('budget');
        View::share('total_budget', number_format($total_budget));

        return $this->builder()
            ->setTableId('projects-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l><"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>>t<"d-flex justify-content-between mx-2 row mb-1"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',)
            ->orderBy(0)
            ->selectStyleSingle()
            ->lengthMenu([[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']])
            ->parameters($this->getParameters());
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return array_map(fn (Column $column) => $column->searchable(false), [ // This line "filter -> searchable(false)" is required so the custom filter works correctly
            Column::make('id')
                ->title((__('strings.ID')))
                ->width(60),
            Column::make(__('strings.PROJECT_NAME')),
            Column::make(__('strings.COMPANY')),
            Column::make(__('strings.NUMBER_OF_BOOK')),
            Column::make(__('strings.DATE_OF_BOOK')),
            Column::make(__('strings.STATUS')),
            Column::make(__('strings.LATEST_STATUS_DATE')),
            Column::make(__('strings.NOTE')),
            Column::make(__('strings.PROJECT_CREATED_DATE')),
            Column::make(__('strings.PROJECT_DAYS_NUMBER')),
            Column::make(__('strings.BUDGET')),
            Column::make('active'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ]);
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Projects_' . date('YmdHis');
    }

    /**
     * Get dataTable parameters array
     *
     * @return array
     */
    protected function getParameters(): array
    {
        $parameters = ['buttons' => []];

     /*    if (auth()->user()?->can('exportDatatable', Project::class)) {
            $parameters["buttons"][] = [
                [
                    "extend" => 'collection',
                    "className" => 'btn btn-outline-secondary dropdown-toggle me-2',
                    "text" => 'Export',
                    "buttons" => [
                        [
                            "extend" => 'print',
                            "text" => 'Print',
                            "className" => 'dropdown-item',
                            "exportOptions" => ["columns" => [0, 1, 2, 3]]
                        ],
                        [
                            "extend" => 'csv',
                            "text" => 'Csv',
                            "className" => 'dropdown-item',
                            "exportOptions" => ["columns" => [0, 1, 2, 3]]
                        ],
                        [
                            "extend" => 'excel',
                            "text" => 'Excel',
                            "className" => 'dropdown-item',
                            "exportOptions" => ["columns" => [0, 1, 2, 3]]
                        ],
                        [
                            "extend" => 'pdf',
                            "text" => 'Pdf',
                            "className" => 'dropdown-item',
                            "exportOptions" => ["columns" => [0, 1, 2, 3]]
                        ],
                        [
                            "extend" => 'copy',
                            "text" => 'Copy',
                            "className" => 'dropdown-item',
                            "exportOptions" => ["columns" => [0, 1, 2, 3]]
                        ]
                    ],
                ]
            ];
        } */

        // Create button
        if (auth()->user()?->hasRole(config('settings.roles.names.adminRole')) || auth()->user()?->hasRole(config('settings.roles.names.subAdminRole'))) {
            $parameters['buttons'][] = [
                "text" =>  __('strings.ADD_PROJECT') ,
                "className" => 'btn-create btn btn-primary',
                "tag" => "a",
                "attr" => [
                    'href' => route('projects.create'),
                ],
            ];
        }


        return $parameters;
    }

    /**
     * Get row actions buttons as HTML
     *
     * @param Offer $Project
     *
     * @return string
     */
    protected function getActionButtonsHtml(Project $project): string
    {
        $buttons = [];

        // Update
        if (auth()->user()?->hasRole(config('settings.roles.names.adminRole')) || auth()->user()?->hasRole(config('settings.roles.names.subAdminRole'))) {
            $buttons[] = DataTableButton::make()
                ->icon('fa-regular fa-pen-to-square')
                ->additionalClass('rounded-circle')
                ->type('flat')
                ->status('info')
                ->attributes([
                    'title' => 'Edit',
                    'href' => route('projects.edit', $project->id),
                ])
                ->tag('a')
                ->render();
        }

           //process
           if (auth()->user()?->hasRole(config('settings.roles.names.adminRole')) || auth()->user()?->hasRole(config('settings.roles.names.subAdminRole'))) {
            $buttons[] = DataTableButton::make()
                ->icon('fa-solid fa-newspaper')
                ->additionalClass('rounded-circle process_btn')
                ->type('flat')
                ->status('info')
                ->attributes([
                    'title' => 'Process report',
                    'href' => route('projects.proccess.index', ['project_id' => $project->id]),
                ])
                ->tag('a')
                ->render();
        }

            //delete
            if (auth()->user()?->hasRole(config('settings.roles.names.adminRole'))) {
            $buttons[] = DataTableButton::make()
                ->icon('fa-solid fa-trash')
                ->additionalClass('rounded-circle confirm-delete')
                ->type('flat')
                ->status('danger')
                ->attributes([
                    'title' => 'Delete',
                    'confirm-delete-url' => route('projects.destroy', $project->id),
                    'confirm-delete-dataTable-id' => 'projects-table',
                ])
                ->render();
        }

        if (auth()->user()?->hasRole(config('settings.roles.names.department6Role')) ) {
            $buttons[] = DataTableButton::make()
                ->icon('fa-solid fa-newspaper')
                ->additionalClass('rounded-circle status_update_info')
                ->type('flat')
                ->status('info')
                ->attributes([
                    'title' => 'update Info',
                    'data-id' => $project->id,
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#update_info_modal'
                ])
                ->render();
        }

        if (!auth()->user()?->hasRole(config('settings.roles.names.adminRole')) && !auth()->user()?->hasRole(config('settings.roles.names.subAdminRole'))) {
            $buttons[] = DataTableButton::make()
                ->icon('fa-regular fa-pen-to-square')
                ->additionalClass('rounded-circle status_update_btn')
                ->type('flat')
                ->status('info')
                ->attributes([
                    'title' => 'update status',
                    'data-id' => $project->id,
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#update_status_modal'
                ])
                ->render();
        }





        $html = '<div class="d-flex">' . implode('', $buttons) . '</div>';

        return $html;
    }

    public static function checkDepartment($role)
    {
        $check_department = false;
        if (in_array($role, config('settings.roles.chosen_departments'))) {
            $check_department = true;
        }
        return $check_department;
    }
}
