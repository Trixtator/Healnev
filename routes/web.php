<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RumahSakitController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\Admin\TestimoniController as AdminTestimoniController;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semuanya akan ditetapkan
| ke grup middleware "web".
|
*/

//======================================================================
// RUTE PUBLIK & HALAMAN UTAMA
//======================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/services', fn() => view('services'))->name('services');
Route::get('/contact', fn() => view('contact'))->name('contact');
Route::get('/our-hospital', [RumahSakitController::class, 'publicIndex'])->name('hospital');
Route::get('/hospital/{id}', [RumahSakitController::class, 'show'])->name('detail-hospital');
Route::get('/packages', [PaketController::class, 'publicIndex'])->name('packages');
Route::get('/paket/{id}', [PaketController::class, 'show'])->name('detail-paket');


//======================================================================
// RUTE OTENTIKASI (LOGIN, REGISTER, LOGOUT, RESET PASSWORD)
//======================================================================
Route::get('login', fn() => view('auth.login'))->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', fn() => view('auth.register'))->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset
Route::get('password/reset', fn() => view('auth.passwords.email'))->name('password.request');
Route::post('password/email', [AuthController::class, 'resetPassword'])->name('password.email');
Route::get('password/reset/{token}', fn($token) => view('auth.passwords.reset', ['token' => $token]))->name('password.reset');
Route::post('password/reset', [AuthController::class, 'updatePassword'])->name('password.update');


//======================================================================
// RUTE YANG MEMBUTUHKAN OTENTIKASI (AUTH MIDDLEWARE)
//======================================================================
Route::middleware(['auth'])->group(function () {
    // Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/upload-photo', [ProfileController::class, 'updateProfilePicture'])->name('profile.upload.photo');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Pemesanan & Pembayaran
    Route::get('/pesan/{id}', [PemesananController::class, 'form'])->name('pemesanan.form');
    Route::post('/pesan', [PemesananController::class, 'proses'])->name('pemesanan.proses');
    
    // Invoice
    Route::get('/invoice/{order}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::post('/invoice/{id}/pay', [InvoiceController::class, 'pay'])->name('invoice.pay');
    Route::get('/invoice/{order}/download', [InvoiceController::class, 'download'])->name('invoice.download');

    // Testimoni
    Route::post('/testimoni', [TestimoniController::class, 'store'])->name('testimoni.store');
});


//======================================================================
// RUTE ADMIN (MEMBUTUHKAN AUTH & IS_ADMIN MIDDLEWARE)
//======================================================================
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/users', [AdminController::class, 'userList'])->name('user.index');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('user.delete');

    // Manajemen Testimoni oleh Admin
    Route::get('/testimoni', [AdminTestimoniController::class, 'index'])->name('testimoni.index');
    Route::post('/testimoni/{id}/toggle', [AdminTestimoniController::class, 'toggleActive'])->name('testimoni.toggle');
    Route::delete('/testimoni/{id}', [AdminTestimoniController::class, 'destroy'])->name('testimoni.destroy');

    // Resource Controllers untuk Admin
    Route::resource('rumahsakit', RumahSakitController::class)->except(['show', 'index']);
    Route::get('/rumahsakit', [RumahSakitController::class, 'index'])->name('rumahsakit.index');
    
    Route::resource('paket', PaketController::class)->except(['show', 'index']);
    Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');
});


//======================================================================
// RUTE BOTMAN
//======================================================================
Route::match(['get', 'post'], '/botman', function (Request $request) {
    $config = [];
    $botman = BotManFactory::create($config);

    $botman->hears('faq|help|support|questions', function (BotMan $bot) {
        $question = Question::create('Silakan pilih pertanyaan di bawah ini:')
            ->addButtons([
                Button::create('Bagaimana cara mendaftar?')->value('faq_register'),
                Button::create('Lupa kata sandi akun')->value('faq_forgot'),
                Button::create('Bagaimana cara memesan layanan?')->value('faq_book'),
                Button::create('Apa saja metode pembayaran?')->value('faq_payment'),
                Button::create('Bagaimana cara melihat riwayat pesanan?')->value('faq_history'),
            ]);
        $bot->reply($question);
    });

    $botman->hears('faq_register', fn($bot) => $bot->reply('Klik tombol "Daftar" di beranda dan isi nama lengkap, email, dan kata sandi Anda.'));
    $botman->hears('faq_forgot', fn($bot) => $bot->reply('Klik "Lupa Kata Sandi?" di halaman login dan ikuti instruksi reset.'));
    $botman->hears('faq_book', fn($bot) => $bot->reply('Pilih layanan > Pesan > Pilih tanggal > Lanjutkan ke pembayaran.'));
    $botman->hears('faq_payment', fn($bot) => $bot->reply('Kami menerima BCA, Dana, ShopeePay, QRIS, dan opsi pembayaran digital lainnya.'));
    $botman_hears('faq_history', fn($bot) => $bot->reply('Masuk ke akun Anda dan buka menu "Riwayat Pesanan".'));
    
    $botman->fallback(fn($bot) => $bot->reply('Maaf, saya tidak mengerti. Ketik "faq" untuk melihat pertanyaan umum.'));

    $botman->listen();
});


//======================================================================
// RUTE LAIN-LAIN (JIKA ADA)
//======================================================================
// Rute ini akan mengarahkan ke halaman sukses setelah pembayaran dari Midtrans.
Route::get('/midtrans/finish', [MidtransController::class, 'paymentSuccess'])->name('midtrans.finish');

// Rute untuk registrasi MCU (jika masih digunakan)
Route::post('/submit-registration', [RegistrationController::class, 'submitRegistration'])->name('submit-registration');
Route::get('/verify-registration', [RegistrationController::class, 'verify'])->name('verify-registration');
