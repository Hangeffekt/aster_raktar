<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Suplier extends Model
{
    use HasFactory;

    protected $fillable = ['suplier_name', 'suplier_settlement', 'suplier_address', 'suplier_zip_code', 'suplier_tax_number', 'suplier_phone', 'suplier_email'];
    protected $primaryKey = 'suplier_id';

    protected static function booted()
    {
        static::creating(function ($suplier) {
            $suplier->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    //filter scopes
    protected function scopeOfSuplierName(Builder $query, ?string $suplier_name): Builder
    {
        return $suplier_name ? $query->whereLike('suplier_name', '%'.$suplier_name.'%') : $query;
    }

    protected function scopeOfSuplierSettlement(Builder $query, ?string $suplier_settlement): Builder
    {
        return $suplier_settlement ? $query->whereLike('suplier_settlement', '%'.$suplier_settlement.'%') : $query;
    }

    protected function scopeOfSuplierAddress(Builder $query, ?string $suplier_address): Builder
    {
        return $suplier_address ? $query->whereLike('suplier_address', '%'.$suplier_address.'%') : $query;
    }

    protected function scopeOfSuplierZipCode(Builder $query, ?int $suplier_zip_code): Builder
    {
        return $suplier_zip_code ? $query->where('suplier_zip_code', $suplier_zip_code) : $query;
    }

    protected function scopeOfSuplierTaxNumber(Builder $query, ?int $suplier_tax_number): Builder
    {
        return $suplier_tax_number ? $query->where('suplier_tax_number', $suplier_tax_number) : $query;
    }

    protected function scopeOfSuplierPhone(Builder $query, ?int $suplier_phone): Builder
    {
        return $suplier_phone ? $query->where('suplier_phone', $suplier_phone) : $query;
    }

    protected function scopeOfSuplierEmail(Builder $query, ?string $suplier_email): Builder
    {
        return $suplier_email ? $query->whereLike('suplier_email', '%'.$suplier_email.'%') : $query;
    }
}
