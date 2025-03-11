<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoPrecio extends Model
{
    protected $table = 'producto_precios';
    protected $fillable = ['product_id', 'currency_id', 'price'];
    public $timestamps = true;
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = [
        'product_id' => 'integer',
        'currency_id' => 'integer',
        'price' => 'float',
    ];
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'product_id');
    }
    public function currency()
    {
        return $this->belongsTo(Divisa::class, 'currency_id');
    }
}
