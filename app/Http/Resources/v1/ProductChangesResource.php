<?php

namespace App\Http\Resources\v1;

use App\Models\ProductChange;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @mixin ProductChange
 */
class ProductChangesResource extends JsonResource
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
            'product_id' => $this->product_id,
            'action' => $this->action,
            'previous' => $this->source_data,
            'affected' => $this->affected_data,
            'modified_at' => (new Carbon($this->created_at))->toDateTimeString()
        ];
    }
}
