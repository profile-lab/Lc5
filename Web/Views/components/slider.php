<?php if (isset($gallery_obj) && count($gallery_obj) > 0) { ?>
    <?php if (count($gallery_obj) > 1) { ?>

            <div class="swiper simple_gallery swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($gallery_obj as $gallery_img) { ?>
                        <div class="swiper-slide">
                            <?= single_img($gallery_img->src, (isset($format_folder) && trim($format_folder)) ? $format_folder : '') ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
    <?php } else { ?>
        <?php foreach ($gallery_obj as $gallery_img) { ?>
            <?= single_img($gallery_img->src, (isset($format_folder) && trim($format_folder)) ? $format_folder : '') ?>
        <?php } ?>
    <?php } ?>
<?php } ?>