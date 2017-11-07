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

Route::get('redirect' , function (){

    $query = http_build_query([
        'client_id' => '12',
        'redirect_uri' => 'http://127.0.0.1:8000/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://localhost:8080/oauth/authorize?'.$query);

})->name('get.token');


Route::get('/callback', function (\Illuminate\Http\Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://localhost:8080/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '12',
            'client_secret' => 'gfmaAHoxA9wjKKROU1RlYC95rmgjnQZ3yD9H5Sfq',
            'redirect_uri' => 'http://127.0.0.1:8000/callback',
            'code' => $request->code,
        ],
    ]);
    return json_decode((string) $response->getBody(), true);
});