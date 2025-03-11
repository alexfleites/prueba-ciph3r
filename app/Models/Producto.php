<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'currency_id',
        'tax_cost',
        'manufacturing_cost',
    ];

    public function currency()
    {
        return $this->belongsTo(Divisa::class);
    }

    public function prices()
    {
        return $this->hasMany(ProductoPrecio::class, 'product_id', 'id');
    }
}
