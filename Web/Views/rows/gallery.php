<div class="row row-<?= $row->type ?> row-<?= $row->type ?>-<?= $row->css_class ?> row-<?= $row->guid ?> <?= $row->css_class ?> <?= $row->css_color ?>">
    <div class="myIn">
        <?= h2($row->titolo) ?>
        <?php if (isset($row->data_object) && count($row->data_object) > 0) { ?>
            <div class="swiper gallery_slider_cnt swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($row->data_object as $slide_data) { ?>

                        <div class="swiper-slide">
                            <div class="gallery_slider_item">
                                <?= h4($slide_data->title) ?>
                                <?= single_img($slide_data->img_path, (isset($format_folder) && trim($format_folder)) ? $format_folder : '') ?>

                            </div>
                            <?php /*
                            <?= view($base_view_folder . 'components/gallery-slide', ['slide_data' => $slide_data, 'format_folder' => '']) ?>
                            */ ?>
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