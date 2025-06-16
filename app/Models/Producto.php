<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductoPrecio;
use App\Models\Divisa;
use App\Models\User;

class Producto extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'currency_id',
        'tax_cost',
        'manufacturing_cost',
    ];

    protected $with = ['currency', 'prices'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Divisa::class);
    }

    public function prices()
    {
        return $this->hasMany(ProductoPrecio::class, 'product_id', 'id');
    }
}
