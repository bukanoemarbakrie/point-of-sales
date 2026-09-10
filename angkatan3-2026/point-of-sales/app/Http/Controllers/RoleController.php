<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $title = 'Data Role';
        $roles = Role::orderBy('id', 'DESC')->get();
        return view('role.index', compact('title', 'roles'));
    }

    public function create()
    {
        $title = 'Create New Role';
        return view('role.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        Role::create([
            'name' => $request->name,
        ]);

        return redirect()->route('role.index')->with('success', 'Role created successfully!');
    }

    public function edit(string $id)
    {
        $title = "Edit Role";
        $role = Role::findOrFail($id);
        return view('role.edit', compact('role', 'title'));
    }

    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        return redirect()->route('role.index')->with('success', 'Role updated successfully!');
    }

    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        if ($role->name == 'Administrator') {
            return redirect()->route('role.index')->with('error', 'Administrator role cannot be deleted!');
        }

        $role->delete();

        return redirect()->route('role.index')->with('success', 'Role deleted successfully!');
    }
}
