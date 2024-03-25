<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\LogM;

use Illuminate\Http\Request;

class LogC extends Controller
{
    public function index()
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Melihat Halaman Log'
        ]);

        $subtittle = "Daftar Aktivitas";
        $LogM = LogM::select('users.*', 'log.*')->join('users', 'users.id', '=', 'log.id_user')->orderBy('log.created_at', 'desc')->get();
        return view('log', compact('LogM', 'subtittle'));
    }
}
