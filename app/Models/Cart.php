<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['item_id','sale_table_id','sale_product_id','sale_product_name','sale_product_qty','sale_product_value','sale_status','finished'];
    protected $primaryKey = 'sale_item_id';
}
