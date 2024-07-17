<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\App;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index($id = 0)
    {
        $lang = App::getLocale();
        $parentCategory = null;
        $num = Category::where('id', $id)->select('num_of_parents')->first();
        if ($num && $num->num_of_parents >= 3) {
            return redirect()->back();
        }

        if ($id == 0) {
            $name = 'Categories List';
        } else {
            $parentCategory = Category::where('id', $id)->first();

            if ($parentCategory) {
                $titleProperty = 'title_' . $lang;
                $name = $parentCategory->$titleProperty . ' Categories List';
            } else {
                $name = 'Categories List';
            }
        }

        return view('Dashboard.Category.index', [
            'id' => $id,
            'name' => $name,
            'parent_id' => $parentCategory ? $parentCategory->parent_id : null,
            'num_of_parents' => $num->num_of_parents ?? 0
        ]);
    }

    public function getData($id = 0)
    {
        $data = Category::where('parent_id', '=', $id)->get();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function addCategory($id = 0)
    {
        return view('Dashboard.Category.addCategory', ['id' => $id]);
    }

    public function storeCategory(CategoryRequest $categoryRequest, $id = 0)
    {
        try {

            $num = 1;
            $parent = Category::find($id);
            if ($parent) {
                $num = $parent->num_of_parents + 1;
            }

            if ($num >= 4) {
                Toastr::error(__('You Can not add a new Sub Category'), __('Error'));
                return redirect()->route('category.index', $id);
            }

            $requestData = $categoryRequest->all();
            $requestData['parent_id'] = $id;
            $requestData['num_of_parents'] = $num;
            if ($categoryRequest->hasFile('image')) {
                $imageName = time() . '.' . $categoryRequest->image->getClientOriginalExtension();
                $categoryRequest->image->move(public_path('images'), $imageName);
                $requestData['image'] = $imageName;
            }

            Category::create($requestData);


            Toastr::success(__('Category Created Successfully'), __('Success'));

            return redirect()->route('category.index', $id);
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function editCategory(Category $id)
    {
        return view('Dashboard.Category.editCategory', compact('id'));
    }

    public function updateCategory(CategoryRequest $categoryRequest, $id)
    {
        try {

            $category = Category::findOrFail($id);
            $requestData = $categoryRequest->all();

            if ($categoryRequest->hasFile('image')) {
                $imageName = time() . '.' . $categoryRequest->image->getClientOriginalExtension();
                $categoryRequest->image->move(public_path('images'), $imageName);

                // Delete old image if it exists
                if ($category->image && file_exists(public_path('images/' . $category->image))) {
                    unlink(public_path('images/' . $category->image));
                }
                $requestData['image'] = $imageName;
            }

            $category->update($requestData);

            Toastr::success(__('Category Updated Successfully'), __('Success'));
            return redirect()->route('category.index', $category->parent_id);
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }


    public function archiveCategory(Category $id)
    {
        try {
            $id->delete(); // Soft delete the Category

            Toastr::success(__('Category Archived Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Category Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    public function archiveCategoryList()
    {
        return view('Dashboard.Category.archiveCategoryList');
    }
    public function getArchivedCategory()
    {
        $data = Category::onlyTrashed()->get();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function restoreCategory($id)
    {
        try {
            Category::withTrashed()
                ->where('id', $id)
                ->restore();
            Toastr::success(__('Category Restored Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Category Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }
}
