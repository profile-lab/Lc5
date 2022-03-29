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
<div class="form-group checkbox-bool <?= (isset($width)) ? $width : 'col-md-12' ?> <?= (isset($input_class)) ? $input_class : '' ?>">
    <label class="form-switch" <?= (isset($id)) ? ' for="' . $id . '" ' : '' ?>><i></i><span><?= (isset($label)) ? $label : 'Attivo' ?></span>
        <select name="<?= $name ?>" class="select-checkbox-bool " <?= (isset($id)) ? ' id="' . $id . '" ' : '' ?> <?= (isset($required)) ? ' required="' . $required . '" ' : '' ?>>
            <option value="0" <?= (0 == $value) ? 'selected' : '' ?>>NO</option>
            <option value="1" <?= (1 == $value) ? 'selected' : '' ?>>SI</option>
        </select>
    </label>
</div>

<?php /*

<div class="field field_in_menu_1 switch_onoff"><label class="form-switch active"><i></i><span>header</span>
        <input type="hidden" name="in_menu_1" value="1">
    </label></div>
*/ ?>