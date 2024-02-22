<?php

use App\Http\Controllers\SaveTokenController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StatiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Route::prefix('import')->group(function () {
    Route::controller(ImportExportController::class)->group(function () {
        Route::get('import_export', 'importExport');
        Route::post('import', 'import')->name('import');
        Route::get('export', 'export')->name('export');
        Route::get('skalla', 'skalla')->name('skalla');
        Route::get('arteast', 'arteast')->name('arteast');
        Route::get('velldoris', 'velldoris')->name('velldoris');
    });
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/doors.xml', [SitemapController::class, 'doors'])->name('doors');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('index');
Route::get('/yandex.xml', [SitemapController::class, 'yandex'])->name('yandex');
Route::get('/vk.xml', [SitemapController::class, 'vk'])->name('vk');
Route::get('/amo', [\App\Http\Controllers\AmoCrmController::class, 'index'])->name('index');


Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::get('/stati/stati', function () {
    return redirect('/stati');
});
Route::get('/stati', [StatiController::class, 'index'])->name('stati');
Route::get('/stati/{statja}', [StatiController::class, 'statja'])->name('statja');

Route::get('/page/contacts', function () {
    return redirect('/contacts');
});

Route::get('/page/success', function () {
    return redirect('/success');
});
Route::get('/success', [ContactsController::class, 'success'])->name('success');
Route::get('/contacts', [ContactsController::class, 'index'])->name('contacts');

Route::get('/page/{name}', [PageController::class, 'index'])->name('page');
Route::get('/search', [SearchController::class, 'search'])->name('search');


//Route::get('/contacts', [PageController::class, 'contacts'])->name('page');


Route::get('/{category}', [CategoryController::class, 'index'])->name('category');
Route::get('/{category}/{product}', [ProductController::class, 'index'])->name('category.product');


Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');
Route::post('/update-to-cart', [CartController::class, 'updateToCart'])->name('updateToCart');
Route::post('/delete-to-cart', [CartController::class, 'deleteToCart'])->name('deleteToCart');
Route::post('/get-cart', [CartController::class, 'getCart'])->name('getCart');
Route::post('/get-cart-qty', [CartController::class, 'getCartQty'])->name('getCartQty');
Route::post('/validate-input', [CartController::class, 'validateInput'])->name('validateInput');
Route::post('/price-calculation', [CartController::class, 'priceCalculation'])->name('priceCalculation');
Route::post('/add-order', [CartController::class, 'addOrder'])->name('addOrder');
Route::post('/send-email', [MailController::class, 'sendEmail'])->name('sendEmail');
Route::post('/send', [MailController::class, 'send'])->name('send');

Route::get('/amo', [SaveTokenController::class, 'index']);
