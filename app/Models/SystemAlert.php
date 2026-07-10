<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemAlert extends Model
{
    use HasFactory;

    protected $fillable = ['level', 'message', 'product_uuid', 'trigger_by'];
    protected $primaryKey = 'id';
}
