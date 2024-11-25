<?php
namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait QueryTrait
{
    public function fetchRecords(
        string $table,
        array $columns = ['*'],
        array $conditions = [],
        array $filters = [],
        array $joins = [],
        string $orderColumn = 'id',
        string $orderDirection = 'asc',
        array $groupBy = [],
        array $having = [],
        int $perPage = 10,
        int $page = 1,
        bool $paginate = true
    ) {
        $columns = is_array($columns) && !empty($columns) ? $columns : ['*'];
        
        
        
        $query = DB::table($table)->select($columns);
    
        // Apply conditions
        foreach ($conditions as $condition) {
            // Ensure the condition is an array with column, operator, and value
            if (is_array($condition) && count($condition) === 3) {
                $query->where($condition[0], $condition[1], $condition[2]);
            } else {
                // Handle simple conditions for backward compatibility
                $query->where($condition);
            }
        }
        
    
        // Apply filters
        foreach ($filters as $column => $filterValue) {
            if (is_array($filterValue)) {
                $query->whereIn($column, $filterValue);
            } else {
                $query->where($column, $filterValue);
            }
        }
    
        // Apply joins
        foreach ($joins as $join) {
            $type = $join['type'] ?? 'join';
            $query->$type($join['table'], $join['first'], '=', $join['second']);
        }
    
        // Apply group by
        if (!empty($groupBy)) {
            $query->groupBy($groupBy);
        }
    
        // Apply having
        foreach ($having as $condition) {
            $query->having($condition['column'], $condition['operator'], $condition['value']);
        }
    
        // Apply ordering
        $query->orderBy($orderColumn, $orderDirection);
        $sql = $query->toSql();
        dd($sql);
        // Get total records count before pagination or filters
        $total = $query->count();
    
        // Handle pagination
        if ($paginate) {
            $records = $query->paginate($perPage, $columns, 'page', $page);
            $data = $records->items(); // Get paginated items
        } else {
            $records = $query->get();
            $data = $records; // Get all records
        }
    
        // Return both paginated data and the total count
        return [
            'data' => $data,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
        ];
    }
    
}

