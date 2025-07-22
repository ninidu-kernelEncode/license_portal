<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\Auth::user()->can('customer.manage')) {
            $customers = Customer::latest()->paginate(10);
            return view('customers.index', compact('customers'));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (\Auth::user()->can('customer.create')) {
            return view('customers.create');
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('customer.create')) {
            $user =  \Auth::user();
            $request->validate([
                'customer_name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:customers',
            ]);

            try {
                $customer = Customer::create([
                    'customer_name'     => $request->customer_name,
                    'email'    => $request->email,
                    'company'    => $request->company,
                    'contact_number'    => $request->contact_number,
                ]);
                $log_description = "Created customer ID - ". $customer->customer_id;
                create_log('Create customer', $log_description, $user);
                return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
            } catch (\Exception $e) {
                return redirect()->route('customers.index')->with('error', 'Failed to create Customer!');
            }
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        if (\Auth::user()->can('customer.view')) {
            return view('customers.show', compact('customer'));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        if (\Auth::user()->can('customer.update')) {
            return view('customers.edit', compact('customer',));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        if (\Auth::user()->can('customer.update')) {
            $user =  \Auth::user();
            $request->validate([
                'customer_name'  => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->customer_id . ',customer_id',
            ]);

            try {
                $data = $request->only(['customer_name', 'email','company','contact_number']);

                $customer->update($data);

                $log_description = "Updated customer ID - ". $customer->customer_id;
                create_log('Update customer', $log_description, $user);
                return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
            } catch (\Exception $e) {
                return redirect()->route('customers.index')->with('error', 'Failed to update Customer!');
            }
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if (\Auth::user()->can('customer.delete')) {
            $user =  \Auth::user();
            try {
                $customer->delete();
                $log_description = "Deleted customers ID - ". $customer->customer_id;
                create_log('Delete customer', $log_description, $user);
                return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
            } catch (\Exception $e) {
                return redirect()->route('customers.index')->with('error', 'Failed to delete Customer!');
            }
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }
}
