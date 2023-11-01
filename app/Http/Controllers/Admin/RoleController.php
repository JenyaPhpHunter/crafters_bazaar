<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::query()->with('users')->orderBy('id')->get();
        return view('admin.roles.index',[
            "roles" => $roles,
        ]);
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles|max:35',
        ]);

        $roles = new Role();
        $roles->name = $request->post('name');

        $roles->save();

        return redirect(route('admin_roles.index'));
    }

    public function show($id)
    {
        $role= Role::query()->with('users')
            ->where('id',$id)->first();
        return view('admin.roles.show',[
            'role' => $role,
        ]);
    }

    public function edit($id)
    {
        $role = Role::query()->with('users')->where('id',$id)->first();
        if(!$role){
            throw new \Exception('Role not found');
        }
        return view('admin.roles.edit', ['role' => $role]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles|max:35',
        ]);

        $role = Role::query()->where('id',$id)->first();
        $role->name = $request->post('name');

        $role->save();

        return redirect( route('roles.show', ['role' => $id]));
    }

    public function destroy($id)
    {
        $role = Role::query()->where('id',$id)->delete();
        return redirect( route('roles.index'));
    }
}
