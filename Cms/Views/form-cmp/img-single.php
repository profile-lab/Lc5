<?php
$fake_item = [
    'id' => null,
    'name' => null,
    'value' => null,
    'label' => null,
    'input_class' => null,
    'width' => null,
    'placeholder' => null,
];
extract($fake_item);
extract($item);
?>

<div class="form-group <?= (isset($width)) ? $width : 'col-md-12' ?> position-relative <?= (isset($src) && trim($src) ) ? 'hasImage' : '' ?> form-field-<?= (isset($input_class)) ? $input_class : str_replace(['[',']'], '', $name) ?>">
<?php /* <label <?= (isset($id)) ? ' for="' . $id . '" ' : '' ?>><?= (isset($label)) ? $label : 'Copertina' ?></label> */ ?>
<a href="#" meta-rel-id="<?= $value ?>" meta-rel-path="<?= (isset($src) && trim($src)) ? $src : '' ?>" class="open-modal-mediagallery-single">
    <input type="hidden" name="<?= $name ?>" value="<?= esc($value) ?>" class="form-control <?= (isset($input_class)) ? $input_class : '' ?>" <?= (isset($id)) ? ' id="' . $id . '" ' : '' ?> <?= (isset($placeholder)) ? ' placeholder="' . $placeholder . '" ' : '' ?> />
    <?php if (isset($src) && trim($src)) { ?>
        <img class="preview-img img-thumbnail" src="<?= site_url( $src) ?>" alt="<?= (isset($placeholder) ? $placeholder : 'placeholder') ?>" />
    <?php } else { ?>
        <img class="preview-img img-thumbnail" src="<?= site_url('assets/lc/img/thumb-default.png') ?>" alt="<?= (isset($placeholder) ? $placeholder : 'placeholder') ?>" />
    <?php } ?>
</a>
<a href="#" class="remove-single-img"><span class="oi oi-x"></span></a>
</div>