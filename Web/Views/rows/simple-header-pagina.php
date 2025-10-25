<div class="row row-header-pagina row-bg-<?= $row->css_class ?> row-<?= $row->guid ?> <?= $row->css_class ?>  <?= $row->css_extra_class ?> <?= $row->css_color ?>">
    <div class="row-header-pagina__content">
        <?php if (isset($row->main_img_obj)) { ?>
            <div class="row-header-pagina__image row-image mobile-full-row-image">
                <?= parseMediaObj($row->main_img_obj,  'panoramica') ?>
            </div>
        <?php } ?>
        <div class="row-header-pagina__text">
            <div class="row-header-pagina__text_inner">
                <?php if ((isset($row->titolo) && trim($row->titolo) !== '') || (isset($row->sottotitolo) && trim($row->sottotitolo) !== '')) { ?>
                    <hgroup>
                        <?= h1($row->titolo) ?>
                        <?= h3($row->sottotitolo) ?>
                    </hgroup>
                <?php } ?>
                <?= txt($row->testo, 'margin-y-lg') ?>
            </div>
        </div>
    </div>
</div>