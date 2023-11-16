<?php

$req = \Config\Services::request();
if (!$req->isCLI()) {
    $uri =$req->getUri();
    $supportedLocales = config(App::class)->{'supportedLocales'};
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



$routes->match(['get', 'post'], 'login', '\Lc5\Web\Controllers\Users\UserDashboard::login', ['as' => 'web_login']);
$routes->match(['get', 'post'], 'registrati', '\Lc5\Web\Controllers\Users\UserDashboard::signUp', ['as' => 'web_signup']);
$routes->get( 'email-template/(:any)', '\Lc5\Web\Controllers\Users\UserDashboard::vediEmailTemplate/$1');
$routes->match(['get', 'post'], 'recupera-password/(:any)', '\Lc5\Web\Controllers\Users\UserDashboard::recuperaPasswordS1/$1', ['as' => 'web_recupera_password_s1_action']);
$routes->match(['get', 'post'], 'recupera-password', '\Lc5\Web\Controllers\Users\UserDashboard::recuperaPasswordS1', ['as' => 'web_recupera_password_s1']);
$routes->match(['get', 'post'], 'crea-nuova-password/(:any)', '\Lc5\Web\Controllers\Users\UserDashboard::recuperaPasswordS2/$1', ['as' => 'web_recupera_password_s2']);
$routes->match(['get'], 'attiva-account/(:any)', '\Lc5\Web\Controllers\Users\UserDashboard::attivaAccount/$1', ['as' => 'web_attiva_account']);
$routes->match(['get'], 'logout', '\Lc5\Web\Controllers\Users\UserDashboard::logout', ['as' => 'web_logout']);



$routes->group('user-zone', ['namespace' => '\Lc5\Web\Controllers\Users', 'filter' => 'web_users_auth'], function ($routes) {
    
    $routes->group('user-settings', function ($routes) {
        // $routes->add('membership', 'UserSettings::membershipList', ['as' => 'web_user_settings_membership']);
        // $routes->match(['get', 'post'], 'profiles/(:num)', 'UserSettings::profilesEdit/$1', ['as' => 'web_user_settings_profile_edit']);
        // $routes->add('profiles/delete/(:num)', 'UserSettings::profilesDelete/$1', ['as' => 'web_user_settings_profile_delete']);
        // $routes->add('profiles', 'UserSettings::profilesList', ['as' => 'web_user_settings_profiles']);
        $routes->match(['get', 'post'], '/', 'UserSettings::userAccount', ['as' => 'web_user_settings_account']);
    });
    // 
    $routes->add('', 'UserDashboard::personalDashboard', ['as' => 'web_dashboard']);
});



$routes->match(['get', 'post'], '/payment-stripe-webhook', '\App\Controllers\App\Webhooks::paymentStripeWebhook', ['as' => 'payment_stripe_webhook']);


// 
$routes->add('add-maintainer', '\Lc5\Web\Controllers\Pages::addMaintainer');
//
$routes->add('archivio/(:segment)/(:segment)/', '\Lc5\Web\Controllers\Posts::post/$1/$2', ['as' => 'web_posts_single']);
$routes->add('archivio/(:segment)', '\Lc5\Web\Controllers\Posts::index/$1', ['as' => 'web_posts_archive']);
$routes->add('archivio', '\Lc5\Web\Controllers\Posts::archivioDefault', ['as' => 'web_posts_archivie_default']);
//
$routes->add('(:any)', '\Lc5\Web\Controllers\Pages::page/$1', ['as' => 'web_page']);
$routes->get('/', '\Lc5\Web\Controllers\Pages::index', ['as' => 'web_homepage']);
$routes->add('', '\Lc5\Web\Controllers\Pages::index');

$routes->setDefaultNamespace('\Lc5\Web\Controllers\Pages');
$routes->setDefaultController('Pages');
$routes->setDefaultMethod('index');
