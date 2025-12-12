<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    public function receive(Request $request)
    {
        // 1. Ambil data notifikasi dari Midtrans
        $notification = $request->all();

        // Log untuk debugging (Cek di storage/logs/laravel.log)
        Log::info('Midtrans Notification:', $notification);

        // 2. Ambil variabel penting
        $status = $notification['transaction_status'];
        $type = $notification['payment_type'];
        $orderId = $notification['order_id'];
        $fraud = $notification['fraud_status'];
        $grossAmount = $notification['gross_amount']; // Penting untuk validasi signature

        // 3. Validasi Signature Key (KEAMANAN)
        // Rumus: SHA512(order_id + status_code + gross_amount + ServerKey)
        // Server Key ada di .env
        $serverKey = env('MIDTRANS_SERVER_KEY');

        // Ambil status code (biasanya 200, 201, 202, dll) dari payload, kalau tidak ada string kosong
        $statusCode = $notification['status_code'];

        $inputSignature = $notification['signature_key'];

        // Generate signature versi kita untuk dicocokkan
        $mySignature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

        if ($inputSignature !== $mySignature) {
            Log::error("Midtrans Signature Invalid: Order ID $orderId");
            return response()->json(['message' => 'Invalid Signature'], 403);
        }

        // 4. Cari Order di Database
        // Pastikan kolom di DB kamu menampung string order_id dari Midtrans (cth: TRX-1729...)
        $order = Order::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 5. Update Status Berdasarkan Response Midtrans
        // Sesuaikan 'status' dengan nama kolom di tabel orders kamu (misal: 'payment_status' atau 'status')

        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $order->update(['status' => 'pending']);
                } else {
                    $order->update(['status' => 'paid']); // Sukses CC
                }
            }
        } else if ($status == 'settlement') {
            // INI YANG PALING UMUM (Transfer, Gopay, QRIS sukses masuk sini)
            $order->update(['status' => 'paid']);
        } else if ($status == 'pending') {
            $order->update(['status' => 'pending']);
        } else if ($status == 'deny') {
            $order->update(['status' => 'failed']);
        } else if ($status == 'expire') {
            $order->update(['status' => 'expired']);
        } else if ($status == 'cancel') {
            $order->update(['status' => 'cancelled']);
        }

        return response()->json(['message' => 'Callback received successfully']);
    }
}
