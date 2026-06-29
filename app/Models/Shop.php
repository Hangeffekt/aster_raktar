<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Shop extends Model
{
    use HasFactory;
    
    protected $fillable = ['shop_name'];
    protected $primaryKey = 'shop_id';

    protected static function booted()
    {
        static::creating(function ($shop) {
            $shop->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
