<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

use function PHPUnit\Framework\returnValue;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tittle = "Data Role";
        $roles = Role::get();
        return view('role.index', compact('tittle', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tittle = "Create New Role";
        return view('Role.create', compact('tittle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        Role::create([
            'name' => $request->name,
        ]);

        Alert::success('Success', 'Role created successfully');
        return redirect()->route('role.index');
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
        $tittle = 'Edit Role';
        $role = Role::find($id); //select * from $roles where id='$id'
        return view('role.edit', compact('tittle', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' .$id,
        ]);

        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();

        Alert::success('Success', 'Role updated successfully');
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id); //select * from role where id= '$id'
        $role->delete();
        Alert::success('Success', 'Role deleted successfully');
        return redirect()->route('role.index');
    }
}
