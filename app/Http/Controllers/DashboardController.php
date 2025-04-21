<?php

namespace App\Http\Controllers;

use App\Constants\LeaveRequestStatus;
use App\Constants\Status;
use App\Models\LeaveRequest;
use App\Models\User;
use Exception;
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
        $logged_in_user = auth()->user();
        $leave_requests = LeaveRequest::when(!$logged_in_user->hasRole(config('settings.roles.names.adminRole')), function ($query) use ($logged_in_user) {
            $query->where('user_id', $logged_in_user->id);
        });

        $users = User::query();

        $data['total_users'] = $users->count();
        $data['active_users'] = (clone $users)->where('status', Status::ACTIVE)->count();
        $data['inactive_users'] =(clone $users)->where('status', Status::UNACTIVE)->count();
        $data['employees_count'] =(clone $users)->whereHas('roles', function ($query) {
            $query->where('name', config('settings.roles.names.employeeRole'));
        })->count();
        $data['total_requests'] = $leave_requests->count();
        $data['approved_requests'] = (clone $leave_requests)->where('status', LeaveRequestStatus::ACCEPTED)->count();
        $data['pending_requests'] = (clone $leave_requests)->where('status', LeaveRequestStatus::REQUESTED)->count();
        $data['rejected_requests'] = (clone $leave_requests)->where('status', LeaveRequestStatus::REJECTED)->count();


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
