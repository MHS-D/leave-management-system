<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\DataTables\Controllers\UsersDataTable;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class UsersController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        $data['roles'] = Role::all();
        $data['wallets'] = [];
        $data['permissions'] = Permission::all();
        $data['countries'] =[];

        return $dataTable->render('backend::sections.users.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create(collect($request->validated())->except(['role'])->toArray());

            $user->assignRole($request->role);

            DB::commit();

            return [
                'success' => true,
                'message' => __('strings.USER_CREATED_SUCCESSFULLY')
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->direct_permissions = $user->getDirectPermissions();
        $user->all_permissions = $user->getAllPermissions();

        return [
            'success' => true,
            'data' => $user
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        DB::beginTransaction();

        try {
            $user->update(collect($request->validated())->except(['role', 'password', 'permissions_by_role', 'permissions'])->toArray());

            if ($request->password)
                $user->update(['password' => Hash::make($request->password)]);

            $user->syncRoles($request->role);

            DB::commit();

            return [
                'success' => true,
                'message' => __('strings.USER_UPDATED_SUCCESSFULLY')
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return [
            'success' => true,
            'message' => __('strings.USER_DELETED_SUCCESSFULLY')
        ];
    }

    /**
     * Get users statists
     *
     * @return array
     */
    public function getStatistics(): array
    {
        $statistics = [
            [
                'label' =>  __('strings.USERS_TOTAL'),
                'value' => User::count(),
                'color' => 'light-primary',
                'icon' => 'fa-solid fa-user',
            ],
            [
                'label' => __('strings.ACTIVE_USERS'),
                'value' => User::whereStatus(Status::ACTIVE)->count(),
                'color' => 'light-success',
                'icon' => 'fa-solid fa-user-check',
            ],
            [
                'label' =>  __('strings.UNACTIVE_USERS'),
                'value' => User::whereStatus(Status::UNACTIVE)->count(),
                'color' => 'light-warning',
                'icon' => 'fa-solid fa-user-clock',
            ],
            // [
            //     'label' => __('strings.'),
            //     'value' => 0,
            //     'color' => 'light-info',
            //     'icon' => 'fa-solid fa-user-clock',
            // ],
        ];

        return [
            'success' => true,
            'data' => [
                'html' => view('backend::sections.users.includes.statistics', compact('statistics'))->render(),
                'json' => $statistics
            ]
        ];
    }

    /**
     * Export users as Excel file
     *
     * @param Request $request
     * @return Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel(Request $request): BinaryFileResponse
    {
        return Excel::download(new UsersExport($request->ids ?? []), 'users.xlsx');
    }

    /**
     * Export users as CSV file
     *
     * @param Request $request
     * @return Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportCsv(Request $request): BinaryFileResponse
    {
        return Excel::download(new UsersExport($request->ids ?? []), 'users.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export users as PDF file
     *
     * @param Request $request
     * @return Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportPdf(Request $request)
    {
        $data['users'] = User::with(['roles'])->whereIn('id', $request->ids ?? [])->latest()->get();

        $pdf = Pdf::loadView('backend::sections.users.export.pdf', $data);

        return $pdf->download('invoice.pdf');
    }

}
