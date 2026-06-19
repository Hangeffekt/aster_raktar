<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'suplier_id'];
    protected $primaryKey = 'transfer_id';

    protected static function booted()
    {
        static::creating(function ($transfer) {
            $transfer->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
