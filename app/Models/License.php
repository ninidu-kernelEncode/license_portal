<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class License extends Model
{
    protected $primaryKey = 'license_id';

    protected $fillable = [
        'product_ref_id',
        'customer_ref_id',
        'license_key',
        'hash_algorithm',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * Create and return a new license for a product-customer pair.
     */

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_ref_id', 'product_ref_id');
    }
    public static function createLicense(array $data): License
    {
        try {
            $rowLicense = "{$data['customer_ref_id']}|{$data['product_ref_id']}|{$data['start_date']}|{$data['end_date']}";

            switch ($data['hash_algorithm']) {
                case 'MD5':
                    $licenseKey = hash('md5', $rowLicense);
                    break;
                case 'SHA256':
                    $licenseKey = hash('sha256', $rowLicense);
                    break;
                case 'HMAC-SHA256':
                    $secret = env('LICENSE_SECRET_KEY');
                    $licenseKey = hash_hmac('sha256', $rowLicense, $secret);
                    $licenseKey = strtoupper($licenseKey);
                    break;
                default:
                    throw new \InvalidArgumentException('Invalid hash algorithm.');
            }

            self::where('customer_ref_id', $data['customer_ref_id'])
                ->where('product_ref_id', $data['product_ref_id'])
                ->where('status', 'Active')
                ->update(['status' => 'Revoked']);

            $license = self::create([
                'product_ref_id' => $data['product_ref_id'],
                'customer_ref_id' => $data['customer_ref_id'],
                'license_key' => $licenseKey,
                'hash_algorithm' => $data['hash_algorithm'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'status' => 'Active',
            ]);

            return $license;

        } catch (\Exception $e) {
            return $e;
        }
    }
}
