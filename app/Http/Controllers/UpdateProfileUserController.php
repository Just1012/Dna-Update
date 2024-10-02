<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\orderDayes;
use App\Trait\UpdateProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UpdateProfileUserController extends Controller
{
    use UpdateProfile;
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


        if(isset($request->suspension)){

        return     UpdateProfile::updateSuspensionDate($request,$id);

        }else{

        return     UpdateProfile::editEndDate( $request,$id);
        }






    }
}
