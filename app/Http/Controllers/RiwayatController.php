<?php

namespace App\Http\Controllers;

use App\Models\ShalatLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();

        // Ambil data ShalatLog (sudah detail, tidak perlu diubah)
        $shalatLogsByDate = ShalatLog::where('user_id', $user_id)
            ->orderBy('tanggal', 'desc')
            ->get()
            ->groupBy(function ($log) {
                return $log->tanggal->toDateString();
            });

        // Ambil data IbadahLainLog (tidak perlu diubah, sudah mengirim semua data)
        // Kita akan memprosesnya nanti di view
        $ibadahLainLogsByDate = DB::table('ibadah_lain_logs')
            ->where('user_id', $user_id)
            ->where('dilaksanakan', true)
            ->get()
            ->groupBy('tanggal');

        // Ambil data TilawahLog (sudah detail, tidak perlu diubah)
        $tilawahLogsByDate = DB::table('tilawah_logs')->where('user_id', $user_id)
            ->get()
            ->keyBy('tanggal');

        // Gabungkan semua tanggal unik
        $allDates = collect($shalatLogsByDate->keys())
            ->merge($tilawahLogsByDate->keys())
            ->merge($ibadahLainLogsByDate->keys())
            ->unique()
            ->sortDesc();

        return view('riwayat.index', [
            'allDates' => $allDates,
            'shalatLogsByDate' => $shalatLogsByDate,
            'tilawahLogsByDate' => $tilawahLogsByDate,
            'ibadahLainLogsByDate' => $ibadahLainLogsByDate,
        ]);
    }
}