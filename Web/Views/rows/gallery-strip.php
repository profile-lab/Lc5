<div class="row myIn img_strip">
    <div class="img_strip__content">
        <?php foreach ($row->data_object as $slide_data) { ?>
            <div class="img_strip__item">
                <?= single_img($slide_data->img_path, (isset($row->formato_media) && trim($row->formato_media)) ? $row->formato_media : '') ?>
            </div>
        <?php } ?>
    </div>
</div>