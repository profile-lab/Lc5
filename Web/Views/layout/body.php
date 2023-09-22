<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?= $this->include($base_view_folder.'layout/components/header-tag') ?>
</head>

<body class="<?php
    echo ((isset($type) && $type != '') ? ' pagemodel-'.$type.'' : ''); 
    echo ((isset($guid) && $guid != '') ? ' page-'.$guid.'' : ''); 
?>">
    <?= $this->include($base_view_folder.'layout/components/header') ?>
    <main id="main_container">
        <?= $this->include($base_view_folder.'layout/components/sidebar') ?>
        <?= $this->renderSection('content') ?>
    </main>
    <?= $this->include($base_view_folder.'layout/components/footer') ?>
    <?= $this->include($base_view_folder.'layout/components/footer-tag') ?>
    <?= $this->renderSection('footer_script') ?>
</body>

</html>