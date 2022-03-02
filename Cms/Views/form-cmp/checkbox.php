<?php
$fake_item = [
    'id' => null,
    'name' => null,
    'value' => null,
    'label' => null,
    'input_class' => null,
    'width' => null,
    'required' => null,
    'placeholder' => null,
];
extract($fake_item);
extract($item);
?>
<?php /*
view('Lc5\Cms\Views\form-cmp/text', ['name' => 'titolo', 'value' => $entity->titolo, 'width' => 'col-md-6', 'placeholder' => 'titolo'])
*/ ?>
<div class="form-group checkbox-cnt <?= (isset($width)) ? $width : '' ?> <?= (isset($input_class)) ? $input_class : '' ?>">
    <div class="checkbox-item">
        <label class="form-check-label" for="<?= (isset($id)) ? $id : $name ?>">
            <input type="checkbox" name="<?= $name ?>" <?= ($value) ? 'checked' : '' ?> class="form-check-input <?= (isset($input_class)) ? $input_class : '' ?>" id="<?= (isset($id)) ? $id : $name ?>" <?= (isset($required)) ? ' required="' . $required . '" ' : '' ?> />
            <?= (isset($label)) ? $label : $name ?></label>
    </div>
</div>