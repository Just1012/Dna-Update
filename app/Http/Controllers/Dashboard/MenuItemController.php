<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuItemRequest;
use App\Models\Category;
use App\Models\Item;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MenuItemController extends Controller
{
    public function index(Menu $menu){

        $category = Category::where('num_of_parents', 1)->get();
        return view('Dashboard.Menu.items',compact('menu','category'));
    }

    public function getItem($id)
    {

        $data = Item::where('category_id', $id)->get();
        return response()->json($data);
    }

      public function getMenuItems($id)
    {
        // $data = Item::whereHas('menuItem', function ($query) use ($id) {
        //     $query->where('menu_id', $id);
        // })->with('menuItem')->get();
        $data=MenuItem::where('menu_id',$id)->with('Item1')->get();

        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function storeItem(MenuItemRequest $menuItemRequest)
    {
        try {
            $requestData = $menuItemRequest->except('category_id');
            MenuItem::create($requestData);

            Toastr::success(__('Item Created Successfully'), __('Success'));

            return redirect()->back();

        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function archiveItem(MenuItem $id)
    {
        try {
            $id->delete(); // Soft delete the Menu

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

    public function archiveMenuItemList($id){
        $menu = Menu::where('id',$id)->get();
        return view('Dashboard.Menu.archiveMenuItemList',compact('id','menu'));
    }

    public function archivedList($id)
    {
        $data=MenuItem::onlyTrashed()->where('menu_id',$id)->with('Item1')->get();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function restoreMenuItem($id)
    {
        try {
            MenuItem::withTrashed()
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





}
