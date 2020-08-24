<?php

use Illuminate\Support\Facades\Artisan;
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
Route::get('/', 'Auth\LoginController@showLoginForm');
Route::group(['prefix' => 'admin',  'middleware' => ['auth','admin'] ], function()
{
    // admin dashboard tickety a klienti
    Route::get('/tickets','AdminController@tickets')->name('admin-tickets');
    Route::get('/clients','AdminController@clients')->name('admin-clients');

    // editace tiketu
    Route::get('/editTicket/{id}','TicketController@edit')->name('edit-ticket');
    Route::post('/editTicket/{id}','TicketController@update')->name('update-ticket');
    Route::post('/deleteTicket/{id}','TicketController@destroy')->name('delete-ticket');
    Route::post('/deleteTickets','TicketController@multipleDestroy')->name('delete-tickets');
    Route::post('/deleteAttachment/{id}','TicketController@deleteAttachment')->name('delete-attachment');

    // rychle zpracovani noveho ticketu
    Route::post('/processNewTicket/{id}','TicketController@processNewTicket')->name('process-ticket');
    
    //vytvareni a editace klientu
    Route::get('/newClient','ClientController@create')->name('create-client');
    Route::Post('/newClient','ClientController@store')->name('store-client');
    Route::get('/editClient/{id}','ClientController@edit')->name('edit-client');
    Route::post('/editClient/{id}','ClientController@update')->name('update-client');
    Route::post('/deleteClient/{id}','ClientController@destroy')->name('delete-client');
    Route::post('/deleteClients/','ClientController@multipleDestroy')->name('delete-clients');
    Route::get('/client/{id}','ClientController@show')->name('show-client');

    //prihlaseni za klietna
    Route::get('/superLogin/{id}','Auth\LoginController@superLogin')->name('super-login');

    //historie prihlaseni
    Route::get('/loginHistory','LoginHistoryController@showHistory')->name('show-login-history');

    //sprava povolenych ip adres pro prihlaseni adminu
    Route::get('/allowedIp','AllowedIpController@edit')->name('edit-allowed-ip');
    Route::post('/allowedIp','AllowedIpController@update')->name('update-allowed-ip');
});

Route::group(['middleware' => 'auth'],function(){    
  
    Route::get('/dashboard', 'UserController@index')->name('dashboard');
    
    // vytvoreni ticketu
    Route::get('/newTicket','TicketController@create')->name('create-ticket');
    Route::post('/newTicket','TicketController@store')->name('store-ticket');
    
    // schvaleni ticketu
    Route::post('/approveTicketCredit/{id}','TicketController@approveTicketCredits')->name('approve-ticket-credits');
    Route::post('/rejectTicketCredit/{id}','TicketController@rejectTicketCredits')->name('reject-ticket-credits');

    Route::post('/approveTicket/{id}','TicketController@approveTicket')->name('approve-ticket');
    Route::post('/rejectTicket/{id}','TicketController@rejectTicket')->name('reject-ticket');

    // zobrazeni ticketu a pridani commentu
    Route::get('/ticket/{id}','TicketController@show')->name('show-ticket');
    Route::post('/ticket/{id}','TicketController@storeComment')->name('store-comment');
    
    //editace uzivatelskych udaju
    Route::get('/editUser/{id}','UserController@edit')->name('edit-user');
    Route::post('/editUser/{id}','UserController@update')->name('update-user');
});

$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->get('logout', 'Auth\LoginController@logout')->name('logout');


//Auth::routes();
