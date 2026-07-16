<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['type','document_type','inner_table_id', 'status', 'qty', 'net_price', 'sale_price', 'reference'];
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

    //filter scopes
    protected function scopeOfTransactionType(Builder $query, ?string $type): Builder
    {
        return $type ? $query->where('type', $type) : $query;
    }

    protected function scopeOfTransactionStatus(Builder $query, ?string $status): Builder
    {
        return $status ? $query->where('status', $status) : $query;
    }

    protected function scopeOfNetPrice(Builder $query, ?int $net_price): Builder
    {
        return $net_price ? $query->where('net_price', $net_price) : $query;
    }

    protected function scopeOfSalePrice(Builder $query, ?int $sale_price): Builder
    {
        return $sale_price ? $query->where('sale_price', $sale_price) : $query;
    }

    protected function scopeOfQty(Builder $query, ?int $qty): Builder
    {
        return $qty ? $query->where('qty', $qty) : $query;
    }
}
