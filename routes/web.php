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

//FALTAN LOS USUARIOS -> ADMIN Y ENTREGADOR

Route::get('/', function () {
    return view('welcome');
});
//DESCOMENTAR ABAJO
/* Auth::routes(); */
Route::get('/home', 'HomeController@index')->name('home');


Route::get('/cargador', 'CargadorController@index');
Route::get('/cargador/create', 'CargadorController@create');
Route::post('/cargador/store', 'CargadorController@store');
Route::get('/cargador/show/{id}', 'CargadorController@show');
Route::get('/cargador/edit/{id}', 'CargadorController@edit');
Route::put('/cargador/update/{id}', 'CargadorController@update');
Route::put('/cargador/destroy/{id}', 'CargadorController@destroy');

Route::get('/destino', 'DestinoController@index');
Route::get('/destino/create', 'DestinoController@create');
Route::post('/destino/store', 'DestinoController@store');
Route::get('/destino/show/{id}', 'DestinoController@show');
Route::get('/destino/edit/{id}', 'DestinoController@edit');
Route::put('/destino/update/{id}', 'DestinoController@update');
Route::put('/destino/destroy/{id}', 'DestinoController@destroy');

Route::get('/corredor', 'CorredorController@index');
Route::get('/corredor/create', 'CorredorController@create');
Route::post('/corredor/store', 'CorredorController@store');
Route::get('/corredor/show/{id}', 'CorredorController@show');
Route::get('/corredor/edit/{id}', 'CorredorController@edit');
Route::put('/corredor/update/{id}', 'CorredorController@update');
Route::put('/corredor/destroy/{id}', 'CorredorController@destroy');

Route::get('/carga', 'CargaController@index');
Route::get('/carga/create', 'CargaController@create');
Route::post('/carga/store', 'CargaController@store');
Route::get('/carga/show/{id}', 'CargaController@show');
Route::get('/carga/edit/{id}', 'CargaController@edit');
Route::put('/carga/update/{id}', 'CargaController@update');
Route::put('/carga/destroy/{id}', 'CargaController@destroy');

Route::get('/descarga', 'DescargaController@index');
Route::get('/descarga/create', 'DescargaController@create');
Route::post('/descarga/store', 'DescargaController@store');
Route::get('/descarga/show/{id}', 'DescargaController@show');
Route::get('/descarga/edit/{id}', 'DescargaController@edit');
Route::put('/descarga/update/{id}', 'DescargaController@update');
Route::put('/descarga/destroy/{id}', 'DescargaController@destroy');

Route::get('/producto', 'ProductoController@index');
Route::get('/producto/create', 'ProductoController@create');
Route::post('/producto/store', 'ProductoController@store');
//Route::get('/producto/show/{id}', 'ProductoController@show');
Route::get('/producto/edit/{id}', 'ProductoController@edit');
Route::put('/producto/update/{id}', 'ProductoController@update');
Route::put('/producto/destroy/{id}', 'ProductoController@destroy');

Route::get('/aviso', 'AvisoController@index');
Route::get('/aviso/create', 'AvisoController@create');
Route::post('/aviso/store', 'AvisoController@store');
Route::get('/aviso/show/{id}', 'AvisoController@show');
Route::get('/aviso/edit/{id}', 'AvisoController@edit');
Route::put('/aviso/update/{id}', 'AvisoController@update');
Route::put('/aviso/destroy/{id}', 'AvisoController@destroy');
