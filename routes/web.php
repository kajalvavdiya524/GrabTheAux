<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Auth;

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
  return view('landing_page');
});

Auth::routes(['verify' => true]);

// Route::get('buy/{cookies}', function ($cookies) {
//   if($cookies == 0) {
//     return 'You can not buy 0 cookie!';
//   }
//   $user = Auth::user();
//   $wallet = $user->wallet;
//   if ($wallet > 0 && $wallet > $cookies) {
//     $user->update(['wallet' => $wallet - $cookies * 1]);
//     Log:info('User ' . $user->email . ' have bought ' . $cookies . ' cookies'); // we need to log who ordered and how much
//     return 'Success, you have bought ' . $cookies . ' cookies!';
//   } else {
//     return 'Your wallet has not enough money or cookies are greater than wallet';
//   }
// });

Route::group(['middleware' => ['auth' , 'verified']], function () {
  Route::get('meetings/join' , 'MeetingController@joinMeeting')->middleware('checkMembership');
  Route::post('/meetings/generate-signature' , 'MeetingController@generate_signature');
  Route::get('/meetings/auth-zoom-verification' , 'MeetingController@auth_zoom_verification');
  Route::post('meetings/auth-code' , 'MeetingController@auth_code');
  Route::get('meetings/create-zoom' , 'MeetingController@createMeeting')->middleware('checkMembership')->name('createZoom');
  Route::get('meetings/check-meeting' , 'MeetingController@checkMeeting')->middleware('checkMembership');
  Route::post('/save-meeting-data' , 'MeetingController@saveMeetingData')->middleware('checkMembership');
  Route::resource('meetings' , 'MeetingController')->middleware('checkMembership');
  Route::get('/profile', 'UserController@profile')->name('profile');
  Route::resource('invite' , 'InviteController');
  Route::get('/participants' , 'MeetingController@meetingParticipants');
  Route::get('/hostchange','MeetingController@hostChange');

  Route::get('/spotify' , 'SpotifyController@index');


  Route::group(['middleware' => ['role:Software-admin']], function () {
    Route::resource('users' , 'UserController');
    Route::resource('memberships' , 'MembershipController');
  });

  Route::get('/membership/payment-detail', 'MembershipController@membershipPaymentDetail');
  Route::post('/payment-membership/{id}', 'MembershipController@membershipPayment');

});



Route::get('zoom/auth/redirect', function () {
    return Socialite::driver('zoom')
        ->scopes(['meeting:read	', 'meeting:write'])
        ->redirect();
})->name('zoomRedirect');
Route::get('/deezer_channel', function()
{
	return view('channel');
});
Route::get('/callback/zoom','MeetingController@meetingCallback')->middleware('checkMembership')->name('zoomCallback');;

