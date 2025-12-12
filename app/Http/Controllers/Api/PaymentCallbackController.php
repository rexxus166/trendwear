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
        // 1. Ambil data notifikasi
        $notification = $request->all();

        Log::info('Midtrans Notification:', $notification);

        // 2. Ambil variabel penting
        $status = $notification['transaction_status'];
        $type = $notification['payment_type'];
        $orderId = $notification['order_id']; // Ini ID dari Midtrans (TRX-xxxxx)
        $fraud = $notification['fraud_status'];
        $grossAmount = $notification['gross_amount'];

        // 3. Validasi Signature Key (Wajib untuk Security)
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $statusCode = $notification['status_code'];
        $inputSignature = $notification['signature_key'];

        $mySignature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

        if ($inputSignature !== $mySignature) {
            Log::error("Midtrans Signature Invalid: Order ID $orderId");
            return response()->json(['message' => 'Invalid Signature'], 403);
        }

        // 4. Cari Order di Database
        // PERBAIKAN DI SINI: Gunakan 'order_number' bukan 'order_id'
        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            Log::error("Order not found: $orderId");
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Cek jika order sudah paid, abaikan saja (biar gak double update)
        if ($order->status == 'paid' || $order->status == 'processing') {
            return response()->json(['message' => 'Order already paid']);
        }

        // 5. Update Status Berdasarkan Response Midtrans
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $order->update(['status' => 'pending']);
                } else {
                    $order->update(['status' => 'paid']);
                }
            }
        } else if ($status == 'settlement') {
            // Sukses bayar (VA, QRIS, Gopay)
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
