<?php

namespace App\Http\Resources\v1;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @mixin Product
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
          'id' => $this->id,
          'name' => $this->name,
          'sku' => $this->sku,
          'quantity' => $this->quantity
        ];
    }
}
