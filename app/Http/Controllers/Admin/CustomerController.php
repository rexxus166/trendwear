<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        // ... (Code index sama seperti sebelumnya) ...
        $query = User::where('role', 'user');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != 'All Status') {
            $query->where('status', strtolower($request->status));
        }

        $customers = $query->latest()->paginate(10);

        $stats = [
            'total' => User::where('role', 'user')->count(),
            'new_this_month' => User::where('role', 'user')->whereMonth('created_at', now()->month)->count(),
            'active' => User::where('role', 'user')->where('status', 'active')->count(),
            'blocked' => User::where('role', 'user')->where('status', 'blocked')->count(),
        ];

        return view('page.admin.pelanggan.index', compact('customers', 'stats'));
    }

    // --- FITUR BARU: TAMBAH CUSTOMER MANUAL ---
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8', // Password wajib saat create
            'status' => 'required|in:active,inactive,blocked',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user', // Pastikan role selalu user
            'status' => $request->status,
        ]);

        return back()->with('success', 'Customer created successfully.');
    }

    // --- FITUR BARU: EDIT CUSTOMER ---
    public function update(Request $request, $id)
    {
        $user = User::where('role', 'user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8', // Password opsional saat edit
            'status' => 'required|in:active,inactive,blocked',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
        ];

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        // ... (Code destroy sama seperti sebelumnya) ...
        $user = User::findOrFail($id);
        if ($user->role === 'admin') return back()->with('error', 'Cannot delete admin.');
        $user->delete();
        return back()->with('success', 'Customer deleted successfully.');
    }
}
