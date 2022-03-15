<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-tools sb-sidenav-tools-languages">
        <?php if (isset($lc_languages) && is_iterable($lc_languages)) { ?>
            <div class="form-group col-md-12">
                <label>Lingua</label>
                <select name="cambia_lingua_lc" target-url="<?= site_url(route_to('lc_cambia_lang','')) ?>" class="custom-select mr-sm-2 go_to_select_target" id="cambia_lingua_lc">
                    <?php foreach ($lc_languages as $lang) { ?>
                        <option value="<?= $lang->val ?>" <?= ($lang->val == $curr_lc_lang) ? 'selected' : '' ?>><?= $lang->nome ?></option>
                    <?php } ?>
                </select>
            </div>
        <?php } ?>
    </div>

    <div class="sb-sidenav-menu">
        <div class="nav">
            <?php if (isset($lc_admin_menu) && is_iterable($lc_admin_menu)) { ?>
                <?php foreach ($lc_admin_menu as $menu_item) { ?>
                    <?php if (isset($menu_item->items) && is_iterable($menu_item->items)) { ?>
                        <a class="nav-link nav-link-<?= $menu_item->module ?> collapsed <?= ($currernt_module == $menu_item->module) ? 'active' : '' ?>" data-bs-toggle="collapse" href="#collapse_<?= $menu_item->module ?>">
                            <span class="oi oi-<?= $menu_item->ico ?>"></span><?= $menu_item->label ?>
                        </a>
                        <div class="collapse <?= ($currernt_module == $menu_item->module) ? 'show' : '' ?>" id="collapse_<?= $menu_item->module ?>">
                            <nav class="sb-sidenav-menu-nested nav">
                                <?php foreach ($menu_item->items as $submenu_item) { ?>
                                    <a class="nav-link nav-link-<?= $menu_item->module ?>-<?= $submenu_item->module_action ?> <?= ( ($currernt_module == $menu_item->module) && ($currernt_module_action == $submenu_item->module_action) ) ? 'active' : '' ?>" href="<?= $submenu_item->route ?>"><?= $submenu_item->label ?></a>
                                <?php } ?>
                            </nav>
                        </div>
                    <?php } else { ?>
                        <a class="nav-link nav-link-<?= $menu_item->module ?> <?= ($currernt_module == $menu_item->module) ? 'active' : '' ?>" href="<?= $menu_item->route ?>">
                            <span class="oi oi-<?= $menu_item->ico ?>"></span><?= $menu_item->label ?>
                        </a>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <div class="sb-sidenav-tools sb-sidenav-tools-apps">
        <?php if (isset($lc_apps) && is_iterable($lc_apps)) { ?>
            <div class="form-group col-md-12">
                <label>Apps</label>
                <select name="cambia_app_lc" target-url="<?= site_url(route_to('lc_cambia_app','')) ?>" class="custom-select mr-sm-2 go_to_select_target" id="cambia_app_lc">
                    <?php foreach ($lc_apps as $app) { ?>
                        <option value="<?= $app->id ?>" <?= ($app->id == $curr_lc_app) ? 'selected' : '' ?>><?= $app->nome ?></option>
                    <?php } ?>
                </select>
            </div>
        <?php } ?>
        
    </div>
</nav>