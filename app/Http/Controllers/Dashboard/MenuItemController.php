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

        return view('Dashboard.Menu.items',compact('menu'));
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
            $items = $menuItemRequest->input('items');

            foreach ($items as $item) {
                // Prepare the data for insertion or update
                $menuItemData = [
                    'menu_id' => $menuItemRequest->menu_id,
                    'item_id' => $item,
                ];

                // Update or create the menu item
                MenuItem::updateOrCreate(
                    ['menu_id' => $menuItemRequest->menu_id, 'item_id' => $item],
                    $menuItemData
                );
            }

            toastr()->success(__('Item Created or Updated Successfully'), __('Success'));

            return redirect()->back();

        } catch (\Throwable $th) {
            toastr()->error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }


    public function create_items_for_menu($id){
        $menu=Menu::find($id);
        $category = Category::where('num_of_parents', 1)->get();

        return view('Dashboard.Menu.addItemToMenu',compact('menu','category'));
    }

    public function archiveItem(MenuItem $id)
    {
        try {
            $id->delete(); // Soft delete the Menu

            toastr()->success(__('Item Archived Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            toastr()->error(__('Item Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Something went wrong. Please try again.'), __('Error'));
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
            toastr()->success(__('Item Restored Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            toastr()->error(__('Item Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }





}
