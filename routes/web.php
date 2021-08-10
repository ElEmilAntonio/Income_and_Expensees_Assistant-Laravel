<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () { 
if(Auth::check()){
return redirect('/redirigir');}else{return view('auth.login');}});
Auth::routes();

Route::get('/Bienvenida', function () {    return view('Bienvenida');});

Route::get('/redirigir','HomeController@redirigir')->name('redirigir');

Route::get('/registro_empleado','Auth\RegisterController@formulario_empleado')->name('registrarempleado');

Route::group(['middleware'=>['auth']], function(){
//rutas administrador
Route::group(['middleware'=>['administrador']],function(){
Route::get('/home', function () {    return redirect('/administrador/'.date("Y-m-d"));});
Route::get('/administrador/{fecha}', 'AdministradorController@mainadministrador')->name('administrador/{fecha}');
Route::get('/gestion_dia/{fecha}', 'AdministradorController@gestiondia')->name('gestion_dia/{fecha}');
Route::get('/permission-denied','DemoController@permissiondenied')->name('nopermission'
);
//gestion categorias
Route::get('/categorias','CategoriaController@main')->name('categorias');
Route::get('/categorias/{id}','CategoriaController@editcategoria')->name('categorias/{id}');
Route::post('/editar_categoria/{id}','CategoriaController@updatecategoria')->name('editar_categoria/{id}');
Route::post('/Guardar_Categoria','CategoriaController@createcategoria')->name('Guardar_Categoria');
Route::get('/eliminar_categoria/{id}','CategoriaController@destroycategoria')->name('eliminar_categoria/{id}');
//gestion Ingresos
Route::post('/update_ingreso/{fecha}','AdministradorController@updateingreso')->name('update_ingreso/{fecha}');

});
Route::post('/create_egreso/{fecha}','AdministradorController@createegreso')->name('/create_egreso/{fecha}');
Route::post('/update_egreso/{fecha}','AdministradorController@updateegreso')->name('/update_egreso/{fecha}');
Route::get('/destroy_egreso/{fecha}/{id}','AdministradorController@destroyegreso')->name('/destroy_egreso/{fecha}/{id}');
Route::get('/cortes/{id}','CorteController@main')->name('cortes/{id}');
Route::get('/generar_corte/{fechaanterior}/{fechasiguiente}','CorteController@generarcorte')->name('cortes/{fechaanterior}/{fechasiguiente}');
Route::post('/buscar_dias','CorteController@buscardias')->name('buscar_dias');
Route::post('/guardar_corte','CorteController@createcorte')->name('guardar_corte');
Route::post('/buscar_dias_edit/{id}','CorteController@buscardiasedit')->name('buscar_dias_edit/{id}');
Route::get('/ir_gestion_corte/{id}/{fechaanterior}/{fechasiguiente}','CorteController@ireditcorte')->name('gestion_corte/{id}/{fechaanterior}/{fechasiguiente}');
Route::get('/gestion_corte/{id}/{fechaanterior}/{fechasiguiente}','CorteController@editcorte')->name('gestion_corte/{id}/{fechaanterior}/{fechasiguiente}');
Route::post('/update_corte/{id}','CorteController@updatecorte')->name('update_corte/{id}');
//busqueda
Route::get('/busqueda/{fechasiguiente}/{fechaanterior}','BusquedaController@main')->name('busqueda/{fechaanterior}/{fechasiguiente}');
Route::post('/buscar','BusquedaController@buscardias')->name('buscar');
Route::get('/buscar_categoria/{categoria}/{fechasiguiente}/{fechaanterior}','BusquedaController@irbusquedacategoria')->name('buscar_categoria/{categoria}/{fechasiguiente}/{fechaanterior}');

Route::get('/excel_dia/{id}', 'AdministradorController@indexexcel')->name('exceldia/{id}');
Route::get('/export_excel/{id}', 'AdministradorController@excel')->name('export_excel/{id}');
Route::get('/export_excel_corte/{id}', 'CorteController@excelcorte')->name('export_excel_corte/{id}');
});