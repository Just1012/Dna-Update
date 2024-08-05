<?php

namespace App\Http\Controllers;

use App\Models\Coupons;
use App\Models\Program;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    //

    public function index(){
        $programs=Program::all();
        return view('Dashboard.coupons.index',compact('programs'));
    }
    public function datatable(){
        $data=Coupons::get();
        if($data->count()>0){
            return response()->json([
                'data'=>$data,
                'message'=>'found data'
            ]);

        }else{
            return response()->json([
                'data'=>$data,
                'message'=>'notfound data'
            ]);

        }
    }
    public function store(Request $request){

        $dataval=$request->validate([
            'programs'=>'nullable|array',

            'start_date'=>'required|date|after:yesterday',
            'end_date'=>'required|date|after:today',
            'MINIMUM_ORDER_AMOUNT'=>'required|numeric|min:1',
            'MAXIMUM_DISCOUNT'=>'required|numeric|min:1',
            'LIMIT_PER_USER'=>'required|numeric|min:1',
            'name'=>'required|string|max:300',
          //  'Code'=>'required|string|max:300',
            'Code' => 'required|string|max:300|unique:coupons,Code,NULL,id',
            'DISCOUNT'=>'required|numeric|min:1',
            'DISCOUNT_TYPE'=>'required|min:0|max:1|boolean',


        ]);

           $data=new Coupons();
           $data->name=$dataval['name'];
           $data->code=$dataval['Code'];
           $data->discount=$dataval['DISCOUNT'];
           $data->discount_type=$dataval['DISCOUNT_TYPE'];
           $data->start_date=$dataval['start_date'];
           $data->end_date=$dataval['end_date'];
           $data->minimum_order=$dataval['MINIMUM_ORDER_AMOUNT'];
           $data->maximum_discount=$dataval['MAXIMUM_DISCOUNT'];
           $data->maximum_discount=$dataval['MAXIMUM_DISCOUNT'];
           $data->limit_per_user=$dataval['LIMIT_PER_USER'];
           $data->programs_ids = json_encode($request->programs); // Convert array to JSON string
           $data->save();
           return redirect()->back()->with('message', 'Successfully Created Coupons');
           try {
        } catch (\Throwable $th) {
             return redirect()->back()->with('error', 'Sorry please try again');
        }

    }
    public function status(Request $request)
    {
        $dataval = $request->validate([
            'id' => 'required|exists:coupons,id'
        ]);

        $data = Coupons::where('id', '=', $dataval['id'])->first();
        if ($data) {
            $data->status =!$data->status  ;
            $data->save();
            return response()->json([
                'message' => 'done update status',
                'status' => '200'
            ]);
        } else {
            return response()->json([
                'message' => 'Not Found',
                'status' => '500'
            ]);
        }
    }


    ////////update coupons

    public function update(Request $request,$id){
        try {
            $data=Coupons::where('id','=',$id)->first();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Sorry don\'t found');

        }

        $dataval=$request->validate([
            'programs'=>'nullable|array',

            'start_date'=>'required|date',
            'end_date'=>'required|date|after:yesterday',
            'MINIMUM_ORDER_AMOUNT'=>'required|numeric|min:1',
            'MAXIMUM_DISCOUNT'=>'required|numeric|min:1',
            'LIMIT_PER_USER'=>'required|numeric|min:1',
            'name'=>'required|string|max:300',
          //  'Code'=>'required|string|max:300',
            //'Code' => 'required|string|max:300|unique:coupons,Code,NULL,id,company_id,' . auth()->user()->company_id,
            'Code' => 'required|string|max:300|unique:coupons,Code,' . $data->id ,

            'DISCOUNT'=>'required|numeric|min:1',
            'DISCOUNT_TYPE'=>'required|min:0|max:1|boolean',

        ]);
        try {

           if($data){
            $data->name=$dataval['name'];
            $data->code=$dataval['Code'];
            $data->discount=$dataval['DISCOUNT'];
            $data->discount_type=$dataval['DISCOUNT_TYPE'];
            $data->start_date=$dataval['start_date'];
            $data->end_date=$dataval['end_date'];
            $data->minimum_order=$dataval['MINIMUM_ORDER_AMOUNT'];
            $data->maximum_discount=$dataval['MAXIMUM_DISCOUNT'];
            $data->maximum_discount=$dataval['MAXIMUM_DISCOUNT'];
            $data->limit_per_user=$dataval['LIMIT_PER_USER'];
            $data->programs_ids = json_encode($request->programs); // Convert array to JSON string

            $data->update();
            return redirect()->back()->with('message', 'Successfully Updated Coupons');
           }else{
            return redirect()->back()->with('error', 'Sorry don\'t allow for your company');
           }


        } catch (\Throwable $th) {
             return redirect()->back()->with('error', 'Sorry please try again');
        }

    }
}
