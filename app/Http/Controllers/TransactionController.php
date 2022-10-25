<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
use Carbon\Carbon;
use App\Http\Traits\IpaymuSignatureTrait;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use Illuminate\Support\Str;
use Validator;

class TransactionController extends Controller
{
    public function check(Request $request) {
        $response = Http::post('https://www.smile.one/merchant/mobilelegends/checkrole', [
            'user_id' => $request->userid,
            'zone_id' => $request->zoneid,
            'pid' => 26,
            'checkrole' => 1
        ]);
        $result = $response->json();
        if($result['code'] != 200) {
            Session::flash('buy_failed', 'USER ID dan ZONE ID tidak ditemukan');
            return back();
        }
        $product = Product::join('categories', 'products.category_id', '=', 'categories.id')->find($request->product_id);
        if(!$product) {
            Session::flash('buy_failed', 'PRODUCT tidak ditemukan');
            return back();
        }
        $payment_method = PaymentMethod::find($request->payment_method_id);
        if(!$payment_method) {
            Session::flash('buy_failed', 'PAYMENT METHOD tidak ditemukan');
            return back();
        }

        $param = [
            "userid" => $request->userid,
            "zoneid" => $request->zoneid,
            "game_user_name" => $result['username'],
            "product" => $product,
            "payment_method" => $payment_method,
            "buyer_name" => $request->buyer_name,
            "whatsapp_number" => $request->whatsapp_number,
            "base_url" => url('/')
        ];
        return view('pages.product_confirm', $param);
    }
    
