<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Numeric;
use Illuminate\Database\Eloquent\Builder;

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

    //filter scopes
    protected function scopeOfBrand(Builder $query, ?int $brand): Builder
    {
        return $brand ? $query->where('brand_id', $brand) : $query;
    }

    protected function scopeOfTax(Builder $query, ?int $tax): Builder
    {
        return $tax ? $query->where('tax_id', $tax) : $query;
    }

    protected function scopeOfCatalog(Builder $query, ?int $catalog): Builder
    {
        return $catalog ? $query->where('catalog_id', $catalog) : $query;
    }

    protected function scopeOfName(Builder $query, ?string $product_name): Builder
    {
        return $product_name ? $query->whereLike('product_name', '%'.$product_name.'%') : $query;
    }

    protected function scopeOfEan(Builder $query, ?int $ean): Builder
    {
        return $ean ? $query->where('ean', $ean) : $query;
    }
}
