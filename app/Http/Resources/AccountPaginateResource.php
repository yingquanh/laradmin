<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountPaginateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'account' => $this->account,
            'name' => $this->name,
            'avatar' => $this->avatar,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'status' => $this->status,
            'role' => count($this->roles->toArray()) ? implode('|', array_column($this->roles->toArray(), 'title')) : '',
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
