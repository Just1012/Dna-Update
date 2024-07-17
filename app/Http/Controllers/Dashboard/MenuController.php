<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MenuController extends Controller
{
    public function index()
    {
        return view('Dashboard.Menu.index');
    }

    public function getMenu()
    {
        $data = Menu::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function addMenu()
    {
        return view('Dashboard.Menu.addMenu');
    }

    public function storeMenu(MenuRequest $menuRequest)
    {
        try {

            $requestData = $menuRequest->all();
            if ($menuRequest->hasFile('image')) {
                $imageName = time() . '.' . $menuRequest->image->getClientOriginalExtension();
                $menuRequest->image->move(public_path('images'), $imageName);
                $requestData['image'] = $imageName;
            }
            Menu::create($requestData);

            Toastr::success(__('Menu Created Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->route('menu.index');
        }
    }

    public function editMenu(Menu $id)
    {

        return view('Dashboard.Menu.editMenu', compact('id'));
    }

    public function updateMenu(MenuRequest $menuRequest, $id)
    {
        try {

            $menu = Menu::findOrFail($id);
            $requestData = $menuRequest->all();

            if ($menuRequest->hasFile('image')) {
                $imageName = time() . '.' . $menuRequest->image->getClientOriginalExtension();
                $menuRequest->image->move(public_path('images'), $imageName);

                // Delete old image if it exists
                if ($menu->image && file_exists(public_path('images/' . $menu->image))) {
                    unlink(public_path('images/' . $menu->image));
                }
                $requestData['image'] = $imageName;
            }

            $menu->update($requestData);

            Toastr::success(__('Menu Updated Successfully'), __('Success'));

            return redirect()->route('menu.index');
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->route('menu.index');
        }
    }


    public function archiveMenu(Menu $id)
    {
        try {
            $id->delete(); // Soft delete the Menu

            Toastr::success(__('Menu Archived Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Menu Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    public function archiveMenuList()
    {
        return view('Dashboard.Menu.archiveMenuList');
    }
    public function getArchivedMenu()
    {
        $data = Menu::onlyTrashed()->get();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function restoreMenu($id)
    {
        try {
            Menu::withTrashed()
                ->where('id', $id)
                ->restore();
            Toastr::success(__('Menu Restored Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Menu Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

}
