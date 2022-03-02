<?php 

if (isset($this->request)) {
	if (!$this->request->isCLI()) {
		$supportedLocalesWithoutDefault = array_diff($this->config->supportedLocales, array($this->config->defaultLocale));
		if (in_array($this->request->uri->getSegment(1), $supportedLocalesWithoutDefault)) {
			// 
			if (env('custom.has_shop') === TRUE) {
				$routes->add('{locale}/shop/empty-cart', '\Lc5\Web\Controllers\Shop\Shop::emptyCart', ['as' => $this->request->uri->getSegment(1) . 'web_shop_cart_empty']);
				$routes->add('{locale}/shop/remove-cart-row/(:any)', '\Lc5\Web\Controllers\Shop\Shop::cartRemoveRow/$1', ['as' => $this->request->uri->getSegment(1) . 'web_shop_cart_remove_row']);
				$routes->add('{locale}/shop/increment-qnt/(:any)', '\Lc5\Web\Controllers\Shop\Shop::cartIncrementQnt/$1', ['as' => $this->request->uri->getSegment(1) . 'web_shop_cart_increment_qnt']);
				$routes->add('{locale}/shop/decrement-qnt/(:any)', '\Lc5\Web\Controllers\Shop\Shop::cartDecrementQnt/$1', ['as' => $this->request->uri->getSegment(1) . 'web_shop_cart_decrement_qnt']);
				$routes->add('{locale}/shop/cart', '\Lc5\Web\Controllers\Shop\Shop::carrello', ['as' => $this->request->uri->getSegment(1) . 'web_shop_cart']);
				// 
				$routes->add('{locale}/shop/product/(:segment)/(:segment)', '\Lc5\Web\Controllers\Shop\Shop::detail/$1/$2', ['as' => $this->request->uri->getSegment(1) . 'web_shop_detail_model']);
				$routes->add('{locale}/shop/product/(:segment)', '\Lc5\Web\Controllers\Shop\Shop::detail/$1', ['as' => $this->request->uri->getSegment(1) . 'web_shop_detail']);
				$routes->add('{locale}/shop/(:segment)', '\Lc5\Web\Controllers\Shop\Shop::index/$1', ['as' => $this->request->uri->getSegment(1) . 'web_shop_category']);
				$routes->add('{locale}/shop', '\Lc5\Web\Controllers\Shop\Shop::index', ['as' => $this->request->uri->getSegment(1) . 'web_shop_home']);
			}
			//
			$routes->add('{locale}/archive/(:segment)/(:segment)/', '\Lc5\Web\Controllers\Posts::post/$1/$2', ['as' => $this->request->uri->getSegment(1) . 'web_posts_single']);
			$routes->add('{locale}/archive/(:segment)', '\Lc5\Web\Controllers\Posts::index/$1', ['as' => $this->request->uri->getSegment(1) . 'web_posts_archive']);
			$routes->add('{locale}/archive', '\Lc5\Web\Controllers\Posts::archivioDefault', ['as' => $this->request->uri->getSegment(1) . 'web_posts_archivie_default']);
			//
			$routes->add('{locale}/(:any)', '\Lc5\Web\Controllers\Pages::page/$1', ['as' => $this->request->uri->getSegment(1) . 'web_page']);
			$routes->add('{locale}', '\Lc5\Web\Controllers\Pages::index', ['as' => $this->request->uri->getSegment(1) . 'web_homepage']);
		}
	}
}
// 
if (env('custom.has_shop') === TRUE) {
	$routes->add('shop/empty-cart', '\Lc5\Web\Controllers\Shop\Shop::emptyCart', ['as' => 'web_shop_cart_empty']);
	$routes->add('shop/remove-cart-row/(:any)', '\Lc5\Web\Controllers\Shop\Shop::cartRemoveRow/$1', ['as' => 'web_shop_cart_remove_row']);
	$routes->add('shop/increment-qnt/(:any)', '\Lc5\Web\Controllers\Shop\Shop::cartIncrementQnt/$1', ['as' => 'web_shop_cart_increment_qnt']);
	$routes->add('shop/decrement-qnt/(:any)', '\Lc5\Web\Controllers\Shop\Shop::cartDecrementQnt/$1', ['as' => 'web_shop_cart_decrement_qnt']);
	$routes->add('shop/carrello', '\Lc5\Web\Controllers\Shop\Shop::carrello', ['as' => 'web_shop_cart']);
	// 
	$routes->add('shop/prodotto/(:segment)/(:segment)', '\Lc5\Web\Controllers\Shop\Shop::detail/$1/$2', ['as' => 'web_shop_detail_model']);
	$routes->add('shop/prodotto/(:segment)', '\Lc5\Web\Controllers\Shop\Shop::detail/$1', ['as' => 'web_shop_detail']);
	$routes->add('shop/(:segment)', '\Lc5\Web\Controllers\Shop\Shop::index/$1', ['as' => 'web_shop_category']);
	$routes->add('shop', '\Lc5\Web\Controllers\Shop\Shop::index', ['as' => 'web_shop_home']);
}
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