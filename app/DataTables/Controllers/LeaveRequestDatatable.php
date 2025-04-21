<?php

namespace App\DataTables\Controllers;

use App\Constants\LeaveRequestStatus;
use App\Constants\Status;
use App\DataTables\Html\Badge;
use App\DataTables\Html\Buttons\Button as DataTableButton;
use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LeaveRequestDatatable extends DataTable
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
            ->editColumn('status', function ($leave_request) {
                return Badge::make()
                    ->text(LeaveRequestStatus::ALL[$leave_request->status] ?? 'Not Found')
                    ->bootstrapColor(LeaveRequestStatus::BOOTSTRAP_COLORS[$leave_request->status] ?? 'danger')
                    ->render();
            })
            ->editColumn('user_id', function ($leave_request) {
                return $leave_request->user->full_name;
            })
            ->editColumn('created_at', fn($leave_request) => Carbon::parse($leave_request->created_at)->format('F j, Y  h:i A'))
            ->editColumn('start_date', fn($leave_request) => Carbon::parse($leave_request->start_date)->format('F j, Y h:i:A') )
            ->editColumn('end_date', fn($leave_request) => Carbon::parse($leave_request->end_date)->format('F j, Y h:i:A') )
            ->editColumn('reason', fn($leave_request) => e($leave_request->reason))
            ->editColumn('note', fn($leave_request) => e($leave_request->note))
            ->addColumn('action', fn ($leave_request) => $this->getActionButtonsHtml($leave_request))
            ->rawColumns(['status', 'action'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LeaveRequest $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LeaveRequest $model): QueryBuilder
    {
        $searchValue = request('search.value');

        $user = auth()->user();
        $is_admin = $user->hasRole(config('settings.roles.names.adminRole'));

        return $model->newQuery()
        ->when($searchValue !== null, function ($query) use ($searchValue) {
            $query->orWhereHas('user', function ($q) use ($searchValue) {
                    $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$searchValue}%"]);
                })
                ->orWhere('start_date', 'like', '%' . $searchValue . '%')
                ->orWhere('end_date', 'like', '%' . $searchValue . '%')
                ->orWhere('reason', 'like', '%' . $searchValue . '%')
                ->orWhere('note', 'like', '%' . $searchValue . '%')
                ->orWhereIn('status', getKeysWhereValues(LeaveRequestStatus::ALL, $searchValue));
        })->when(!$is_admin, function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('leave-requests-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l><"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>>t<"d-flex justify-content-between mx-2 row mb-1"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',)
            ->orderBy(0)
            ->selectStyleSingle()
            ->parameters($this->getParameters())
            ->lengthMenu([[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return array_map(fn (Column $column) => $column->searchable(false), [
            Column::make('id')->title('ID'),
            Column::make('user_id')->title(__('strings.USER_NAME')),
            Column::make('start_date')->title(__('strings.START_DATE')),
            Column::make('end_date')->title(__('strings.END_DATE')),
            Column::make('reason')->title(__('strings.REASON')),
            Column::make('note')->title(__('strings.NOTE')),
            Column::make('status')->title(__('strings.STATUS')),
            Column::make('created_at')->title(__('strings.REQUESTED_AT')),
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
        return 'leave_requests' . date('YmdHis');
    }

    /**
     * Get dataTable parameters array
     *
     * @return array
     */
    protected function getParameters(): array
    {
        $parameters = ['buttons' => []];

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

        // Create button
        if (auth()->user()?->hasRole(config('settings.roles.names.employeeRole'))) {
            $parameters['buttons'][] = [
                "text" =>  __('strings.NEW_LEAVE_REQUEST'),
                "className" => 'btn-create btn btn-primary',
                "tag" => "a",
                "attr" => [
                    'href' => route('leave-requests.create'),
                ],
            ];
        }


        return $parameters;
    }

    /**
     * Get row actions buttons as HTML
     *
     * @param Offer $leave_request
     *
     * @return string
     */
    protected function getActionButtonsHtml(LeaveRequest $leave_request): string
    {
        $buttons = [];

        // Update
        if (auth()->user()?->hasRole(config('settings.roles.names.employeeRole')) && $leave_request->status == LeaveRequestStatus::REQUESTED) {
            $buttons[] = DataTableButton::make()
                ->icon('fa-regular fa-pen-to-square')
                ->additionalClass('rounded-circle')
                ->type('flat')
                ->status('info')
                ->attributes([
                    'title' => 'Edit',
                    'href' => route('leave-requests.edit', $leave_request->id),
                ])
                ->tag('a')
                ->render();
        }



        //accept reject
        if (auth()->user()?->hasRole(config('settings.roles.names.adminRole'))) {
            $buttons[] = DataTableButton::make()
                ->icon('fa-regular fa-pen-to-square')
                ->additionalClass('rounded-circle status_update_btn')
                ->type('flat')
                ->status('info')
                ->attributes([
                    'title' => 'update status',
                    'data-id' => $leave_request->id,
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#update_status_modal'
                ])
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
                    'confirm-delete-url' => route('leave-requests.destroy', $leave_request->id),
                    'confirm-delete-dataTable-id' => 'leave-requests-table',
                ])
                ->render();
        }


        $html = '<div class="d-flex">' . implode('', $buttons) . '</div>';

        return $html;
    }

}
