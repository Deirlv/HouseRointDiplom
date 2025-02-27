<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




Route::get('/', function () {
    return view('houses.sections.index');
});

Route::get('/', [HouseController::class, 'index'])->name('houses.index');


Route::get('/about', function () {
    return view('houses.sections.about');
});



Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');

Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');



Route::get('/privacypolicy', function () {
    return view('houses.sections.privacypolicy');
});

Route::get('/terms', function () {
    return view('houses.sections.terms');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/houses/create', [HouseController::class, 'create'])->name('houses.create');

    Route::post('/houses', [HouseController::class, 'store'])->name('houses.store');

    Route::get('/houses/{house}/edit', [HouseController::class, 'edit'])->name('houses.edit');
    Route::put('/houses/{house}', [HouseController::class, 'update'])->name('houses.update');
    Route::delete('/houses/{house}', [HouseController::class, 'destroy'])->name('houses.destroy');

    Route::get('/my-houses', [HouseController::class, 'myHouses'])->name('houses.my');
});


Route::get('/houses', [HouseController::class, 'index'])->name('houses.index');

Route::get('/houses/{house}', [HouseController::class, 'show'])->name('houses.show');

require __DIR__.'/auth.php';
