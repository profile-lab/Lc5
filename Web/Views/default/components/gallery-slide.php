<?php if (isset($slide_data) && $slide_data != null) { ?>
    <div class="gallery_slider_item">
        <?= h4($slide_data->title) ?>
        <?= single_img($slide_data->img_path, (isset($format_folder) && trim($format_folder)) ? $format_folder : '') ?>

    </div>
<?php } ?>