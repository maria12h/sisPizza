<?php

Route::get('/', function () {
    return view('/trabajador/login');
});

Route::resource('cocina/producto','ProductoController');
Route::resource('ventas/cliente','ClienteController');
Route::resource('pedido','PedidoController');
Route::resource('ventas/venta','VentaController');
//comprobante
Route::get('/ventas/comprobante/{id}','VentaController@actionPdfComprobante');
Route::get('/Pedido/comprobante/{id}','PedidoController@actionPdfComprobante');
//reportes
Route::get('/reportes/listaProducto', 'PdfController@actionPdfProducto');
Route::get('/reportes/listaPedido', 'PdfController@actionPdfPedido');
Route::get('/reportes/listaTrabajador', 'PdfController@actionPdfTrabajador');
Route::get('/reportes/listaVenta', 'PdfController@actionPdfVenta');
Route::get('/reportes/listaCliente', 'PdfController@actionPdfCliente');
//usuario
Route::resource('trabajador', 'TrabajadorController');
Route::post('/usuari/login','ControlUsuarioController@actionLogIn');
Route::get('/usuari/logout','ControlUsuarioController@actionLogOut');

Route::resource('/{slug?}', 'VentaController');

