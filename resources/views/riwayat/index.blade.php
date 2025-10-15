<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Ibadah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            <div class="space-y-6">

                {{-- Loop untuk setiap tanggal yang memiliki catatan --}}
                @forelse ($allDates as $date)
                    @php
                        // Ambil data spesifik untuk tanggal ini
                        $shalatLogsForDate = $shalatLogsByDate->get($date, collect());
                        $tilawahLogForDate = $tilawahLogsByDate->get($date);
                        $completedShalatCount = $shalatLogsForDate->where('dilaksanakan', true)->count();
                        $ibadahLainForDate = $ibadahLainLogsByDate->get($date, collect());
                    @endphp

                    {{-- Kartu Riwayat per Hari --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">

                            {{-- Tanggal --}}
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($date)->translatedFormat('l, j F Y') }}
                            </h3>

                            {{-- Divider --}}
                            <div class="my-4 border-t border-gray-200 dark:border-gray-700"></div>

                            {{-- Ringkasan Ibadah --}}
                            <div class="space-y-3 text-sm">

                                @if ($ibadahLainForDate->isNotEmpty())
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 dark:text-gray-400">Ibadah Lain Selesai</span>
                                        <span class="font-semibold text-gray-800 dark:text-gray-200">
                                            {{ $ibadahLainForDate->count() }}
                                        </span>
                                    </div>
                                @endif
                                
                                {{-- Ringkasan Shalat --}}
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">Shalat Wajib Selesai</span>
                                    <span
                                        class="font-semibold px-2 py-1 rounded-md {{ $completedShalatCount >= 5 ? 'bg-green-100 dark:bg-green-800/30 text-green-800 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-800/30 text-yellow-800 dark:text-yellow-300' }}">
                                        {{ $completedShalatCount }} / 5
                                    </span>
                                </div>

                                {{-- Ringkasan Tilawah --}}
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">Tilawah Al-Qur'an</span>
                                    <span class="font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $tilawahLogForDate ? $tilawahLogForDate->halaman_dibaca : 0 }} Halaman
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                @empty
                    {{-- Tampilan jika tidak ada riwayat sama sekali --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                            <p>Belum ada riwayat ibadah yang tercatat.</p>
                            <p class="mt-2">Mulai catat ibadahmu di halaman <a href="{{ route('dashboard') }}"
                                    class="text-primary-600 dark:text-primary-400 hover:underline">Dasbor</a>.</p>
                        </div>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
