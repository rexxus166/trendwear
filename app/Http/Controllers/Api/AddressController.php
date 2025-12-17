<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\UserAddress; // Pastikan Model UserAddress sudah dibuat!

class AddressController extends Controller
{
    // 1. AMBIL ALAMAT UTAMA
    public function getPrimaryAddress(Request $request)
    {
        // Cari alamat yg is_primary = 1 milik user ini
        $address = DB::table('user_addresses')
            ->where('user_id', $request->user()->id)
            ->where('is_primary', true)
            ->first();

        // Kalau gak ada yg primary, ambil sembarang alamat pertama
        if (!$address) {
            $address = DB::table('user_addresses')
                ->where('user_id', $request->user()->id)
                ->first();
        }

        if (!$address) {
            return response()->json(['message' => 'Alamat belum diatur', 'data' => null], 404);
        }

        return response()->json(['message' => 'Alamat ditemukan', 'data' => $address]);
    }

    // 2. SIMPAN ALAMAT BARU
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipient_name' => 'required|string',
            'phone_number' => 'required|string',
            'address_line1' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'village' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cek apakah ini alamat pertama? Kalau iya, jadikan primary otomatis
        $count = DB::table('user_addresses')->where('user_id', $request->user()->id)->count();
        $isPrimary = $count === 0 ? true : false;

        $address = DB::table('user_addresses')->insert([
            'user_id' => $request->user()->id,
            'recipient_name' => $request->recipient_name,
            'phone_number' => $request->phone_number,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2 ?? null,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'village' => $request->village,
            'postal_code' => $request->postal_code,
            'is_primary' => $isPrimary,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Alamat berhasil disimpan'], 201);
    }
}
