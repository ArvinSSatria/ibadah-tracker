<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dasbor Ibadah Harian') }}
        </h2>
    </x-slot>

    {{-- Gunakan Alpine.js untuk mengontrol modal --}}
    <div x-data="{ modalOpen: false, customIbadahOpen: false }" class="py-12">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">

            {{-- =================================== --}}
            {{-- Tombol "Tambah Ibadah" (BARU)       --}}
            {{-- =================================== --}}
            <div class="mb-6">
                <button @click="modalOpen = true"
                    class="w-full flex items-center justify-center px-4 py-4 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition dark:text-white">
                    <!-- ... ikon svg ... -->
                    + Tambah Ibadah Baru
                </button>
            </div>


            {{-- ======================== --}}
            {{-- KARTU SHALAT WAJIB       --}}
            {{-- ======================== --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-white">
                            Shalat Wajib Hari Ini
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ \Carbon\Carbon::parse($today)->translatedFormat('l, j F Y') }}
                        </p>
                    </div>

                    @if (session('shalat_status'))
                        <div class="mb-4 rounded-md bg-green-50 dark:bg-green-900/20 p-4">
                            <p class="text-sm font-medium text-green-800 dark:text-green-300">
                                {{ session('shalat_status') }}
                            </p>
                        </div>
                    @endif

                    <div class="mt-4 space-y-3">
                        @foreach ($shalatLogs as $waktu => $log)
                            <form action="{{ route('shalat-log.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="shalat" value="{{ $waktu }}">
                                <input type="hidden" name="tanggal" value="{{ $today }}">
                                <button type="submit"
                                    class="w-full text-left p-4 rounded-lg transition-colors duration-200 {{ $log->dilaksanakan ? 'bg-green-100 dark:bg-green-800/30 text-green-800 dark:text-green-300' : 'bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg capitalize font-semibold">{{ $waktu }}</span>
                                        <div class="flex items-center">
                                            @if ($log->dilaksanakan)
                                                <span class="text-sm mr-3 font-medium">Selesai</span>
                                                <div
                                                    class="w-6 h-6 flex items-center justify-center rounded-full bg-green-500 text-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-4 h-4">
                                                        <path fill-rule="evenodd"
                                                            d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @else
                                                <span class="text-sm mr-3 text-gray-500 dark:text-gray-400">Belum</span>
                                                <div
                                                    class="w-6 h-6 border-2 border-gray-300 dark:border-gray-500 rounded-full">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- =================================== --}}
            {{-- KARTU IBADAH LAIN (BARU)            --}}
            {{-- =================================== --}}
            @if (isset($userTrackedIbadah) && $userTrackedIbadah->isNotEmpty())
                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-white">Ibadah Harian
                                Lainnya</h3>
                        </div>
                        @if (session('status'))
                            <div class="mb-4 rounded-md bg-green-50 dark:bg-green-900/20 p-4">
                                <p class="text-sm font-medium text-green-800 dark:text-green-300">
                                    {{ session('status') }}
                                </p>
                            </div>
                        @endif
                        <div class="mt-4 space-y-3">
                            @foreach ($userTrackedIbadah as $namaIbadah)
                                @php
                                    $log = $ibadahLainLogs->get($namaIbadah);
                                    $isDone = $log && $log->dilaksanakan;
                                @endphp
                                <form action="{{ route('ibadah-lain.log') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="nama_ibadah" value="{{ $namaIbadah }}">
                                    <input type="hidden" name="tanggal" value="{{ $today }}">
                                    <button type="submit"
                                        class="w-full text-left p-4 rounded-lg transition-colors duration-200 {{ $isDone ? 'bg-green-100 dark:bg-green-800/30 text-green-800 dark:text-green-300' : 'bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                        <div class="flex items-center justify-between">
                                            <span class="text-lg capitalize font-semibold">{{ $namaIbadah }}</span>
                                            <div class="flex items-center">
                                                @if ($isDone)
                                                    <span class="text-sm mr-3 font-medium">Selesai</span>
                                                    <div
                                                        class="w-6 h-6 flex items-center justify-center rounded-full bg-green-500 text-white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-4 h-4">
                                                            <path fill-rule="evenodd"
                                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @else
                                                    <span
                                                        class="text-sm mr-3 text-gray-500 dark:text-gray-400">Belum</span>
                                                    <div
                                                        class="w-6 h-6 border-2 border-gray-300 dark:border-gray-500 rounded-full">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- ======================== --}}
            {{-- KARTU TILAWAH            --}}
            {{-- ======================== --}}
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-white">Tilawah Al-Qur'an</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Total Halaman Dibaca Hari Ini: <span
                                class="font-bold text-lg text-primary-600 dark:text-primary-400">{{ $totalHalamanHariIni }}</span>
                        </p>
                    </div>
                    @if (session('tilawah_status'))
                        <div class="mb-4 rounded-md bg-green-50 dark:bg-green-900/20 p-4">
                            <p class="text-sm font-medium text-green-800 dark:text-green-300">
                                {{ session('tilawah_status') }}
                            </p>
                        </div>
                    @endif
                    <form action="{{ route('tilawah-log.store') }}" method="POST">
                        @csrf
                        <label for="halaman_dibaca"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tambah Halaman
                            Dibaca</label>
                        <div class="mt-2 flex items-center space-x-3">
                            <input type="number" name="halaman_dibaca" id="halaman_dibaca" min="1" required
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                                placeholder="Contoh: 10">
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">Simpan</button>
                        </div>
                        @error('halaman_dibaca')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </form>
                </div>
            </div>
        </div>

        <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-10 overflow-y-auto bg-gray-500 bg-opacity-75" aria-labelledby="modal-title"
            role="dialog" aria-modal="true" style="display: none;">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div @click.away="modalOpen = false; customIbadahOpen = false"
                    class="relative inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-xl rounded-2xl">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Pelacak Ibadah</h3>
                        <button @click="modalOpen = false; customIbadahOpen = false"
                            class="text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="mt-6">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Ibadah Pilihan</p>
                        <div class="mt-2 space-y-2">
                            @php $predefined = ['Shalat Dhuha', 'Tilawah Harian', 'Zikir Pagi', 'Zikir Petang', 'Shalat Tahajud']; @endphp
                            @foreach ($predefined as $ibadah)
                                <form action="{{ route('ibadah-lain.track') }}" method="POST"> @csrf <input
                                        type="hidden" name="nama_ibadah" value="{{ $ibadah }}">
                                    {{-- PERBAIKAN DI SINI --}}
                                    <button type="submit"
                                        class="w-full text-left p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white">{{ $ibadah }}</button>
                                </form>
                            @endforeach
                        </div>
                        <div class="my-6 text-center text-sm text-gray-400">ATAU</div>
                        <div>
                            <button @click="customIbadahOpen = !customIbadahOpen"
                                class="w-full flex justify-between items-center text-left p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                {{-- PERBAIKAN DI SINI --}}
                                <span class="dark:text-white">Tambah Ibadah Custom</span>
                                <svg xmlns="http://www.w.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5 text-gray-700 dark:text-white">
                                    <path
                                        d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                            </button>
                            <div x-show="customIbadahOpen" x-transition class="mt-2">
                                <form action="{{ route('ibadah-lain.track') }}" method="POST"
                                    class="flex items-center space-x-2">
                                    @csrf
                                    <input type="text" name="nama_ibadah" placeholder="Contoh: Puasa Senin"
                                        required
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:text-white">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
