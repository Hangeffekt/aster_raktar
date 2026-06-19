<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','product_id','product_name','type','document_type','inner_table_id', 'status', 'qty', 'net_price', 'sale_price', 'reference'];
    protected $primaryKey = 'id';

    public function product() { return $this->belongsTo(Product::class, 'product_id'); }

    protected static function booted()
    {
        static::creating(function ($transaction) {
            $transaction->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
