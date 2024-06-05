<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Definir a localidade para português do Brasil
        Carbon::setLocale('pt_BR');

        $formattedDate = $this->created_at->translatedFormat('d \d\e F \d\e Y');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'class' => ClassesResource::make($this->whenLoaded('class')),
            'section' => SectionResource::make($this->whenLoaded('section')),
            'created_at' => $formattedDate,
        ];
    }
}
