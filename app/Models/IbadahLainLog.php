<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IbadahLainLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tanggal', 'nama_ibadah', 'dilaksanakan'];
    protected $casts = [
        'tanggal' => 'date',
    ];
}
