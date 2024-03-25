<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LogM;    
use PDF;

class UsersR extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Melihat Halaman User'
        ]);

        $usersM = User::all();
        $subtittle = "Users List";
        return view('users', compact('usersM'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User di Halaman Tambah Data User'
        ]);

        $usersM = User::all();
        $subtittle = "Add user Page";
        return view('users_create', compact('subtittle', 'usersM'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Melakukan Proses Tambah Akun User'
        ]);

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
            'role' => 'required',
        ]);

        $users = new User([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        $users->save();

        return redirect()->route('users.index')->with('success', 'Users Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Di Halaman Edit Data User'
        ]);

        $users = User::find($id);
        $subtittle = "Edit Users Page";
        return view('users_edit', compact('users', 'subtittle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Melakukan Proses Edit Data User'
        ]);
        

        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'role' => 'required',
        ]);

        $users = User::find($id);
        $users->name = $request->input('name');
        $users->username = $request->input('username');
        $users->role = $request->input('role');
        $users->update();

        return redirect()->route('users.index')->with('success', 'Data Users Berhasil Diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $LogM = LogM::create([
            'id_user'=> Auth::user()->id,
            'activity'=> 'User Menghapus Data User'
        ]);

        User::where('id',$id)->delete();
        return redirect()->route('users.index')->with('success', 'Users Berhasil Dihapus');
    }

    public function pdf()
    {
        $LogM = LogM::create([
            'id_user'=> Auth::user()->id,
            'activity'=> 'User Mencetak PDF Data User'
        ]);
    
        $usersM = User::all();
        $pdf = PDF::loadview('users_pdf', ['usersM' => $usersM]);
        return $pdf->stream('users.pdf');
    }  

    public function changepassword($id)
    {
        $LogM = LogM::create([
            'id_user'=> Auth::user()->id,
            'activity'=> 'User di Halaman Ubah Password'
        ]);

        $users = User::find($id);
        $subtittle = "Edit Password Page";
        return view('users_changepassword', compact('users','subtittle'));
    }

    public function change(Request $request, $id){

        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Melakukan Proses Ganti Password Data User' 
        ]);

        $request->validate([
            'new_password' => 'required',
            'password_confirm' => 'required|same:new_password',
        ]);

        $users = User::where("id", $id)->first();
        $users->update([
            'password' => Hash::make($request->new_password),
        ]);
        
        return redirect()->route('users.index')->with('success', 'Password Berhasil Diedit');
    }
}
