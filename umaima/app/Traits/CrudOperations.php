<?php

namespace App\Traits;
trait CrudOperations {
  
    public function create($table, $data) {
        return $this->db->table($table)->insert($data);
    }

    public function update($table, $data, $id, $idColumn = 'id') {
        return $this->db->table($table)->where($idColumn, $id)->update($data);
    }

    public function delete($table, $id, $idColumn = 'id') {
        return $this->db->table($table)->where($idColumn, $id)->delete();
    }

    public function getFilteredPaginated($table, $perPage = 10, $page = 1, $columns = ['*'], $filters = [], $joins = [], $orderColumn = 'id', $orderDirection = 'asc', $groupBy = [], $having = []) {
        $builder = $this->db->table($table)->select($columns);

        // Apply joins dynamically
        foreach ($joins as $join) {
            $builder->join($join['table'], $join['on'], $join['type'] ?? 'inner');  // Default to inner join
        }

        // Apply filters dynamically (support for various operators)
        foreach ($filters as $column => $value) {
            if ($value !== null && $value !== '') {
                // Check for operators like '>', '<', '=', 'LIKE', etc.
                if (is_array($value)) {
                    $builder->whereIn($column, $value);  // For "in" operator
                } elseif (strpos($value, '%') !== false) {
                    $builder->like($column, $value);  // For LIKE operator
                } else {
                    $builder->where($column, $value);  // For basic equality check
                }
            }
        }

        // Apply ordering
        if (!empty($orderColumn)) {
            $builder->orderBy($orderColumn, $orderDirection);
        }

        // Apply GROUP BY clause
        if (!empty($groupBy)) {
            $builder->groupBy($groupBy);
        }

        // Apply HAVING clause
        if (!empty($having)) {
            foreach ($having as $condition) {
                $builder->having($condition['column'], $condition['operator'], $condition['value']);
            }
        }

        // Return paginated results
        return $builder->paginate($perPage, 'page', $page);
    }

  
    public function getAllRecords($table, $columns = ['*'], $filters = [], $joins = [], $groupBy = [], $having = []) {
        $builder = $this->db->table($table)->select($columns);

        // Apply joins dynamically
        foreach ($joins as $join) {
            $builder->join($join['table'], $join['on'], $join['type'] ?? 'inner');
        }

        // Apply filters
        foreach ($filters as $column => $value) {
            if ($value !== null && $value !== '') {
                if (is_array($value)) {
                    $builder->whereIn($column, $value);  // For "in" operator
                } elseif (strpos($value, '%') !== false) {
                    $builder->like($column, $value);  // For LIKE operator
                } else {
                    $builder->where($column, $value);
                }
            }
        }

        // Apply GROUP BY clause
        if (!empty($groupBy)) {
            $builder->groupBy($groupBy);
        }

        // Apply HAVING clause
        if (!empty($having)) {
            foreach ($having as $condition) {
                $builder->having($condition['column'], $condition['operator'], $condition['value']);
            }
        }

        // Return all records matching the query
        return $builder->get()->getResult();
    }
}
