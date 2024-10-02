<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Order;
use App\Models\orderDayes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        return view('Dashboard.Order.order');
    }

    public function getOrder()
    {
        $data = Order::with('User')->get();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function orderDetails($id)
    {
        $order = Order::with(['User','OrderDays.Address','Program'])->where('id',$id)->first();
        return view('Dashboard.Order.orderDetails',compact('order'));
    }

    public function edit($id)
    {
        $order = Order::with(['User','OrderDays.Address','Program'])->where('id',$id)->first();
        return view('Dashboard.Order.orderUpdate',compact('order'));
    }


    public function update(Request $request,$id)
    {
        $request->validate([
            "comment"=>"required|string"
        ]);
        User::where("id",$id)->update($request->only("name","phone"));
        Order::where(["id"=>$request->order_id,"user_id"=>$id])->update([
            "end_date"=>$request->end_date,
            "comment"=>$request->comment
        ]);

        orderDayes::where("order_id",$request->order_id)->update([
            'Monday'    => $request->input('Monday')??0,
            'Tuesday'   => $request->input('Tuesday')??0,
            'Wednesday' => $request->input('Wednesday')??0,
            'Thursday'  => $request->input('Thursday')??0,
            'Friday'    => $request->input('Friday')??0,
            'Saturday'  => $request->input('Saturday')??0,
            'Sunday'    => $request->input('Sunday')??0,
        ]);

        return view('Dashboard.Order.order');


    }

}
