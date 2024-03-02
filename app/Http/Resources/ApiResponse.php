<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponse extends JsonResource
{
    public $status;
    public $message;
    public $pagination;


    public function __construct($status, $message, $resource = null, $pagination = null)
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
        $this->pagination = $pagination;
    }

    public function toResponse($request)
    {
        return parent::toResponse($request)->setStatusCode($this->status);
    }

    public function toArray($request)
    {
        $response = [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->resource,
            'pagination' => $this->pagination,
        ];

        return $response;
    }
}
