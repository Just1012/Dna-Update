<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DaySetting;
use Illuminate\Http\Request;

class DaySettingController extends Controller
{

    public function index()
    {
        return view('Dashboard.DaySetting.index');
    }

    public function getDays()
    {
        $data = DaySetting::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function updateStatus(DaySetting $daySetting)
    {
        try {
            $daySetting->update([
                'status' => $daySetting->status == 0 ? 1 : 0
            ]);

            $successMessage = $daySetting->status == 1 ?
                'تم تفعيل اليوم بنجاح' :
                'تم إلغاء تفعيل اليوم بنجاح';

            return $successMessage;
        } catch (\Throwable $th) {
            return response()->json(['status' => '404']);
        }
    }
}
