<header class="site_header">
    <div class="logo">
        <a href="<?= site_url() ?>" title="Homepage">
            <img alt="<?= $app->nome ?>" src="<?= site_url(__base_assets_folder__ . 'lc-admin-assets/frontend/lc5_front_logo.svg') ?>" />
        </a>
        <?= (isset($app->app_claim) && trim($app->app_claim)) ? '<div class="site_claim">'.$app->app_claim.'</div>' : '' ?>
    </div>
    <div class="hamburger">
        <div class="hamburger-box hamburger--elastic">
            <div class="hamburger-inner"></div>
        </div>
    </div>
    <nav class="navbar site_navbar">
        <?php if (isset($site_menus['main-menu'])) { ?>
            <?= printSiteMenu($site_menus['main-menu'])  ?>
        <?php } ?>
        <?php if (isset($lang_menu) && count($lang_menu) > 0) { ?>
            <?= printLangsMenu($lang_menu)  ?>
        <?php } ?>
    </nav>
</header>