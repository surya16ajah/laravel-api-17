<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class KategoriCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => true,
            'message' => 'Categories Retrieved Succesfully',
            'data' => $this->collection,
            'meta' => [
                'current_page' => $this->current_Page(),
                'last_page' => $this->last_Page(),
                'per_page' => $this->per_Page(),
                'total' => $this->total(),
            ],
        ];
    }
}
