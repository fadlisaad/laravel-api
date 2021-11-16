<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Tree extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->INV_NOMBORIDS,
            'inventori' => $this->INV_INVENTORI,
            'kategori' => $this->INV_KATEGORI,
            'qr_code' => $this->INV_QR

        ];
    }
}