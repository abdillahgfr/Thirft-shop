<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Cart;
use App\Transaction;
use App\TransactionDetail;

use Exception;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        //Save Users Data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        //Proses Checkout
        $code = 'THRFT-' . mt_rand(000000, 999999);
        $carts = Cart::with(['product', 'user'])
            ->where('users_id',  Auth::user()->id)
            ->get();

        //Transaction Create
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'insurance_price' => 0,
            'shipping_price	' => 0,
            'total_price' => $request->total_price,
            'transaction_status' => 'PENDING',
            'code' => $code
        ]);

        //Transaction Detail
        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(000000, 999999);

            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'price' => $cart->product->price,
                'shipping_status' => 'PENDING',
                'resi' => '',
                'code' => $trx,
            ]);
        }

        //Delete Cart Data
        Cart::where('users_id', Auth::user()->id)->delete();

        //Konfigurasi Midtrans
        // Set your Merchant Server Key
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.IsProduction');
        Config::$isSanitized = config('services.midtrans.IsSanitized');
        Config::$is3ds = config('services.midtrans.Is3ds');

        //Buat array untuk dikirim ke midtrans

        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone_number,
            ],
            "billing_address" => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone_number,
                'address' => Auth::user()->address_one,
                'postal_code' => Auth::user()->zip_code,
                'country_code' => Auth::user()->country
            ],
            'shipping_address' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone_number,
                'address' => Auth::user()->address_one,
                'city' => Auth::user()->city,
                'postal_code' => Auth::user()->zip_code,
            ],
            'enabled_payments' => [
                'gopay', 'indomaret', 'bank_transfer', 'shopeepay', 'bca_klikbca', 'akulaku'
            ],
            'vtweb' => []

        ];


        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function callback(Request $request)
    {
        // Set Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.IsProduction');
        Config::$isSanitized = config('services.midtrans.IsSanitized');
        Config::$is3ds = config('services.midtrans.Is3ds');

        // Intance Midtrans Notification
        $notif = new Notification();

        // Asign ke variable
        $status = $notif->transaction_status;
        $type = $notif->payment_type;
        $fraud = $notif->fraud_status;
        $order_id = $notif->order_id;

        // Cari transaksi berdasarkan ID
        $transaction = Transaction::where('code', $order_id)->firstOrFail();

        // Handle notification status midtrans
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaction->transaction_status = 'PENDING';
                } else {
                    $transaction->transaction_status = 'SUCCESS';
                }
            }
        } else if ($status == 'settlement') {
            $transaction->transaction_status = 'SUCCESS';
        } else if ($status == 'pending') {
            $transaction->transaction_status = 'PENDING';
        } else if ($status == 'deny') {
            $transaction->transaction_status = 'CANCELLED';
        } else if ($status == 'expire') {
            $transaction->transaction_status = 'CANCELLED';
        } else if ($status == 'cancel') {
            $transaction->transaction_status = 'CANCELLED';
        }

        // Simpan transaksi
        $transaction->save();


        // Kirimkan email
        if ($transaction) {
            if ($status == 'capture' && $fraud == 'accept') {
                //
            } else if ($status == 'settlement') {
                //
            } else if ($status == 'success') {
                //
            } else if ($status == 'capture' && $fraud == 'challenge') {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment Challenge'
                    ]
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment not Settlement'
                    ]
                ]);
            }

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Midtrans Notification Success'
                ]
            ]);
        }
    }


    public function success(Request $request)
    {
        return view('pages.success');
    }


    public function unfinish(Request $request)
    {
        return view('checkout.unfinish');
    }

    public function error(Request $request)
    {
        return view('checkout.error');
    }
}
