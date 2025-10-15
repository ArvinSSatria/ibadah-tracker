<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTrackedIbadah extends Model
{
    protected $fillable = ['user_id', 'nama_ibadah'];
}
