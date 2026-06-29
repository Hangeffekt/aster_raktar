<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Catalog extends Model
{
    use HasFactory;

    protected $fillable = ['catalog_name'];
    protected $primaryKey = 'catalog_id';

    protected static function booted()
    {
        static::creating(function ($catalog) {
            $catalog->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
