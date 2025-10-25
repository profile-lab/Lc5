<div class="row row-testi-img-col row-<?= $row->guid ?> <?= $row->css_class ?> <?= $row->css_extra_class ?> <?= $row->css_color ?>">
    <div class="myIn testi-img-col__content">
        <?php if (isset($row->main_img_obj)) { ?>
            <div class="testi-img-col__image row-col-image">
                <?= parseMediaObj($row->main_img_obj, (isset($row->formato_media) && trim($row->formato_media)) ? $row->formato_media : '') ?>
            </div>
        <?php } ?>
        <div class="testi-img-col__text">
            <hgroup>
                <?= h3($row->titolo) ?>
                <?= h4($row->sottotitolo) ?>
            </hgroup>
            <?= txt($row->testo, 'testi-img-col__description') ?>
            <?= cta($row->cta_url, $row->cta_label) ?>
        </div>

    </div>
</div>