<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;
use Validator;

class CategoriesController extends Controller
{

    public function getCategories()
    {
        $Categories = Categories::all();
        return view('mobAdmin.categories.showCategories', compact('Categories'));
    }

    public function insertCategories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categories_name' => 'required ',
        ]);
        if ($validator->fails())
            return redirect()->back()->WithErrors($validator->errors()->all())->withInput();
        else {

            $Categories = new Categories();
            $Categories->categories_name = $request->categories_name;
            $Categories->save();
            return redirect('/dashboard/categories');
        }
    }

    public function updateCategories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categories_name' => 'required ',
        ]);
        if ($validator->fails())
            return redirect()->back()->WithErrors($validator->errors()->all())->withInput();
        else {
            $Categories = Categories::find($request->categories_id_edit);
            $Categories->categories_name = $request->categories_name;
            $Categories->save();
            return redirect('/dashboard/categories');
        }
    }

    public function updateCategoriesPage($id)
    {
        $Categories = Categories::find($id);
        return view('mobAdmin.categories.updateCategories', compact('Categories'));
    }

    public function deleteCategories($id)
    {
        $Categories = Categories::find($id);
        $Categories->delete();
        return redirect()->back();
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $searchResults = Categories::where('categories_name', 'like', '%' . $search . '%')
            ->get();
        $Categories = Categories::all();
        return view('mobAdmin.categories.showCategories', compact('searchResults', 'Categories'));
    }


}
