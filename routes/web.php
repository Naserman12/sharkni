<?php


use App\Http\Controllers\LangController;
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
use App\Livewire\Pages\Rentals\CompleteRental;
use  App\Livewire\Pages\Tool\AddTool;
use App\Livewire\Pages\Tool\ListTools;
use App\Livewire\Pages\Tool\ShowTool;
use App\Livewire\PaymentForm;
use App\Http\Controllers\Payments\PaymentController;
use App\Livewire\Pages\Categories\EditCategory;
use App\Livewire\Pages\Dashboard\UserDashboard;
use App\Livewire\Pages\Home\HomePage;
use App\Livewire\Pages\Tool\EditTool;

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
Route::get('/', HomePage::class)->name('home');
Route::get('/dashboard', UserDashboard::class)->name('dashboard');
// Route::get('/', function(){
//     // dd(app()->getLocale());
//     return view('welcome');
// })->name('home');
// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth'])
//     ->name('dashboard');
Route::view('/send','livewire.email.send-email-test');
    // Tools
Route::prefix('tools')->middleware('auth')->group(function (){
    Route::get('/add', AddTool::class)->name('tools.add');
    Route::get('/', ListTools::class)->name('tools.index');
    Route::get('/{id}', ShowTool::class)->name('tools.show');
    Route::get('/{id}/edit', EditTool::class)->name('tools.edit');
    Route::get('/category/{slug}', ListTools::class)->name('tools.by_category');
});

// Rentals
Route::prefix('rentals')->middleware('auth')->group(function(){
    Route::get('/', RentalRequests::class)->middleware('auth')->name('rentals.index');
    Route::get('/complete/{id}', CompleteRental::class)->middleware('auth')->name('rentals.complete');
});

// damage Reports
route::prefix('damages')->middleware('auth')->group(function(){
    Route::get('/report', ReportDamage::class)->name('damage.report');
    Route::get('/reports', ManageDamageReports::class)->name('damage.reports');
});

// Catefories
Route::get('categories/add', AddCategory::class)->middleware('auth')->name('categories.add');
Route::get('categories/edit/{id}', EditCategory::class)->middleware('auth',)->name('categories.edit');

// languages
Route::get('/lang/{lang}', [LangController::class,'changeLang']);
// payments
// Route::get('/pay/{paymentId}', [PaymentController::class,"redirectToGateway"])->name('pay');
Route::prefix('payments')->middleware('auth')->group(function(){
    Route::get('/', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/initiate', action: [PaymentController::class, 'initiatePayment'])->name('paystack.initiate');
    Route::get('/callback', [PaymentController::class, 'handlePaystackCallback'])->name('paystack.callback');
    Route::post('/verify', [PaymentController::class, 'verifyPayment'])->name('paystack.verify');
    Route::get('/redirect/{payment}', [PaymentController::class, 'redirectToPayment'])->name('paystack.redirect');
    Route::get('/{rentalId}/{toolId}', PaymentForm::class)->name('payment.form');
    Route::get('/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/failure', [PaymentController::class, 'paymentFailure'])->name('payment.failure');
});
Route::middleware(['auth'])->group(function () {
    // Route::get('/payment/{rental}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
 Route::get('/webhooks/paystack', [PaymentController::class, 'handleWebhook'])->name('paystack.webhook');
});

Route::get('/test-session', function () {
    session()->put('test_key', 'test_value');
    session()->put('test_key', 'test_value');
    return session('test_key'); // يجب أن يعرض 'test_value'
});
require __DIR__.'/auth.php';
