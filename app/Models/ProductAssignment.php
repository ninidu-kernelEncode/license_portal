<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAssignment extends Model
{
    use HasFactory;

    protected $table = 'product_assignments';
    protected $primaryKey = 'assignment_id';

    protected $fillable = [
        'product_ref_id',
        'customer_ref_id',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_ref_id', 'product_ref_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_ref_id', 'customer_ref_id');
    }

    }
