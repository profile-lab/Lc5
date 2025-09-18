<?php
// ['namespace' => 'Lc5\Cms\Controllers', 'filter' => 'admin_auth'], 
// 
$routes->group('api',  function ($routes) {
	$routes->group('v1',  function ($routes) {
		$req = \Config\Services::request();

		// if (!$req->isCLI()) {
		// 	$uri = $req->getUri();
		// 	$supportedLocales = config("APP")->{'supportedLocales'};
		// 	$supportedLocalesWithoutDefault = array_diff($supportedLocales, array($req->getDefaultLocale()));
		// 	if (in_array($uri->getSegment(1), $supportedLocalesWithoutDefault)) {
		// 		//
		// 		$routes->add('{locale}/archive/(:segment)/(:segment)/', 'Posts::post/$1/$2', ['as' => $uri->getSegment(1) . 'api_posts_single']);
		// 		$routes->add('{locale}/archive/(:segment)', 'Posts::index/$1', ['as' => $uri->getSegment(1) . 'api_posts_archive']);
		// 		$routes->add('{locale}/archive', 'Posts::archivioDefault', ['as' => $uri->getSegment(1) . 'api_posts_archivie_default']);
		// 		//
		// 		$routes->add('{locale}/(:any)', 'PagesApi::page/$1', ['as' => $uri->getSegment(1) . 'api_page']);
		// 		$routes->add('{locale}', 'PagesApi::index', ['as' => $uri->getSegment(1) . 'api_homepage']);
		// 	}
		// }

		// 
		//
		// $routes->add('archivio/(:segment)/(:segment)/', 'Posts::post/$1/$2', ['as' => 'api_posts_single']);
		// $routes->add('archivio/(:segment)', 'Posts::index/$1', ['as' => 'api_posts_archive']);
		// $routes->add('archivio', 'Posts::archivioDefault', ['as' => 'api_posts_archivie_default']);
		// 
		$routes->match(['GET', 'POST'], 'page/index', '\Lc5\Api\Controllers\PagesApi::index', ['as' => 'api_homepage']);
		$routes->match(['GET', 'POST'], 'page/(:any)', '\Lc5\Api\Controllers\PagesApi::page/$1', ['as' => 'api_page']);

		// $routes->set404Override('PagesApi::error404');
		// $routes->setDefaultNamespace('Pages');
		// $routes->setDefaultController('Pages');
		// $routes->setDefaultMethod('index');

		// $routes->set404Override(function( $message = null )
		// {
		//     $data = [
		//         'title' => '404 - Page not found',
		//         'message' => $message,
		//     ];
		//     echo view('my404/viewfile', $data);
	});
});
