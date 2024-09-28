<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

class Admin_dashboard extends Controller
{
    public function home ()
    {
        return view('admin.home');
    }
    public function add ()
    
    {
        $categories = Category::all();
        return view('admin.add',compact('categories'));
    }

    public function add_category (Request $request)
    {
        $insertRecord = new Category;
        $insertRecord->name = trim($request->name);
        $insertRecord->save();
        return redirect()->back()->with('success', "Business Record Successfully Add");
    }

    public function delete_category ($id)
    {
        $deleteRecord =  Category::find($id);
        $deleteRecord->delete();
        return redirect()->back()->with('success', "Business Record Successfully Add");
    }

    public function list ()
    {
        return view('admin.list');
    }

}
