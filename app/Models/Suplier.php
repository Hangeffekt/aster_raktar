<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Suplier extends Model
{
    use HasFactory;

    protected $fillable = ['suplier_name', 'suplier_settlement', 'suplier_zip_code', 'suplier_tax_number', 'suplier_phone', 'suplier_email'];
    protected $primaryKey = 'suplier_id';

    protected static function booted()
    {
        static::creating(function ($suplier) {
            $suplier->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
