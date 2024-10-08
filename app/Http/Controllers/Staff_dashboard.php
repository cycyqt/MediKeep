<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Supplier;

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

    public function delete_product ($id)
    {
        $deleteRecord =  Product::find($id);
        $deleteRecord->delete();
        return redirect()->back()->with('success', "Medicine CAtegory Successfully Deleted");
    }

    public function list ()
    {
        $products = Product::all();
        return view('staff.list', compact('products'));
    }

    public function order ()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('staff.order', compact('products','suppliers'));
    }

    public function add_order(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'staff_id' => 'required|string',
            'order_date' => 'required|date',
            'status' => 'required|string',
            'product_id' => 'required|array',
            'quantity' => 'required|array',
            'unit_price' => 'required|array',
            'total_price' => 'required|array',
        ]);
    
        // Debugging: Log the validated data
        \Log::info('Validated Data:', $validatedData);
    
        // Create the order
        $order = new Order;
        $order->supplier_id = $validatedData['supplier_id'];
        $order->staff_id = $validatedData['staff_id'];
        $order->order_date = $validatedData['order_date'];
        $order->status = $validatedData['status'];
        $order->total_amount = array_sum($validatedData['total_price']); // Calculate total amount
    
        // Save the order
        $orderSaved = $order->save();
        
        // Check if order saved successfully
        if (!$orderSaved) {
            return redirect()->back()->with('error', "Failed to save the order.");
        }
    
        // Save the order items
        foreach ($validatedData['product_id'] as $index => $productId) {
            $orderItem = new Order_item;
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $productId;
            $orderItem->quantity = $validatedData['quantity'][$index];
            $orderItem->unit_price = $validatedData['unit_price'][$index];
            $orderItem->total_amount = $validatedData['total_price'][$index];
    
            $orderItem->save();
        }
    
        return redirect()->back()->with('success', "Order successfully submitted.");
    }
    

    public function supplier ()
    {
        
        return view('staff.supplier');
    }

    public function add_supplier (Request $request)
    {
        $insertRecord = new Supplier;
        $insertRecord->name = trim($request->name);
        $insertRecord->contact_info = trim($request->contact_info);
        $insertRecord->address = trim($request->address);

        $insertRecord->save();

        return redirect()->back()->with('success', "Supplier Successfully Added");
    }

    


}
