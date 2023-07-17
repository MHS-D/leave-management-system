<?php

namespace App\Http\Controllers;

use App\Constants\ProjectStatus;
use App\Constants\Status;
use App\DataTables\Controllers\ProjectsDataTable;
use App\DataTables\Controllers\ProjectsProccessDataTable;
use App\Models\Project;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Requests\Project\UpdateProjectStatusRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class ProjectProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProjectsProccessDataTable $dataTable)
    {
        abort_if(!in_array(auth()->user()->role,[config('settings.roles.names.adminRole'),config('settings.roles.names.subAdminRole')]),403);
        return $dataTable->render('backend::sections.projects.process.index');
    }

}
