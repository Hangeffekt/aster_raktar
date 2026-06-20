<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PaymentType extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','payment_type'];
    protected $primaryKey = 'payment_id';

    protected static function booted()
    {
        static::creating(function ($payment_type) {
            $payment_type->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
