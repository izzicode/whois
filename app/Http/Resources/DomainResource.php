<?php

namespace App\Http\Resources;

use App\Dto\DomainDto;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read DomainDto $resource
 */
class DomainResource extends JsonResource
{
    public function __construct(DomainDto $resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return $this->resource->jsonSerialize();
    }
}
