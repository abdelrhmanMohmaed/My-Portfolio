<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return response()->json([
            'users' => $users
        ], 200);
    }
    public function role()
    {
        $roles = Role::get();
        return response()->json([
            'roles' => $roles
        ], 200);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'bio' => 'required|string|',
            'password' => 'required|string|confirmed|min:5|max:25',
            'role_id' => 'required|exists:roles,id',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
        $user->role_id = $request->role_id;
        $user->photo = 'avatar.png';
        $user->password = Hash::make($request->password);
        $user->save();
    }

    public function delete(User $user)
    {
        return $user->delete();
    }
}
