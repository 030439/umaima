<?php

namespace App\Services;

use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
class UserService
{
    use QueryTrait;

    protected $table;
    protected $request;

    public function __construct(Request $request)
    {
        $this->table = 'users'; // Define the table name for users
        $this->request = $request; // Inject Request
    }

    public function getUsers()
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('perPage', 10);
        $page = $this->request->input('page', 1);
        $filters = $this->request->input('filters', []);
        $joins = $this->request->input('joins', []);
        $orderColumn = $this->request->input('orderColumn', 'id');
        $orderDirection = $this->request->input('orderDirection', 'asc');
        $groupBy = $this->request->input('groupBy', []);
        $having = $this->request->input('having', []);
        $paginate = $this->request->input('paginate', true);
        $draw=$this->request->get('draw');

        // Fetch the records using QueryTrait's fetchRecords method
        $result = $this->fetchRecords(
            $this->table,
            $perPage,
            $page,
            $filters,
            $joins,
            $orderColumn,
            $orderDirection,
            $groupBy,
            $having,
            $paginate,
            $draw
        );

        // Return only the data if pagination is enabled, or full response if not paginated
        return[
            'data' => $result['data'],
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'draw' => $draw,
        ];
    }

    public function createPermission()
    {
       
        // Validate the request
        $this->request->validate([
            'modalPermissionName' => 'required|unique:permissions,name'
        ]);

        // Create the permission
        $permission = Permission::create([
            'name' => $this->request->modalPermissionName
        ]);
        // Return success response
        return [
            'success' => true,
            'message' => 'Permission created successfully.',
        ];
    }
}
