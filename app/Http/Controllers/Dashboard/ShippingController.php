<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class ShippingController extends Controller
{
    public function index()
    {
        return view('Dashboard.Shipping.governorate');
    }


    public function getGovernorates()
    {
        $data = DB::table('governorates')->get();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function area($id)
    {
        return view('Dashboard.Shipping.area', compact('id'));
    }

    public function storeArea(Request $request)
    {
        try {
            $request->validate([
                'area_ar' => 'required|string|max:255',
                'area_en' => 'required|string|max:255',
                'governorate_id' => 'required|exists:governorates,id'
            ]);

            DB::table('areas')->insert([
                'area_ar' => $request->area_ar,
                'area_en' => $request->area_en,
                'governorate_id' => $request->governorate_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            toastr()->success('Area added successfully.', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error('An error occurred. Please try again.', 'Error');
            return redirect()->back()->withErrors(['error' => $th->getMessage()])->withInput();
        }
    }
    public function storeGovernorate(Request $request)
    {
        try {
            $request->validate([
                'title_ar' => 'required|string|max:255',
                'title_en' => 'required|string|max:255',
            ]);

            DB::table('governorates')->insert([
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            toastr()->success('Governorate added successfully.', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error('An error occurred. Please try again.', 'Error');
            return redirect()->back()->withErrors(['error' => $th->getMessage()])->withInput();
        }
    }

    public function getArea($id)
    {

        $data = DB::table('areas')->where('governorate_id', $id)->get();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function updateStatus($governorateId)
    {
        try {
            $governorate = DB::table('governorates')->where('id', $governorateId)->first();

            if (!$governorate) {
                return response()->json(['status' => '404', 'message' => 'Governorate not found']);
            }

            $newStatus = $governorate->status == 0 ? 1 : 0;
            DB::table('governorates')->where('id', $governorateId)->update(['status' => $newStatus]);

            $successMessage = $newStatus == 1 ? 'تم تفعيل المنطقة بنجاح' : 'تم إلغاء تفعيل المنطقة بنجاح';

            return response()->json(['status' => '200', 'message' => $successMessage]);
        } catch (\Throwable $th) {
            return response()->json(['status' => '500', 'message' => 'An error occurred']);
        }
    }
    public function updateAreaStatus($areaId)
    {
        try {
            $area = DB::table('areas')->where('id', $areaId)->first();

            if (!$area) {
                return response()->json(['status' => '404', 'message' => 'Area not found']);
            }

            $newStatus = $area->status == 0 ? 1 : 0;
            DB::table('areas')->where('id', $areaId)->update(['status' => $newStatus]);

            $successMessage = $newStatus == 1 ? 'تم تفعيل المنطقة بنجاح' : 'تم إلغاء تفعيل المنطقة بنجاح';

            return response()->json(['status' => '200', 'message' => $successMessage]);
        } catch (\Throwable $th) {
            return response()->json(['status' => '500', 'message' => 'An error occurred']);
        }
    }

    public function ShippingTime()
    {
        $governorates = DB::table('governorates')->where('status', 1)->get();
        return view('Dashboard.Shipping.shippingTime', compact('governorates'));
    }

    public function getSubTypes($id)
    {
        $data = DB::table('areas')
            ->where('status', 1)
            ->where('governorate_id', $id)
            ->select('id', 'area_ar', 'area_en')
            ->get();

        return response()->json($data);
    }

    public function timeDataTable()
    {
        $data = DB::table('shippings')
            ->join('governorates', 'shippings.governorate_id', '=', 'governorates.id')
            ->join('areas', 'shippings.area_id', '=', 'areas.id')
            ->select(
                'shippings.*',
                'governorates.title_en as governorate_name_en',
                'governorates.title_ar as governorate_name_ar',
                'areas.area_en as area_name_en',
                'areas.area_ar as area_name_ar'
            )
            ->get();

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function updateTimeStatus($timeId)
    {
        try {
            $time = DB::table('shippings')->where('id', $timeId)->first();

            if (!$time) {
                return response()->json(['status' => '404', 'message' => 'Time not found']);
            }

            $newStatus = $time->status == 0 ? 1 : 0;
            DB::table('shippings')->where('id', $timeId)->update(['status' => $newStatus]);

            $successMessage = $newStatus == 1 ? 'تم تفعيل المنطقة بنجاح' : 'تم إلغاء تفعيل المنطقة بنجاح';

            return response()->json(['status' => '200', 'message' => $successMessage]);
        } catch (\Throwable $th) {
            return response()->json(['status' => '500', 'message' => 'An error occurred']);
        }
    }

    public function storeShippingTime(Request $request)
    {
        try {
            $request->validate([
                'governorates' => 'required|exists:governorates,id',
                'areas' => 'required|exists:areas,id',
                'shipping_time' => 'required|string|max:255',
            ]);

            DB::table('shippings')->insert([
                'governorate_id' => $request->governorates,
                'area_id' => $request->areas,
                'shipping_time' => $request->shipping_time,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            toastr()->success('Time added successfully.', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error('An error occurred. Please try again.', 'Error');
            return redirect()->back()->withErrors(['error' => $th->getMessage()])->withInput();
        }
    }
}
