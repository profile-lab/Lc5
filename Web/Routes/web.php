<?php

$req = \Config\Services::request();
if (!$req->isCLI()) {
    $uri =$req->getUri();
    $supportedLocales = config(App::class)->{'supportedLocales'};
    $supportedLocalesWithoutDefault = array_diff($supportedLocales, array($req->getDefaultLocale()));
	if (in_array($uri->getSegment(1), $supportedLocalesWithoutDefault)) {
		// 
		// if (env('custom.has_shop') === TRUE) {
		// 	$routes->add('{locale}/shop/empty-cart', '\Lc5\Web\Controllers\Shop\Shop::emptyCart', ['as' => $uri->getSegment(1) . 'web_shop_cart_empty']);
		// 	$routes->add('{locale}/shop/remove-cart-row/(:any)', '\Lc5\Web\Controllers\Shop\Shop::cartRemoveRow/$1', ['as' => $uri->getSegment(1) . 'web_shop_cart_remove_row']);
		// 	$routes->add('{locale}/shop/increment-qnt/(:any)', '\Lc5\Web\Controllers\Shop\Shop::cartIncrementQnt/$1', ['as' => $uri->getSegment(1) . 'web_shop_cart_increment_qnt']);
		// 	$routes->add('{locale}/shop/decrement-qnt/(:any)', '\Lc5\Web\Controllers\Shop\Shop::cartDecrementQnt/$1', ['as' => $uri->getSegment(1) . 'web_shop_cart_decrement_qnt']);
		// 	$routes->add('{locale}/shop/cart', '\Lc5\Web\Controllers\Shop\Shop::carrello', ['as' => $uri->getSegment(1) . 'web_shop_cart']);
		// 	// 
		// 	$routes->add('{locale}/shop/product/(:segment)/(:segment)', '\Lc5\Web\Controllers\Shop\Shop::detail/$1/$2', ['as' => $uri->getSegment(1) . 'web_shop_detail_model']);
		// 	$routes->add('{locale}/shop/product/(:segment)', '\Lc5\Web\Controllers\Shop\Shop::detail/$1', ['as' => $uri->getSegment(1) . 'web_shop_detail']);
		// 	$routes->add('{locale}/shop/(:segment)', '\Lc5\Web\Controllers\Shop\Shop::index/$1', ['as' => $uri->getSegment(1) . 'web_shop_category']);
		// 	$routes->add('{locale}/shop', '\Lc5\Web\Controllers\Shop\Shop::index', ['as' => $uri->getSegment(1) . 'web_shop_home']);
		// }
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
    // $routes->group('api', function ($routes) {
    //     $routes->match(['get', 'post'], 'set-video-status/(:num)', 'Api\Lezioni::lezioneVista/$1', ['as' => 'web_api_lezione_vista']);
    // });
    // $routes->match(['get', 'post'], 'create-profile', 'UserDashboard::createUserProfile', ['as' => 'web_create_user_profile']);
    // $routes->add('set-user-profile', 'UserDashboard::setUserProfile', ['as' => 'web_set_user_profile']);
    // $routes->add('user-switch', 'UserDashboard::userProfileSwitch', ['as' => 'web_switch_user_profile']);
    // // 
    // $routes->add('buy-subscription', 'UserSubscriptions::selectSubscription', ['as' => 'web_buy_subscription']);
    // $routes->add('buy-subscription/pay/(:any)/(:any)', 'UserSubscriptions::paySubscription/$1/$2', ['as' => 'web_pay_subscription']);
    // $routes->add('buy-subscription/ok', 'UserSubscriptions::paySubscriptionOk', ['as' => 'web_pay_subscription_ok']);


    // // 
    // $routes->add('quiz-results/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Corsi::quizFatto/$1/$2/$3/$4/$5/$6', ['as' => 'web_lezione_quiz_fatto']);
    // $routes->match(['get', 'post'], 'quiz/(:any)/(:any)/(:any)/(:any)/(:any)', 'Corsi::quizDaFare/$1/$2/$3/$4/$5', ['as' => 'web_lezione_quiz_da_fare']);
    // $routes->add('lezione/(:any)/(:any)/(:any)/(:any)', 'Corsi::dettaglioLezione/$1/$2/$3/$4', ['as' => 'web_dettaglio_corso_lezione']);
    // $routes->add('corso-dett/(:any)/(:any)/(:any)', 'Corsi::dettaglioCorso/$1/$2/$3', ['as' => 'web_dettaglio_corso']);

    // $routes->add('corso/(:any)/anno/(:any)', 'Corsi::anno/$1/$2', ['as' => 'web_corsi_anno']);
    // // $routes->add( 'corsi/(:any)', 'Corsi::scool/$1', ['as' => 'web_corsi_scool']);
    // $routes->add('corsi/(:any)', 'Corsi::index/$1', ['as' => 'web_corsi_scuola']);
    // $routes->add('corsi', 'Corsi::index', ['as' => 'web_corsi']);
    // // 
    // $routes->add('riepilogo-progressi/(:any)', 'UserDashboard::riepilogoProgressi/$1', ['as' => 'web_riepilogo_progressi']);
    // // 
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
// if (env('custom.has_shop') === TRUE) {
// 	$routes->add('shop/empty-cart', '\Lc5\Web\Controllers\Shop\Shop::emptyCart', ['as' => 'web_shop_cart_empty']);
// 	$routes->add('shop/remove-cart-row/(:any)', '\Lc5\Web\Controllers\Shop\Shop::cartRemoveRow/$1', ['as' => 'web_shop_cart_remove_row']);
// 	$routes->add('shop/increment-qnt/(:any)', '\Lc5\Web\Controllers\Shop\Shop::cartIncrementQnt/$1', ['as' => 'web_shop_cart_increment_qnt']);
// 	$routes->add('shop/decrement-qnt/(:any)', '\Lc5\Web\Controllers\Shop\Shop::cartDecrementQnt/$1', ['as' => 'web_shop_cart_decrement_qnt']);
// 	$routes->add('shop/carrello', '\Lc5\Web\Controllers\Shop\Shop::carrello', ['as' => 'web_shop_cart']);
// 	// 
// 	$routes->add('shop/prodotto/(:segment)/(:segment)', '\Lc5\Web\Controllers\Shop\Shop::detail/$1/$2', ['as' => 'web_shop_detail_model']);
// 	$routes->add('shop/prodotto/(:segment)', '\Lc5\Web\Controllers\Shop\Shop::detail/$1', ['as' => 'web_shop_detail']);
// 	$routes->add('shop/(:segment)', '\Lc5\Web\Controllers\Shop\Shop::index/$1', ['as' => 'web_shop_category']);
// 	$routes->add('shop', '\Lc5\Web\Controllers\Shop\Shop::index', ['as' => 'web_shop_home']);
// }
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
