<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'role:admin']);
    } //end of constructor

    public function index()
    {
        return User::latest()->paginate(10);
    } //end of index


    public function create()
    {
        return Role::get();
    } //end of create


    public function store(StoreUserRequest $request)
    {
        $user = User::create($this->getUserData($request));
        $user->syncRoles([$request->role]);
        return response()->json('success', 200);
    } //end of store


    public function edit(User $user)
    {
        return response()->json(['user' => $user, 'roles' => Role::get()]);
    } //end of edit


    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($this->getUserData($request));
        $user->syncRoles([$request->role]);
        return response()->json('success', 200);
    } //end of update


    public function destroy(User $user)
    {
        $user->detachRoles($user->getRoles());
        $user->delete();
    } //end of destroy


    public function getUserData($request)
    {
        $user_data = $request->except(['role', 'password']);
        $password = Hash::make($request->password);
        $user_data['password'] = $password;
        return $user_data;
    } //end of getUserData
}
