<?php if (isset($row->data_object)) { ?>
    <div class="row-hero <?= $row->css_class ?> <?= $row->css_color ?>">
        <div class="hero_gallery__content">
            <?php if (count($row->data_object) > 1) { ?>
                <div class="swiper hero_swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($row->data_object as $slide_data) { ?>
                            <div class="swiper-slide">
                                <?php if (isset($slide_data->img_path) && trim($slide_data->img_path)) { ?>
                                    <div class="hero_gallery__item">
                                        <div class="hero_gallery__image">
                                            <?= single_img($slide_data->img_path, (isset($row->formato_media) && trim($row->formato_media)) ? $row->formato_media : '') ?>
                                        </div>
                                        <?php if( isset($slide_data->title) && trim($slide_data->title) ) { ?>
                                            <div class="hero_gallery__caption">
                                                <div class="h"><?= $slide_data->title ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } else if (isset($row->data_object[0]->img_path) && trim($row->data_object[0]->img_path)) { ?>
                <div class="hero_gallery__item">
                    <div class="hero_gallery__image">
                        <?= single_img($row->data_object[0]->img_path, (isset($row->formato_media) && trim($row->formato_media)) ? $row->formato_media : '') ?>
                    </div>
                    <?php if( isset($row->data_object[0]->title) && trim($row->data_object[0]->title) ) { ?>
                        <div class="hero_gallery__caption">
                            <div class="h"><?= $row->data_object[0]->title ?></div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>