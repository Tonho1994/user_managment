<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
            $user->password=Hash::make($validated['password']);
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
