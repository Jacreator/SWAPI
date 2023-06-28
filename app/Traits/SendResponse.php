<?php 

namespace App\Traits;

use Illuminate\Http\JsonResponse;


/**
 * @property-read mixed $data
 * @property-read Http $status
 */
trait SendResponse
{
    public function toResponse($request)
    {
        return new JsonResponse(
            data: $this->data,
            status: $this->status,
        );
    }
}