<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->name,
            'email' => $this->email,
            'jabatan' => $this->roles->pluck('name')->first(),
            'perusahaan' => $this->company->name,
            'alamat' => $this->when($this->address, $this->address),
            'telepon' => $this->when($this->phone, $this->phone),
        ];
    }
}
