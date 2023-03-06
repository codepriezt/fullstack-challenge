<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;

class DefaultResourceCollection extends ResourceCollection
{
    protected $collector;
    public function __construct($resource, $collector)
    {
        $this->collector = $collector;
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $paginated = $this->resource->toArray();

        return [
            'data' => $this->collector::collection($this->collection),
            'links' => $this->paginationLinks($paginated),
            'meta' => $this->meta($paginated),
        ];
    }

    protected function paginationLinks($paginated)
    {
      
        return [
            'first' => $paginated['first_page_url'] ?? null,
            'last' => $paginated['last_page_url'] ?? null,
            'prev' => $paginated['prev_page_url'] ?? null,
            'next' => $paginated['next_page_url'] ?? null,
            'total' => $paginated['total'] ?? 0,
            'pageSize' => $paginated['per_page'] ??0
        ];
    }

    /**
     * Gather the meta data for the response.
     *
     * @param array $paginated
     *
     * @return array
     */
    protected function meta($paginated)
    {
        return Arr::except($paginated, [
            'data',
            'first_page_url',
            'last_page_url',
            'prev_page_url',
            'next_page_url',
        ]);
    }
}
