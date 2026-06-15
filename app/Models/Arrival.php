<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arrival extends Model
{
    use HasFactory;
    protected $fillable = ['suplier_id','arrival_date','payment_date','suplier_note_number','invoice_number',];
    protected $primaryKey = 'arrival_id';
}
