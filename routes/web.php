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

Route::get('/', function () {
    return view('welcome');
});

//user login route
Auth::routes();

Route::get('/home', 'HomeController@index');
Route::post('/send', 'HomeController@sendMail');
route::post('/saveAsDraft', 'HomeController@saveAsDraft');

Route::get('/inbox', 'InboxController@index');
Route::get('/inbox/{id}', 'InboxController@openMail');
Route::post('/inbox/sendReply', 'InboxController@sendReply');
Route::post('/inbox/forwardMail', 'InboxController@forwardMail');
Route::post('/inbox/trashReceivedMail', 'InboxController@trashReceivedMail');

Route::get('/sent', 'SentController@index');
Route::get('/sent/{id}', 'SentController@openMail');
Route::post('/sent/sendReply', 'SentController@sendReply');
Route::post('/sent/forwardMail', 'SentController@forwardMail');
Route::post('/sent/trashMail', 'SentController@trashMail');

Route::get('/drafts', 'DraftController@index');
Route::get('/drafts/{id}', 'DraftController@openDraft');
Route::post('/drafts/trashDraft', 'DraftController@discardDraft');
Route::post('/drafts/sendMail', 'DraftController@sendMail');

Route::get('/trash', 'TrashController@index');
