<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait PaginateData
{
    /**
     * Get paginated data from model.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  bool  $paginate
     * @param  int  $page
     * @param  int  $perPage
     * @param  string  $sortKey
     * @param  string  $sortOrder
     * @param  string  $search
     * @param  array  $withRelations
     * @param  array  $filters
     * @return array
     */
    public function scopeGetPaginatedData(
        Builder $query,
        $paginate = true,
        $page = 1,
        $perPage = 20,
        $sortKey = 'id',
        $sortOrder = 'asc',
        $search = null,
        $withRelations = [],
        $filters = [],
        $appends = [],
    ) {
        $query = $query->with($withRelations);

        if (method_exists($this, 'scopeWithSort')) {
            $query = $query->withSort($sortKey, $sortOrder);
        } else {
            $query = $query->orderBy($sortKey, $sortOrder);
        }

        if ($search) {
            $searchKeyword = "%$search%";
            if (method_exists($this, 'scopeWithSearch')) {
                $query = $query->withSearch($searchKeyword);
            } else {
                $query = $query->where(function ($q) use ($searchKeyword) {
                    if ($this->searchable) {
                        $searchable = $this->searchable;
                    } else {
                        $searchable = $this->getFillable();
                    }

                    foreach ($searchable as $field) {
                        $q->orWhere($field, 'like', $searchKeyword);
                    }
                });
            }
        }

        if (method_exists($this, 'scopeWithFilter')) {
            $query = $query->withFilter($filters);
        }

        if (method_exists($this, 'scopeBeforePaginate')) {
            $query = $query->beforePaginate($query);
        }

        if ($paginate) {
            return $this->paginate($query, $page, $perPage, $appends);
        }

        $data = $query->get();
        if (count($appends) > 0) {
            $data = $data->each->setAppends($appends);
        }

        return $data;
    }

    /**
     * Get paginated query.
     *
     * @return mixed
     */
    public function paginate($query, $page = 1, $perPage = 20, $appends = [])
    {
        $offset = ($page - 1) * $perPage;

        $total = $query->count();
        $lastPage = ceil($total / $perPage);

        if ($page > 1 && $page > $lastPage) {
            return $this->paginate($query, $page - 1, $perPage);
        }

        $query = $query->offset($offset)->limit($perPage);

        $pagination = (object) [
            'page' => (int) $page,
            'perPage' => (int) $perPage,
            'lastPage' => (int) $lastPage,
            'start' => (int) $page ? $offset + 1 : 0,
            'end' => (int) $page ? $offset + $query->count() : 0,
            'total' => (int) $total
        ];

        $data = $query->get();

        if (count($appends) > 0) {
            $data = $data->each->setAppends($appends);
        }

        $result = (object) [
            'data' => $data,
            'pagination' => $pagination
        ];

        return $result;
    }
}
