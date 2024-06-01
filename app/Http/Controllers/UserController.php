<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Users datatables
     */
    public function index()
    {
        //
        $roles = Role::all()->pluck('name');
        return view('users.index',compact('roles'));
    }

    /**
     * Create new user
     */
    public function create(UserCreateRequest $request)
    {
        //
        try {
            $validated = $request->validated();
            $user = User::create([
                'name'	=> $validated['name'],
                'email'	=> $validated['email'],
                'phone'	=> $validated['phone'],
                'password'	=> Hash::make($validated['password']),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
            $user->assignRole($validated['role']);
            return response()->json([
                'message'	=> 'User created',
            ],200);
        } catch (\Throwable $th) {
            Log::warning(__METHOD__."--->Line:".$th->getLine()."----->".$th->getMessage());
            return response()->json([
                'message'	=> 'UC-03',
            ],500);
        }
    }
    /**
     * Show card from to edit user
     */
    public function show(User $user)
    {
        $roles = Role::all()->pluck('name');
        foreach ($user->getRoleNames() as $role) {
            $user->role = $role;
        }
        return view('users.show',compact('user','roles'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request,User $user)
    {
        //
        try {
            $validated = $request->validated();
            $user->name=$validated['name'];
            $user->email=$validated['email'];
            $user->phone=$validated['phone'];
            if(isset($validated['password'])){
                $user->password=Hash::make($validated['password']);
            }
            $user->syncRoles([$validated['role']]);
            $user->save();
            return response()->json([
                'message'	=> 'User updated',
            ],200);
        } catch (\Throwable $th) {
            Log::warning(__METHOD__."--->Line:".$th->getLine()."----->".$th->getMessage());
            return response()->json([
                'message'	=> 'UC-01',
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        try {
            $user->delete();
            return response()->json([
                'message'	=> 'User deleted',
            ],200);
        } catch (\Throwable $th) {
            Log::warning(__METHOD__."--->Line:".$th->getLine()."----->".$th->getMessage());
            return response()->json([
                'message'	=> 'UC-02',
            ],500);
        }
    }
    /**
     * Gets the tada of all users
     */
    public function getUsers(Request $request)
    {
        $query = User::query();
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%$search%");
        }
        if ($sort = $request->input('sort')) {
            $direction = $request->input('order', 'asc');
            $query->orderBy($sort, $direction);
        }
        $users = $query->paginate($request->input('itemsPerPage', 15));
        return response()->json($users);
    }
}
