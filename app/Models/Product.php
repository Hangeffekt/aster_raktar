<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['brand_id','product_name','ean','net_price','sale_price','qty','tax_id','catalog_id'];
    protected $primaryKey = 'product_id';

    protected static function booted()
    {
        static::creating(function ($product) {
            $product->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function brand() { return $this->belongsTo(Brand::class, 'brand_id'); }
    public function catalog() { return $this->belongsTo(Catalog::class, 'catalog_id'); }
    public function tax() { return $this->belongsTo(Tax::class, 'tax_id'); }

    public function getFullNameAttribute()
    {
        $brand = $this->brand ? $this->brand->brand_name : '';
        $catalog = $this->catalog ? $this->catalog->catalog_name : '';

        // Itt úgy formázod, ahogy csak akarod
        return "{$brand} {$this->product_name} <span class='catalog-gray'>({$catalog})</span>";
    }
}
