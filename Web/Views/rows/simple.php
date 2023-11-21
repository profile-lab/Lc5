<div class="row row-<?= $row->type ?> row-<?= $row->type ?>-<?= $row->css_class ?> row-<?= $row->guid ?> <?= $row->css_class ?>  <?= $row->css_extra_class ?> <?= $row->css_color ?>">
    <div class="myIn">
        <div class="medias-row medias-row-<?= $row->type ?> medias-row-<?= $row->css_class ?>">
            <?php if (isset($row->gallery_obj) && count($row->gallery_obj) > 0) { ?>
                <div class="swiper simple_gallery swiper-container">
                    <div class="swiper-wrapper">
                        <?php foreach ($row->gallery_obj as $gallery_img) { ?>
                            <div class="simple_gallery_img swiper-slide">
                                <?= single_img($gallery_img->src, (isset($row->formato_media) && trim($row->formato_media)) ? $row->formato_media : 'full') ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            <?php } else { ?>
                <?= parseMediaObj($row->main_img_obj, (isset($row->formato_media) && trim($row->formato_media)) ? $row->formato_media : '') ?>
            <?php } ?>
        </div>
        <div class="txts-row txts-row-<?= $row->type ?> txts-row-<?= $row->css_class ?>">
            <?= h2($row->titolo) ?>
            <?= h3($row->sottotitolo) ?>
            <?= txt($row->testo) ?>
            <?= cta($row->cta_url, $row->cta_label) ?>
        </div>
    </div>
</div>