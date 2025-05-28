<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use  App\Livewire\Pages\Auth\VerifyEmail;
use  App\Livewire\Pages\Auth\Register;
use  App\Livewire\Pages\Auth\Login;
use App\Livewire\Pages\Auth\Profile;
use App\Livewire\Pages\Categories\AddCategory;
use App\Livewire\Pages\Rentals\RentalRequests;
use  App\Livewire\Pages\Tool\AddTool;
use App\Livewire\Pages\Tool\ListTools;
use App\Livewire\Pages\Tool\ShowTool;

// Logon && logout
Route::get('/register', Register::class)->middleware('guest')->name('register');
Route::get('/login', Login::class)->middleware('guest')->name('login');
Route::get('/logout', function(){
    Auth::logout();
    return redirect('/login');
})->middleware('auth')->name('logout');
Route::view('profile/edit', 'profile')
    ->middleware(['auth'])
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

// Profile
Route::get('profile/{id?}', Profile::class)->middleware('auth')->name('profile');

Route::view('/', 'welcome');
Route::view('/send','livewire.email.send-email-test');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');
    // Tools
Route::get('tools/add', AddTool::class)->middleware('auth')->name('tools.add');
Route::get('tools', ListTools::class)->name('tools.index');
Route::get('tools/{id}', ShowTool::class)->name('tools.show');

// Rentals
Route::get('/rentals', RentalRequests::class)->middleware('auth')->name('rentals.index');

// Catefories
Route::get('categories/add', AddCategory::class)->middleware('auth')->name('categories.add');




require __DIR__.'/auth.php';
