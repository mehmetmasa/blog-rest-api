<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseHelper;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /*
     *
     * Show All Category
     *
     */
    public function showAllCategory()
    {
        $categories = Category::where('situation', '!=', CATEGORY_DELETE)->get();
        if ($categories->isEmpty())
        {
            return ResponseHelper::response(false,'Category not found');
        }
        return ResponseHelper::response(true,'All Categories', $categories);
    }

    /*
     *
     *  Show One Category
     *
     */

    public function showOneCategory($id)
    {
        $category = Category::where('id', $id)->where('situation', '!=', CATEGORY_DELETE)->get();

        if ($category->isEmpty())
        {
            return ResponseHelper::response(false,'Category not found');
        }

        return ResponseHelper::response(true,'Category Detail', $category);
    }

    /*
     *
     *  Create Category
     *
     */

    public function create(Request $request)
    {

        $this->validate($request,[
            'name' => 'required|max:50',
            'order' => 'required',
            'situation' => 'required',
        ]);

        $createCategory = new Category();
        $createCategory->name = $request->name;
        $createCategory->order = $request->order;
        $createCategory->situation = $request->situation;
        $createCategory->save();

        if (!$createCategory)
        {
            return ResponseHelper::response(false,'System error! Failed to create category');
        }

        return ResponseHelper::response(true,'Category Added', $createCategory);

    }

    /*
     *
     *  Category Update
     *
     */

    public function update(Request $request, $id)
    {
        $category = Category::where('id', $id)->where('situation', '!=', CATEGORY_DELETE)->get();

        if ($category->isEmpty())
        {
            return ResponseHelper::response(false,'Category not found');
        }

        $this->validate($request,[
            'name' => 'required|max:50',
            'order' => 'required',
            'situation' => 'required'
        ]);


        $categoryUpdate = Category::where('id', $id)
            ->update(
                [
                    'name' => $request->name,
                    'order' =>$request->order,
                    'situation' => $request->situation,
                ]
            );


        if (!$categoryUpdate)
        {
            return ResponseHelper::response(false,'System error! Failed to update category.');
        }

        $resCategory = Category::where('id', $id)->get();

        return ResponseHelper::response(true,'Category Updated', $resCategory);
    }


    /*
     *
     *  Categoy Delete
     *
     */

    public function delete($id)
    {

        $category = Category::where('id', $id)->where('situation', '!=', CATEGORY_DELETE)->get();

        if ($category->isEmpty())
        {
            return ResponseHelper::response(false,'Category not found');
        }


        $categoryDelete = Category::where('id', $id)
            ->update(
                [
                    'situation' => CATEGORY_DELETE
                ]
            );

        if (!$categoryDelete)
        {
            return ResponseHelper::response(false,'System error! Failed to delete category');

        }

        return ResponseHelper::response(true,'Category Deleted');
    }

}
