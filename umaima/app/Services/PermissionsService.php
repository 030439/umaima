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
class PermissionsService
{
    use QueryTrait;

    protected $table;
    protected $request;

    public function __construct(Request $request)
    {
        $this->table = 'permissions'; // Define the table name for users
        $this->request = $request; // Inject Request
    }

    public function getAll()
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('length', 10);
        $page = $this->request->input('page', 1);
        $joins = $this->request->input('joins', []);
        $orderColumn = $this->request->input('orderColumn', 'id');
        $orderDirection = $this->request->input('orderDirection', 'asc');
        $groupBy = $this->request->input('groupBy', []);
        $having = $this->request->input('having', []);
        $paginate = $this->request->input('paginate', true);
        $draw=$this->request->get('draw');
        $searchValue = $this->request->get('search')['value']; // This is the value you want to search for

        // Initialize an array for the conditions
        $filters = [];

        if (!empty($searchValue)) {
            // Using an associative array instead of a nested array
            $filters['name'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
        }

        // Fetch the records using QueryTrait's fetchRecords method
        $result = $this->fetchRecords(
            $this->table,
            $columns=['*'],
            $conditions = [],
            $filters,
            $joins,
            $orderColumn,
            $orderDirection,
            $groupBy ,
            $having ,
            $perPage ,
            $page ,
            $paginate = true
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
        try {
            // Validate the request for a unique permission name
            $this->request->validate([
                'modalPermissionName' => 'required|unique:permissions,name'
            ]);

            // Create the permission if validation passes
            $permission = Permission::create([
                'name' => $this->request->modalPermissionName
            ]);

            // Prepare response in the expected DataTable format
            $response = [
                'message' => 'Permission created successfully!',
                 'success' => true
            ];

            // Return success response in DataTable format
            return response()->json($response);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Capture the validation error details
            $errors = $e->errors();

            // If the error is due to a duplicate permission name
            if (isset($errors['modalPermissionName']) && strpos($errors['modalPermissionName'][0], 'unique') !== false) {
                // Return a response with the same structure, but with error details
                $response = [
                    'message' => 'This permission name already exists.',
                    'success' => false,
                    'exception' => $errors
                ];

                return response()->json($response, 409); // 409 Conflict for duplicate permission
            }

            // Return a general validation failure response in DataTable format
            $response = [
                'message' => $e->getMessage(),
                'success' => false,
                'exception' => $errors
            ];

            return response()->json($response, 422); // 422 Unprocessable Entity for validation errors

        } catch (\Exception $e) {
            // Handle generic errors
            $response = [
                'message' => 'An unexpected error occurred. Please try again later.',
                'success' => false,
                'exception' => $e->getMessage() // Exception message for debugging
            ];

            return response()->json($response, 500); // 500 Internal Server Error for unexpected errors
        }
    }

    public function createRoleWithPermissions()
    {
        try {
            // The incoming request is already validated by StoreRoleRequest
            $validator = Validator::make($this->request->all(), [
                'modalRoleName' => 'required|string|unique:roles,name|max:255',
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id', // Ensures each permission ID exists in the permissions table
            ]);
        
            // If validation fails, return a response with errors
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); // Unprocessable Entity
            }
        
            // Retrieve validated data
            $roleName = $this->request->input('modalRoleName');
            $permissions_ = $this->request->input('permissions');

            // Start transaction
            DB::beginTransaction();

            // Step 1: Create the role
            $role = Role::create(['name' => $roleName]);
           

            // Step 2: Retrieve permissions by names
            $permissions = Permission::whereIn('id', $permissions_)->get();
           
            // Step 3: Attach permissions to the role
            $role->permissions()->attach($permissions);

            // Commit transaction
            DB::commit();

            // Return success response
            
            $response = [
                'message' => 'Role created successfully with permissions!',
                 'success' => true
            ];

            // Return success response in DataTable format
            return response()->json($response);
        } catch (Exception $e) {
            // Rollback transaction in case of error
            DB::rollBack();

            // Return error response
            $response = [
                'message' => 'An unexpected error occurred while creating the role.',
                 'success' => false
            ];

            // Return success response in DataTable format
            return response()->json($response);

        }
    }




}
