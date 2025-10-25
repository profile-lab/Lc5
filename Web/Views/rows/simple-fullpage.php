<div class="row row-fullpage row-bg-<?= $row->css_class ?> row-<?= $row->guid ?> <?= $row->css_class ?>  <?= $row->css_extra_class ?> <?= $row->css_color ?>">
    <div class="row-fullpage__content">
        <?php if (isset($row->main_img_obj)) { ?>
            <div class="row-fullpage__image row-image mobile-full-row-image">
                <?= parseMediaObj($row->main_img_obj, (isset($row->formato_media) && trim($row->formato_media)) ? $row->formato_media : '') ?>
            </div>
        <?php } ?>
        <div class="row-fullpage__text">
            <?php if (trim($row->titolo) !== '' || trim($row->sottotitolo) !== '') { ?>
                <hgroup>
                    <?= h2($row->titolo) ?>
                    <?= h4($row->sottotitolo) ?>
                </hgroup>
            <?php } ?>
            <?= txt($row->testo) ?>
            <?= cta($row->cta_url, $row->cta_label) ?>
        </div>
    </div>
</div>