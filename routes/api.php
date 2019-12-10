<?php

use Illuminate\Http\Request;



// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::get('/libros/list', 'LibroController@bookList');
Route::post('/libros/add', 'LibroController@addBook');
Route::put('/libros/update', 'LibroController@updateBook');
Route::delete('/libros/delete', 'LibroController@deleteBook');

Route::post('/usuarios/add', 'UsuarioController@postUsuario');
Route::put('/usuarios/update', 'UsuarioController@putUsuarios');
Route::delete('/usuarios/delete', 'UsuarioController@deleteUsuarios');

Route::post('/prestar', 'PrestarController@prestarLibro');
Route::put('/devolver', 'PrestarController@devolverLibro');
