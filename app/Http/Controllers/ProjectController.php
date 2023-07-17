<?php

namespace App\Http\Controllers;

use App\Constants\ProjectStatus;
use App\Constants\Status;
use App\DataTables\Controllers\ProjectsDataTable;
use App\Models\Project;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Requests\Project\UpdateProjectStatusRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void (Permissions disabled on offers Only roles used, dont delete we may need in upcoming update)
     */
    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProjectsDataTable $dataTable)
    {
        $data['statuses'] = ProjectStatus::ALL;
        $data['types'] =Status::ALL;

        return $dataTable->render('backend::sections.projects.index', $data);
    }

    /**
     * Display the specified resource form page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['statuses'] = auth()->user()->hasRole(config('settings.roles.names.adminRole')) ? ProjectStatus::ALL : [ProjectStatus::CREATED => ProjectStatus::ALL[ProjectStatus::CREATED]];
        $data['types'] = Status::ALL;
        $data['project_status'] = new ProjectStatus();

        return view('backend::sections.projects.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        try {
            $project = Project::create(collect($request->validated())->toArray());
            $project->setStatus($request->status);

            return [
                'success' => true,
                'message' => __('strings.PROJECT_CREATED_SUCCESSFULLY'),
                'redirect_url' => route('projects.index')
            ];
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Display the specified resource form page with data.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $this->authorize('edit', $project);

        $data['statuses'] = auth()->user()->hasRole(config('settings.roles.names.adminRole')) ? ProjectStatus::ALL : [ProjectStatus::CREATED => ProjectStatus::ALL[ProjectStatus::CREATED]];
        $data['types'] = Status::ALL;
        $data['project'] = $project;
        $data['project_status'] = new ProjectStatus();


        return view('backend::sections.projects.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        DB::beginTransaction();

        try {
            $project->update(collect($request->validated())->toArray());

            if(!auth()->user()->hasRole(config('settings.roles.names.department6Role'))){
                $project->setStatus($request->status);
            }

            DB::commit();

            return [
                'success' => true,
                'message' => __('strings.PROJECT_UPDATED_SUCCESSFULLY'),
                'redirect_url' => route('projects.index')
            ];
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return [
            'success' => true,
            'message' => __('strings.PROJECT_DELETED_SUCCESSFULLY'),
        ];
    }


    public function getProjectInfo()
    {
        request()->validate([
            'project_id' => 'required|exists:projects,id',
        ]);

        $project = Project::find(request()->project_id);
        $data['project'] = $project;
        $allowed_actions =[];

        collect(getAllowedStatuses('actions'))->each(function ($status) use (&$allowed_actions) {
            $allowed_actions[] = [
                'id' => $status,
                'name' => __('strings.' . ProjectStatus::ALL[$status]),
            ];
        });

        $data['allowed_actions'] = $allowed_actions;
        $data['selected_status'] = intval($project->status);
        $data['latest_updated_at'] = $project->updated_at->format('H:i:s Y-m-d');
        $data['enable_list_at_done'] = false;

        if(auth()->user()->role == config('settings.roles.names.department1Role'))
        {
            $data['enable_list_at_done'] = true;
            $data['enable_list_at_done_action_id'] = ProjectStatus::ONE_DONE;
            $data['list_users'] = User::whereHas('roles', function ($query) {
                $query->whereIn('name', config('settings.roles.chosen_departments'));
            })->get();
        }

        return response()->json($data);
    }

    public function updateStatus(UpdateProjectStatusRequest $request)
    {
        $validated = $request->validated();

        try{
            DB::beginTransaction();

            self::checkProjectFinished($validated);

            $project = Project::find($validated['project_id']);
            $project->update([
                'status' => $validated['action_id'],
                'chosen_department_id' => $validated['department_id'] ?? $project->chosen_department_id,
            ]);
            $project->setStatus($validated['action_id'], $validated['note'] ?? null);

            DB::commit();
            return [
                'success' => true,
                'message' => __('strings.PROJECT_UPDATED_SUCCESSFULLY'),
            ];
        }catch(Exception $e){
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function checkProjectFinished($data)
    {
        try{
            if($data['action_id'] == ProjectStatus::FOUR_DONE){
                $project = Project::whereKey($data['project_id'])
                ->where(function($q){
                    $q->whereNull('assignment_book_number')
                    ->orWhereNull('assignment_book_date')
                    ->orWhereNull('assignment_book_submition_day')
                    ->orWhereNull('contract_book_number')
                    ->orWhereNull('contract_book_date')
                    ->orWhereNull('signature_date')
                    ->orWhereNull('work_starting_date');
                })->exists();

                throw_if($project, new Exception(__('strings.ADDITIONAL_INFO_MISSING')));
            }

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }

}
