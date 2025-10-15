import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// --- Elemen Tombol Desktop ---
var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
var themeToggleBtn = document.getElementById('theme-toggle');

// --- Elemen Tombol Mobile (BARU) ---
var themeToggleDarkIconMobile = document.getElementById('theme-toggle-dark-icon-mobile');
var themeToggleLightIconMobile = document.getElementById('theme-toggle-light-icon-mobile');
var themeToggleBtnMobile = document.getElementById('theme-toggle-mobile');


// --- Inisialisasi Tampilan Ikon Saat Halaman Dimuat ---
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    // Tampilkan ikon terang (bulan) di kedua tombol
    if(themeToggleLightIcon) themeToggleLightIcon.classList.remove('hidden');
    if(themeToggleLightIconMobile) themeToggleLightIconMobile.classList.remove('hidden'); // BARU
} else {
    // Tampilkan ikon gelap (matahari) di kedua tombol
    if(themeToggleDarkIcon) themeToggleDarkIcon.classList.remove('hidden');
    if(themeToggleDarkIconMobile) themeToggleDarkIconMobile.classList.remove('hidden'); // BARU
}


// --- Fungsi Utama untuk Mengubah Tema (Dibuat agar bisa dipanggil ulang) ---
function handleThemeToggle() {
    // Toggle ikon di kedua tombol
    if(themeToggleDarkIcon) themeToggleDarkIcon.classList.toggle('hidden');
    if(themeToggleLightIcon) themeToggleLightIcon.classList.toggle('hidden');
    if(themeToggleDarkIconMobile) themeToggleDarkIconMobile.classList.toggle('hidden');     // BARU
    if(themeToggleLightIconMobile) themeToggleLightIconMobile.classList.toggle('hidden'); // BARU

    // Logika untuk mengubah tema dan menyimpan di local storage
    if (localStorage.getItem('color-theme')) {
        if (localStorage.getItem('color-theme') === 'light') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }
    } else {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    }
}


// --- Pasang Event Listener ---

// Listener untuk tombol Desktop
if(themeToggleBtn) {
    themeToggleBtn.addEventListener('click', handleThemeToggle);
}

// Listener untuk tombol Mobile (BARU)
if(themeToggleBtnMobile) {
    themeToggleBtnMobile.addEventListener('click', handleThemeToggle);
}