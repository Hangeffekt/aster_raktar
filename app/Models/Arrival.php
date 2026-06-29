<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Arrival extends Model
{
    use HasFactory;
    protected $fillable = ['suplier_id','arrival_date','payment_date','suplier_note_number','invoice_number','arrival_status'];
    protected $primaryKey = 'arrival_id';

    protected static function booted()
    {
        static::creating(function ($arrival) {
            $arrival->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
