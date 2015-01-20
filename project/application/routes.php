<?php

//aplication/routes.php
Route::controller('page_loader');
Route::controller('contact');
Route::controller('backend');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		
|
*/

/*
 *FRONT END ROUTES
 */

Route::get('/', 'page_loader@index');
Route::get('menu/(:any)', 'page_loader@load');

/*
 *BACKEND ROUTES
 */

 //GET
Route::get('/admin-control', 'backend@login');
Route::get('/admin-control/menu/eventos', 'eventos@index');
Route::get('/admin-control/menu/publicidad', 'publicidad@index');
Route::get('/admin-control/menu/usuarios', 'usuarios@index');
Route::get('/admin-control/menu/zonas', 'zonas@index');
Route::get('/admin-control/menu/(:any)', 'backend@load');
Route::get('/admin-control/dashboard', 'backend@index');
Route::get('/admin-control/logout', 'backend@logout');

//---------Establecimientos
Route::get('/admin-control/nuevo-registro/(:any)', 'establecimientos@nuevo_registro');
Route::get('/admin-control/editar-registro/(:any)', 'establecimientos@editar_registro');
//---------Establecimientos

//---------Eventos
Route::get('/admin-control/nuevo-evento/(:any)', 'eventos@nuevo_evento');
Route::get('/admin-control/editar-evento/(:any)/(:any)', 'eventos@editar_evento');
//---------Eventos

//---------Publicidad
Route::get('/admin-control/nueva-publicidad', 'publicidad@nueva_publicidad');
Route::get('/admin-control/editar-publicidad/(:any)', 'publicidad@editar_publicidad');
//---------Publicidad

//---------Usuarios
Route::get('/admin-control/nuevo-usuario', 'usuarios@agregar_usuario');
Route::get('/admin-control/editar-usuario/(:any)', 'usuarios@editar_usuario');
//---------Usuarios

//---------Zonas
Route::get('/admin-control/nueva-zona', 'zonas@nueva_zona');
Route::get('/admin-control/editar-zona/(:any)', 'zonas@editar_zona');
//---------Zonas

//POST
Route::post('/admin-control/login', 'backend@post_login');
//---------Establecimientos
Route::post('/admin-control/nuevo-registro/(:any)', 'establecimientos@nuevo_registro_post');
Route::post('/admin-control/editar-registro/(:any)/(:any)', 'establecimientos@editar_registro_post');
Route::post('/admin-control/eliminar-registros', 'establecimientos@eliminar_registro_post');
//---------Establecimientos

//---------Eventos
Route::post('/admin-control/nuevo-evento/(:any)', 'eventos@nuevo_evento_post');
Route::post('/admin-control/editar-evento/(:any)/(:any)', 'eventos@editar_evento_post');
Route::post('/admin-control/eliminar-evento', 'eventos@eliminar_evento_post');
//---------Eventos

//---------Publicidad
Route::post('/admin-control/nueva-publicidad', 'publicidad@nueva_publicidad_post');
Route::post('/admin-control/editar-publicidad/(:any)', 'publicidad@editar_publicidad_post');
Route::post('/admin-control/eliminar-publicidad', 'publicidad@eliminar_publicidad_post');
//---------Publicidad

//---------Usuarios
Route::post('/admin-control/nuevo-usuario', 'usuarios@agregar_usuario_post');
Route::post('/admin-control/editar-usuario/(:any)', 'usuarios@editar_usuario_post');
Route::post('/admin-control/eliminar-usuario', 'usuarios@eliminar_usuarios_post');
//---------Usuarios

//---------Zonas
Route::post('/admin-control/nueva-zona', 'zonas@nueva_zona_post');
Route::post('/admin-control/editar-zona/(:any)', 'zonas@editar_zona_post');
Route::post('/admin-control/eliminar-zona', 'zonas@eliminar_zona_post');
//---------Zonas
/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});