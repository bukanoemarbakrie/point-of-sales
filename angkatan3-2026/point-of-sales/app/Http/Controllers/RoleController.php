<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Role';
        $roles = Role::orderBy('id', 'DESC')->get();
        return view('role.index', compact('title', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create New Role';
        return view('role.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'is_active' => 'required|in:0,1'
        ]);

        Role::create([
            'name' => $request->name,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('role.index')->with('success', 'Role created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Edit Role";
        $role = Role::findOrFail($id);
        return view('role.edit', compact('role', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        // Cegah update Administrator role name
        if ($role->name == 'Administrator' && $request->name != 'Administrator') {
            return redirect()->route('role.index')->with('error', 'Administrator role name cannot be changed!');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'is_active' => 'required|in:0,1'
        ]);

        $role->update([
            'name' => $request->name,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('role.index')->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        // Cegah penghapusan Administrator role
        if ($role->name == 'Administrator') {
            return redirect()->route('role.index')->with('error', 'Administrator role cannot be deleted!');
        }

        $role->delete();

        return redirect()->route('role.index')->with('success', 'Role deleted successfully!');
    }
}
