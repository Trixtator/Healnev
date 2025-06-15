<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\DepartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\McuRegistrationController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;
// use App\Http\Controllers\PaymentController;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\RumahSakitController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MidtransController;










DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', function () {
    return view('index');
})->name('main');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/our-hospital', function () {
    return view('hospital');
})->name('hospital');


// Route::get('/department', [DepartController::class, 'index'])->name('department');
Route::get('/department-single', function () {
    return view('department-single');
})->name('department-single');

Route::get('/doctor', function () {
    return view('doctor');
})->name('doctor');

Route::get('/doctor-single', function () {
    return view('doctor-single');
})->name('doctor-single');

Route::get('/appoinment', function () {
    return view('appoinment');
})->name('appoinment');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/mail', function () {
    return view('mail');
})->name('mail');

// Authentication Routes
Route::get('login', function () {
    return view('auth.login');
})->name('login');

Route::post('login', [AuthController::class, 'login']);

Route::get('register', function () {
    return view('auth.register');
})->name('register');

Route::post('register', [AuthController::class, 'register']);

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('password/reset', function () {
    return view('auth.passwords.email');
})->name('password.request');

Route::post('password/email', [AuthController::class, 'resetPassword'])->name('password.email');

Route::get('password/reset/{token}', function ($token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->name('password.reset');

Route::post('password/reset', [AuthController::class, 'updatePassword'])->name('password.update');

// MCU Registration Routes
Route::post('/submit-registration', [RegistrationController::class, 'submitRegistration'])->name('submit-registration');
Route::get('/verify-registration', [RegistrationController::class, 'verifyRegistration'])->name('verify-registration');
Route::post('/create-pdf', [RegistrationController::class, 'createPDF'])->name('create-pdf');
Route::get('/back-to-main', [RegistrationController::class, 'backToMain'])->name('back-to-main');

// Verification Routes
Route::get('/verifikasi', [RegistrationController::class, 'showVerificationForm'])->name('verification.form');
Route::post('/verifikasi', [RegistrationController::class, 'submitVerification'])->name('verification.submit');
Route::post('/confirm-registration', [RegistrationController::class, 'confirmRegistration'])->name('confirm-registration');

// Payment Routes
// Route::post('/payment', [PaymentController::class, 'showPaymentPage'])->name('payment');
// Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('process.payment');
// Route::get('/payment-success', function () {
//     return view('payment-success');
// })->name('payment.success');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/password/change', [ProfileController::class, 'showChangePassword'])->name('password.change');
    Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::put('/change-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/upload-photo', [ProfileController::class, 'updateProfilePicture'])->name('profile.upload.photo');




    // Admin Routes
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::post('/admin/update-status/{id}', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
    });
});

