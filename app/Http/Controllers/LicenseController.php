<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\Customer;
use App\Models\ProductAssignment;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\Auth::user()->can('license.manage')) {
            $customers = Customer::with(['licenses.product'])
                ->where('status', 1)
                ->get();
            return view('licenses.index', compact('customers'));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(License $license)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(License $license)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, License $license)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (\Auth::user()->can('license.delete')) {
            try {
                $license = License::find($id);
                $license->status = 'Revoked';
                $license->save();

                return true;
            } catch (\Exception $e) {
                return false;
            }

        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    public function checkLicenseValidity($licenseKey, $customer_id, $product_id)
    {
        $license = License::where('customer_id', $customer_id)
            ->where('product_id', $product_id)
            ->where('status', 'Active')
            ->latest()
            ->first();

        if (!$license) {
            return [
                'valid' => false,
                'license_key' => $licenseKey,
                'customer_id' => $customer_id,
                'product_id' => $product_id
            ];
        }

        $rawLicense = "{$customer_id}|{$product_id}|{$license->start_date}|{$license->end_date}";

        switch ($license->hash_algorithm) {
            case 'MD5':
                $expectedKey = hash('md5', $rawLicense);
                break;
            case 'SHA256':
                $expectedKey = hash('sha256', $rawLicense);
                break;
            case 'HMAC-SHA256':
                $secret = env('LICENSE_SECRET_KEY');
                $expectedKey = strtoupper(hash_hmac('sha256', $rawLicense, $secret));
                break;
            default:
                return [
                    'valid' => false,
                    'license_key' => $licenseKey,
                    'customer_id' => $customer_id,
                    'product_id' => $product_id
                ];
        }

        if ($expectedKey !== $licenseKey) {
            return [
                'valid' => false,
                'license_key' => $licenseKey,
                'customer_id' => $customer_id,
                'product_id' => $product_id
            ];
        }

        // Check date validity
        $now = now();
        if ($now->lt($license->start_date)) {
            return [
                'valid' => false,
                'license_key' => $licenseKey,
                'customer_id' => $customer_id,
                'product_id' => $product_id
            ];
        }

        if ($now->gt($license->end_date)) {
            return [
                'valid' => false,
                'license_key' => $licenseKey,
                'customer_id' => $customer_id,
                'product_id' => $product_id
            ];
        }

        return [
            'valid' => true,
            'license_key' => $licenseKey,
            'customer_id' => $customer_id,
            'product_id' => $product_id
        ];
    }
}
