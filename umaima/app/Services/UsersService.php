<?php

namespace App\Services;

use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use App\Models\User;
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
            'type'=>'join',
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
        $columns = ['*'],
        $conditions = [],
        $filters,
        $joins,
        $orderColumn = 'users.id',
        $orderDirection = 'asc',
        $groupBy = [],
        $having = [],
        $perPage ,
        $page = 1,
        $paginate = true        
    );

    return [
        'data' => $result['data'],
        'recordsTotal' => $result['recordsTotal'],
        'recordsFiltered' => $result['recordsFiltered'],
        'draw' => $draw,
    ];
}
public function getSingleUser(){
    $user = User::find($this->request->id);
    if($user){
        $userDetails = $user->toArray(); 
        $roleNames = $user->getRoleNames();
         $roleName = $roleNames->first();
        $userDetails['roles'] = $roleName;
        return response()->json(['success' => true, 'user' => $userDetails], 200);
    }
    return response()->json(['success' => false, 'user' => "User not Found"], 403);
    

}


  





}
