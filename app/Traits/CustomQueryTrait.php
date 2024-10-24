<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

trait CustomQueryTrait
{
    /**
     * Filter, search, order, and paginate the query based on the request parameters.
     *
     * @param  mixed  $query  The query to filter, search, order, and paginate.
     * @param  Request  $request  The request containing filter, search, sort, and pagination parameters.
     * @param  array  $fields  The fields to apply the filter, search, and sort operations.
     * @return Collection|LengthAwarePaginator The filtered, searched, ordered, and paginated query results.
     */
    public function cfilterSeachOrderPaginate(mixed $query, Request $request, array $fields): Collection|LengthAwarePaginator
    {
        $this->cFilter($query, $request->filter, $fields);
        $this->cSearch($query, $request->search, $fields);
        $this->cOrder($query, $request->sortBy, $request->sortOrder, $fields);

        return $this->cPaginate($query, $request->pageSize);
    }

    /**
     * Filter the query based on the given filters and fields.
     *
     * @param  mixed  $query  The query to filter.
     * @param  array|null  $filters  The filters to apply to the query.
     * @param  array  $fields  The fields to apply the filter operations.
     */
    public function cFilter(mixed &$query, ?array $filters, array $fields): void
    {
        if ($filters) {
            foreach ($filters as $key => $value) {

                $field = $this->filterField($fields, $key);

                if (filled($field) && filled($value)) {
                    $query->where($field, $value);
                }
            }
        }
    }

    /**
     * Search the query based on the given search term and fields.
     *
     * @param  mixed  $query  The query to search.
     * @param  string|null  $search  The search term to search for in the query.
     * @param  array  $fields  The fields to search.
     */
    public function cSearch(mixed &$query, ?string $search, array $fields): void
    {
        if ($search) {
            $query->where(function ($query) use ($search, $fields) {
                foreach ($fields as $field) {
                    $query->orWhere($field, 'like', "%{$search}%");
                }
            });
        }
    }

    /**
     * Order the query based on the given sort field and order.
     *
     * @param  mixed  $query  The query to order.
     * @param  string|null  $sortBy  The field to sort by.
     * @param  string|null  $sortOrder  The order of sorting ('asc' or 'desc').
     * @param  array  $fields  The fields available for sorting.
     */
    public function cOrder(mixed &$query, ?string $sortBy, ?string $sortOrder, array $fields): void
    {
        $orderBy = 'asc';

        if ($sortBy && $this->filterField($fields, $sortBy)) {

            $sortBy = $this->filterField($fields, $sortBy);

            if ($sortOrder && in_array($sortOrder, ['asc', 'desc'])) {
                $orderBy = $sortOrder;
            }

            $query->orderBy($sortBy, $orderBy);
        }
    }

    /**
     * Paginate the query based on the given page size.
     *
     * @param  mixed  $query  The query to paginate.
     * @param  int|null  $pageSize  The number of items per page.
     * @return Collection|LengthAwarePaginator The paginated query results.
     */
    public function cPaginate(mixed &$query, ?int $pageSize): Collection|LengthAwarePaginator
    {
        if ($pageSize) {
            return $query->paginate($pageSize)->withQueryString();
        }

        return $query->get();
    }

    /**
     * Filter a field from the given fields array based on the given key.
     *
     * This function is used to filter a field from the given fields array based on the given key.
     * If the key is not found in the given fields array, or if the key is not a string or an integer, the function will return null.
     *
     * @param  array  $fields  The fields array to filter the key from.
     * @param  string|int  $key  The key to filter from the given fields array.
     * @return string|null The filtered field if found, otherwise null.
     */
    private function filterField(array $fields, string|int $key): ?string
    {
        return Arr::first($fields, function ($fieldQuery) use ($key) {
            $fieldExplode = explode('.', $fieldQuery);
            if (count($fieldExplode) > 1) {
                $fieldQuery = $fieldExplode[1];
            }

            return $fieldQuery == $key;
        });
    }
}
