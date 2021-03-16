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

Auth::routes();

Route::get('/', 'HomeController@verificacion');

Route::get('/home', 'HomeController@index')->middleware('entregador')->name('home');
Route::get('/verificacion', 'HomeController@verificacion');

Route::get('/login', 'Auth\LoginController@login')->name('login');
Route::post('/login/auth', 'Auth\LoginController@authenticate');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/admin', 'AdminController@index');
Route::get('/admin/create', 'AdminController@create');
Route::post('/admin/store', 'AdminController@store');
Route::get('/admin/show', 'AdminController@show');
Route::get('/admin/edit', 'AdminController@edit');
Route::put('/admin/update', 'AdminController@update');
Route::get('/admin/contact', 'AdminController@contact');
Route::get('/admin/add_contact', 'AdminController@add_contact');
Route::get('/admin/delete_contact/{id}', 'AdminController@delete_contact');
Route::get('/admin/domicile', 'AdminController@domicile');
Route::get('/admin/add_domicile', 'AdminController@add_domicile');
Route::get('/admin/delete_domicile/{id}', 'AdminController@delete_domicile');
Route::get('/admin/getLocalidades', 'AdminController@getLocalidades');
Route::get('/admin/form_password', 'AdminController@form_password');
Route::post('/admin/change_password', 'AdminController@change_password');
Route::get('/admin/email_preferences', 'AdminController@edit_email_preferences');
Route::post('/admin/email_preferences/store', 'AdminController@store_email_preferences');
Route::get('/admin/usuarios', 'AdminController@view_users');
Route::get('/admin/usuario/change_status/{id}', 'AdminController@change_status');
Route::get('/admin/backup', 'AdminController@backup');

Route::get('/usuario/show', 'UsuarioController@show');
Route::get('/usuario/edit', 'UsuarioController@edit');
Route::put('/usuario/update', 'UsuarioController@update');
Route::get('/usuario/contact', 'UsuarioController@contact');
Route::get('/usuario/add_contact', 'UsuarioController@add_contact');
Route::get('/usuario/delete_contact/{id}', 'UsuarioController@delete_contact');
Route::get('/usuario/domicile', 'UsuarioController@domicile');
Route::get('/usuario/add_domicile', 'UsuarioController@add_domicile');
Route::get('/usuario/delete_domicile/{id}', 'UsuarioController@delete_domicile');
Route::get('/usuario/getLocalidades', 'UsuarioController@getLocalidades');
Route::get('/usuario/form_password', 'UsuarioController@form_password');
Route::post('/usuario/change_password', 'UsuarioController@change_password');
Route::get('/usuario/email_preferences', 'UsuarioController@edit_email_preferences');
Route::post('/usuario/email_preferences/store', 'UsuarioController@store_email_preferences');

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
Route::get('/titular/getLocalidades', 'TitularController@getLocalidades');

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
Route::get('/intermediario/getLocalidades', 'IntermediarioController@getLocalidades');

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
Route::get('/remitente/getLocalidades', 'RemitenteController@getLocalidades');

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
Route::get('/destino/getLocalidades', 'DestinoController@getLocalidades');

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
Route::get('/corredor/getLocalidades', 'CorredorController@getLocalidades');

Route::get('/carga/create/{id}', 'CargaController@create');
Route::post('/carga/store', 'CargaController@store');
Route::get('/carga/edit/{id}', 'CargaController@edit');
Route::put('/carga/update/', 'CargaController@update');

Route::get('/descarga/create/{id}', 'DescargaController@create');
Route::post('/descarga/store', 'DescargaController@store');

Route::get('/producto', 'ProductoController@index');
Route::get('/producto/show/{id}', 'ProductoController@show');

Route::get('/aviso', 'AvisoController@index');
Route::get('/aviso/create', 'AvisoController@create');
Route::post('/aviso/store', 'AvisoController@store');
Route::get('/aviso/show/{id}', 'AvisoController@show');
Route::get('/aviso/edit/{id}', 'AvisoController@edit');
Route::put('/aviso/update/{id}', 'AvisoController@update');
Route::get('/aviso/destroy/{id}', 'AvisoController@destroy');
Route::get('/aviso/change_status/{id}', 'AvisoController@change_status');
Route::get('/aviso/export_excel/{id}', 'AvisoController@export_excel');
Route::get('/aviso/export_pdf/{id}', 'AvisoController@export_pdf');
Route::get('/aviso/send_email/{id}', 'AvisoController@send_email');
Route::get('/aviso/getLocalidades', 'AvisoController@getLocalidades');

Route::get('/reporte/summary', 'ReporteController@summary');
Route::get('/reporte/export_excel', 'ReporteController@export_excel');
Route::get('/reporte/export_pdf', 'ReporteController@export_pdf');
Route::post('/reporte/send_email', 'ReporteController@send_email');
Route::get('/reporte/load_email', 'ReporteController@load_email');
Route::get('/reporte/products', 'ReporteController@products');
Route::get('/reporte/productivity', 'ReporteController@productivity');

