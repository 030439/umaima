<?php
namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait BalanceTrait
{
    public function fetchRecordsBank(
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
        bool $paginate = true,
        string $balanceColumn = 'amount', // Column for running balance
        bool $includeRunningBalance = false // Flag for running balance
    ) {
        $columns = is_array($columns) && !empty($columns) ? $columns : ['*'];

        $query = DB::table($table)->select($columns);

        // Apply conditions
        foreach ($conditions as $condition) {
            if (is_array($condition) && count($condition) === 3) {
                $query->where($condition[0], $condition[1], $condition[2]);
            } else {
                $query->where($condition);
            }
        }

        // Apply filters
        $query->where(function ($q) use ($filters) {
            foreach ($filters as $column => $filterValue) {
                if (is_array($filterValue)) {
                    $q->orWhereIn($column, $filterValue);
                } elseif (is_string($filterValue) && str_contains($filterValue, '%')) {
                    $q->orWhere($column, 'LIKE', $filterValue);
                } else {
                    $q->orWhere($column, $filterValue);
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

        // Apply having
        foreach ($having as $condition) {
            $query->having($condition['column'], $condition['operator'], $condition['value']);
        }

        // Apply ordering
        $query->orderBy($orderColumn, $orderDirection);

        // Get total records count
        $total = $query->count();

        // Fetch data
        if ($paginate) {
            $records = $query->paginate($perPage, $columns, 'page', $page);
            $data = $records->items();
        } else {
            $data = $query->get();
        }

        // Calculate running balance
        $runningBalance = 0;
        foreach ($data as &$row) { // Using reference to modify $row directly
            $amount = (float) $row->$balanceColumn;
            if ((int) $row->payment_type === 1) {
                $runningBalance += $amount; // Add if payment_type = 1
            } else {
                $runningBalance -= $amount; // Subtract otherwise
            }
            $row->running_balance = $runningBalance; // Add running_balance to each row
        }

        return [
            'data' => $data,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'runningBalance' => $runningBalance, // Final balance
        ];
    }
}
