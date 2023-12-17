<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateRequest;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return Inertia::render('profile/index');
    }

    public function update(User $user,  UpdateRequest $request)
    {
        if(!$request == null){
            if($request->password == null){
                $user->update($request->except('password'));    
            }else{
                $user->update([
                    'name' => $request->name,
                    'lastname' => $request->lastname,
                    'direction' => $request->direction,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                ]);    
            }
            return redirect()->back()->with('message', [
                'title'=> 'Exitoso!',
                'type' => 'success',
                'text' => 'Perfil actualizado!',
            ]);
        }

    }
}
