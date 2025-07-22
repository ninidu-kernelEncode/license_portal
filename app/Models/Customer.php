<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Customer extends Model
{
    use HasFactory,HasRoles;

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_name',
        'email',
        'company',
        'contact_number',
    ];
    public function assignments()
    {
        return $this->hasMany(\App\Models\ProductAssignment::class, 'customer_id', 'customer_id');
    }


}
