<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TilawahLogController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'halaman_dibaca' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $halamanBaru = (int) $request->halaman_dibaca;

        // --- Menggunakan Query Builder yang kebal masalah $casts ---
        $exists = DB::table('tilawah_logs')
            ->where('user_id', $user->id)
            ->where('tanggal', $today)
            ->exists();

        if ($exists) {
            DB::table('tilawah_logs')
                ->where('user_id', $user->id)
                ->where('tanggal', $today)
                ->increment('halaman_dibaca', $halamanBaru);
        }
        else {
            DB::table('tilawah_logs')->insert([
                'user_id' => $user->id,
                'tanggal' => $today,
                'halaman_dibaca' => $halamanBaru,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('tilawah_status', 'Catatan tilawah berhasil ditambahkan!');
    }
}