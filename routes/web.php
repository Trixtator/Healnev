<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\{
    AuthController,
    ProfileController,
    McuRegistrationController,
    RegistrationController,
    AdminController,
    RumahSakitController,
    KonsultasiController,
    UserController,
    PaketController,
    HomeController,
    PemesananController,
    OrderController,
    InvoiceController,
    MidtransController,
    TestimoniController
};
use App\Http\Controllers\Admin\TestimoniController as AdminTestimoniController;
use App\Http\Middleware\AdminMiddleware;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\BotMan;

// Load BotMan driver
DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

// ==================== PUBLIC ROUTES ====================

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/services', 'services')->name('services');
Route::view('/our-hospital', 'hospital')->name('hospital');
Route::view('/department-single', 'department-single')->name('department-single');
Route::view('/doctor', 'doctor')->name('doctor');
Route::view('/doctor-single', 'doctor-single')->name('doctor-single');
Route::view('/appoinment', 'appoinment')->name('appoinment');
Route::view('/contact', 'contact')->name('contact');
Route::post('/mail', fn() => view('mail'))->name('mail');

// ==================== AUTH ROUTES ====================

Route::view('login', 'auth.login')->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::view('register', 'auth.register')->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::view('password/reset', 'auth.passwords.email')->name('password.request');
Route::post('password/email', [AuthController::class, 'resetPassword'])->name('password.email');
Route::get('password/reset/{token}', fn($token) => view('auth.passwords.reset', ['token' => $token]))->name('password.reset');
Route::post('password/reset', [AuthController::class, 'updatePassword'])->name('password.update');

// ==================== MCU & VERIFICATION ====================

Route::post('/submit-registration', [RegistrationController::class, 'submit'])->name('submit-registration');
Route::get('/verify-registration', [RegistrationController::class, 'verify'])->name('verify-registration');
Route::post('/create-pdf', [RegistrationController::class, 'createPDF'])->name('create-pdf');
Route::get('/back-to-main', [RegistrationController::class, 'backToMain'])->name('back-to-main');

Route::get('/verifikasi', [RegistrationController::class, 'showVerificationForm'])->name('verification.form');
Route::post('/verifikasi', [RegistrationController::class, 'submitVerification'])->name('verification.submit');
Route::post('/confirm-registration', [RegistrationController::class, 'confirmRegistration'])->name('confirm-registration');

// ==================== PAKET & PESANAN ====================

Route::resource('paket', PaketController::class)->only(['index', 'show', 'store']);
Route::get('/packages', [PaketController::class, 'publicIndex'])->name('packages');
Route::get('/paket/{id}', [PaketController::class, 'show'])->name('user.paket.detail');
Route::post('/paket/{paket}/check-quota', [OrderController::class, 'checkQuota'])->name('api.quota.check');

Route::get('/pesan/{id}', [PemesananController::class, 'form'])->name('pemesanan.form');
Route::post('/pemesanan/proses', [PemesananController::class, 'proses'])->name('pemesanan.proses');
Route::get('/bayar/{id}', [MidtransController::class, 'bayar'])->name('bayar.midtrans');
Route::post('/order/create', [OrderController::class, 'createOrder'])->name('api.order.create');

// ==================== RUMAH SAKIT ====================

Route::get('/our-hospital', [RumahSakitController::class, 'publicIndex'])->name('hospital');
Route::get('/hospital/{id}', [RumahSakitController::class, 'show'])->name('detail-hospital');

// ==================== INVOICE ====================

Route::middleware('auth')->group(function () {
    Route::get('/invoice/{order}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::post('/invoice/{id}/pay', [InvoiceController::class, 'pay'])->name('invoice.pay');
    Route::get('/invoice/{order}/download', [InvoiceController::class, 'download'])->name('invoice.download');
});

// ==================== PROFILE (AUTH REQUIRED) ====================

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/password/change', [ProfileController::class, 'showChangePassword'])->name('password.change');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::put('/profile/email', [ProfileController::class, 'updateEmail'])->name('profile.email.update');
    Route::post('/profile/upload-photo', [ProfileController::class, 'updateProfilePicture'])->name('profile.upload.photo');
});

