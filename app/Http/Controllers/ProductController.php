<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\Auth::user()->can('product.manage')) {
            $products = Product::latest()->paginate(10);
            return view('products.index', compact('products'));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (\Auth::user()->can('product.create')) {
            return view('products.create');
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('product.create')) {
            $user =  \Auth::user();
            $request->validate([
                'name'     => 'required|string|max:255',
                'version'     => 'required|string|max:255',
            ]);

            try {
                $Product = Product::create([
                    'name'     => $request->name,
                    'version'    => $request->version,
                    'description'    => $request->description,
                ]);
                $log_description = "Created Product ID - ". $Product->product_id;
                create_log('Create Product', $log_description, $user);
                return redirect()->route('products.index')->with('success', 'Product created successfully.');
            } catch (\Exception $e) {
                return redirect()->route('products.index')->with('error', 'Failed to create Product!');
            }
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        if (\Auth::user()->can('product.view')) {
            return view('products.show', compact('product'));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if (\Auth::user()->can('product.update')) {
            return view('products.edit', compact('product',));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if (\Auth::user()->can('product.update')) {
            $user =  \Auth::user();
            $request->validate([
                'name'     => 'required|string|max:255',
                'version'     => 'required|string|max:255',
            ]);

            try {
                $data = $request->only(['name', 'version','description']);

                $product->update($data);

                $log_description = "Updated Product ID - ". $product->product_id;
                create_log('Update Product', $log_description, $user);
                return redirect()->route('products.index')->with('success', 'Product updated successfully.');
            } catch (\Exception $e) {
                return redirect()->route('products.index')->with('error', 'Failed to update Product!');
            }
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (\Auth::user()->can('product.delete')) {
            $user =  \Auth::user();
            try {
                $product->delete();
                $log_description = "Deleted Product ID - ". $product->product_id;
                create_log('Delete Product', $log_description, $user);
                return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
            } catch (\Exception $e) {
                return redirect()->route('products.index')->with('error', 'Failed to delete Product!');
            }
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }
}
