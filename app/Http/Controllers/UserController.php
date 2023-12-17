<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = new User();

        if($request->has('sortBy')){
            if($request->get('sortDesc') === 'true'){
                $user = $user->orderBy($request->get('sortBy'), 'desc');
            }else{
                $user = $user->orderBy($request->get('sortBy'), 'asc');
            }
        }else{
            $user = $user->orderBy('id', 'desc');
        }


        if($request->has('itemsPerPage')){
            $itemsPerPage = $request->get('itemsPerPage');
        }else{
            $itemsPerPage = 15;
        }

        $search = $request->get('search');

        $user = $user->where(function($query) use ($search){
            $query->whereHas('roles', function ($query) use ($search){
                $query->where('name', 'LIKE', "%$search%");
            });
            $query->orWhere('name', 'LIKE', "%$search%");
            $query->orWhere('lastname', 'LIKE', "%$search%");
        })->orderBy('id', 'desc')
        ->paginate($itemsPerPage);

        return Inertia::render('users/index', [
            'users' => $user,
            'roles' => Role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->direction = $request->direction;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->syncRoles($request->role_id);

        return redirect()->back()->with('message', [
            'title'=> 'Exitoso!',
            'type' => 'success',
            'text' => 'Se ha registrado el usuario',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return Inertia::render('users/show', [
            'user' => $user,
            'user_permission' => $user->permissions,
            'user_permissions_by_role' => $user->getPermissionsViaRoles(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateRequest $request)
    {
        if(!$request == null){
            if($request->password == null){
                $user->update($request->except('password', 'role_id'));  
                $user->syncRoles(collect($request->role_id)->pluck('id')->toArray());
            }else{
                $user->update([
                    'name' => $request->name,
                    'lastname' => $request->lastname,
                    'direction' => $request->direction,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                ]);    
                $user->syncRoles(collect($request->role_id)->pluck('id')->toArray());
            }
            return redirect()->back()->with('message', [
                'title'=> 'Exitoso!',
                'type' => 'success',
                'text' => 'Se ha actualizado el usuario',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('message', [
            'title'=> 'Exitoso!',
            'type' => 'success',
            'text' => 'Se ha eliminado el usuario',
        ]);
    }

    public function user_permissions(User $user){
        return Inertia::render('users/permissions', [
            'user' => $user,
            'user_permission' => $user->permissions,
            'user_permissions_by_role' => $user->getPermissionsViaRoles(),
            'permissions' => Permission::all()
        ]);
    }

    public function update_permissions(Request $request, User $user){
        if($request->has('permissions')){
            $user->givePermissionTo(collect($request->permissions)->pluck('id')->toArray());
        }
        $user->syncPermissions(collect($request->permissions)->pluck('id')->toArray());

        return redirect()->route('users.show', $user);
    }
}
