<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\LotCategoriesController;
use App\Http\Controllers\LotsController;
use App\Http\Controllers\LotTypesController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\ServiceController;
use App\Models\BlogCategory;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Route;

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

Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::get('/', [PageController::class, 'homepage'])->name('homepage');
Route::get('/about-us', [PageController::class, 'aboutUs'])->name('about-us');
Route::get('/properties', [PageController::class, 'properties'])->name('properties.show');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/blogs', [PageController::class, 'blogs'])->name('blogs.show');
Route::get('/contact-us', [PageController::class, 'contactUs'])->name('contactUs');
Route::get('/blogs/blog-details/{id}', [PageController::class, 'blog_Details'])->name('blogs.details');
Route::get('/properties/property-details/{id}', [PageController::class, 'propertiesSinglePage'])->name('properties.single-page');
Route::get('/rentals', [PageController::class, 'rentals'])->name('rentals');
Route::get('/rentals/rental-details/{id}', [PageController::class, 'rentalDetails'])->name('rental-details');

Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');
Route::post('/contact-us', [ContactUsController::class, 'store'])->name('contacts.store');

Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
Route::get('/payments/success', [PaymentController::class, 'success'])->name('payments.success');
Route::get('/payments/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');

Route::get('/properties/property-details/{id}/for-rent', [PageController::class, 'propertyForRent'])
    ->name('properties.for-rent');
Route::get('/properties/{id}/for-sale', [PageController::class, 'propertyForSale'])->name('properties.for_sale');

Route::view('/terms-and-conditions', 'frontend.terms')->name('terms');
Route::view('/privacy-policy', 'frontend.privacy')->name('privacy');



Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('banners', BannerController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('blogCategories', BlogCategoryController::class);
    Route::resource('newsletters', NewsletterController::class);
    Route::resource('contacts', ContactUsController::class);
    Route::resource('properties', PropertiesController::class);
    Route::resource('blocks', BlockController::class);
    Route::resource('lots', LotsController::class);
    Route::resource('lotCategories', LotCategoriesController::class);
    Route::resource('lotTypes', LotTypesController::class);
    Route::resource('payments', PaymentController::class);

    Route::get('newsletter-export', [NewsletterController::class, 'export'])->name('newsletter.export');
    Route::get('contacts-export', [ContactUsController::class, 'export'])->name('contacts.export');

    // ✅ Custom single property image deletion route
    Route::delete('property-images/{id}', [App\Http\Controllers\PropertiesController::class, 'destroyImage'])
        ->name('property-images.destroy');
    // ✅ Custom single lot image deletion route
    Route::delete('lots/images/{id}', [LotsController::class, 'destroyImage'])->name('lots.images.destroy');
});
