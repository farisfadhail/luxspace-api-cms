<?php

namespace App\Http\Controllers\API;

use Midtrans\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function callback()
    {
        // Set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');
        
        // Buat instance midtrans notification
        $notification = new Notification();

        // Assign ke variable untuk memudahkan coding
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // Get transaction ID
        $order = explode('-', $order_id); // ['LUX', 4]

        // Cari transaksi berdasarkan ID
        $transaction = Transaction::finOrFail($order[1]);

        // Handle notification status midtrans
        if($status == 'capture') {
            if($type == 'credit_card') {
                if($fraud == 'challenge') {
                    $transaction->status = 'PENDING';
                }
                else {
                    $transaction->status = 'SUCCESS';
                }
            }
        }

        else if($status == 'settlement') {
            $transaction->status = 'SUCCESS';
        }

        else if($status == 'pending') {
            $transaction->status = 'PENDING';
        }

        else if($status == 'deny') {
            $transaction->status = 'PENDING';
        }

        else if($status == 'expire') {
            $transaction->status = 'CANCELLED';
        }

        else if($status == 'cancel') {
            $transaction->status = 'CANCELLED';
        }

        // Simpan transaksi
        $transaction->save();

        // Return response untuk midtrans 
        return response()->json([
            'meta' => [
                'code' => 200,
                'message' => 'Midtrans Notification Success!'
            ]
        ]);
    }
}
