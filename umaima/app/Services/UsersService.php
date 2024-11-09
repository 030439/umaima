<?php

namespace App\Services;

use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Exception;
class UsersService
{
    use QueryTrait;

    protected $table;
    protected $request;

    public function __construct(Request $request)
    {
        $this->table = 'users'; // Define the table name for users
        $this->request = $request; // Inject Request
    }

    public function getUsersWithRoles()
{
    $perPage = $this->request->input('perPage', 10);
    $page = $this->request->input('page', 1);
    $orderColumn = $this->request->input('orderColumn');
    $orderDirection = $this->request->input('orderDirection', 'asc');
    $draw = $this->request->get('draw');
    $searchValue = $this->request->get('search')['value'];

    $filters = [];
    if (!empty($searchValue)) {
        $filters['users.name'] = '%' . $searchValue . '%';
    }

    // Define the joins for roles
    $joins = [
        [
            'table' => 'model_has_roles',
            'first' => 'users.id',
            'operator' => '=',
            'second' => 'model_has_roles.model_id'
        ],
        [
            'table' => 'roles',
            'first' => 'model_has_roles.role_id',
            'operator' => '=',
            'second' => 'roles.id'
        ]
    ];

    $result = $this->fetchRecords(
        $this->table,
        $perPage,
        $page,
        $filters,
        $joins,
        $orderColumn=!empty($orderColumn)?$orderColumn:"users.id",
        $orderDirection,
        [], // groupBy
        [], // having
        true, // paginate
        $draw
    );

    return [
        'data' => $result['data'],
        'recordsTotal' => $result['recordsTotal'],
        'recordsFiltered' => $result['recordsFiltered'],
        'draw' => $draw,
    ];
}


  





}
