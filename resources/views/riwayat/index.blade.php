<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Ibadah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 px-8">
            <div class="space-y-6">

                @forelse ($allDates as $date)
                    @php
                        // Ambil koleksi data untuk tanggal ini
                        $shalatLogsForDate = $shalatLogsByDate->get($date, collect());
                        $tilawahLogForDate = $tilawahLogsByDate->get($date);
                        $ibadahLainForDate = $ibadahLainLogsByDate->get($date, collect());
                        
                        // Hitung ringkasan
                        $completedShalatCount = $shalatLogsForDate->where('dilaksanakan', true)->count();
                        $shalatBerjamaahCount = $shalatLogsForDate->where('berjamaah', true)->count();
                        $shalatTepatWaktuCount = $shalatLogsForDate->where('tepat_waktu', true)->count();
                    @endphp

                    {{-- Kartu Riwayat per Hari dengan Desain Dropdown Baru --}}
                    <div x-data="{ openShalat: false, openIbadahLain: false }" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                        <div class="p-4 sm:p-6 text-gray-900 dark:text-gray-100">

                            <h3 class="font-bold text-lg text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($date)->translatedFormat('l, j F Y') }}
                            </h3>
                            
                            <div class="mt-4 space-y-1">
                                {{-- Baris Tilawah (statis) --}}
                                <div class="flex justify-between items-center p-2">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Tilawah Al-Qur'an</span>
                                    <span class="font-semibold text-sm text-gray-800 dark:text-gray-200">{{ $tilawahLogForDate ? $tilawahLogForDate->halaman_dibaca : 0 }} Halaman</span>
                                </div>
                                
                                <hr class="border-gray-200 dark:border-gray-700">

                                {{-- Baris Shalat Wajib (Dropdown) --}}
                                <div class="cursor-pointer" @click="openShalat = !openShalat">
                                    <div class="flex justify-between items-center p-2 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Shalat Wajib Selesai</span>
                                        <div class="flex items-center space-x-2">
                                            <span class="font-semibold px-2 py-1 rounded-md text-sm {{ $completedShalatCount >= 5 ? 'bg-green-100 dark:bg-green-800/30 text-green-800 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-800/30 text-yellow-800 dark:text-yellow-300' }}">
                                                {{ $completedShalatCount }} / 5
                                            </span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400 transition-transform duration-300" :class="{ 'rotate-180': openShalat }">
                                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    {{-- Konten Dropdown Shalat --}}
                                    <div x-show="openShalat" x-transition class="px-2 pt-1 pb-2 ml-4 border-l-2 border-primary-500/50">
                                        <div class="space-y-2 text-xs text-gray-500 dark:text-gray-400">
                                            <p class="flex items-center">Berjamaah: <span class="font-semibold ml-1">{{ $shalatBerjamaahCount }}</span></p>
                                            <p class="flex items-center">Tepat Waktu: <span class="font-semibold ml-1">{{ $shalatTepatWaktuCount }}</span></p>
                                        </div>
                                    </div>
                                </div>

                                <hr class="border-gray-200 dark:border-gray-700">
                                
                                {{-- Baris Ibadah Lain (Dropdown) --}}
                                @if($ibadahLainForDate->isNotEmpty())
                                <div class="cursor-pointer" @click="openIbadahLain = !openIbadahLain">
                                    <div class="flex justify-between items-center p-2 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Ibadah Lain Selesai</span>
                                        <div class="flex items-center space-x-2">
                                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $ibadahLainForDate->count() }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400 transition-transform duration-300" :class="{ 'rotate-180': openIbadahLain }">
                                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    {{-- Konten Dropdown Ibadah Lain --}}
                                    <div x-show="openIbadahLain" x-transition class="px-2 pt-1 pb-2 ml-4 border-l-2 border-primary-500/50">
                                        <ul class="space-y-1 text-xs text-gray-500 dark:text-gray-400">
                                            @foreach($ibadahLainForDate as $ibadah)
                                                <li>{{ $ibadah->nama_ibadah }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                            <p>Belum ada riwayat ibadah yang tercatat.</p>
                            <p class="mt-2">Mulai catat ibadahmu di halaman <a href="{{ route('dashboard') }}" class="text-primary-600 dark:text-primary-400 hover:underline">Beranda</a>.</p>
                        </div>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>