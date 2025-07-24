<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\License;
use Illuminate\Support\Carbon;

class LicenseController extends Controller
{

    public function checkLicenseValidity(Request $request)
    {
        if (\Auth::user()->can('license.view')) {
            $license = License::where('customer_ref_id', $request['customer_id'])
                ->where('product_ref_id', $request['product_id'])
                ->latest()
                ->first();

            $response = [
                'valid' => false,
                'license key' => $request['license_key'],
                'license Status' => $license->status,
                'customer ID' => $request['customer_id'],
                'product ID' => $request['product_id'],
                'start Date' => optional($license)->start_date,
                'End Date' => optional($license)->end_date,
            ];

            if (!$license) {
                return response()->json($response);
            }

            if ($license->status == 'Revoked') {
                return response()->json($response);
            }

            $rawLicense = "{$request['customer_id']}|{$request['product_id']}|{$license->start_date}|{$license->end_date}";

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

            if ($expectedKey !== $request['license_key']) {

                $old_license = License::where('license_key', $request['license_key'])->latest()->first();
                if ($old_license) {
                    $response = [
                        'valid' => false,
                        'license key' => $request['license_key'],
                        'license Status' => $old_license->status,
                        'customer ID' => $request['customer_id'],
                        'product ID' => $request['product_id'],
                        'start Date' => $old_license->start_date,
                        'End Date' => $old_license->end_date,
                    ];
                }else{
                    $response = [
                        'valid' => false,
                        'license key' => $request['license_key'],
                        'license Status' => '',
                        'customer ID' => $request['customer_id'],
                        'product ID' => $request['product_id'],
                        'start Date' => '',
                        'End Date' => '',
                    ];
                }

                return response()->json($response);
            }

            $today = now()->startOfDay();
            $startDate = Carbon::parse($license->start_date)->startOfDay();
            $endDate = Carbon::parse($license->end_date)->startOfDay();

            if ($today->gte($startDate) && $today->lte($endDate)) {
                $response['valid'] = true;
            }

            return response()->json($response);
        }else{
            return response()->json([
                'message' => 'Unauthorized: You do not have permission to view license information.'
            ], 403);
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



}
