<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => 'home','uses'=>'HomeController@index'))->before('auth:norule');

Route::get('inscripcion', array('uses'=>'InscripcionesController@index'))->before('auth:authorize');

Route::get('status', array('uses'=>'SociosController@index'))->before('auth:authorize');

Route::get('reportes', array('uses'=>'ReportesController@index'))->before('auth:authorize');

Route::get('reporteGeneral', array('uses'=>'ReportesController@reporteGeneral'))->before('auth:authorize');

Route::get('reportePagos', array('uses'=>'ReportesController@reportePagos'))->before('auth:authorize');

Route::get('debug', array('uses'=>'DebugController@index'))->before('auth:norule');

Route::get('noAccess', array('uses'=>'HomeController@noAccess'));

Route::get('agregarEmpleadoView', array('uses'=>'EmpleadosController@agregarEmpleadoView'))->before('auth:authorize');

Route::get('pagarEmpleadoView', array('uses'=>'EmpleadosController@pagarEmpleadoView'))->before('auth:authorize');

Route::get('pagarServicioView', array('uses'=>'ServiciosController@pagarServicioView'))->before('auth:authorize');

Route::any('updateSocio', array('uses'=>'SociosController@updateSocio'))->before('auth:authorize');

Route::any('borrarPago', array('uses'=>'PagosController@borrarPago'))->before('auth:authorize');

Route::any('updatePago', array('uses'=>'PagosController@updatePago'))->before('auth:authorize');

Route::post('addEmpleado', array('uses'=>'EmpleadosController@addEmpleado'))->before('auth:authorize');

Route::post('getClassesToRemove', array('uses'=>'HomeController@getClassesToRemove'));

Route::post('addInscripcion', array('uses'=>'InscripcionesController@addInscripcion'))->before('auth:authorize');

Route::post('addPago', array('uses'=>'PagosController@registrarPago'))->before('auth:authorize');

Route::post('pagarEmpleado', array('uses'=>'EmpleadosController@pagarEmpleado'))->before('auth:authorize');

Route::post('pagarServicio', array('uses'=>'ServiciosController@pagarServicio'))->before('auth:authorize');

Route::post('verificarPromoYStatus', array('uses'=>'PagosController@verificarPromocionYStatus'))->before('auth:norule');

Route::post('statusSocio', array('uses'=>'SociosController@getStatus'))->before('auth:authorize');

Route::get('busquedaSocios', array('uses'=>'BusquedasController@index'))->before('auth:authorize');

Route::any('listarSocios', array('uses'=>'BusquedasController@listarSocios'))->before('auth:authorize');

Route::any('listarEmpleadosView', array('uses'=>'BusquedasController@listarEmpleadosView'))->before('auth:authorize');

Route::any('listarPromosView', array('uses'=>'PromosController@index'))->before('auth:authorize');

Route::any('listarEmpleados', array('uses'=>'BusquedasController@listarEmpleados'))->before('auth:authorize');

Route::any('listarPagos', array('uses'=>'BusquedasController@indexListaPagos'))->before('auth:authorize');

Route::any('listarPagosServicios', array('uses'=>'BusquedasController@indexListaPagosServicios'))->before('auth:authorize');

Route::any('listarPagosEmpleados', array('uses'=>'BusquedasController@indexListaPagosEmpleados'))->before('auth:authorize');

Route::any('listarLogEventos', array('uses'=>'BusquedasController@indexLogEventos'))->before('auth:authorize');

Route::any('getPagos', array('uses'=>'BusquedasController@listarPagos'))->before('auth:authorize');

Route::any('getPromos', array('uses'=>'PromosController@listarPromos'))->before('auth:authorize');
Route::any('updatePromo', array('uses'=>'PromosController@updatePromo'))->before('auth:authorize');
Route::any('deletePromo', array('uses'=>'PromosController@deletePromo'))->before('auth:authorize');
Route::any('createPromo', array('uses'=>'PromosController@createPromo'))->before('auth:authorize');

Route::any('getPagosServicios', array('uses'=>'BusquedasController@listarPagosServicios'))->before('auth:authorize');

Route::any('getPagosEmpleados', array('uses'=>'BusquedasController@listarPagosEmpleados'))->before('auth:authorize');

Route::any('getLogEventos', array('uses'=>'BusquedasController@listarLogEventos'))->before('auth:authorize');

Route::any('pago', array('uses'=>'PagosController@index'))->before('auth:authorize');

Route::post('getUsuariosPorNombre', array('uses'=>'BusquedasController@listarSociosPorNombre'))->before('auth:authorize');

Route::post('getEmpleadosPorNombre', array('uses'=>'BusquedasController@listarEmpleadosPorNombre'))->before('auth:authorize');

Route::post('getPromociones', array('uses'=>'CommonController@getPromociones'))->before('auth:norule');

// login

Route::get('login', array('as' => 'login', function () {
    return View::make('login.login')->with('sectionText','Login');
}))->before('guest');

Route::post('login', function () {
        $user = array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
        );
        
        if (Auth::attempt($user)) {
            return Redirect::route('home')
                ->with('flash_notice', 'Bienvenido!.');
        }
        
        // authentication failure! lets go back to the login page
        return Redirect::route('login')
            ->with('flash_error', 'Datos de usuario incorrectos')
            ->withInput();
});

Route::get('logout', array('as' => 'logout', function () {
    Auth::logout();
    return View::make('login.login')->with('sectionText','Login');
}))->before('auth:norule');

//end login