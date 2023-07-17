<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\UpdateSettingRequest;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['settings'] = Setting::all()->pluck('value', 'key');

        return view('backend::sections.settings.general.index', $data);
    }

    /**
     * Update the settings data.
     *
     * @param UpdateSettingRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSettingRequest $request)
    {
        DB::beginTransaction();

        try {
            foreach ($request->all() as $key => $value) {
                // ! Only update, do not create if not exist, keys must be initialized using a seeder
                Setting::query()
                    ->where('key', $key)
                    ->update(['value' => $value]);
            }

            DB::commit();

            return [
                'success' => true,
                'message' => __('strings.SETTINGS_UPDATED_SUCCESSFULLY')
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