// BotMan Routes
Route::match(['get', 'post'], '/botman', function (Request $request) {
    $config = [];
    $botman = BotManFactory::create($config);

    // [KUNCI 1] FUNGSI PEMBUAT CHAT
    // Fungsi ini dirancang untuk membuat 2 chat bubble: satu untuk user, satu untuk bot.
    function faqAnswer(BotMan $bot, string $questionText, string $answerText)
    {
        // Perintah ini membuat bubble chat dengan 'tanda' CSS khusus agar bisa dipindah ke kanan.
        $bot->reply($questionText, [
            'css_class' => 'user-bubble' // Ini adalah "tanda" untuk CSS
        ]);

        // Bot jeda sejenak, seolah sedang mengetik.
        $bot->typesAndWaits(1);

        // Bot mengirim jawaban finalnya (ini akan muncul di kiri secara normal).
        $bot->reply($answerText);
    }

    // Trigger utama untuk menampilkan pertanyaan.
    $botman->hears('faq|help|bantuan|pertanyaan', function (BotMan $bot) {
        $question = Question::create('Silakan pilih pertanyaan di bawah ini:')
            // [PENTING] Pastikan .setAsNotified(true) TIDAK ADA di sini.
            ->addButtons([
                Button::create('Bagaimana cara daftar akun?')->value('faq_daftar'),
                Button::create('Lupa password akun')->value('faq_lupa'),
                Button::create('Cara ubah email')->value('faq_email'),
                Button::create('Cara hapus akun')->value('faq_hapus'),
                Button::create('Cara pesan layanan')->value('faq_pesan'),
                Button::create('Metode pembayaran?')->value('faq_bayar'),
                Button::create('Lihat riwayat pesanan')->value('faq_riwayat'),
                Button::create('Apa itu MCU & Wisata?')->value('faq_mcu'),
                Button::create('Cara membatalkan pesanan')->value('faq_batal'),
            ]);

        $bot->reply($question);
    });

    // Blok ini berisi semua pasangan Pertanyaan (dari tombol) dan Jawaban (dari bot).
    // Setiap `hears` akan memanggil fungsi `faqAnswer` untuk menciptakan alur chat yang diinginkan.
    $botman->hears('faq_daftar', fn($bot) => faqAnswer($bot, 'Bagaimana cara daftar akun?', 'Klik tombol “Daftar” di halaman utama, lalu lengkapi data diri seperti nama lengkap, email, dan password.'));
    $botman->hears('faq_lupa', fn($bot) => faqAnswer($bot, 'Lupa password akun', 'Klik “Lupa Kata Sandi?” di halaman login, lalu ikuti petunjuk reset.'));
    $botman->hears('faq_email', fn($bot) => faqAnswer($bot, 'Cara ubah email', 'Masuk ke halaman profil > ubah email di bagian pengaturan akun.'));
    $botman->hears('faq_hapus', fn($bot) => faqAnswer($bot, 'Cara hapus akun', 'Silakan hubungi admin melalui menu “Hubungi Kami” untuk menghapus akun Anda.'));
    $botman->hears('faq_pesan', fn($bot) => faqAnswer($bot, 'Cara pesan layanan', 'Pilih layanan > Booking > Pilih tanggal > Lanjut pembayaran.'));
    $botman->hears('faq_bayar', fn($bot) => faqAnswer($bot, 'Metode pembayaran?', 'Kami mendukung BCA, Dana, ShopeePay, QRIS, dan metode pembayaran digital lainnya.'));
    $botman->hears('faq_riwayat', fn($bot) => faqAnswer($bot, 'Lihat riwayat pesanan', 'Masuk ke akun Anda lalu buka menu “Riwayat Pemesanan”.'));
    $botman->hears('faq_mcu', fn($bot) => faqAnswer($bot, 'Apa itu MCU & Wisata?', 'Layanan gabungan Medical Check-Up dan rekreasi di lokasi wisata.'));
    $botman->hears('faq_batal', fn($bot) => faqAnswer($bot, 'Cara membatalkan pesanan', 'Pesanan yang belum dibayar dapat dibatalkan di menu “Riwayat Pesanan”.'));

    // Fallback jika bot tidak mengerti.
    $botman->fallback(fn($bot) => $bot->reply('Maaf, saya belum paham. Ketik "faq" untuk lihat pertanyaan umum.'));

    $botman->listen();
});

    Route::post('/submit-registration', [RegistrationController::class, 'store'])->name('submit-registration');


Route::post('/admin/rumahsakit/store', action: [RumahSakitController::class, 'store'])->name('rumahsakit.store');
Route::post('/admin/konsultasi/store', action: [KonsultasiController::class, 'store'])->name('konsultasi.store');
Route::get('/admin/rumahsakit', [RumahSakitController::class, 'index'])->name('rumahsakit.index');
Route::get('/admin/konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi.index');
Route::get('/admin/user', [UserController::class, 'index'])->name('user.index');


Route::get('/rumahsakit', [RumahSakitController::class, 'index'])->name('rumahsakit.index');
Route::post('/rumahsakit', [RumahSakitController::class, 'store'])->name('rumahsakit.store');

Route::resource('rumahsakit', RumahSakitController::class);

Route::resource('paket', PaketController::class);
Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');

Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');
Route::post('/paket', [PaketController::class, 'store'])->name('paket.store');

// Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update')->middleware('auth');
Route::put('/profile/email', [ProfileController::class, 'updateEmail'])->name('profile.email.update')->middleware('auth');

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rute untuk Homepage (sudah ada)
Route::get('/', [HomeController::class, 'index'])->name('home');

