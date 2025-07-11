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
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\Admin\TestimoniController as AdminTestimoniController;








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
Route::get('/verify-registration', [RegistrationController::class, 'verify'])->name('verify-registration');
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

    // [KEY 1] CHAT GENERATION FUNCTION
    // This function is designed to create two chat bubbles: one for the user, one for the bot.
    function faqAnswer(BotMan $bot, string $questionText, string $answerText)
    {
        // This creates a chat bubble with a special CSS class so it appears on the right.
        $bot->reply($questionText, [
            'css_class' => 'user-bubble' // This is a CSS marker
        ]);

        // The bot pauses for a moment as if it's typing.
        $bot->typesAndWaits(1);

        // The bot sends its final answer (normally displayed on the left).
        $bot->reply($answerText);
    }

    // Main trigger to show FAQ options.
    $botman->hears('faq|help|support|questions', function (BotMan $bot) {
        $question = Question::create('Please choose a question below:')
            // [IMPORTANT] Make sure .setAsNotified(true) is NOT present here.
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
            ]);

        $bot->reply($question);
    });

    // This block maps each question (button value) to an appropriate answer.
    // Each `hears` triggers `faqAnswer` to create the desired chat flow.
    $botman->hears('faq_register', fn($bot) => faqAnswer($bot, 'How to register an account?', 'Click the “Register” button on the homepage and fill in your full name, email, and password.'));
    $botman->hears('faq_forgot', fn($bot) => faqAnswer($bot, 'Forgot account password', 'Click “Forgot Password?” on the login page and follow the reset instructions.'));
    $botman->hears('faq_email', fn($bot) => faqAnswer($bot, 'How to change email', 'Go to your profile page > update email in account settings.'));
    $botman->hears('faq_delete', fn($bot) => faqAnswer($bot, 'How to delete my account', 'Please contact the admin through the “Contact Us” menu to request account deletion.'));
    $botman->hears('faq_book', fn($bot) => faqAnswer($bot, 'How to book a service', 'Select a service > Book > Choose date > Proceed to payment.'));
    $botman->hears('faq_payment', fn($bot) => faqAnswer($bot, 'What are the payment methods?', 'We accept BCA, Dana, ShopeePay, QRIS, and other digital payment options.'));
    $botman->hears('faq_history', fn($bot) => faqAnswer($bot, 'How to view order history', 'Log in to your account and go to the “Order History” menu.'));
    $botman->hears('faq_mcu', fn($bot) => faqAnswer($bot, 'What is MCU & Travel?', 'A combined service of Medical Check-Up and recreational tour at tourist locations.'));
    $botman->hears('faq_cancel', fn($bot) => faqAnswer($bot, 'How to cancel a booking', 'Unpaid bookings can be canceled from the “Order History” menu.'));

    // Fallback if the bot doesn't understand the input.
    $botman->fallback(fn($bot) => $bot->reply('Sorry, I didn’t understand. Type "faq" to see common questions.'));

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
// Route::post('/midtrans/callback', [MidtransController::class, 'callback']);

Route::get('/paket/{id}', [PemesananController::class, 'form'])->name('pemesanan.form');
Route::post('/pemesanan/proses', [PemesananController::class, 'proses'])->name('pemesanan.proses');
// Route::get('/pembayaran/{id}', [PembayaranController::class, 'bayar'])->name('bayar.midtrans');
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
Route::get('/hospital/{id}', [RumahSakitController::class, 'show'])->name('detail-hospital');

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

Route::post('/invoice/pay/{id}', [MidtransController::class, 'bayar'])->name('invoice.pay');
Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler']);
// Route::post('/midtrans/notification', [MidtransController::class, 'handleNotification']);
// Route::post('/midtrans/notification', [MidtransController::class, 'handleMidtransWebhook']);
// Route::post('/midtrans/webhook', [MidtransController::class, 'notificationHandler']);
Route::post('/midtrans/notification', [InvoiceController::class, 'handleNotification']);

Route::post('/midtrans/notification', [\App\Http\Controllers\InvoiceController::class, 'handleNotification']);
Route::post('api/midtrans/notification', [MidtransController::class, 'handleNotification']);
Route::get('/midtrans/finish', [MidtransController::class, 'finish']);


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/testimoni', [TestimoniController::class, 'store'])->middleware('auth')->name('testimoni.store');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/testimoni', [App\Http\Controllers\Admin\TestimoniController::class, 'index'])->name('admin.testimoni.index');
    Route::post('/admin/testimoni/{id}/toggle', [App\Http\Controllers\Admin\TestimoniController::class, 'toggleActive'])->name('admin.testimoni.toggle');
    Route::delete('/admin/testimoni/{id}', [App\Http\Controllers\Admin\TestimoniController::class, 'destroy'])->name('admin.testimoni.destroy');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/testimoni', [AdminTestimoniController::class, 'index'])->name('admin.testimoni.index');
    Route::post('/testimoni/{id}/toggle', [AdminTestimoniController::class, 'toggle'])->name('admin.testimoni.toggle');
    Route::delete('/testimoni/{id}', [AdminTestimoniController::class, 'destroy'])->name('admin.testimoni.destroy');
});



Route::post('/admin/testimoni/toggle/{id}', [AdminTestimoniController::class, 'toggle'])->name('admin.testimoni.toggle');

