<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsM;
use App\Models\LogM;
use Illuminate\Support\Facades\Auth;
use PDF;


class ProductsR extends Controller
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
            'activity' => 'User Melihat Halaman Produk'
        ]);


        $subtittle = "Products List";
        $productsM = ProductsM::all();
        return view('products', compact('productsM', 'subtittle'));  
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
            'activity' => 'User Di halaman Tambah Produk'
        ]);

        $subtittle = "Add Products Page";
        return view('products_create', compact('subtittle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'nama_produk' => 'required',
            'harga_produk' => 'required',
        ]);

        productsM::create($request->post());

        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Menambah Produk baru dengan nama ' . $request->nama_produk
          ]);

          
        return redirect()->route('products.index')->with('success', 'Produk Berhasil Ditambah');
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
            'activity' => 'User Di Halaman Edit Data Produk'
        ]);

        $products = productsM::find($id);
        $subtittle = "Edit Products Page";
        return view('products_edit', compact('products', 'subtittle'));
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
            'activity' => 'User Melakukan Proses Update Data Produk' . $request->nama_produk
        ]);

        $request->validate([
            'nama_produk' => 'required',
            'harga_produk' => 'required',
        ]);
        $data = request()->except(['_token', '_method', 'submit']);

        productsM::where('id',$id)->update($data);

        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Mengupdate Produk dengan ID ' . $id . ' untuk produk ' . $request->nama_produk
            ]);

            
        return redirect()->route('products.index')->with('success', 'Produk Berhasil Diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        {
    
            productsM::where('id',$id)->delete();

            $LogM = LogM::create([
                'id_user' => Auth::user()->id,
                'activity' => 'User Melakukan Penghapusan Data Produk ' . $products->nama_produk
               ]);
       
            return redirect()->route('products.index')->with('success', 'Produk Berhasil Dihapus');
        }    
    }

    public function pdf(){
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Mengunduh PDF Produk'
        ]);

        $productsM = productsM::all();
        //return view('pesertadidik_pdf', compact('products'));
        $pdf = PDF::loadview('products_pdf', ['productsM' => $productsM]);
        return $pdf->stream('products.pdf');
    }
}