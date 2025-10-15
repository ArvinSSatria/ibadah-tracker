<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ShalatLog;
use Illuminate\Http\Request;
use App\Models\UserTrackedIbadah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShalatLogController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $shalatWajib = collect(['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya']);

        // Logika untuk Shalat (sudah stabil)
        $existingShalatNames = ShalatLog::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->pluck('shalat');
        $missingShalat = $shalatWajib->diff($existingShalatNames);
        if ($missingShalat->isNotEmpty()) {
            $newLogs = [];
            foreach ($missingShalat as $waktu) {
                $newLogs[] = ['user_id' => $user->id, 'tanggal' => $today, 'shalat'  => $waktu, 'created_at' => now(), 'updated_at' => now()];
            }
            ShalatLog::insert($newLogs);
        }
        $shalatLogs = ShalatLog::where('user_id', $user->id)->where('tanggal', '=', $today)->get()->keyBy('shalat');

        // Mengambil Data Tilawah (sudah stabil)
        $tilawahLogHariIni = DB::table('tilawah_logs')->where('user_id', $user->id)->where('tanggal', $today)->first();
        $totalHalamanHariIni = $tilawahLogHariIni ? $tilawahLogHariIni->halaman_dibaca : 0;

        // --- PERBAIKAN: Mengambil Data Ibadah Lain Menggunakan Query Builder ---
        $userTrackedIbadah = UserTrackedIbadah::where('user_id', $user->id)->pluck('nama_ibadah');
        $ibadahLainLogs = DB::table('ibadah_lain_logs') // <-- PERUBAHAN DI SINI
            ->where('user_id', $user->id)
            ->where('tanggal', $today)
            ->get()
            ->keyBy('nama_ibadah');

        return view('dashboard', compact('shalatLogs', 'today', 'totalHalamanHariIni', 'userTrackedIbadah', 'ibadahLainLogs'));
    }

    public function store(Request $request)
    {
        // ... method store tidak berubah ...
        $request->validate(['shalat' => 'required|string', 'tanggal' => 'required|date']);
        $log = ShalatLog::where('user_id', Auth::id())->where('tanggal', $request->tanggal)->where('shalat', $request->shalat)->first();
        if ($log) {
            $log->dilaksanakan = !$log->dilaksanakan;
            $log->save();
        }
        return back()->with('shalat_status', 'Catatan shalat berhasil diperbarui!');
    }
}