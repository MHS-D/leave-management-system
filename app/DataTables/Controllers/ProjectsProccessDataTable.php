<?php

namespace App\DataTables\Controllers;

use App\Constants\ProjectStatus;
use App\Constants\Status;
use App\DataTables\Html\Badge;
use App\DataTables\Html\Buttons\Button as DataTableButton;
use App\Models\Project;
use App\Models\StatusModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProjectsProccessDataTable extends DataTable
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
            ->editColumn(__('strings.STATUS'), function ($process) {
                return Badge::make()
                    ->text(__('strings')[ProjectStatus::ALL[$process->name]] ?? 'Not Found')
                    ->bootstrapColor(ProjectStatus::BOOTSTRAP_COLORS[$process->name] ?? 'danger')
                    ->render();
            })
            ->editColumn(__('string.ID'), function ($process){
                return $process->model->id;
            })
            ->editColumn(__('strings.PROJECT_NAME'), function ($process) {
                return $process->model->name;
            })
            ->editColumn(__('strings.PROJECT_CREATED_DATE'), function ($process) {
                return $process->model->created_at->format('H:i:s Y-m-d');
            })
            ->editColumn(__('strings.STATUS_DATE'), function ($process) {
                return $process->created_at->format('H:i:s Y-m-d');
            })
            ->editColumn(__('strings.NOTE'), function ($process) {
                return $process->reason;
            })
            ->addColumn('action', fn($process) => $this->getActionButtonsHtml($process))
            ->rawColumns([__('strings.STATUS'), 'action'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Project $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(StatusModel $model): QueryBuilder
    {
        return $model->where('model_id', request()->project_id)->with('model')->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('process-table')
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
        return array_map(fn(Column $column) => $column->searchable(false),
            [ // This line "filter -> searchable(false)" is required so the custom filter works correctly
                Column::make('id')->title((__('strings.ID')))->width(60)->data('DT_RowIndex'),
                Column::make(__('strings.PROJECT_NAME')),
                Column::make(__('strings.STATUS')),
                Column::make(__('strings.STATUS_DATE')),
                Column::make(__('strings.NOTE')),
                Column::make(__('strings.PROJECT_CREATED_DATE')),
            ]
        );
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Projects_process' . date('YmdHis');
    }

    /**
     * Get dataTable parameters array
     *
     * @return array
     */
    protected function getParameters(): array
    {
        $parameters = ['buttons' => []];

        return $parameters;
    }

    /**
     * Get row actions buttons as HTML
     *
     * @param Offer $Project
     *
     * @return string
     */
    protected function getActionButtonsHtml(StatusModel $status): string
    {
        return '';
    }

}
