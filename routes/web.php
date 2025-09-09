<?php

use App\Http\Controllers\AwardController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\HomeWebController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TestimonialController;

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

// PUBLIC ROUTES
Route::get('/', [HomeWebController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [HomeWebController::class, 'sitemap'])->name('sitemap');
Route::get('/portfolio', [HomeWebController::class, 'portfolio'])->name('portfolio');
Route::get('/gallery', [HomeWebController::class, 'gallery'])->name('gallery');
Route::get('/portfolio/{slug}', [HomeWebController::class, 'portfolioDetail'])->name('portfolio.detail');
Route::get('/articles', [HomeWebController::class, 'articles'])->name('articles');
Route::get('/article/{slug}', [HomeWebController::class, 'articleDetail'])->name('article.detail');
Route::get('/gallery/{award}/items', [GaleriController::class, 'getGalleryByAward'])->name('gallery.by-award');
Route::get('/api/gallery/{gallery}/items', [HomeWebController::class, 'getGalleryItems'])->name('api.gallery.items');

// Additional gallery API routes for better compatibility
Route::get('/gallery/{gallery}/items', [HomeWebController::class, 'getGalleryItems'])->name('gallery.items');
Route::get('/galeri/{galeri}/items', [GaleriController::class, 'getGalleryItems'])->name('galeri.items');

// Gallery Item Detail (AJAX, JSON)
Route::get('/gallery-item/{id}', [GaleriController::class, 'showItem'])->name('gallery.item.show');

// Optional: Gallery page with items
Route::get('/galeri/{id}', [GaleriController::class, 'show'])->name('galeri.show');

// Test routes (outside authentication for debugging)
Route::get('/galeri-test-simple', function() {
    return view('galeri.test-simple');
})->name('galeri.test.simple');

Route::get('/galeri-test', function() {
    $awards = \App\Models\Award::orderBy('nama_award', 'asc')->get();
    return view('galeri.test-form', compact('awards'));
})->name('galeri.test');

// Force redirect test
Route::get('/test-login-redirect', function() {
    return redirect()->route('login')->with('message', 'Redirected from test route');
})->name('test.login.redirect');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// AUTHENTICATED ROUTES
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard.index');
    
    Route::post('image-upload', [SettingController::class, 'storeImage'])->name('image.upload');
    Route::resource('setting', SettingController::class);
    
    // Section Management Routes
    Route::get('/setting/sections/manage', [SettingController::class, 'sections'])->name('setting.sections');
    Route::put('/setting/sections/update', [SettingController::class, 'updateSections'])->name('setting.sections.update');

    // API endpoint for article search
    Route::get('/api/articles/search', [BeritaController::class, 'searchArticles'])->name('articles.search');
    
    // Session check endpoint
    Route::get('/api/auth/check', function() {
        return response()->json([
            'authenticated' => true,
            'user' => Auth::user()->name ?? 'Unknown'
        ]);
    })->name('auth.check');

    // Resource Routes
    Route::resource('dashboard', dashboardController::class);
    Route::resource('berita', BeritaController::class);
    Route::resource('layanan', LayananController::class);
    Route::resource('galeri', GaleriController::class);
    
    Route::resource('project', ProjectController::class);
    Route::resource('testimonial', TestimonialController::class);
    Route::resource('award', AwardController::class);
    Route::resource('contacts', ContactController::class);

    Route::get('/tentang-sistem', [SettingController::class, 'about'])->name('setting.about');
});
