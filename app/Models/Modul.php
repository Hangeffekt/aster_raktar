<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Modul extends Model
{
    use HasFactory;

    protected $fillable = ['zone_id','line','modul_number','is_active'];
    protected $primaryKey = 'modul_id';

    protected static function booted()
    {
        static::creating(function ($modul) {
            $modul->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
