<?php

namespace App\Http\Controllers;

use App\Constants\LeaveRequestStatus;
use App\Constants\Status;
use App\DataTables\Controllers\LeaveRequestDatatable;
use App\Models\LeaveRequest;
use App\Http\Requests\LeaveRequest\StoreLeaveRequest;
use App\Http\Requests\LeaveRequest\UpdateLeaveRequest;
use App\Http\Requests\LeaveRequest\UpdateLeaveStatusRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LeaveRequestDatatable $dataTable)
    {

        $this->authorize('viewAny', LeaveRequest::class);

        $data['statuses'] = LeaveRequestStatus::ALL;

        return $dataTable->render('backend::sections.leave-requests.index', $data);
    }

    /**
     * Display the specified resource form page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', LeaveRequest::class);

        return view('backend::sections.leave-requests.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLeaveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLeaveRequest $request)
    {

        try {
            $this->authorize('create', LeaveRequest::class);

            $data = collect($request->validated())->toArray();
            $data['user_id'] = auth()->user()->id;
            $data['status'] = LeaveRequestStatus::REQUESTED;

            LeaveRequest::create($data);

            return [
                'success' => true,
                'message' => __('strings.LEAVE_REQUEST_CREATED_SUCCESSFULLY'),
                'redirect_url' => route('leave-requests.index')
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Display the specified resource form page with data.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveRequest $leave_request)
    {
        $this->authorize('edit', $leave_request);

        abort_if($leave_request->status != LeaveRequestStatus::REQUESTED, 403, __('strings.ACTION_FORBIDDEN'));

        $data['leave_request'] = $leave_request;

        return view('backend::sections.leave-requests.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLeaveRequest  $request
     * @param  \App\Models\LeaveRequest $leave_request
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLeaveRequest $request, LeaveRequest $leave_request)
    {
        DB::beginTransaction();

        abort_if($leave_request->status != LeaveRequestStatus::REQUESTED, 403, __('strings.ACTION_FORBIDDEN'));

        try {
            $data = collect($request->validated())->toArray();

            $leave_request->update($data);

            DB::commit();

            return [
                'success' => true,
                'message' => __('strings.LEAVE_REQUEST_UPDATED_SUCCESSFULLY'),
                'redirect_url' => route('leave-requests.index')
            ];
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeaveRequest $leave_request
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeaveRequest $leave_request)
    {
        $this->authorize('delete', LeaveRequest::class);

        $leave_request->delete();

        return [
            'success' => true,
            'message' => __('strings.LEAVE_REQUEST_DELETED_SUCCESSFULLY'),
        ];
    }


    public function getRequestInfo(LeaveRequest $leave_request)
    {
        $this->authorize(('getRequestInfo'), LeaveRequest::class);

        $data['leave_request'] = $leave_request->toArray();
        $data['status'] = LeaveRequestStatus::ALL;
        $data['latest_updated_at'] = $leave_request->updated_at->format('F j, Y h:i A');

        return response()->json($data);
    }

    public function updateStatus(UpdateLeaveStatusRequest $request)
    {

        try{
            $validated = $request->validated();

            $leave_request = LeaveRequest::find($validated['request_id']);
            $leave_request->update([
                'status' => $validated['status'],
                'note' => $validated['note'] ?? null,
            ]);

            return [
                'success' => true,
                'message' => __('strings.LEAVE_REQUEST_UPDATED_SUCCESSFULLY'),
            ];

        }catch(Exception $e){
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

}
