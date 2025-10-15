<?php

namespace App\Http\Controllers;

use App\Models\ShalatLog;
use Illuminate\Http\Request;
use App\Models\IbadahLainLog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();

        // --- PERBAIKAN: Paksa kunci grouping menjadi string ---
        // 1. Ambil semua log shalat
        $shalatLogsByDate = ShalatLog::where('user_id', $user_id)
            ->orderBy('tanggal', 'desc')
            ->get()
            // Gunakan callback untuk memastikan kunci grup adalah string 'YYYY-MM-DD'
            ->groupBy(function ($log) {
                return $log->tanggal->toDateString();
            });

        $ibadahLainLogsByDate = IbadahLainLog::where('user_id', $user_id)
            ->where('dilaksanakan', true) // Hanya ambil yang sudah dicentang
            ->get()
            ->groupBy(function ($log) {
                return $log->tanggal->toDateString();
            });

        // 2. Ambil semua log tilawah menggunakan Query Builder (kuncinya sudah pasti string)
        $tilawahLogsByDate = DB::table('tilawah_logs')->where('user_id', $user_id)
            ->get()
            ->keyBy('tanggal');

        // 3. Sekarang, kedua sumber data memiliki kunci string, jadi penggabungan akan berhasil.
        $allDates = collect($shalatLogsByDate->keys())
            ->merge($tilawahLogsByDate->keys())
            ->merge($ibadahLainLogsByDate->keys())
            ->unique()
            ->sortDesc();

        // 4. Kirim semua data yang sudah terorganisir ke view
        return view('riwayat.index', [
            'allDates' => $allDates,
            'shalatLogsByDate' => $shalatLogsByDate,
            'tilawahLogsByDate' => $tilawahLogsByDate,
            'ibadahLainLogsByDate' => $ibadahLainLogsByDate,
        ]);
    }
}
