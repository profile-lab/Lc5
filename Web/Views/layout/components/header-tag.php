<title><?= (@checkNotNull($seo_title)) ? $seo_title : ''. (( checkNotNull($titolo)) ? $titolo . ' - ' : '') . $app->seo_title ?></title>
<?= (isset($seo_description) && trim($seo_description)) ? '<meta name="description" content="'.$seo_description .'"/> ': '' ?>
<meta name="robots" content="<?= (isset($seo_meta_robots) && trim($seo_meta_robots)) ? ''.$seo_meta_robots .'': 'index, follow' ?>" />
<?php if (isset($meta_pagination)) : ?>
    <?= $meta_pagination ?>
<?php else : ?>
<link rel="canonical" href="<?= current_url() ?>" />
<?php endif; ?>
<?php if (isset($meta_og)) : ?>
<?= $meta_og ?>
<?php endif; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<link rel="stylesheet" href="<?= __base_assets_folder__.'css/style-default.css' ?>" />
