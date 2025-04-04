<?php
$fake_item = [
    'id' => null,
    'name' => '',
    'value' => null,
    'label' => null,
    'input_class' => null,
    'width' => null,
    'required' => null,
    'placeholder' => null,
    'sources' => null,
    'no_empty' => null,
];
extract($fake_item);
extract($item);
?>
<div class="form-group <?= (isset($width)) ? $width : 'col-md-12' ?> form-field-<?= (isset($input_class)) ? $input_class : str_replace(['[',']'], '', $name) ?> selectize-tags">
    <label <?= (isset($id)) ? ' for="' . $id . '" ' : '' ?>><?= (isset($label)) ? $label : 'Select' ?></label>
    <select name="<?= $name ?>[]" class="select-tags <?= (isset($input_class)) ? $input_class : '' ?>" multiple>
        <?php if (isset($sources) && is_array($sources)) { ?>
            <?php foreach ($sources as $item) { ?>
                <option value="<?= $item->val ?>" <?= (is_array($value) && in_array($item->val, $value)) ? 'selected' : '' ?>><?= $item->nome ?></option>
            <?php } ?>
        <?php } ?>
    </select>

</div>