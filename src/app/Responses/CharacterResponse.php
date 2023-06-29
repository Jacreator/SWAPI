<?php

namespace App\Responses;

use App\Traits\SendResponse;
use Illuminate\Contracts\Support\Responsable;

class CharacterResponse implements Responsable
{
    use SendResponse;

    public function __construct(
        public readonly array $data,
        public readonly string $status,
    ) {
    }
}