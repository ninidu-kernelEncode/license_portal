<?php

namespace App\Http\Controllers;

use App\Models\ProductAssignment;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use App\Models\License;

class ProductAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request  $request)
    {
        if (\Auth::user()->can('product_assignment.manage')) {
            $customers = Customer::where('status', 1)->get();
            $products = Product::where('status', 1)->get();
            $assignments = Customer::whereHas('assignments')
            ->with(['assignments.product'])
                ->get();
            return view('product_assignments.index', compact('assignments','customers','products'));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (\Auth::user()->can('product_assignment.create')) {
            $customers = Customer::where('status', 1)->get();
            return view('product_assignments.create', compact('customers'));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('product_assignment.create')) {
            $user =  \Auth::user();

            if( $request['isLicenseCreate'] == 0 ){
                $request->validate([
                    'customer_id' => 'required|exists:customers,customer_id',
                    'product_id' => 'required|exists:products,product_id',
                ]);
            }else{
                $request->validate([
                    'customer_id' => 'required|exists:customers,customer_id',
                    'product_id' => 'required|exists:products,product_id',
                    'hash_algorithm' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                ]);
            }
            try {
               $product_assignment = ProductAssignment::create([
                    'customer_id' => $request->customer_id,
                    'product_id' => $request->product_id,
                    'assigned_at' => now(),
                    'status' => 1,
                ]);

               if( $request['isLicenseCreate'] == 1 ){
                   $data['customer_id'] =  $request->customer_id;
                   $data['product_id'] =  $request->product_id;
                   $data['hash_algorithm'] =  $request->hash_algorithm;
                   $data['start_date'] =  $request->start_date;
                   $data['end_date'] =  $request->end_date;
                   $license = License::createLicense($data);
                   $log_description = "license Created to assignment ID - ". $product_assignment->assignment_id;
                   create_log('Create license', $log_description, $user);
               }

                $log_description = "Product Assign ID - ". $product_assignment->assignment_id;
                create_log('Product Assign', $log_description, $user);
                return redirect()->route('product_assignments.index')->with('success', 'Product Assign Successfully.');
            } catch (\Exception $e) {
                return redirect()->route('product_assignments.index')->with('error', 'Failed to Assign Product!');
            }
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductAssignment $productAssignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (\Auth::user()->can('product_assignment.update')) {
            $assignment = ProductAssignment::with(['product', 'customer'])->findOrFail($id);
            $customer = Customer::find($assignment->customer_id);
            $product =  Product::find($assignment->product_id);
            $license = License::where('customer_id', $assignment->customer_id)
                ->where('product_id', $assignment->product_id)
                ->latest()
                ->first();
            return view('product_assignments.edit', compact('assignment','customer', 'license','product'));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductAssignment $productAssignment)
    {
        if (\Auth::user()->can('product_assignment.update')) {
            $user =  \Auth::user();
            if( $request['isLicenseCreate'] == 1 ){
                $request->validate([
                    'customer_id' => 'required|exists:customers,customer_id',
                    'product_id' => 'required|exists:products,product_id',
                    'hash_algorithm' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                ]);
            }
            try {
                if( $request['isLicenseCreate'] == 1 ){
                    $data['customer_id'] =  $request->customer_id;
                    $data['product_id'] =  $request->product_id;
                    $data['hash_algorithm'] =  $request->hash_algorithm;
                    $data['start_date'] =  $request->start_date;
                    $data['end_date'] =  $request->end_date;
                    $license = License::createLicense($data);
                    $log_description = "license Created to assignment ID - ". $productAssignment->assignment_id;
                    create_log('Create license', $log_description, $user);
                }
                return redirect()->route('product_assignments.index')->with('success', 'license Created Successfully.');
            } catch (\Exception $e) {
                return redirect()->route('product_assignments.index')->with('error', 'Failed to Create license!');
            }
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (\Auth::user()->can('license.delete')) {
            try {
                $assignment = ProductAssignment::with(['product', 'customer'])->findOrFail($id);
                $license = License::where('customer_id', $assignment->customer_id)
                    ->where('product_id', $assignment->product_id)
                    ->latest()
                    ->first();
                $license->status = 'Revoked';
                $license->save();

                return redirect()->route('product_assignments.index')->with('success', 'License revoked successfully.');
            } catch (\Exception $e) {
                return redirect()->route('product_assignments.index')->with('error', 'Failed to revoke License!');
            }

        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    public function getUnassignedProducts($customer_id)
    {
        $assignedProductIds = ProductAssignment::where('customer_id', $customer_id)
            ->pluck('product_id')
            ->toArray();

        $products = Product::whereNotIn('product_id', $assignedProductIds)->get();

        return response()->json($products);
    }


}
