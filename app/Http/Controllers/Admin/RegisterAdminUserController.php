<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterAdminUserController extends Controller
{
    public function index()
    {
        $adminUsers = User::where('user_type', 'admin')->get();
        return view('admin.admin-users', compact('adminUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'admin',
        ]);

        return to_route('admin.register-admin-user.index')->with('status', "admin-created");
    }

    public function destroy(User $admin) {
        $admin->delete();
        return back()->with('status', "admin-destroyed");
    }
}
