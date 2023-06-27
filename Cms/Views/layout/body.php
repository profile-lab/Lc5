<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?= $this->include('Lc5\Cms\Views\layout/components/header-tag') ?>
    <?= (isset($row_styles_conf_css) && $row_styles_conf_css != '') ? $row_styles_conf_css : '' ?>
</head>

<body class="sb-nav-fixed bg-dark">
    <?= $this->include('Lc5\Cms\Views\layout/components/header') ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?= $this->include('Lc5\Cms\Views\layout/components/sidebar') ?>
        </div>
        <div id="layoutSidenav_content">
            <main class="position-relative  bg-dark text-white my_main_container">
                <div class="container-fluid container-main mth-<?= (isset($current_lc_method)) ? $current_lc_method : 'default' ?>" style="min-height: 100%;">
                    <?= $this->renderSection('content') ?>
                </div>
            </main>
            <?= $this->include('Lc5\Cms\Views\layout/components/footer') ?>
        </div>
    </div>
    <script>
    const lc_root = '<?= site_url(route_to('lc_dashboard')) ?>';
    </script>
    <?= $this->include('Lc5\Cms\Views\layout/components/footer-tag') ?>
    <?= $this->renderSection('footer_script') ?>
    <script type="text/html" id="files-template" style="display: none;">
        <?= view('Lc5\Cms\Views\part-cmp/media-list-item', ['item' => (object) []]) ?>
    </script>


    <script type="text/html" id="mediagallery_modal_code">
        <?= view('Lc5\Cms\Views\part-cmp/modal-gallery-cnt', ['item' => (object) []]) ?>
    </script>
</body><?php /*
<?= (isset($currernt_module_action)) ? $currernt_module_action : 'default' ?>
<h4><?= $current_lc_controller . ' - ' . $current_lc_module . ' ' . $current_lc_sub_module ?></h4>
*/ ?>
</html>