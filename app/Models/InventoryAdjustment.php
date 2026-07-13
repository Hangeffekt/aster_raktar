<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InventoryAdjustment extends Model
{
    use HasFactory;
    protected $fillable = ['approves','status','adjustment_type'];
    protected $primaryKey = 'id';

    protected static function booted()
    {
        static::creating(function ($inventoryAdjustment) {
            $inventoryAdjustment->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
