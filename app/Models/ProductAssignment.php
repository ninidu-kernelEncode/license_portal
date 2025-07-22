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
        'product_id',
        'customer_id',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    }
