<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrivalItem extends Model
{
    use HasFactory;

    protected $fillable = ['arrival_table_id','item_id','item_name','net_price','sale_price','qty','finished'];
    protected $primaryKey = 'arrival_item_id';

    public function product() { return $this->belongsTo(Product::class, 'item_id'); }
}
