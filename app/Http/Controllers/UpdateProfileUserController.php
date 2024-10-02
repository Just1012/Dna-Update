<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\orderDayes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UpdateProfileUserController extends Controller
{
    public function show($id)
    {


    $order = Order::with(['User','OrderDays.Address','Program'])->where('id',$id)->first();

        return view('users.update',compact('order'));
    }


    public function update(Request $request,$id)
    {
        $request->validate([
            "comment"=>"required|string"
        ]);



    //سوف يتم تعديل الاوردر وادخال تاريخ توقيف الاوردر
        if(isset($request->suspension)){
            $now_date=now()->translatedFormat('Y-m-d');
            Order::where(["id"=>$request->order_id,"user_id"=>$id])->update([
                "suspension_date"=>$now_date,
                "comment"=>$request->comment
            ]);
            return to_route('front.index');
        }
         //سوف يتم تعديل الاوردر وادخال تاريخ توقيف الاوردر



        if(!empty($request->activeCount)){
            //لحساب عدد الايام التي لا يريد الحصول علي اوردر
            $daysOf=7-$request->activeCount;
        }else{
            $daysOf=0;
        }

                    // الحصول علي بدايه التاريخ
            $start_date = Carbon::create($request->start_date);
                    // الحصول عليه نهايه التاريخ
            $end_date = Carbon::create($request->end_date);
                    // الحصول علي الفرق بالايام بينهم
             $daysDifference = $start_date->diffInDays($end_date);

             $all_day_of= $daysOf + $daysDifference;



                //  إضافة الأيام المطلوب تريحلها مع التاريخ
                    $newDate = $start_date->addDays($all_day_of);

                // الحصول على اسم اليوم
              $dayName = $newDate->translatedFormat('l');
            if($dayName=="Friday"){
                // اضافه يوم في حاله كان اليوم هوه يوم الجمعه
                 $newDate->addDays(1);
            }

                $EndDate= $newDate->translatedFormat('Y-m-d');




            User::where("id",$id)->update($request->only("name","phone"));
            Order::where(["id"=>$request->order_id,"user_id"=>$id])->update([
                "end_date"=>DB::raw("DATE_ADD(date, INTERVAL $newDate DAY)"),
                "comment"=>$request->comment
            ]);
            // ->update(['date' => DB::raw("DATE_ADD(date, INTERVAL $daysToAdd DAY)")]);

            orderDayes::where("order_id",$request->order_id)->update([
                'Monday'    => $request->input('Monday')??0,
                'Tuesday'   => $request->input('Tuesday')??0,
                'Wednesday' => $request->input('Wednesday')??0,
                'Thursday'  => $request->input('Thursday')??0,
                'Friday'    => $request->input('Friday')??0,
                'Saturday'  => $request->input('Saturday')??0,
                'Sunday'    => $request->input('Sunday')??0,
            ]);
            return to_route('front.index');



    }
}
