<?php
namespace App\Services;

use App\Traits\CrudOperations;

class UserService {
    use CrudOperations;

    protected $table = 'users';

    /**
     * Get filtered and paginated users list with multiple conditions.
     *
     * @param int $perPage
     * @param int $page
     * @param array $filters
     * @param array $joins
     * @param string $orderColumn
     * @param string $orderDirection
     * @param array $groupBy
     * @param array $having
     * @return array
     */
    public function getFilteredUsers($perPage = 10, $page = 1, $filters = [], $joins = [], $orderColumn = 'id', $orderDirection = 'asc', $groupBy = [], $having = []) {
        return $this->getFilteredPaginated($this->table, $perPage, $page, ['*'], $filters, $joins, $orderColumn, $orderDirection, $groupBy, $having);
    }

    /**
     * Get all users (no pagination) with complex queries.
     *
     * @param array $filters
     * @param array $joins
     * @param array $groupBy
     * @param array $having
     * @return array
     */
    public function getAllUsers($filters = [], $joins = [], $groupBy = [], $having = []) {
        return $this->getAllRecords($this->table, ['*'], $filters, $joins, $groupBy, $having);
    }
}
