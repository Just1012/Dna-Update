<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ShippingNote;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class ShippingNoteController extends Controller
{
    public function index()
    {
        return view('Dashboard.Shipping.shippingNoteList');
    }

    public function getShippingNote()
    {
        $data = ShippingNote::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function addShippingNote()
    {
        return view('Dashboard.Shipping.shippingNoteAdd');
    }

    public function storeShippingNote(Request $request)
    {
        try {
            $requestData = $request->all();

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);
                $requestData['image'] = $imageName;
            }

            // Set the default status to 0
            $requestData['status'] = 0;

            ShippingNote::create($requestData);

            toastr()->success(__('ShippingNote Added Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Try Again'), __('Error'));
            return redirect()->route('shippingNote.index');
        }
    }


    public function editShippingNote(ShippingNote $id)
    {
        return view('Dashboard.Shipping.shippingNoteEdit', compact('id'));
    }

    public function updateShippingNote(Request $request, $id)
    {
        try {
            $shipping_note = ShippingNote::findOrFail($id);
            $requestData = $request->all();

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);

                // Delete old image if it exists
                if ($shipping_note->image && file_exists(public_path('images/' . $shipping_note->image))) {
                    unlink(public_path('images/' . $shipping_note->image));
                }
                $requestData['image'] = $imageName;
            }

            $shipping_note->update($requestData);
            toastr()->success(__('Shipping Note Updated Successfully'), __('Success'));
            return redirect()->route('shippingNote.index');
        } catch (\Throwable $th) {
            toastr()->error(__('Try Again'), __('Error'));
            return redirect()->route('shippingNote.index');
        }
    }

    public function updateStatus(ShippingNote $shippingNote)
    {
        try {
            $shippingNote->update([
                'status' => $shippingNote->status == 0 ? 1 : 0
            ]);

            $successMessage = $shippingNote->status == 1 ?
                'تم التفعيل  بنجاح' :
                'تم إلغاء التفعيل  بنجاح';

            return $successMessage;
        } catch (\Throwable $th) {
            return response()->json(['status' => '404']);
        }
    }

    public function deleteShippingNote($id)
    {
        try {
            $slider = ShippingNote::findOrFail($id);
            $slider->delete();

            toastr()->success(__('Shipping Note Deleted Successfully'), __('Success'));
            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            toastr()->error(__('Shipping Note Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }
}
