<?php
namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait QueryTrait
{
    public function fetchRecords(
        $table,
        $perPage = 10,
        $page = 1,
        $filters = [],
        $joins = [],
        $orderColumn = 'id',
        $orderDirection = 'asc',
        $groupBy = [],
        $having = [],
        $paginate = true
    ) {
        $query = DB::table($table)->select('*');

        // Apply joins if provided
        if (!empty($joins)) {
            foreach ($joins as $join) {
                $query->join($join['table'], $join['first'], $join['operator'], $join['second']);
            }
        }

        // Apply filters if provided
        // Apply filters if provided
        if (!empty($filters)) {
            foreach ($filters as $column => $value) {
                // Apply the like condition for each filter
                $query->where($column, 'like', $value);
            }
        }


        // Apply group by if provided
        if (!empty($groupBy)) {
            $query->groupBy($groupBy);
        }

        // Apply having if provided
        if (!empty($having)) {
            foreach ($having as $condition) {
                $query->having($condition['column'], $condition['operator'], $condition['value']);
            }
        }

        // Apply ordering
        $query->orderBy($orderColumn, $orderDirection);

        // Get the total count of records
        $total = $query->count();

        // Return paginated data or all records depending on $paginate flag
        if ($paginate) {
            $records = $query->paginate($perPage, ['*'], 'page', $page);
        } else {
            $records = $query->get();
        }

        // Return both paginated data and the total count
        return [
            'data' => $records->items(),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
        ];
    }
}

