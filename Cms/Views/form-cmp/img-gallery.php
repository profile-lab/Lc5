<?php
$fake_item = [
    'id' => null,
    'name' => '',
    'value' => '{}',
    'label' => null,
    'input_class' => null,
    'width' => null,
    'placeholder' => null,
    'obj_items' => null,
];
extract($fake_item);
extract($item);
?>

<div class="form-group <?= (isset($width)) ? $width : 'col-md-12' ?> d-block form-field-<?= (isset($input_class)) ? $input_class : str_replace(['[',']'], '', $name) ?>">
    <a href="#" class="open-modal-mediagallery-gallery">
        <label <?= (isset($id)) ? ' for="' . $id . '" ' : '' ?>><?= (isset($label)) ? $label : 'Gallery' ?></label>
        <input type="hidden" name="<?= $name ?>" value="<?= esc($value) ?>" class="form-control <?= (isset($input_class)) ? $input_class : '' ?>" <?= (isset($id)) ? ' id="' . $id . '" ' : '' ?> />
        <div class="w-100 rounded border-dark bg-light d-flex p-2 overflow-hidden gallery_imgs_container <?= (isset($gallery_obj) && isset($gallery_obj) && count($gallery_obj) > 0 ) ? ' gallery_imgs_container_w_img ' : '' ?>" style="height: 5em;">
        <?php if (isset($gallery_obj) && is_iterable($gallery_obj) && count($gallery_obj) > 0 ) { ?>
            <?php foreach ($gallery_obj as $img_item) { ?>
                <img class="preview-img img-thumbnail" src="<?= site_url($img_item->thumb) ?>" alt="placeholder-img" />
                <?php /* <img class="preview-img img-thumbnail" src="<?= site_url('uploads/thumbs/' . $img_item->src) ?>" alt="placeholder-img" /> */ ?>
            <?php } ?>
        <?php } ?>
        </div>
    </a>
</div>