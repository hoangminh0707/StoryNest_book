<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RolesAdminController extends Controller
{
    public function index()
    {

        $roles = Role::all();
        return view('admin.pages.Roles.listRoles', compact('roles'));
    }


    public function create()
    {
        return view('admin.pages.Roles.createRoles');
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        Role::create($request->all());

        return redirect()->route('admin.roleIndex')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.pages.Roles.editRoles', compact('role'));
    }


    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        $role->update($request->all());

        return redirect()->route('admin.roleIndex')->with('success', 'Role updated successfully.');
    }


    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.roleIndex')->with('success', 'Role deleted successfully.');
    }

}