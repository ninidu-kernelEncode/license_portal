<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('user.manage')) {
            $users = User::latest()->paginate(10);
            return view('users.index', compact('users'));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    public function create()
    {
        if (\Auth::user()->can('user.create')) {
        $roles = Role::all();
        return view('users.create', compact('roles'));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('user.create')) {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole($request->role);
            $log_description = "Created user ID - ". $user->id;
            create_log('Create user', $log_description, $user);
            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Failed to create User!');
        }
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    public function edit(User $user)
    {
        if (\Auth::user()->can('user.update')) {
        $roles = Role::all();
        return view('users.edit', compact('user','roles'));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    public function update(Request $request, User $user)
    {
        if (\Auth::user()->can('user.update')) {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $data = $request->only(['name', 'email']);
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            $user->assignRole($request->role);
            $log_description = "Updated User ID - ". $user->id;
            create_log('Update user', $log_description, $user);
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Failed to update User!');
        }
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }
    public function show(User $user)
    {
        if (\Auth::user()->can('user.view')) {
        return view('users.show', compact('user'));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    public function destroy(User $user)
    {
        if (\Auth::user()->can('user.delete')) {
        try {
            $user->delete();
            $log_description = "Deleted user ID - ". $user->id;
            create_log('Delete User', $log_description, $user);
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Failed to delete User!');
        }
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }
}
