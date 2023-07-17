<?php

namespace App\Http\Controllers;

use App\Constants\ProjectStatus;
use App\Constants\Status;
use App\Constants\SubscriptionStatus;
use App\Models\Project;
use App\Models\ProjectSubscription;
use App\Models\SystemTotal;
use App\Models\User;
use App\Models\WithdrawRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;



class DashboardController extends Controller
{
    /**
     * Go to the "Dashboard" page
     *
     * @return View|Factory
     */
    public function index(): View|Factory
    {
        $projects = Project::all();
        $department2_users_ids = User::whereHas('roles', function ($query) {
            $query->where('name', config('settings.roles.names.department2Role'));
        })->pluck('id')->toArray() ?? [];
        $department3_users_ids = User::whereHas('roles', function ($query) {
            $query->where('name', config('settings.roles.names.department3Role'));
        })->pluck('id')->toArray() ?? [];
        $department4_users_ids = User::whereHas('roles', function ($query) {
            $query->where('name', config('settings.roles.names.department4Role'));
        })->pluck('id')->toArray() ?? [];

        // routes
        $data = [
            'active_users_route' => route('users.index', ['status' => Status::ACTIVE]),
            'projects_route' => route('projects.index'),
            'active_projects_route' => route('projects.index', ['active' => Status::ACTIVE]),
            'unactive_projects_route' => route('projects.index', ['active' => Status::UNACTIVE]),
            'projects_done_route' => route('projects.index', ['status' => [ProjectStatus::FOUR_DONE]]),
            'projects_in_created_case_route' => route('projects.index', ['status' => [ProjectStatus::CREATED]]),
            'projects_in_cas1_route' => route('projects.index', ['status' => [ProjectStatus::ONE_DONE, ProjectStatus::ONE_INPROGRESS]]),
            'projects_in_cas2_route' => route('projects.index', ['status' => [ProjectStatus::TWO_DONE, ProjectStatus::TWO_INPROGRESS]]),
            'projects_in_cas3_route' => route('projects.index', ['status' => [ProjectStatus::THREE_DONE, ProjectStatus::THREE_INPROGRESS]]),
            'projects_in_cas4_route' => route('projects.index', ['status' => [ProjectStatus::FOUR_INPROGRESS]]),
            'projects_in_department2_route' => route('projects.index', ['role' => config('settings.roles.names.department2Role')]),
            'projects_in_department3_route' => route('projects.index', ['role' => config('settings.roles.names.department3Role')]),
            'projects_in_department4_route' => route('projects.index', ['role' => config('settings.roles.names.department4Role')]),
            'number_of_project_positions_route' => route('projects.index',['column' => 'project_position']),
            'number_of_assignment_book_route' => route('projects.index',['column' => 'assignment_book_number']),
            'number_of_assignment_book_date_route' => route('projects.index',['column' => 'assignment_book_date']),
            'number_of_assignment_book_submited_date_route' => route('projects.index',['column' => 'assignment_book_submition_day']),
            'number_of_contracts_route' => route('projects.index',['column' => 'contract_book_number']),
            'number_of_signings_recieved_route' => route('projects.index',['column' => 'signature_date']),
            'number_of_work_started_route' => route('projects.index',['column' => 'work_starting_date']),
        ];

        $data['active_users'] = number_format(User::whereStatus(Status::ACTIVE)->count());
        $data['projects'] = $projects->count();
        $data['active_projects'] = $projects->where('active',Status::ACTIVE)->count();
        $data['unactive_projects'] = $projects->where('active',Status::UNACTIVE)->count();
        $data['projects_done'] = $projects->where('status',ProjectStatus::FOUR_DONE)->count();
        $data['projects_in_created_case'] = $projects->where('status',[ProjectStatus::CREATED])->count();
        $data['projects_in_cas1'] = $projects->whereIn('status',[ProjectStatus::ONE_DONE, ProjectStatus::ONE_INPROGRESS])->count();
        $data['projects_in_cas2'] = $projects->whereIn('status',[ProjectStatus::TWO_DONE, ProjectStatus::TWO_INPROGRESS])->count();
        $data['projects_in_cas3'] = $projects->whereIn('status',[ProjectStatus::THREE_DONE, ProjectStatus::THREE_INPROGRESS])->count();
        $data['projects_in_cas4'] = $projects->whereIn('status',[ProjectStatus::FOUR_INPROGRESS])->count();
        $data['projects_in_department2'] = $projects->whereIn('status',[ProjectStatus::ONE_DONE,ProjectStatus::TWO_INPROGRESS])->whereIn('chosen_department_id', $department2_users_ids)->count();
        $data['projects_in_department3'] = $projects->whereIn('status',[ProjectStatus::ONE_DONE,ProjectStatus::TWO_INPROGRESS])->whereIn('chosen_department_id', $department3_users_ids)->count();
        $data['projects_in_department4'] = $projects->whereIn('status',[ProjectStatus::ONE_DONE,ProjectStatus::TWO_INPROGRESS])->whereIn('chosen_department_id', $department4_users_ids)->count();
        $data['number_of_project_positions'] = $projects->whereNotNull('project_position')->count();
        $data['number_of_assignment_book'] = $projects->whereNotNull('assignment_book_number')->count();
        $data['number_of_assignment_book_date'] = $projects->whereNotNull('assignment_book_date')->count();
        $data['number_of_assignment_book_submited_date'] = $projects->whereNotNull('assignment_book_submition_day')->count();
        $data['number_of_contracts'] = $projects->whereNotNull('contract_book_number')->count();
        $data['number_of_signings_recieved'] = $projects->whereNotNull('signature_date')->count();
        $data['number_of_work_started'] = $projects->whereNotNull('work_starting_date')->count();


        return view('backend::sections.dashboard.index', $data);
    }

    public function changeLocale($lang)
    {
        try{
            session()->put('locale', $lang);
            return redirect()->back();
        }catch(\Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}