// TAMBAHKAN RUTE INI: Rute untuk menampilkan detail satu paket
Route::get('/paket/{id}', [HomeController::class, 'detailPaket'])->name('user.paket.detail');
Route::get('/paket/{id}', [PaketController::class, 'show'])->name('user.paket.detail');


// Rute untuk form (sudah ada)
Route::post('/submit-registration', [App\Http\Controllers\RegistrationController::class, 'submit'])->name('submit-registration');

Route::get('/our-hospital', [RumahSakitController::class, 'publicIndex'])->name('hospital');

Route::get('/hospital/{id}', [RumahSakitController::class, 'show'])->name('detail-hospital');

Route::get('/pesan/{id}', [PemesananController::class, 'form'])->name('pemesanan.form');
Route::post('/pesan', [PemesananController::class, 'proses'])->name('pemesanan.proses');

Route::get('/bayar/{id}', [MidtransController::class, 'bayar'])->name('bayar.midtrans');
Route::post('/midtrans/callback', [MidtransController::class, 'callback']);

Route::get('/paket/{id}', [PemesananController::class, 'form'])->name('pemesanan.form');
Route::post('/pemesanan/proses', [PemesananController::class, 'proses'])->name('pemesanan.proses');
Route::get('/pembayaran/{id}', [PembayaranController::class, 'bayar'])->name('bayar.midtrans');
// Route::get('/user/paket/{id}', [UserPaketController::class, 'detailPaket'])->name('user.paket.detail');

Route::get('/paket/{id}', [PaketController::class, 'show'])->name('user.paket.detail');

// Rute untuk mengecek kuota paket
// Contoh URL: /api/paket/15/check-quota
Route::post('/paket/{paket}/check-quota', action: [OrderController::class, 'checkQuota'])->name('api.quota.check');


// Rute untuk membuat pesanan baru
// Contoh URL: /api/order/create
Route::post('/order/create', [OrderController::class, 'createOrder'])->name('api.order.create');

// Rute untuk menampilkan halaman invoice
Route::get('/invoice/{order}', [OrderController::class, 'showInvoice'])->name('invoice.show')->middleware('auth');

// Rute untuk memproses pembayaran dummy
// Route::post('/invoice/{order}/pay', [OrderController::class, 'processDummyPayment'])->name('invoice.pay')->middleware('auth');
// Route::post('/invoice/{order}/pay', [OrderController::class, 'processDummyPayment'])->name('invoice.pay');
// Route::post('/invoice/{order}/pay', [OrderController::class, 'processDummyPayment'])->name('invoice.pay');

Route::get('/invoice/download/{order}', [InvoiceController::class, 'download'])->name('invoice.download');

Route::get('/invoice/{order}', [InvoiceController::class, 'show'])->name('invoice.show');
Route::get('/invoice/download/{order}', [InvoiceController::class, 'download'])->name('invoice.download');

Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler'])->name('midtrans.notification');
// web.php
Route::post('/invoice/pay/{id}', [InvoiceController::class, 'pay'])->name('invoice.pay');

Route::get('/packages', [PaketController::class, 'publicIndex'])->name('packages');
Route::get('/packages', [PaketController::class, 'publicIndex'])->name('packages');
// Route::get('/paket/{id}', [PaketController::class, 'show'])->name('detail-paket');
Route::get('/user/paket/{id}', [PaketController::class, 'show'])->name('user.paket.detail');

Route::get('/paket/{id}', [PaketController::class, 'show'])->name('detail-paket');
Route::get('/hospital/{id}', [HospitalController::class, 'show'])->name('user.hospital.detail');

Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

// Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
// Route::get('/admin/users', [AdminController::class, 'userList'])->name('admin.users');
// Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
// Route::get('/admin/users', [AdminController::class, 'userList'])->name('user.index');
// Route::get('/admin/users', [AdminController::class, 'userList'])->name('user.index');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'userList'])->name('user.index');
    Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');
    Route::get('/rumahsakit', [RumahSakitController::class, 'index'])->name('rumahsakit.index');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');

});
