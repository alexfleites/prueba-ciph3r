<?php
namespace App\Filament\Resources\DivisaResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Divisa;

/**
 * @property Divisa $resource
 */
class DivisaTransformer extends JsonResource
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
