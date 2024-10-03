<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;

class Staff_dashboard extends Controller
{
    public function home ()
    {
        return view('staff.home');
    }
    public function add ()
    
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('staff.add',compact('categories', 'subcategories'));
    }

    public function add_category (Request $request)
    {
        $insertRecord = new Category;
        $insertRecord->name = trim($request->name);
        $insertRecord->save();

        session(['activeTab' => 'category']);
        return redirect()->back()->with('success', "Medicine Category Successfully Add");
    }

    public function update_category(Request $request)
    {
        $category = Category::find($request->id); 
        $category->name = $request->name;         
        $category->save();  
        
        session(['activeTab' => 'category']);
        return redirect()->back()->with('success', "Name Successfully Updated");
    }

    public function delete_category ($id)
    {
        $deleteRecord =  Category::find($id);
        $deleteRecord->delete();
        return redirect()->back()->with('success', "Medicine CAtegory Successfully Deleted");
    }

    public function add_subcategory (Request $request)
    {
        $insertRecord = new Subcategory;
        $insertRecord->name = trim($request->name);
        $insertRecord->save();

       
        return redirect()->back()->with('success', "Medicine Type Successfully Add");
    }

    public function update_subcategory(Request $request)
    {
        $category = Subcategory::find($request->id); 
        $category->name = $request->name;         
        $category->save();  
        
      
        return redirect()->back()->with('success', "Name Successfully Updated");
    }

    public function delete_subcategory ($id)
    {
        $deleteRecord =  Subcategory::find($id);
        $deleteRecord->delete();


        return redirect()->back()->with('success', "Medicine CAtegory Successfully Deleted");
    }

    public function add_product (Request $request)
    {
        $insertRecord = new Product;
        $insertRecord->name = trim($request->name);
        $insertRecord->category = trim($request->category);
        $insertRecord->subcategory = trim($request->subcategory);
        $insertRecord->description = trim($request->description);
        $insertRecord->price = trim($request->price);
        $insertRecord->manufacturer = trim($request->manufacturer);
        $insertRecord->prescription = $request->has('prescription');
        $insertRecord->measurement = trim($request->measurement);

        $insertRecord->save();

      

        return redirect()->back()->with('success', "Medicine Type Successfully Add");
    }

    public function update_product (Request $request)
    {
        $product = Product::find($request->id); 
        $product->name = trim($request->name);
        $product->category = trim($request->category);
        $product->subcategory = trim($request->subcategory);
        $product->description = trim($request->description);
        $product->price = trim($request->price);
        $product->manufacturer = trim($request->manufacturer);
        $product->prescription = $request->has('prescription');
        $product->measurement = trim($request->measurement);

        $product
        ->save();

      

        return redirect()->back()->with('success', "Medicine Type Successfully Add");
    }

    public function list ()
    {
        $products = Product::all();
        return view('staff.list', compact('products'));
    }

}
