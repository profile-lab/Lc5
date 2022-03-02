<footer class="site_footer">
	<div class="footer_info_contatti">
		<?= (isset($app->address) && trim($app->address)) ? '<div class="address">' . $app->address . '</div>' : '' ?>
		<?= (isset($app->piva) && trim($app->piva)) ? '<div class="piva">P.IVA: ' . $app->piva . '</div>' : '' ?>
		<?= (isset($app->email) && trim($app->email)) ? '<div class="email">' . $app->email . '</div>' : '' ?>
		<?= (isset($app->phone) && trim($app->phone)) ? '<div class="phone">' . $app->phone . '</div>' : '' ?>
		<?= (isset($app->app_description) && trim($app->app_description)) ? '<div class="app_description">' . $app->app_description . '</div>' : '' ?>
		<?= (isset($app->copy) && trim($app->copy)) ? '<div class="copy">' . $app->copy . '</div>' : '' ?>
	</div>

	<div>

		<nav class="navbar footer_navbar">
			<?php if (isset($site_menus['footer-menu'])) { ?>
				<?= printSiteMenu($site_menus['footer-menu'])  ?>
			<?php } ?>
		</nav>
	</div>

</footer>