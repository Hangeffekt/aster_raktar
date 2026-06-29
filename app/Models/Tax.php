<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = ['tax_value'];
    protected $primaryKey = 'tax_id';

    protected static function booted()
    {
        static::creating(function ($tax) {
            $tax->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
