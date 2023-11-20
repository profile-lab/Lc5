<@php
//----------------------------------------------------------------------------
//------------------- LC

$routes->group('lc-admin', ['namespace' => 'App\Controllers\LcCustom', 'filter' => 'admin_auth'], function ($routes) {
	// {nome_modulo}
    $routes->group('{nome_modulo}', function ($routes) {
		$routes->get('delete/(:num)', '{backClassName_string}::delete/$1', ['as' => 'lc_{nome_modulo}_delete']);
		$routes->match(['get', 'post'], 'edit/(:num)', '{backClassName_string}::edit/$1', ['as' => 'lc_{nome_modulo}_edit']);
		$routes->match(['get', 'post'], 'newpost', '{backClassName_string}::newpost', ['as' => 'lc_{nome_modulo}_new']);
		$routes->get('', '{backClassName_string}::index', ['as' => 'lc_{nome_modulo}']);
	});
});
//----------------------------------------------------------------------------
//------------------- WEB


$routes->group('{nome_modulo}', function ($routes) {
	$routes->match(['get', 'post'], '(:any)', '{className_string}::detail/$1', ['as' => '{nome_modulo}_detail']);
});
