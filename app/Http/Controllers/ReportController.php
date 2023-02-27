<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index() {
        $user_id = Auth::id();
        
        $reports = DB::table('transaction_header')
        ->select('*', 'transaction_header.id as id_transaction')
        ->join('users', 'users.id', '=', 'transaction_header.id_user')->get();

        // dd($reports);

        return view('report-sales', compact('reports'));
    }
}
