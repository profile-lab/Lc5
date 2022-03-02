<div class="row row-gallery row-<?= $row->guid ?> <?= $row->css_class ?> <?= $row->css_color ?>">
    <div class="myIn">
        <?= h2($row->titolo) ?>
        <?php if (isset($row->data_object) && count($row->data_object) > 0) { ?>
            <div class="gallery_slider_cnt swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($row->data_object as $slide_item) { ?>
                        <div class="swiper-slide">
                            <?= view($base_view_folder . 'components/gallery-slide', ['slide_data' => $slide_item, 'format_folder' => '']) ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        <?php } ?>
    </div>
</div>