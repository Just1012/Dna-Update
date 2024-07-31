<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Models\Item;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ItemController extends Controller
{
    public function index()
    {
        $category = Category::where('num_of_parents', 1)->get();
        $subCategory = Category::where('num_of_parents', 2)->get();
        $subSubCategory = Category::where('num_of_parents', 3)->get();
        return view('Dashboard.Items.index', compact('category', 'subCategory', 'subSubCategory'));
    }

    public function getItems()
    {
        $data = Item::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function addItem()
    {
        $category = Category::where('parent_id', 0)->get();
        return view('Dashboard.Items.addItem', compact('category'));
    }

    public function getSubCategory($id)
    {
        $data = Category::where('parent_id', $id)->get();
        return response()->json($data);
    }

    public function getSubSubCategory($id)
    {
        $data = Category::where('parent_id', $id)->get();
        return response()->json($data);
    }

    public function storeItem(ItemRequest $itemRequest)
    {
        try {

            $requestData = $itemRequest->all();
            if ($itemRequest->hasFile('image')) {
                $imageName = time() . '.' . $itemRequest->image->getClientOriginalExtension();
                $itemRequest->image->move(public_path('images'), $imageName);
                $requestData['image'] = $imageName;
            }
            Item::create($requestData);

            Toastr::success(__('Item Created Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->route('item.index');
        }
    }

    public function editItem(Item $id)
    {
        $category = Category::where('parent_id', 0)->get();
        return view('Dashboard.Items.editItem', compact('id', 'category'));
    }

    public function updateItem(ItemUpdateRequest $itemRequest, $id)
    {
        try {

            $item = Item::findOrFail($id);
            $requestData = $itemRequest->all();

            if ($itemRequest->hasFile('image')) {
                $imageName = time() . '.' . $itemRequest->image->getClientOriginalExtension();
                $itemRequest->image->move(public_path('images'), $imageName);

                // Delete old image if it exists
                if ($item->image && file_exists(public_path('images/' . $item->image))) {
                    unlink(public_path('images/' . $item->image));
                }
                $requestData['image'] = $imageName;
            }

            $item->update($requestData);

            Toastr::success(__('Item Updated Successfully'), __('Success'));

            return redirect()->route('item.index');
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->route('item.index');
        }
    }


    public function archiveItem(Item $id)
    {
        try {
            $id->delete(); // Soft delete the Item

            Toastr::success(__('Item Archived Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Item Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    public function archiveItemList()
    {
        return view('Dashboard.Items.archiveItemList');
    }
    public function getArchivedItem()
    {
        $data = Item::onlyTrashed()->get();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function restoreItem($id)
    {
        try {
            Item::withTrashed()
                ->where('id', $id)
                ->restore();
            Toastr::success(__('Item Restored Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Item Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    public function filter(Request $request)
    {
        $category = $request->input('category');
        $subCategory = $request->input('subCategory');
        $subSubCategory = $request->input('subSubCategory');

        $query = Item::query();

        if ($category !== null && $category !== '') {
            $query->orWhere('category_id', $category);
        }
        if ($subCategory !== null && $subCategory !== '') {
            $query->orWhere('subCategory_id', $subCategory);
        }
        if ($subSubCategory !== null && $subSubCategory !== '') {
            $query->orWhere('subSubCategory_id', $subSubCategory);
        }

        $filteredItems = $query->get();

        return response()->json([
            'data' => $filteredItems,
            'message' => 'found data'
        ]);
    }

}
