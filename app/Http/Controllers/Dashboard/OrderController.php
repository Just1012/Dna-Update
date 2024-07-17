<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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

}
