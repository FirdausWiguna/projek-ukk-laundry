<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogM extends Model
{
    use HasFactory;
    protected $table = "log";
    protected $fillable = ["id", "id_user", "activity"];

    public function activity($activity)
    {
        $data = [
            "id_user" => Auth::user()->id,
            "activity" => $activity
        ];

        LogM::save();
        redirect('products');
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->LogOnly(['id_user', 'activity']);
    }
}
