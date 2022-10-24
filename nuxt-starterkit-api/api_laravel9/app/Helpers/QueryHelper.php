<?php

if (!function_exists('simplePaginate')) {
    function simplePaginate($query, $page = 1, $perpage = 10, $columns = ['*'])
    {
        $result = $query->paginate($perpage, $columns, 'page', $page);
        return collect($result->toArray())
            ->only(['current_page', 'data', 'from', 'last_page', 'per_page', 'to', 'total']);
    }
}

if (!function_exists('getBoundQueryString')) {
    function getBoundQueryString($query)
    {
        return vsprintf(
            str_replace('?', '%s', $query->toSql()),
            collect($query->getBindings())->map(function ($binding) {
                $binding = addslashes($binding);
                return is_numeric($binding) ? $binding : "'{$binding}'";
            }
            )->toArray());
    }
}
