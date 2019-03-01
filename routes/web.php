<?php

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

use App\Contacts;
use Illuminate\Support\Facades\App;


Route::get('/', function () {
    $locale = session('locale');

    if(isset($locale)){
        App::setLocale($locale);

        if($locale == "es"){
            $locale = "en";
        }else{
            $locale = "es";
        }
    }else{
        $locale = "en";
    }

    return view('main',compact('locale'));
});


Route::get('/locale/{locale?}', function ($locale = 'en') {
    session()->put('locale', $locale);
    return redirect('/');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//CONTACTS

Route::get('sendMail/{email}/{subject}/{message}', 'ContactsController@sendMail');
Route::post('contact','ContactsController@store');



//EXCURSIONES
Route::get('excursion-list', 'ExcursionsController@list');
Route::get('excursion-lugar/{id}', 'ExcursionsController@lugares');

//LUGARES
Route::get('lugar-list', 'LugarController@list');


Route::group(['middleware' => 'auth'], function() {
    Route::get('contact-list', 'ContactsController@list');
    Route::Resource('contact','ContactsController', ['except' => 'store']);

    Route::Resource('excursion','ExcursionsController');

    Route::Resource('lugar','LugarController');
    Route::delete('image-delete/{id}', 'LugarController@deleteImage');
});
