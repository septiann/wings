<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $id_user = Auth::id();

        $checkout_data = DB::table('checkout')
        ->join('product', 'checkout.id_product', '=', 'product.id')
        ->where('id_user', $id_user)->get();

        return view('checkout', compact('checkout_data'));
    }

    public function store($code)
    {
        $id_user = Auth::id();

        $product = DB::table('product')->where('product_code', $code)->first();

        $checkout_data = DB::table('checkout')->where('id_user', $id_user)->where('id_product', $product->id)->first();

        if ($checkout_data != null) {
            $quantity = $checkout_data->quantity + 1;
            $price = $product->price * $quantity;

            $data = [
                'quantity' => $quantity,
                'subtotal' => $price,
            ];

            DB::table('checkout')->where('id_user', $id_user)->where('id_product', $product->id)->update($data);

            Alert::success('Success', 'Product added to checkout!');

            return redirect()->route('checkout');
        } else {
            $quantity = 1;
            $price = $product->price * $quantity;

            $data = [
                'id_user' => $id_user,
                'id_product' => $product->id,
                'quantity' => $quantity,
                'subtotal' => $price,
            ];

            DB::table('checkout')->insert($data);

            Alert::success('Success', 'Product added to checkout!');

            return redirect()->route('checkout');
        }
    }

    public function confirm(Request $request)
    {
        $id_user = Auth::id();
        $total = (int)$request->total;

        $checkout_data = DB::table('checkout')
        ->join('product', 'checkout.id_product', '=', 'product.id')
        ->where('id_user', $id_user)->get();

        /* $total = 0;
        foreach ($checkout_data as $data) {
            $total += $data->subtotal;
        } */

        $last_transaction = DB::table('transaction_header')->orderBy('id', 'desc')->first();

        if (!$last_transaction) {
            $document_number = "01";
        } else {
            $document_number = substr($last_transaction->document_number, 0, 2) + 1;
            $last_transaction->document_number = str_pad($document_number, 2, "0", STR_PAD_LEFT);
        }
        
        $data = [
            'document_code' => "TRX",
            'document_number' => $last_transaction->document_number,
            'id_user' => $id_user,
            'total' => $total,
            'date' => date('Y-m-d'),
        ];

        $id_transaction = DB::table('transaction_header')->insertGetId($data);

        foreach ($checkout_data as $data) {
            $data = [
                'id_transaction_header' => $id_transaction,
                'id_product' => $data->id_product,
                'quantity' => $data->quantity,
                'subtotal' => $data->subtotal
            ];

            DB::table('transaction_detail')->insert($data);
        }

        DB::table('checkout')->where('id_user', $id_user)->delete();

        Alert::success('Success', 'Transaction success!');

        return redirect()->route('reports');
    }
}
