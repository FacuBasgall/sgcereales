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
Route::get('/usuario/contact/{id}', 'UsuarioController@contact');
Route::get('/usuario/add_contact/{id}', 'UsuarioController@add_contact');
Route::get('/usuario/delete_contact/{id}', 'UsuarioController@delete_contact');

Route::get('/titular', 'TitularController@index');
Route::get('/titular/create', 'TitularController@create');
Route::post('/titular/store', 'TitularController@store');
Route::get('/titular/show/{id}', 'TitularController@show');
Route::get('/titular/edit/{id}', 'TitularController@edit');
Route::put('/titular/update/{id}', 'TitularController@update');
Route::get('/titular/destroy/{id}', 'TitularController@destroy');
Route::get('/titular/contact/{id}', 'TitularController@contact');
Route::get('/titular/add_contact/{id}', 'TitularController@add_contact');
Route::get('/titular/delete_contact/{id}', 'TitularController@delete_contact');

Route::get('/intermediario', 'IntermediarioController@index');
Route::get('/intermediario/create', 'IntermediarioController@create');
Route::post('/intermediario/store', 'IntermediarioController@store');
Route::get('/intermediario/show/{id}', 'IntermediarioController@show');
Route::get('/intermediario/edit/{id}', 'IntermediarioController@edit');
Route::put('/intermediario/update/{id}', 'IntermediarioController@update');
Route::get('/intermediario/destroy/{id}', 'IntermediarioController@destroy');
Route::get('/intermediario/contact/{id}', 'IntermediarioController@contact');
Route::get('/intermediario/add_contact/{id}', 'IntermediarioController@add_contact');
Route::get('/intermediario/delete_contact/{id}', 'IntermediarioController@delete_contact');

Route::get('/remitente', 'RemitenteController@index');
Route::get('/remitente/create', 'RemitenteController@create');
Route::post('/remitente/store', 'RemitenteController@store');
Route::get('/remitente/show/{id}', 'RemitenteController@show');
Route::get('/remitente/edit/{id}', 'RemitenteController@edit');
Route::put('/remitente/update/{id}', 'RemitenteController@update');
Route::get('/remitente/destroy/{id}', 'RemitenteController@destroy');
Route::get('/remitente/contact/{id}', 'RemitenteController@contact');
Route::get('/remitente/add_contact/{id}', 'RemitenteController@add_contact');
Route::get('/remitente/delete_contact/{id}', 'RemitenteController@delete_contact');

Route::get('/destino', 'DestinoController@index');
Route::get('/destino/create', 'DestinoController@create');
Route::post('/destino/store', 'DestinoController@store');
Route::get('/destino/show/{id}', 'DestinoController@show');
Route::get('/destino/edit/{id}', 'DestinoController@edit');
Route::put('/destino/update/{id}', 'DestinoController@update');
Route::get('/destino/destroy/{id}', 'DestinoController@destroy');
Route::get('/destino/contact/{id}', 'DestinoController@contact');
Route::get('/destino/add_contact/{id}', 'DestinoController@add_contact');
Route::get('/destino/delete_contact/{id}', 'DestinoController@delete_contact');

Route::get('/corredor', 'CorredorController@index');
Route::get('/corredor/create', 'CorredorController@create');
Route::post('/corredor/store', 'CorredorController@store');
Route::get('/corredor/show/{id}', 'CorredorController@show');
Route::get('/corredor/edit/{id}', 'CorredorController@edit');
Route::put('/corredor/update/{id}', 'CorredorController@update');
Route::get('/corredor/destroy/{id}', 'CorredorController@destroy');
Route::get('/corredor/contact/{id}', 'CorredorController@contact');
Route::get('/corredor/add_contact/{id}', 'CorredorController@add_contact');
Route::get('/corredor/delete_contact/{id}', 'CorredorController@delete_contact');

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
Route::get('/producto/show/{id}', 'ProductoController@show');
//Route::get('/producto/create', 'ProductoController@create');
//Route::post('/producto/store', 'ProductoController@store');
//Route::get('/producto/edit/{id}', 'ProductoController@edit');
//Route::put('/producto/update/{id}', 'ProductoController@update');
//Route::get('/producto/destroy/{id}', 'ProductoController@destroy');

Route::get('/aviso', 'AvisoController@index');
Route::get('/aviso/create', 'AvisoController@create');
Route::post('/aviso/store', 'AvisoController@store');
Route::get('/aviso/show/{id}', 'AvisoController@show');
Route::get('/aviso/edit/{id}', 'AvisoController@edit');
Route::put('/aviso/update/{id}', 'AvisoController@update');
Route::get('/aviso/destroy/{id}', 'AvisoController@destroy');
