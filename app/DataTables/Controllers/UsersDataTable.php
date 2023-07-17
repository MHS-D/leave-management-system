<?php

namespace App\DataTables\Controllers;

use App\Constants\Status;
use App\DataTables\Html\Badge;
use App\DataTables\Html\Buttons\Button as DataTableButton;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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

            ->editColumn('status', function ($user) {
                return Badge::make()
                    ->text(__('strings')[Status::ALL[$user->status]] ?? 'Not Found')
                    ->bootstrapColor(Status::BAGDE_MAP[Status::ALL[$user->status]] ?? 'danger')
                    ->render();
            })

            ->editColumn('role', fn ($user) => __('strings')[$user->role])
            ->orderColumn('role', fn ($query, $direction) => $query->orderByRole($direction))

            ->addColumn('action', fn ($user) => $this->getActionButtonsHtml($user))
            ->setRowAttr(['data-id' => fn ($user) => $user->id])
            ->rawColumns(['action', 'status'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
    {
        $searchValue = request('search.value');

        return $model->newQuery()
            ->with(['roles'])
            ->when($searchValue !== null, function ($query) use ($searchValue) {
                $query->orWhere('first_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('last_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('username', 'like', '%' . $searchValue . '%')
                    ->orWhereIn('status', getKeysWhereValues(Status::ALL, $searchValue))
                    ->orWhereHas('roles', fn ($query) => $query->where('name', 'like', '%' . $searchValue . '%')->limit(1)->orderBy('id', 'asc'));
            })
            ->when(request('status') !== null, fn ($query) => $query->where('status', request('status')));
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l><"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>>t<"d-flex justify-content-between mx-2 row mb-1"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',)
            ->orderBy(1)
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
        return array_map(fn (Column $column) => $column->searchable(false), [
//            Column::checkbox('<input type="checkbox" class="row-selection__checkbox--all">')
//                ->content('<input type="checkbox" class="row-selection__checkbox">'),
            Column::make('id')
                ->title((__('strings.ID')))
                ->width(60),
            Column::make('first_name'),
            Column::make('last_name'),
            Column::make('username'),
            Column::make('status'),
            Column::make('role'),
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
        return 'Users_' . date('YmdHis');
    }

    /**
     * Get dataTable parameters array
     *
     * @return array
     */
    protected function getParameters(): array
    {
        $parameters = ['buttons' => []];

        // if (auth()->user()?->can('exportDatatable', User::class)) {
        //     $parameters["buttons"][] = [
        //         [
        //             "extend" => 'collection',
        //             "className" => 'btn btn-outline-secondary dropdown-toggle me-2',
        //             "text" => 'Export',
        //             "buttons" => [
        //                 [
        //                     "text" => 'Excel',
        //                     "className" => 'dropdown-item export-selected-rows',
        //                     "attr" => [
        //                         "href" => route('users.export.excel'),
        //                         "target" => "_blank",
        //                     ],
        //                     "tag" => "a",
        //                 ],
        //                 [
        //                     "text" => 'CSV',
        //                     "className" => 'dropdown-item export-selected-rows',
        //                     "attr" => [
        //                         "href" => route('users.export.csv'),
        //                         "target" => "_blank",
        //                     ],
        //                     "tag" => "a",
        //                 ],
        //                 [
        //                     "text" => 'PDF',
        //                     "className" => 'dropdown-item export-selected-rows',
        //                     "attr" => [
        //                         "href" => route('users.export.pdf'),
        //                         "target" => "_blank",
        //                     ],
        //                     "tag" => "a",
        //                 ],
        //             ],
        //         ]
        //     ];
        // }

        // Create button
        if (auth()->user()?->can('create', User::class)) {
            $parameters['buttons'][] = [
                "text" => __('strings.ADD_USER'),
                "className" => 'btn-create btn btn-primary',
                "attr" => [
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#crud-modal'
                ],
            ];
        }

        $parameters['drawCallback'] = "function () { checkSelectedRows() }";

        return $parameters;
    }

    /**
     * Get row actions buttons as HTML
     *
     * @param User $user
     *
     * @return string
     */
    protected function getActionButtonsHtml(User $user): string
    {
        $buttons = [];


        // Update
        if (auth()->user()?->can('update', $user)) {
            $buttons[] = DataTableButton::make()
                ->icon('fa-regular fa-pen-to-square')
                ->additionalClass('rounded-circle btn-update')
                ->type('flat')
                ->status('info')
                ->attributes([
                    'title' => 'Edit',
                    'data-id' => $user->id,
                ])
                ->render();
        }

        // Delete
        if (auth()->user()?->can('delete', $user)) {
            $buttons[] = DataTableButton::make()
                ->icon('fa-solid fa-trash')
                ->additionalClass('rounded-circle confirm-delete')
                ->type('flat')
                ->status('danger')
                ->attributes([
                    'title' => 'Delete',
                    'confirm-delete-url' => route('users.destroy', $user->id),
                    'confirm-delete-dataTable-id' => 'users-table',
                    'confirm-delete-on-success' => 'getStatistics()',
                ])
                ->render();
        }

        $html = '<div class="d-flex">' . implode('', $buttons) . '</div>';

        return $html;
    }
}
