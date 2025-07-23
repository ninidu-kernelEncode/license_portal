<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\Customer;
use App\Models\ProductAssignment;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
        $license = License::where('customer_ref_id', $customer_id)
            ->where('product_ref_id', $product_id)
            ->where('status', 'Active')
            ->latest()
            ->first();

        $response = [
            'valid' => false,
            'license_key' => $licenseKey,
            'customer_id' => $customer_id,
            'product_id' => $product_id,
            'start_date' => optional($license)->start_date,
            'end_date' => optional($license)->end_date,
        ];

        if (!$license) {
            return response()->json($response);
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
                return response()->json($response);
        }

        if ($expectedKey !== $licenseKey) {
            return response()->json($response);
        }

        $today = now()->startOfDay();
        $startDate = Carbon::parse($license->start_date)->startOfDay();
        $endDate = Carbon::parse($license->end_date)->startOfDay();

        if ($today->gte($startDate) && $today->lte($endDate)) {
            $response['valid'] = true;
        }

        return response()->json($response);
    }
}
