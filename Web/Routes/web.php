<?php

$req = \Config\Services::request();

if (env('custom.no_add_maintainer_action') === true) {    
    // dd(env('custom.no_add_maintainer_action'));
} else {
    $routes->add('add-maintainer', '\Lc5\Web\Controllers\Pages::addMaintainer');
}

if (!$req->isCLI()) {
    $uri =$req->getUri();
    $supportedLocales = config("APP")->{'supportedLocales'};
    $supportedLocalesWithoutDefault = array_diff($supportedLocales, array($req->getDefaultLocale()));
	if (in_array($uri->getSegment(1), $supportedLocalesWithoutDefault)) {
		//
		$routes->add('{locale}/archive/(:segment)/(:segment)/', '\Lc5\Web\Controllers\Posts::post/$1/$2', ['as' => $uri->getSegment(1) . 'web_posts_single']);
		$routes->add('{locale}/archive/(:segment)', '\Lc5\Web\Controllers\Posts::index/$1', ['as' => $uri->getSegment(1) . 'web_posts_archive']);
		$routes->add('{locale}/archive', '\Lc5\Web\Controllers\Posts::archivioDefault', ['as' => $uri->getSegment(1) . 'web_posts_archivie_default']);
		//
		$routes->add('{locale}/(:any)', '\Lc5\Web\Controllers\Pages::page/$1', ['as' => $uri->getSegment(1) . 'web_page']);
		$routes->add('{locale}', '\Lc5\Web\Controllers\Pages::index', ['as' => $uri->getSegment(1) . 'web_homepage']);
	}
}

// 
//
$routes->add('archivio/(:segment)/(:segment)/', '\Lc5\Web\Controllers\Posts::post/$1/$2', ['as' => 'web_posts_single']);
$routes->add('archivio/(:segment)', '\Lc5\Web\Controllers\Posts::index/$1', ['as' => 'web_posts_archive']);
$routes->add('archivio', '\Lc5\Web\Controllers\Posts::archivioDefault', ['as' => 'web_posts_archivie_default']);
//
$routes->add('design-system-grid', '\Lc5\Web\Controllers\DesignSystem::grid', ['as' => 'design_system_grid_page']);
$routes->add('design-system', '\Lc5\Web\Controllers\DesignSystem::list', ['as' => 'design_system_page']);
// 
$routes->add('(:any)', '\Lc5\Web\Controllers\Pages::page/$1', ['as' => 'web_page']);
$routes->get('/', '\Lc5\Web\Controllers\Pages::index', ['as' => 'web_homepage']);
$routes->add('', '\Lc5\Web\Controllers\Pages::index');

$routes->set404Override('\Lc5\Web\Controllers\Pages::error404');
$routes->setDefaultNamespace('\Lc5\Web\Controllers\Pages');
$routes->setDefaultController('Pages');
$routes->setDefaultMethod('index');

// $routes->set404Override(function( $message = null )
// {
//     $data = [
//         'title' => '404 - Page not found',
//         'message' => $message,
//     ];
//     echo view('my404/viewfile', $data);
// });