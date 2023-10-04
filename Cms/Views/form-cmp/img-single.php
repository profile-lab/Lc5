<?php
$fake_item = [
    'id' => null,
    'name' => '',
    'value' => null,
    'label' => null,
    'input_class' => null,
    'width' => null,
    'placeholder' => null,
];
extract($fake_item);
extract($item);
?>

<div style="max-width: 300px; max-height:330px" class="form-group <?= (isset($width)) ? $width : 'col-md-12' ?> position-relative <?= (isset($src) && trim($src)) ? 'hasImage' : '' ?> form-field-<?= (isset($input_class)) ? $input_class : str_replace(['[', ']'], '', $name) ?>">
    <?= (isset($label)) ? '<label>' . $label . '</label>' : '' ?>
    <a href="#" meta-rel-id="<?= $value ?>" meta-rel-path="<?= (isset($src) && trim($src)) ? $src : '' ?>" class="open-modal-mediagallery-single">
        <input type="hidden" name="<?= $name ?>" value="<?= esc($value) ?>" class="form-control <?= (isset($input_class)) ? $input_class : '' ?>" <?= (isset($id)) ? ' id="' . $id . '" ' : '' ?> <?= (isset($placeholder)) ? ' placeholder="' . $placeholder . '" ' : '' ?> />
        <?php if (isset($src) && trim($src)) { ?>
            <img class="preview-img img-thumbnail" src="<?= site_url($src) ?>" alt="<?= (isset($placeholder) ? $placeholder : 'placeholder') ?>" />
        <?php } else { ?>
            <img class="preview-img img-thumbnail" src="<?= site_url('assets/lc-admin-assets/img/thumb-default.png') ?>" alt="<?= (isset($placeholder) ? $placeholder : 'placeholder') ?>" />
        <?php } ?>
    </a>
    <a href="#" class="remove-single-img"><span class="oi oi-x"></span></a>
</div>