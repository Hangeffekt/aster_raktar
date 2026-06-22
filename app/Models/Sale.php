<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['customer_code', 'employee_code', 'sale_status', 'payment_type'];
    protected $primaryKey = 'sale_id';

    protected static function booted()
    {
        static::creating(function ($sale) {
            $sale->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
