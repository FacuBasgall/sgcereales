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
    return view('home');
});
//DESCOMENTAR ABAJO
/* Auth::routes(); */
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/usuario/show/{id}', 'UsuarioController@show');
Route::get('/usuario/edit/{id}', 'UsuarioController@edit');
Route::put('/usuario/update/{id}', 'UsuarioController@update');

Route::get('/cargador', 'CargadorController@index');
Route::get('/cargador/create', 'CargadorController@create');
Route::post('/cargador/store', 'CargadorController@store');
Route::get('/cargador/show/{id}', 'CargadorController@show');
Route::get('/cargador/edit/{id}', 'CargadorController@edit');
Route::put('/cargador/update/{id}', 'CargadorController@update');
Route::get('/cargador/destroy/{id}', 'CargadorController@destroy');

Route::get('/destino', 'DestinoController@index');
Route::get('/destino/create', 'DestinoController@create');
Route::post('/destino/store', 'DestinoController@store');
Route::get('/destino/show/{id}', 'DestinoController@show');
Route::get('/destino/edit/{id}', 'DestinoController@edit');
Route::put('/destino/update/{id}', 'DestinoController@update');
Route::get('/destino/destroy/{id}', 'DestinoController@destroy');

Route::get('/corredor', 'CorredorController@index');
Route::get('/corredor/create', 'CorredorController@create');
Route::post('/corredor/store', 'CorredorController@store');
Route::get('/corredor/show/{id}', 'CorredorController@show');
Route::get('/corredor/edit/{id}', 'CorredorController@edit');
Route::put('/corredor/update/{id}', 'CorredorController@update');
Route::get('/corredor/destroy/{id}', 'CorredorController@destroy');

//Route::get('/carga', 'CargaController@index');
Route::get('/carga/create', 'CargaController@create');
Route::post('/carga/store', 'CargaController@store');
//Route::get('/carga/show/{id}', 'CargaController@show');
Route::get('/carga/edit/{id}', 'CargaController@edit');
Route::put('/carga/update/{id}', 'CargaController@update');
//Route::get('/carga/destroy/{id}', 'CargaController@destroy');

//Route::get('/descarga', 'DescargaController@index');
Route::get('/descarga/create/{id}', 'DescargaController@create');
Route::post('/descarga/store', 'DescargaController@store');
//Route::get('/descarga/show/{id}', 'DescargaController@show');
Route::get('/descarga/edit/{id}', 'DescargaController@edit');
Route::put('/descarga/update/{id}', 'DescargaController@update');
//Route::get('/descarga/destroy/{id}', 'DescargaController@destroy');

Route::get('/producto', 'ProductoController@index');
Route::get('/producto/create', 'ProductoController@create');
Route::post('/producto/store', 'ProductoController@store');
Route::get('/producto/edit/{id}', 'ProductoController@edit');
Route::put('/producto/update/{id}', 'ProductoController@update');
Route::get('/producto/destroy/{id}', 'ProductoController@destroy');

Route::get('/aviso', 'AvisoController@index');
//Route::get('/aviso/create', 'AvisoController@create');
//Route::post('/aviso/store', 'AvisoController@store');
Route::get('/aviso/show/{id}', 'AvisoController@show');
Route::get('/aviso/edit/{id}', 'AvisoController@edit');
Route::put('/aviso/update/{id}', 'AvisoController@update');
Route::get('/aviso/destroy/{id}', 'AvisoController@destroy');