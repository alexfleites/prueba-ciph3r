<?php
namespace App\Filament\Resources\ProductoResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Producto;

/**
 * @property Producto $resource
 */
class ProductoTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->toArray();
    }
}
