<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Arrival extends Model
{
    use HasFactory;
    protected $fillable = ['suplier_id','approves','arrival_date','payment_date','suplier_note_number','invoice_number','arrival_status'];
    protected $primaryKey = 'arrival_id';

    protected static function booted()
    {
        static::creating(function ($arrival) {
            $arrival->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    //filter scopes
    protected function scopeOfArrivalStatus(Builder $query, ?string $arrival_status): Builder
    {
        return $arrival_status ? $query->where('arrival_status', $arrival_status) : $query;
    }

    protected function scopeOfSuplier(Builder $query, ?int $suplier_id): Builder
    {
        return $suplier_id ? $query->where('a.suplier_id', $suplier_id) : $query;
    }

    protected function scopeOfSuplierNoteNumber(Builder $query, ?string $suplier_note_number): Builder
    {
        return $suplier_note_number ? $query->where('suplier_note_number', $suplier_note_number) : $query;
    }

    protected function scopeOfInvoiceNumber(Builder $query, ?string $invoice_number): Builder
    {
        return $invoice_number ? $query->where('invoice_number', $invoice_number) : $query;
    }

    protected function scopeOfCreatedAt(Builder $query, ?DateTime $from, ?DateTime $to): Builder
    {
        return $query
        ->when($from, fn ($q) => $q->where('updated_at', '>=', $from))
        ->when($to, fn ($q) => $q->where('updated_at', '<=', $to));
    }
}
