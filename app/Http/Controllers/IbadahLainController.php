<?php

namespace App\Http\Controllers;

use App\Models\IbadahLainLog;
use App\Models\UserTrackedIbadah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IbadahLainController extends Controller
{
    // Method untuk menambahkan ibadah baru ke daftar yang dilacak pengguna
    public function storeTrackedIbadah(Request $request)
    {
        $request->validate(['nama_ibadah' => 'required|string|max:255']);

        UserTrackedIbadah::firstOrCreate([
            'user_id' => Auth::id(),
            'nama_ibadah' => $request->nama_ibadah,
        ]);

        return back()->with('status', 'Ibadah baru berhasil ditambahkan ke dasbor!');
    }

    // Method untuk mencentang/membatalkan centang ibadah harian
    public function toggleLog(Request $request)
    {
        $request->validate([
            'nama_ibadah' => 'required|string',
            'tanggal'     => 'required|date',
        ]);

        $log = IbadahLainLog::firstOrNew([
            'user_id'     => Auth::id(),
            'tanggal'     => $request->tanggal,
            'nama_ibadah' => $request->nama_ibadah,
        ]);

        $log->dilaksanakan = !$log->dilaksanakan;
        $log->save();

        return back();
    }
}