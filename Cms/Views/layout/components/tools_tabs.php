<nav class="tools_tabs" id="tools_tabs">

    <?php if (isset($shop_tools_tabs) && is_iterable($shop_tools_tabs)) { ?>
        <?php foreach ($shop_tools_tabs as $menu_item) { ?>
            <a class="tab-link <?= (isset($currernt_module_tab) && $currernt_module_tab == $menu_item->module_tab) ? 'active' : '' ?>" href="<?= $menu_item->route ?>"><?= $menu_item->label ?></a>
        <?php } ?>
    <?php } ?>

</nav>