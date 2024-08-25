<?php
namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;

trait PaginationLinksTrait
{
    protected function getPaginator()
    {
        if ($this->collection instanceof LengthAwarePaginator || $this->collection instanceof Paginator) {
            return $this->collection;
        }

        return null;
    }

    public function getSelfLink()
    {
        return url()->current();
    }

    public function getFirstLink()
    {
        $paginator = $this->getPaginator();
        return $paginator ? $paginator->url(1) : null;
    }

    public function getLastLink()
    {
        $paginator = $this->getPaginator();
        return $paginator ? $paginator->url($paginator->lastPage()) : null;
    }

    public function getPrevLink()
    {
        $paginator = $this->getPaginator();
        return $paginator ? $paginator->previousPageUrl() : null;
    }

    public function getNextLink()
    {
        $paginator = $this->getPaginator();
        return $paginator ? $paginator->nextPageUrl() : null;
    }
}