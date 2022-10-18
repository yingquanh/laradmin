<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RolePaginateCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'page' => $this->currentPage(),
            'total' => $this->total(),
            'pageSize' => (int) $this->perPage(),
            'lists' => RolePaginateResource::collection($this->collection)
        ];
    }
}
