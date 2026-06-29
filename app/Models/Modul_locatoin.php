<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Modul_locatoin extends Model
{
    use HasFactory;

    protected $fillable = ['zone_id','product_id','qty','order','qty','faces','is_active'];
    protected $primaryKey = 'modul_location_id';

    protected static function booted()
    {
        static::creating(function ($modul_location) {
            $modul_location->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