// ==================== ADMIN ROUTES ====================

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/update-status/{id}', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
    Route::get('/users', [AdminController::class, 'userList'])->name('user.index');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');

    Route::get('/rumahsakit', [RumahSakitController::class, 'index'])->name('rumahsakit.index');
    Route::post('/rumahsakit/store', [RumahSakitController::class, 'store'])->name('rumahsakit.store');

    Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi.index');
    Route::post('/konsultasi/store', [KonsultasiController::class, 'store'])->name('konsultasi.store');

    Route::get('/testimoni', [AdminTestimoniController::class, 'index'])->name('admin.testimoni.index');
    Route::post('/testimoni/{id}/toggle', [AdminTestimoniController::class, 'toggle'])->name('admin.testimoni.toggle');
    Route::delete('/testimoni/{id}', [AdminTestimoniController::class, 'destroy'])->name('admin.testimoni.destroy');
});

// ==================== TESTIMONI ====================

Route::post('/testimoni', [TestimoniController::class, 'store'])->middleware('auth')->name('testimoni.store');

// ==================== BOTMAN CHAT ====================

Route::match(['get', 'post'], '/botman', function (Request $request) {
    $botman = BotManFactory::create([]);

    function faqAnswer(BotMan $bot, string $questionText, string $answerText) {
        $bot->reply($questionText, ['css_class' => 'user-bubble']);
        $bot->typesAndWaits(1);
        $bot->reply($answerText);
    }

    $botman->hears('faq|help|support|questions', function (BotMan $bot) {
        $bot->reply(
            Question::create('Please choose a question below:')
                ->addButtons([
                    Button::create('How to register an account?')->value('faq_register'),
                    Button::create('Forgot account password')->value('faq_forgot'),
                    Button::create('How to change email')->value('faq_email'),
                    Button::create('How to delete my account')->value('faq_delete'),
                    Button::create('How to book a service')->value('faq_book'),
                    Button::create('What are the payment methods?')->value('faq_payment'),
                    Button::create('How to view order history')->value('faq_history'),
                    Button::create('What is MCU & Travel?')->value('faq_mcu'),
                    Button::create('How to cancel a booking')->value('faq_cancel'),
                ])
        );
    });

    $botman->hears('faq_register', fn($bot) => faqAnswer($bot, 'How to register an account?', 'Click the “Register” button on the homepage...'));
    $botman->hears('faq_forgot', fn($bot) => faqAnswer($bot, 'Forgot account password', 'Click “Forgot Password?”...'));
    $botman->hears('faq_email', fn($bot) => faqAnswer($bot, 'How to change email', 'Go to profile > update email.'));
    $botman->hears('faq_delete', fn($bot) => faqAnswer($bot, 'How to delete my account', 'Contact admin via “Contact Us”.'));
    $botman->hears('faq_book', fn($bot) => faqAnswer($bot, 'How to book a service', 'Choose service > Book > Pay.'));
    $botman->hears('faq_payment', fn($bot) => faqAnswer($bot, 'Payment methods?', 'BCA, Dana, ShopeePay, QRIS.'));
    $botman->hears('faq_history', fn($bot) => faqAnswer($bot, 'View order history?', 'Log in > “Order History”.'));
    $botman->hears('faq_mcu', fn($bot) => faqAnswer($bot, 'What is MCU & Travel?', 'Medical Check-Up & Tour.'));
    $botman->hears('faq_cancel', fn($bot) => faqAnswer($bot, 'Cancel booking?', 'Unpaid bookings can be canceled.'));

    $botman->fallback(fn($bot) => $bot->reply('Sorry, I didn’t understand. Type "faq" to see help.'));
    $botman->listen();
});
