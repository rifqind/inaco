<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\MenuNavigation;
use App\Models\MenuNavigationTranslation;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    public function roleIndex()
    {
        $query = Roles::query();
        $data = $query->get();
        foreach ($data as $key => $value) {
            # code...
            $roles_permissions = DB::table('roles_permissions')->where('role_id', $value->id)->pluck('permission_id');
            $value->permissions = DB::table('permissions')->whereIn('id', $roles_permissions)->pluck('permission_name')->toArray();
            // $value->permissions = implode(', ', $permissions);
        }
        return view('cms.user.list_role', [
            'data' => $data,
        ]);
    }

    public function permissionIndex()
    {
        $data = DB::table('permissions')->get();
        return view('cms.user.list_permissions', [
            'data' => $data
        ]);
    }

    public function index()
    {
        $query = User::query();
        $query->join('roles as r', 'r.id', '=', 'users.role_id');
        $query->select([
            'users.*',
            'r.role_name'
        ]);
        $data = $query->get();
        return view('cms.user.list_user', [
            'data' => $data
        ]);
    }

    public function roleCreate(Request $request)
    {
        if ($request->isMethod('get')) {
            $permissions = DB::table('permissions')->get(['id', 'permission_name']);
            return view('cms.user.create_role', [
                'permissions' => $permissions
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate([
                    'role_name' => 'string|required|unique:roles',
                    'role_status' => 'integer|required',
                    'permission_id.*' => 'integer',
                    'permission_id' => 'required'
                ]);
                $insertRole = Roles::create([
                    'role_name' => $data['role_name'],
                    'role_status' => $data['role_status']
                ]);
                foreach ($data['permission_id'] as $key => $value) {
                    # code...
                    DB::table('roles_permissions')->insert([
                        'role_id' => $insertRole->id,
                        'permission_id' => $value
                    ]);
                }
                DB::commit();
                return response()->json(['message' => 'Success']);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                return response()->json([
                    'error' => 'Error when storing data! ' . $th->getMessage()
                ]);
            }
        }
    }

    public function permissionCreate(Request $request)
    {
        if ($request->isMethod('get')) {
            $menu = MenuNavigation::where('parent_menu', 0)->get();
            foreach ($menu as $key => $value) {
                # code...
                //search available languague, english is priority
                $getData = MenuNavigationTranslation::where('menu_id', $value->menu_id)->get();
                //check if language with code en exists if isnt exist get first row
                $translation = $getData->firstWhere('language_code', 'en');
                if (!$translation) $translation = $getData->first();
                $value->menu_title = $translation->menu_title;
            }

            return view('cms.user.create_permission', [
                'menu' => $menu,
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate(['permission_name' => ['required', 'unique:permissions']]);
                DB::table('permissions')->insert($data);
                DB::commit();
                return response()->json(['message' => 'Success']);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                return response()->json([
                    'error' => 'Error when storing data! ' . $th->getMessage()
                ]);
            }
        }
    }

    public function create(Request $request, String $id = null)
    {
        if ($request->isMethod('get')) {
            $roles = Roles::get();
            return view('cms.user.create_user', [
                'roles' => $roles
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate([
                    'email' => ['required', 'email', 'unique:users,email'],
                    'password' => ['required', 'confirmed', Password::defaults()],
                    'name' => ['required', 'string', 'max:100'],
                    'role_id' => ['nullable', 'integer'],
                    'user_status' => ['integer', 'required'],
                ]);
                User::create([
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'name' => $data['name'],
                    'role_id' => $data['role_id'],
                    'user_status' => $data['user_status']
                ]);
                DB::commit();
                return response()->json(['message' => 'Success']);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                return response()->json([
                    'error' => 'Error when storing data! ' . $th->getMessage()
                ]);
            }
        }
    }

    public function update(Request $request, String $id = null)
    {
        if ($request->isMethod('get')) {
            $roles = Roles::get();
            $data = User::where('id', $id)->first();
            return view('cms.user.update_user', [
                'roles' => $roles,
                'data' => $data
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate([
                    'id' => 'required|integer',
                    'email' => ['required', 'email', Rule::unique('users')->ignore($request->id)],
                    'password' => ['sometimes', 'nullable', 'confirmed', Password::defaults()],
                    'name' => ['required', 'string', 'max:100'],
                    'role_id' => ['nullable', 'integer'],
                    'user_status' => ['integer', 'required'],
                ]);
                User::where('id', $data['id'])->update([
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'name' => $data['name'],
                    'role_id' => $data['role_id'],
                    'user_status' => $data['user_status']
                ]);
                DB::commit();
                return response()->json(['message' => 'Success']);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                return response()->json([
                    'error' => 'Error when updating data! ' . $th->getMessage()
                ]);
            }
        }
    }
    public function updateRole(Request $request, String $id = null)
    {
        if ($request->isMethod('get')) {
            $data = Roles::where('id', $id)->first();
            $permissions = DB::table('permissions')->get(['id', 'permission_name']);
            $permission_list = DB::table('roles_permissions')->pluck('permission_id')->toArray();
            return view('cms.user.update_role', [
                'permissions' => $permissions,
                'data' => $data,
                'roles_permissions' => $permission_list
            ]);
        } else if ($request->isMethod('post')) {
            try {
                //code...
                DB::beginTransaction();
                $data = $request->validate([
                    'id' => 'integer|required',
                    'role_name' => ['string', 'required', Rule::unique('roles')->ignore($request->id)],
                    'role_status' => 'integer|required',
                    'permission_id.*' => 'integer',
                    'permission_id' => 'required'
                ]);
                $updateRole = Roles::where('id', $data['id'])
                    ->update([
                        'role_name' => $data['role_name'],
                        'role_status' => $data['role_status']
                    ]);
                $deleteRolePermission = DB::table('roles_permissions')
                    ->where('role_id', $data['id'])
                    ->delete();
                foreach ($data['permission_id'] as $key => $value) {
                    # code...
                    DB::table('roles_permissions')->insert([
                        'role_id' => $data['id'],
                        'permission_id' => $value
                    ]);
                }
                DB::commit();
                return response()->json(['message' => 'Success']);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                return response()->json([
                    'error' => 'Error when updating data! ' . $th->getMessage()
                ]);
            }
        }
    }

    public function permissionDestroy(String $id)
    {
        try {
            //code...
            DB::beginTransaction();
            DB::table('permissions')->where('id', $id)->delete();
            DB::commit();
            return response()->json([
                'message' => 'Successfully deleted'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'error' => 'Error while deleting ' . $th->getMessage()
            ]);
        }
    }

    public function roleDestroy(String $id)
    {
        try {
            //code...
            DB::beginTransaction();
            DB::table('roles')->where('id', $id)->delete();
            DB::table('roles_permissions')->where('role_id', $id)->delete();
            DB::commit();
            return response()->json([
                'message' => 'Successfully deleted'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'error' => 'Error while deleting ' . $th->getMessage()
            ]);
        }
    }
    public function destroy(String $id)
    {
        try {
            //code...
            DB::beginTransaction();
            DB::table('users')->where('id', $id)->delete();
            DB::commit();
            return response()->json([
                'message' => 'Successfully deleted'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'error' => 'Error while deleting ' . $th->getMessage()
            ]);
        }
    }
}
