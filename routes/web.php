<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use  App\Livewire\Pages\Auth\VerifyEmail;
use  App\Livewire\Pages\Auth\Register;
use  App\Livewire\Pages\Auth\Login;
use App\Livewire\Pages\Auth\Profile;
use App\Livewire\Pages\Categories\AddCategory;
use App\Livewire\Pages\Damage\ManageDamageReports;
use App\Livewire\Pages\Damage\ReportDamage;
use App\Livewire\Pages\Rentals\RentalRequests;
use  App\Livewire\Pages\Tool\AddTool;
use App\Livewire\Pages\Tool\ListTools;
use App\Livewire\Pages\Tool\ShowTool;
use App\Livewire\PaymentForm;
use App\Http\Controllers\Payments\PaymentController;

// Logon && logout
Route::get('/register', Register::class)->middleware('guest')->name('register');
Route::get('/login', Login::class)->middleware('guest')->name('login');
Route::get('/logout', function(){
    Auth::logout();
    return redirect('/login');
})->middleware('auth')->name('logout');
// Profile
Route::get('profile/{id?}', Profile::class)->middleware('auth')->name('profile');
Route::get('profiles/me', function(){
 return view('edit-profile');
})->middleware('auth')
    ->name('profile.edit');

// Verification Email
Route::get('/email/verify', VerifyEmail::class)
->middleware('auth')->name('verification.notice');
Route::post('email/verification-notification', function(){
    Auth::user()->sendEmailVerificationNotification();
    return back()->with('message', app()->getLocale() == 'ha' ? 'An saka aiko da imel na tabbatarwa. ' : 'Verification email resent');
})->middleware('auth')->name('verification.send');
Route::get('/email/verify/{id}/{hash}', function($id, $hash){
    $user = \App\Models\User::findOrFail($id);
    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
      return redirect()->route('login')->with('error', app()->getLocale() == 'ha' ? 'Hanyar tabbatarwa ba ta daidai ba.' : 'Invalid verification link.');
    }
    if ($user->hasVerifiedEmail()) {
        return redirect()->route('dashboard')->with('message', app()->getLocale() == 'ha' ? 'An riga an tabbatar da imel qin ka.' : 'Your email is already verified.');
    }
    $user->markEmailAsVerified();
    return redirect()->route('dashboard')->with('messagr', app()->getLocale() == 'ha' ? 'An tabbatar da imel qin ka cikin nasara!' : 'Your email has been verified successfully');
})->middleware('auth','signed')->name('verification.verify');

// Home Routes
Route::view('/', 'welcome');
Route::view('/send','livewire.email.send-email-test');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');
    // Tools
Route::get('tools/add', AddTool::class)->middleware('auth')->name('tools.add');
Route::get('tools', ListTools::class)->name('tools.index');
Route::get('tools/{id}', ShowTool::class)->name('tools.show');
Route::get('tools/category/{slug}', ListTools::class)->middleware('auth')->name('tools.by_category');

// Rentals
Route::get('/rentals', RentalRequests::class)->middleware('auth')->name('rentals.index');

// damage Reports
Route::get('damage/report', ReportDamage::class)->middleware('auth')->name('damage.report');
Route::get('damage/reports', ManageDamageReports::class)->middleware('auth')->name('damage.reports');

// Catefories
Route::get('categories/add', AddCategory::class)->middleware('auth')->name('categories.add');

// test SSL 


// Route::get('/test-curl', function () {
//     $ch = curl_init();

//     curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co");
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//     $response = curl_exec($ch);

//     if (curl_errno($ch)) {
//         return 'cURL Error: ' . curl_error($ch);
//     }

//     curl_close($ch);

//     return '✅ تم الاتصال بنجاح بدون التحقق من الشهادة';
// });

//End Test SSL
// payments
Route::get('/pay/{paymentId}', [PaymentController::class,"redirectToGateway"])->name('pay');
Route::prefix('payments')->group(function(){
    Route::get('/', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/initiate', [PaymentController::class, 'initiatePayment'])->name('paystack.initiate');
    Route::get('/callback', [PaymentController::class, 'handlePaystackCallback'])->name('paystack.callback');
    Route::post('/verify', [PaymentController::class, 'verifyPayment'])->name('paystack.verify');
    Route::get('/redirect/{payment}', [PaymentController::class, 'redirectToPayment'])->name('paystack.redirect');
});
Route::get('/payment/{rentalId}/{toolId}', PaymentForm::class)->name('payment.form');
Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/failed', [PaymentController::class, 'paymentfailed'])->name('payment.failed');

Route::middleware(['auth'])->group(function () {
    // Route::get('/payment/{rental}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
 Route::get('/webhooks/paystack', [PaymentController::class, 'handleWebhook'])->name('paystack.webhook');
});


require __DIR__.'/auth.php';
