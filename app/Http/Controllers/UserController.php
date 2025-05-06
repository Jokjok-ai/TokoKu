<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        if (!Gate::allows('manage-users')) {
            abort(403);
        }

        $users = User::orderBy('name')->get();
        return view('users.index', [
            'users' => $users,
            'roles' => [
                User::ROLE_ADMIN => 'Admin',
                User::ROLE_SUPER_ADMIN => 'Super Admin'
            ]
        ]);
    }

    public function create()
    {
        if (!Gate::allows('manage-users')) {
            abort(403);
        }

        return view('users.create', [
            'roles' => [
                User::ROLE_ADMIN => 'Admin',
                User::ROLE_SUPER_ADMIN => 'Super Admin'
            ]
        ]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('manage-users')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'nullable|string|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:' . User::ROLE_ADMIN . ',' . User::ROLE_SUPER_ADMIN,
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat');
    }

    public function edit(User $user)
    {
        if (!Gate::allows('manage-users')) {
            abort(403);
        }

        return view('users.edit', [
            'user' => $user,
            'roles' => [
                User::ROLE_ADMIN => 'Admin',
                User::ROLE_SUPER_ADMIN => 'Super Admin'
            ]
        ]);
    }

    public function update(Request $request, User $user)
    {
        if (!Gate::allows('manage-users')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
    'role' => 'required|in:'.User::ROLE_ADMIN.','.User::ROLE_SUPER_ADMIN,
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'role' => $request->role,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        if (!Gate::allows('manage-users')) {
            abort(403);
        }

        if (auth()->id() === $user->id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }

    public function profile()
    {
        return view('users.profile', [
            'user' => auth()->user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'phone' => 'nullable|string|max:20',
    'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profile berhasil diupdate');
    }
}
