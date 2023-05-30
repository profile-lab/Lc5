<header class="site_header">
    <div class="head_logo_cnt">
        <div class="website_logo">
            <a href="<?= site_url() ?>" title="Homepage">
                <img alt="<?= $app->nome ?>" src="<?= site_url(__base_assets_folder__.'img/logo.png') ?>" />
            </a>
        </div>
        <?php if (isset($app->app_claim) && trim($app->app_claim)) { ?>
            <?= h5($app->app_claim, 'site_claim') ?>
        <?php } ?>
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