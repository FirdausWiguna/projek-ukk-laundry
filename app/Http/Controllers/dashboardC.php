<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\LogM;
use App\Models\ProductsM;
use App\Models\TransactionsM;
use App\Models\User;

class dashboardC extends Controller
{
    public function index()
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Melihat Halaman Dashboard'
        ]);
        $totaluser = User::count();
        $totalproduk =ProductsM::count();
        $totaltransaksi = TransactionsM::count();
        $totaluangbayar = DB::table('transactions')
            ->sum('uang_bayar');
        $subtittle = "Dashboard";
        return view('dashboard', compact('LogM','totaluser','totaltransaksi','totalproduk','totaluangbayar', 'subtittle'));
    
    }
}