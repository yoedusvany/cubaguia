<?php

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

Route::get('/home', 'ContactsController@index')->name('home');



Route::get('/servicios/{path?}', [
    'uses' => 'ContactsController@index',
    'as' => 'servicios',
    'where' => ['path' => '.*']
]);


//CONTACTS
Route::get('sendMail/{email}/{subject}/{message}', 'ContactsController@sendMail');
Route::post('contact','ContactsController@store');
Route::get('getContactData', 'ContactsController@getContactData');
Route::get('/contact-details/{path?}', [
    'uses' => 'ContactsController@index',
    'as' => 'contact-details',
    'where' => ['path' => '.*']
]);

//EXCURSIONES
Route::get('excursion-list', 'ExcursionsController@list');
Route::get('excursion-lugar/{id}', 'ExcursionsController@lugares');

//LUGARES
Route::get('lugar-list', 'LugarController@list');


Route::group(['middleware' => 'auth'], function() {
    //contacts
    Route::get('contact-list', 'ContactsController@list');
    Route::Resource('contact','ContactsController', ['except' => 'store']);
    Route::put('update-contact-data', 'ContactsController@updateContactData');
    Route::get('getContactData1', 'ContactsController@getContactData');

    //excursiones
    Route::Resource('excursion','ExcursionsController');

    //lugares
    Route::Resource('lugar','LugarController');
    Route::delete('image-delete/{id}', 'LugarController@deleteImage');
});
