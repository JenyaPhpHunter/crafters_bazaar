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
            'title' => 'required|unique:roles|max:35',
        ]);

        $roles = new Role();
        $roles->title = $request->post('title');

        $roles->save();

        return redirect(route('admin_roles.index'));
    }

    public function show($id)
    {
        $role= Role::query()->with('users')
            ->where('id',$id)->first();
        return view('admin.roles.show',[
            'admin_role' => $id,
        ]);
    }

    public function edit($id)
    {
        $role = Role::query()->with('users')->where('id',$id)->first();
        if(!$role){
            throw new \Exception('Role not found');
        }
        return view('admin.roles.edit', ['admin_role' => $role]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|unique:roles,title,' . $id . '|max:35',
        ]);

        $role = Role::query()->where('id',$id)->first();
        $role->title = $request->post('title');

        $role->save();

        return redirect( route('admin.roles.show', ['admin_role' => $id]));
    }

    public function destroy($id)
    {
        $role = Role::query()->where('id',$id)->delete();
        return redirect( route('roles.index'));
    }
}
