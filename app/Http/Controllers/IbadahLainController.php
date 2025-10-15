<?php

namespace App\Http\Controllers;

use App\Models\UserTrackedIbadah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- Pastikan ini ada

class IbadahLainController extends Controller
{
    public function storeTrackedIbadah(Request $request)
    {
        $request->validate(['nama_ibadah' => 'required|string|max:255']);

        UserTrackedIbadah::firstOrCreate([
            'user_id' => Auth::id(),
            'nama_ibadah' => $request->nama_ibadah,
        ]);

        return back()->with('status', 'Ibadah baru berhasil ditambahkan ke dasbor!');
    }

    public function toggleLog(Request $request)
    {
        $request->validate([
            'nama_ibadah' => 'required|string',
            'tanggal'     => 'required|date',
        ]);

        $userId = Auth::id();
        $tanggal = $request->tanggal; // Ini adalah string 'YYYY-MM-DD'
        $namaIbadah = $request->nama_ibadah;

        // Gunakan Query Builder yang kebal terhadap masalah $casts
        $log = DB::table('ibadah_lain_logs')
            ->where('user_id', $userId)
            ->where('tanggal', $tanggal)
            ->where('nama_ibadah', $namaIbadah)
            ->first();

        if ($log) {
            // Jika log ada, update nilainya (toggle)
            DB::table('ibadah_lain_logs')
                ->where('id', $log->id)
                ->update([
                    'dilaksanakan' => !$log->dilaksanakan,
                    'updated_at' => now(),
                ]);
        } else {
            // Jika log tidak ada, buat baru
            DB::table('ibadah_lain_logs')->insert([
                'user_id' => $userId,
                'tanggal' => $tanggal,
                'nama_ibadah' => $namaIbadah,
                'dilaksanakan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back();
    }
}