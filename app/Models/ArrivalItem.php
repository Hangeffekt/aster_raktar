<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ArrivalItem extends Model
{
    use HasFactory;

    protected $fillable = ['arrival_table_id','item_id','net_price','sale_price','qty'];
    protected $primaryKey = 'arrival_item_id';

    public function product() { return $this->belongsTo(Product::class, 'item_id'); }

    protected static function booted()
    {
        static::creating(function ($arrivalItem) {
            $arrivalItem->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
