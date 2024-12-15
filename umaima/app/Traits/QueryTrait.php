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
        // Apply filters dynamically
        $query->where(function ($q) use ($filters) {
            foreach ($filters as $column => $filterValue) {
                if (is_array($filterValue)) {
                    $q->orWhereIn($column, $filterValue); // Handle array values (IN clause)
                } elseif (is_string($filterValue) && str_contains($filterValue, '%')) {
                    $q->orWhere($column, 'LIKE', $filterValue); // Handle LIKE clause for strings with wildcards
                } else {
                    $q->orWhere($column, $filterValue); // Standard equality check
                }
            }
        });
        

    
        // Apply joins
        foreach ($joins as $join) {
            $type = $join['type'] ?? 'join';
            $query->$type($join['table'], $join['first'], '=', $join['second']);
        }
    
        // Apply group by
        if (!empty($groupBy)) {
            $query->groupBy($groupBy);
        }
    //still same issue
    
        // Apply having
        foreach ($having as $condition) {
            $query->having($condition['column'], $condition['operator'], $condition['value']);
        }
    
        // Apply ordering
        $query->orderBy($orderColumn, $orderDirection);
        //check /debug query
        // $sql = $query->toSql();
        // $bindings = $query->getBindings();
        // dd(vsprintf(str_replace('?', '%s', $sql), array_map(fn($value) => is_string($value) ? "'$value'" : $value, $bindings)));
        
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