    public function buy(Request $request) {
        $response = Http::post('https://www.smile.one/merchant/mobilelegends/checkrole', [
            'user_id' => $request->userid,
            'zone_id' => $request->zoneid,
            'pid' => 26,
            'checkrole' => 1
        ]);
        $result = $response->json();
        if($result['code'] != 200) {
            Session::flash('buy_failed', 'USER ID dan ZONE ID tidak ditemukan');
            return back();
        }
        $product = Product::join('categories', 'products.category_id', '=', 'categories.id')->find($request->product_id);
        $payment_method = PaymentMethod::find($request->payment_method_id);
        $transaction = new Transaction;
        $transaction->uuid = Str::orderedUuid();
        $transaction->product_id = $request->product_id;
        $transaction->user_id = $request->userid;
        $transaction->zone_id = $request->zoneid;
        $transaction->name = $request->buyer_name;
        $transaction->whatsapp = $request->whatsapp_number;
        $transaction->nominal = $product->nominal;
        $transaction->price = $product->price;
        $transaction->payment_method_id = $request->payment_method_id;
        $transaction->status = "belum bayar";
        $transaction->save();
        

        //Harga product
        $prod[] = $product->name . ' ' . $product->nominal . ' diamond';
        $qty[] = 1;
        $price[] = $product->price;
        $desc[] = "Topup " . $product->nominal . " diamond";
        
        //Biaya fee
        $prod[] = "Fee";
        $qty[] = 1;
        if($payment_method->is_percent) {
            $price[] = $product->price * $payment_method->fee / 100;
        } else {
            $price[] = $payment_method->fee;
        }
        // $desc[] = "";
        $body = [
            "account" => IpaymuSignatureTrait::getVa(),
            "product" => $prod,
            "qty" => $qty,
            "price" => $price,
            // "description" => $desc,
            "returnUrl" => url('/') . "/transaction" . "/" . $transaction->uuid,
            "notifyUrl" => url('/') . "/api/transaction/validation/" . $transaction->uuid,
            "cancelUrl" => url('/') . "/transaction" . "/" . $transaction->uuid,
            "referenceId" => $transaction->uuid,
            "buyerName" => $request->buyer_name,
            "buyerPhone" => $request->whatsapp_number,
            "paymentMethod" => $payment_method->payment_method
        ];
        $sig = IpaymuSignatureTrait::makeSignature('POST', $body);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'signature' => $sig,
            'va' => IpaymuSignatureTrait::getVa(),
            'timestamps' => Carbon::now()->format('YYYYMMDDhhmmss')
        ])->post('https://sandbox.ipaymu.com/api/v2/payment', $body);
        $result_ipay = $response->json();
        if($result_ipay['Status'] == 200 && $result_ipay['Message'] == "success") {
            $transaction->session_id = $result_ipay["Data"]["SessionID"];
            $transaction->save();
            echo $result_ipay["Data"]["Url"];
            return redirect($result_ipay["Data"]["Url"]);
        } else {
            Session::flash('ipaymu_failed', 'Service IPAYMU sedang bermasalah');
            return back();
        }
    }

    private function sendMessage($uuid){
        $transaction = Transaction::where('uuid', $uuid)
        ->with(['PaymentMethod'])
        ->first();
        $response = Http::post('https://www.smile.one/merchant/mobilelegends/checkrole', [
            'user_id' => $transaction->user_id,
            'zone_id' => $transaction->zone_id,
            'pid' => 26,
            'checkrole' => 1
        ]);
        $result = $response->json();
        $key = "bot5243355329:AAGTo3UL5eBMOLQ_x4nFqlSLPansw85Fwos";
        $nama_pelanggan = $result['username'];
        $userid = $transaction->user_id . " (" . $transaction->zone_id . ")";
        $product = "Diamond Mobile Legend";
        $qty = $transaction->nominal;
        $price = $transaction->price;
        $text = "<b>Orderan baru oleh {$nama_pelanggan}</b>\nUSER ID : <b>{$userid}</b>\nProduct : <b>{$product}</b>\nJumlah Diamond : <b>{$qty}</b>\nHarga : <b>{$price}</b>";
        $request = Http::post('https://api.telegram.org/'.$key.'/sendMessage', [
            'chat_id' => -1001756536273,
            'text' => $text,
            'parse_mode' => 'HTML',
            'disable_web_page_preview'=> true,
        ]);
        // echo json_encode($request->json());
    }

    // public function tes($uuid) {
    //     $this->sendMessage($uuid);
    // }

    public function index(Request $request) {
        $transaction = Transaction::where('uuid', $request->uuid)
        ->with(['PaymentMethod'])
        ->first();
        if(!$transaction || $transaction->trx_id == null) {
            abort(404);
        }
        $param = [
            "transaction" => $transaction
        ];
        return view('pages.transaction', $param);
    }

    public function validation(Request $request) {
        $validator = Validator::make($request->all(),[
            "trx_id" => "required",
            "status" => "required"
        ]);
        if($validator->fails()){
            return response()->json("404", 404);
        }
        // disini memvalidasi apakah trx_id nya valid.
        $body = [
            "transactionId" => $request->trx_id
        ];
        $sig = IpaymuSignatureTrait::makeSignature('POST', $body);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'signature' => $sig,
            'va' => IpaymuSignatureTrait::getVa(),
            'timestamps' => Carbon::now()->format('YYYYMMDDhhmmss')
        ])->post('https://sandbox.ipaymu.com/api/v2/transaction', $body);
        $result_ipay = $response->json();

        if($result_ipay["Status"] != 200 || $result_ipay["Data"]["Status"] != 1) {
            return response()->json("404", 404);
        }

        $transaction = Transaction::where([
            'uuid' => $request->uuid,
            'session_id' => $request->sid
        ])->first();
        if(!$transaction || $transaction->status == 'sudah bayar') {
            return response()->json("404", 404);
        }
        $transaction->trx_id = $request->trx_id;
        if($request->status == 'berhasil') {
            $transaction->status = 'sudah bayar';
        } else if($request->status == 'gagal') {
            $transaction->status = 'gagal';
        } else {
            $transaction->status = 'pending';
        }
        $transaction->save();

        if($transaction->status == 'sudah bayar') {
            $this->sendMessage($request->uuid);
        }

        return response()->json("Berhasil diterima!", 200);
    }
}
