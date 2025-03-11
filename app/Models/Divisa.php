<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisa extends Model
{
    protected $table = 'divisas';
    protected $fillable = ['name', 'symbol', 'exchange_rate'];
    public $timestamps = true;
    protected $hidden = ['created_at', 'updated_at'];
    
    protected $casts = [
        'exchange_rate' => 'float',
    ];
    
    public function productoPrecios()
    {
        return $this->hasMany(ProductoPrecio::class, 'currency_id');
    }
}
