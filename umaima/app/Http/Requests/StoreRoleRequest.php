<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize()
    {
        // Ensure the user has permission to create a role
        return true; // You can modify this as needed
    }

    public function rules()
    {
        return [
            'roleName' => 'required|string|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name', // Validate permissions exist
        ];
    }

    public function messages()
    {
        return [
            'roleName.required' => 'Role name is required.',
            'roleName.unique' => 'This role name already exists.',
            'permissions.required' => 'At least one permission is required.',
            'permissions.*.exists' => 'One or more permissions are invalid.',
        ];
    }
}
