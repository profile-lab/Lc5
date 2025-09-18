<?php
$routes->match(['GET', 'POST'], 'lc-admin/first-login', '\Lc5\Cms\Controllers\Admins::firstLogin', ['as' => 'lc_first_login']); //, ['filter' => 'noauth']
$routes->match(['GET'], 'lc-admin/update-db', '\Lc5\Cms\Controllers\Migrate::update', ['as' => 'lc_update_db']); //, ['filter' => 'noauth']
// $routes->match(['GET'], 'lc-admin/datibase-db', '\Lc5\Cms\Controllers\Migrate::datiBase', ['as' => 'lc_datiBase_db']); //, ['filter' => 'noauth']