<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?= $this->include(customOrDefaultViewFragment('layout/components/header-tag')) ?>
</head>

<body class="<?php
    echo ((isset($type) && $type != '') ? ' pagemodel-'.$type.'' : ''); 
    echo ((isset($guid) && $guid != '') ? ' page-'.$guid.'' : ''); 
?>">
    <?= $this->include(customOrDefaultViewFragment('layout/components/header')) ?>
    <main id="main_container">
        <?= $this->include(customOrDefaultViewFragment('layout/components/sidebar')) ?>
        <?= $this->renderSection('content') ?>
    </main>
    <?= $this->include(customOrDefaultViewFragment('layout/components/footer')) ?>
    <?= $this->include(customOrDefaultViewFragment('layout/components/footer-tag')) ?>
    <?= $this->renderSection('footer_script') ?>
</body>

</html>