<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

//ログイン画面
Route::get('/', function () {
    return view('login');
});

//サービストップ画面
Route::get('/top', function () {
    return view('top');
});

Route::post('/top', function () {
    return view('top');
});

//登録情報変更画面
Route::get('/change', function () {
    return view('change');
});

//登録変更完了画面
Route::post('/accept', function () {
    return view('changeAccept');
});

//新規登録画面
Route::get('/resistration', function () {
    return view('resistration');
});

//新規登録完了画面
Route::post('/entry', function () {
    return view('entry');
});

//所持資格一覧及び登録情報修正画面
Route::get('/qualification', function () {
    return view('qualification');
});
Route::post('/qualification', function () {
    return view('qualification');
});

//所持資格新規登録画面
Route::get('/qual_entry', function () {
    return view('qualificationEntry');
});
Route::post('/qual_entry', function () {
    return view('qualificationEntry');
});

//受検予定資格登録修正画面
Route::get('/expected_qual', function () {
    return view('expectedQualification');
});
Route::post('/expected_qual', function () {
    return view('expectedQualification');
});

//メール送信
// Route::get('/mail',[MailController::class,'send']);

/*以下ルーティングテスト*/
// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('about', function () {
//     return '<h1>このページについて</h1>';
// });
// Route::get('/', [LoginController::class, 'test']);
/*Laravel7以前では、○○Controller@class　のような記述ができたが、Laravel8以降ではできなくなった。*/
