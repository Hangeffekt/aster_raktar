<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = ['name','is_active'];
    protected $primaryKey = 'zone_id';

    protected static function booted()
    {
        static::creating(function ($zone) {
            $zone->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
