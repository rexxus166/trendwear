<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    // Menampilkan halaman daftar alamat
    public function index()
    {
        $addresses = UserAddress::where('user_id', Auth::id())
            ->orderBy('is_primary', 'desc') // Utamakan alamat utama di paling atas
            ->latest()
            ->get();

        return view('page.profile.address', compact('addresses'));
    }

    // Menyimpan alamat baru
    public function store(Request $request)
    {
        // Cek batasan max 3 alamat
        $count = UserAddress::where('user_id', Auth::id())->count();
        if ($count >= 3) {
            return back()->with('error', 'Maksimal 3 alamat tersimpan. Hapus salah satu untuk menambah baru.');
        }

        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address_line1' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'village' => 'required|string',
            'postal_code' => 'required|numeric',
            'label' => 'required|string|max:50',
        ]);

        DB::transaction(function () use ($request, $count) {
            // Jika ini alamat pertama, otomatis jadi primary
            $isPrimary = $count === 0 ? true : ($request->has('is_primary') ? true : false);

            // Jika user set sebagai primary, reset alamat lain dulu
            if ($isPrimary) {
                UserAddress::where('user_id', Auth::id())->update(['is_primary' => false]);
            }

            UserAddress::create([
                'user_id' => Auth::id(),
                'recipient_name' => $request->recipient_name,
                'phone_number' => $request->phone_number,
                'address_line1' => $request->address_line1,
                'address_line2' => $request->address_line2,
                'province' => $request->province,
                'city' => $request->city,
                'district' => $request->district,
                'village' => $request->village,
                'postal_code' => $request->postal_code,
                'label' => $request->label,
                'is_primary' => $isPrimary,
            ]);
        });

        return back()->with('success', 'Alamat berhasil ditambahkan!');
    }

    // Update alamat
    public function update(Request $request, $id)
    {
        $address = UserAddress::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address_line1' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'village' => 'required|string',
            'postal_code' => 'required|numeric',
            'label' => 'required|string|max:50',
        ]);

        DB::transaction(function () use ($request, $address) {
            // Logika ganti primary address
            if ($request->has('is_primary') && $request->is_primary) {
                UserAddress::where('user_id', Auth::id())->update(['is_primary' => false]);
                $address->is_primary = true;
            }

            $address->update([
                'recipient_name' => $request->recipient_name,
                'phone_number' => $request->phone_number,
                'address_line1' => $request->address_line1,
                'address_line2' => $request->address_line2,
                'province' => $request->province,
                'city' => $request->city,
                'district' => $request->district,
                'village' => $request->village,
                'postal_code' => $request->postal_code,
                'label' => $request->label,
                'is_primary' => $address->is_primary // Pertahankan status primary jika tidak diubah via checkbox, atau update jika logic di atas jalan
            ]);
        });

        return back()->with('success', 'Alamat berhasil diperbarui!');
    }

    // Set alamat sebagai Utama (lewat tombol khusus)
    public function setPrimary($id)
    {
        DB::transaction(function () use ($id) {
            UserAddress::where('user_id', Auth::id())->update(['is_primary' => false]);
            UserAddress::where('user_id', Auth::id())->where('id', $id)->update(['is_primary' => true]);
        });

        return back()->with('success', 'Alamat utama berhasil diubah!');
    }

    // Hapus alamat
    public function destroy($id)
    {
        $address = UserAddress::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        // Cegah hapus alamat utama jika masih ada alamat lain
        if ($address->is_primary && UserAddress::where('user_id', Auth::id())->count() > 1) {
            return back()->with('error', 'Tidak bisa menghapus alamat utama. Set alamat lain sebagai utama terlebih dahulu.');
        }

        $address->delete();
        return back()->with('success', 'Alamat berhasil dihapus.');
    }
}
