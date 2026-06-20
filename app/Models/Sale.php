<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['customer_code', 'employee_code', 'sale_status', 'payment_type'];
    protected $primaryKey = 'sale_id';
}
