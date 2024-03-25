<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionsM extends Model
{
    use HasFactory;
    protected $table = "transactions";
    protected $fillable = ["id", "id_produk", "nama_pelanggan", "nomor_unik", "qty","uang_bayar", "uang_kembali",'status_pengambilan', "created_at", "updated_at"];
}   
