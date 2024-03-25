<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionsM;
use App\Models\ProductsM;
use App\Models\LogM;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;

class TransactionsR extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        public function index(Request $request){
            $LogM = LogM::create([
                'id_user' => Auth::user()->id,
                'activity' => 'User Melihat Halaman Transaksi'
            ]);

        $query = TransactionsM::select('transactions.*', 'products.*', 'transactions.id AS id_trans', 'transactions.created_at as createtrans')
            ->join('products', 'products.id', '=', 'transactions.id_produk')
            ->orderBy('transactions.id', 'desc');
        if ($request->filled('start_date') && $request->filled('end_date')) {
            // Jika kedua tanggal diisi, cari transaksi antara rentang tanggal
            $query->whereDate('transactions.created_at', '>=', $request->start_date)
                  ->whereDate('transactions.created_at', '<=', $request->end_date);
        } elseif ($request->filled('start_date')) {
            // Jika hanya tanggal awal diisi, cari transaksi pada tanggal awal
            $query->whereDate('transactions.created_at', '=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            // Jika hanya tanggal akhir diisi, cari transaksi pada tanggal akhir
            $query->whereDate('transactions.created_at', '=', $request->end_date);
        }

        $transactionsM = $query->get();


            $subtittle = "Daftar Transaksi";
            return view('transactions', compact('subtittle','transactionsM'));
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
            'activity' => 'User Di halaman Tambah Transaksi'
        ]);

        $subtittle = "Tambah Data Transaksi";
        $productsM = productsM::all();
        return view('transactions_create', compact('productsM', 'subtittle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $productsM = productsM::where("id", $request->input('id_produk'))->first();
        
        $request->validate([
            'nomor_unik' => 'required',
            'nama_pelanggan' => 'required',
            'id_produk' => 'required',
            'qty' => 'required|numeric|min:1', // Validasi qty sebagai angka positif
            'uang_bayar' => 'required',
        ]);
        
        // Hitung total harga berdasarkan harga produk dan qty
        $totalHarga = $productsM->harga_produk * $request->input('qty');
        
        $transaksi = new TransactionsM;
        $transaksi->nomor_unik = $request->input('nomor_unik');
        $transaksi->nama_pelanggan = $request->input('nama_pelanggan');
        $transaksi->id_produk = $request->input('id_produk');
        $transaksi->qty = $request->input('qty');
        $transaksi->uang_bayar = $request->input('uang_bayar');
        $transaksi->uang_kembali = $request->input('uang_bayar') - $totalHarga;
        $transaksi->total_harga = $totalHarga; // Simpan total harga ke dalam kolom total_harga
        $transaksi->status_pengambilan = false;
        $transaksi->save();
        
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Melakukan Proses Tambah Transaksi' . $request->nama_produk
        ]);
        // TransactionM::create($request->post());
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil di tambahkan');
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
            'activity' => 'User Di Halaman Edit Data Transaksi'
        ]);

        $subtittle = "Edit Transaksi";
        $transaksi = TransactionsM::find($id);
        $productsM = productsM::all();

        return view('transactions_edit', compact('subtittle', 'productsM', 'transaksi'));
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
        
        
        $request->validate([
            'nomor_unik' => 'required',
            'nama_pelanggan' => 'required',
            'id_produk' => 'required',
            'uang_bayar' => 'required',
            'qty' => 'required|integer|min:1', // Validasi qty
        ]);
        
        $productsM = productsM::where("id", $request->input('id_produk'))->first();
        $hargaProduk = ProductsM::find($request->input('id_produk'))->harga_produk;
        $totalHarga = $hargaProduk * $request->input('qty');
        
        $transaksi = TransactionsM::find($id);
        $transaksi->nomor_unik = $request->input('nomor_unik');
        $transaksi->nama_pelanggan = $request->input('nama_pelanggan');
        $transaksi->id_produk = $request->input('id_produk');
        $transaksi->uang_bayar = $request->input('uang_bayar');
        $transaksi->uang_kembali = $request->input('uang_bayar') - $totalHarga;
        $transaksi->qty = $request->input('qty'); // Simpan qty
        $transaksi->total_harga = $totalHarga; // Simpan total harga ke dalam kolom total_harga
        // Perbarui status pengambilan jika ada input yang diberikan
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Mengupdate Transaksi dengan ID ' . $id . ' untuk pelanggan ' . $transaksi->nama_pelanggan
        ]);

        $transaksi->status_pengambilan = $request->input('status_pengambilan', false);
        $transaksi->save();
        // transaksiM::create($request->post());
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil di perbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TransactionsM::where('id', $id)->delete();

        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Melakukan Penghapusan Data Transaksi ' . $transaksi->nama_pelanggan . ' dengan ID ' . $id
        ]);

        return redirect()->route('transactions.index')->with('success', 'Data Transaksi Berhasil Dihapus');
    }

    public function pdf(){

        $LogM = LogM::create([
            'id_user'=> Auth::user()->id,
            'activity'=> 'User Mencetak PDF Transaksi'
        ]);

        $transactionsM = TransactionsM::select('transactions.*', 'products.*', 'transactions.id AS id_trans', 'transactions.created_at as createtrans')
        ->join('products', 'products.id', '=', 'transactions.id_produk')->get();
        $pdf = PDF::loadview('transactions_pdf',['transactionsM' => $transactionsM])->setPaper('a4', 'landscape');;
        return $pdf->stream('transactions.pdf');
    }

    public function pdf2($id)
    {
        $LogM = LogM::create([
            'id_user'=> Auth::user()->id,
            'activity'=> 'User Mencetak PDF Struk'
        ]);
        // Ambil data transaksi dan produk berdasarkan ID
        $transaksi = TransactionsM::select('transactions.*', 'products.*', 'transactions.id AS id_trans')->join('products', 'products.id', '=', 'transactions.id_produk')->where('transactions.id', $id)->first();
    
        if ($transaksi) {
            // Jika data ditemukan, buat PDF
            $pdf = PDF::loadView('transactions_struk', ['transaksi' => $transaksi]);
            return $pdf->stream('transactions.struk' . $id . '.pdf');
        } else {
            // Jika data tidak ditemukan, Anda dapat mengembalikan respons yang sesuai, misalnya, halaman 404.
            return response('Data transaksi tidak ditemukan', 404);
        }
    }
    public function tgl()
    {
        $subtittle = "Transaksi PDF Berdasarkan Tanggal";
        return view('transactions_tgl', compact('subtittle'));
    }

    public function pertanggal(Request $request)
    {
        // Gunakan tanggal yang diterima sesuai kebutuhan
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');

    // Jika tanggal awal dan tanggal akhir sama, atur rentang tanggal agar mencakup seluruh hari tersebut
    if ($tgl_awal == $tgl_akhir) {
        $tgl_awal = Carbon::parse($tgl_awal)->startOfDay();
        $tgl_akhir = Carbon::parse($tgl_akhir)->endOfDay();
    }

    // Lakukan pengolahan data sesuai rentang tanggal yang diinginkan
    $transactionsM = transactionsM::select('transactions.*', 'products.*', 'transactions.id AS id_tran', 'transactions.created_at AS createtrans')
        ->join('products', 'products.id', '=', 'transactions.id_produk')
        ->whereBetween('transactions.created_at', [$tgl_awal, $tgl_akhir])
        ->get();

        $pdf = PDF::loadview('transactions_pertanggal', ['transactionsM' => $transactionsM])->setPaper('a4', 'landscape');;
        return $pdf->stream('stgl.pdf');
    }

    public function updatestatus(Request $request, $id)
    {
        // Temukan transaksi berdasarkan ID
        $transaksi = TransactionsM::findOrFail($id);
    
        // Perbarui status_pengambilan dari transaksi
        $transaksi->status_pengambilan = !$transaksi->status_pengambilan;
        $transaksi->save();
    
        // Kembali ke halaman sebelumnya
        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }
    



}
