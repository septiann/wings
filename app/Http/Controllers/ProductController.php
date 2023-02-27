<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index() {
        $products = DB::table('product')->get();

        return view('product-list', compact('products'));
    }

    public function show($code) {
        $product = DB::table('product')->where('product_code', $code)->first();

        return view('product-detail', compact('product'));
    }
}
