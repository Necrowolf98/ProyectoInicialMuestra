<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\UpdateRequest;
use App\Models\Role;
use Inertia\Inertia;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        $role = Role::with('permissions');

        if($request->has('sortBy')){
            if($request->get('sortDesc') === 'true'){
                $role = $role->orderBy($request->get('sortBy'), 'desc');
            }else{
                $role = $role->orderBy($request->get('sortBy'), 'asc');
            }
        }else{
            $role = $role->orderBy('id', 'desc');
        }


        if($request->has('itemsPerPage')){
            $itemsPerPage = $request->get('itemsPerPage');
        }else{
            $itemsPerPage = 15;
        }

        $search = $request->get('search');

        $role = $role->whereHas('permissions', function ($query) use ($search){
            $query->where('name', 'LIKE', "%$search%");
        })->orWhere('name', 'LIKE', "%$search%")->orderBy('id', 'desc')
        ->paginate($itemsPerPage);

        return Inertia::render('roles/index', [
            'roles' => $role,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions =  Permission::all();
        return Inertia::render('roles/create', [
            'permissions' => $permissions,  
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
            'guard_name' => 'web',
        ]);

        if ($request->has('permissions')) {
            $role->givePermissionTo(collect($request->permissions)->pluck('id')->toArray());
        }

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $role = Role::with('permissions')->findOrFail($role->id);
        return Inertia::render('roles/edit', [
            'role' => $role,
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Role $role)
    {
        if($request->has('permissions')){
            $role->givePermissionTo(collect($request->permissions)->pluck('id')->toArray());
        }
        $role->syncPermissions(collect($request->permissions)->pluck('id')->toArray());
        $role->update([ 'name' => $request->name, 'description' => $request->description ]);

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->back()->with('message', [
            'title'=> 'Exitoso!',
            'type' => 'success',
            'text' => 'Se ha eliminado el rol',
        ]);
    }
}
