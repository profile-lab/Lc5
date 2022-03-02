<?php

namespace Config;

// Create a new instance of our RouteCollection class.
// $routes = Services::routes();

// // Load the system's routing file first, so that the app and ENVIRONMENT
// // can override as needed.
// if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
// 	require SYSTEMPATH . 'Config/Routes.php';
// }

// /**
//  * --------------------------------------------------------------------
//  * Router Setup
//  * --------------------------------------------------------------------
//  */
// $routes->setDefaultNamespace('Lc5\Web');
// $routes->setDefaultController('Pages');
// $routes->setDefaultMethod('index');
// $routes->setTranslateURIDashes(false);
// $routes->set404Override();
// $routes->setAutoRoute(true);


// // $routes->group('{locale}',function ($routes){});

if (file_exists(ROOTPATH.'lc5/cms/Routes/routes-config.php')) {
    require ROOTPATH.'lc5/cms/Routes/routes-config.php';
}

if (file_exists(ROOTPATH.'lc5/cms/Routes/lc-install.php')) {
    require ROOTPATH.'lc5/cms/Routes/lc-install.php';
}

if (file_exists(ROOTPATH.'lc5/cms/Routes/lc-admin.php')) {
    require ROOTPATH.'lc5/cms/Routes/lc-admin.php';
}

// if (file_exists(ROOTPATH.'lc5/cms/Routes/custom-router.php')) {
// 	require ROOTPATH.'lc5/cms/Routes/custom-router.php';
// }

// if (file_exists(ROOTPATH.'lc5/cms/Routes/api-custom.php')) {
// 	require ROOTPATH.'lc5/cms/Routes/api-custom.php';
// }else if (file_exists(ROOTPATH.'lc5/cms/Routes/api.php')) {
// 	require ROOTPATH.'lc5/cms/Routes/api.php';
// }

// if (file_exists(ROOTPATH.'lc5/cms/Routes/web-custom.php')) {
// 	require ROOTPATH.'lc5/cms/Routes/web-custom.php';
// }else if (file_exists(ROOTPATH.'lc5/cms/Routes/web.php')) {
// 	require ROOTPATH.'lc5/cms/Routes/web.php';
// }
