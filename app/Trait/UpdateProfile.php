<?php
namespace App\Trait;

use App\Models\User;
use App\Models\Order;
use App\Models\orderDayes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

trait UpdateProfile
 {
    public static function updateSuspensionDate($request,$id)
    {

        $now_date=now()->translatedFormat('Y-m-d');
        Order::where(["id"=>$request->order_id,"user_id"=>$id])->update([
            "suspension_date"=>$now_date,
            "comment"=>$request->comment
        ]);
        return to_route('front.index');
    }



    public static function editEndDate($request,$id)
    {
                //لحساب عدد الايام التي لا يريد الحصول علي اوردر
        $daysOf=7-$request->activeCount;
                // الحصول علي بدايه التاريخ
        $start_date = Carbon::create($request->start_date);
                // الحصول عليه نهايه التاريخ
        $end_date = Carbon::create($request->end_date);
                // الحصول علي الفرق بالايام بينهم
         $daysDifference = $start_date->diffInDays($end_date);

         $all_day_of= $daysOf + $daysDifference;


if($request->start_date!==null && $request->end_date!==null ){

    User::where("id",$id)->update($request->only("name","phone"));
    Order::where(["id"=>$request->order_id,"user_id"=>$id])->update([
        "end_date"=>DB::raw("DATE_ADD(end_date, INTERVAL $all_day_of DAY)"),
        "suspension_date"=>null,
        "update_from_user"=>"1",
        "comment"=>$request->comment
    ]);

}else{
    Order::where(["id"=>$request->order_id,"user_id"=>$id])->update([
        "suspension_date"=>null,
        "comment"=>$request->comment
    ]);

}




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
