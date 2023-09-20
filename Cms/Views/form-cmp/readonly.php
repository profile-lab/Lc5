<?php 
$fake_item = [
    'id' => null,
    'name' => '',
    'if_active_name' => null,
    'value' => null,
    'label' => null,
    'input_class' => null,
    'width' => null,
    'required' => null,
    'placeholder' => null,
    'enabled' => false,
];
extract($fake_item);
extract($item);
?>
<?php /*
view('Lc5\Cms\Views\form-cmp/readonly', [ 'value' => $entity->aaa, 'width' => 'col-md-6', 'placeholder' => ''])
*/ ?>

<div class="form-group <?= (isset($width)) ? $width : 'col-md-12' ?> form-field-<?= (isset($input_class)) ? $input_class : str_replace(['[',']'], '', $name) ?>">
    <label <?= (isset($id)) ? ' for="'.$id.'" ' : '' ?>><?= (isset($label)) ? $label : '&nbsp;' ?></label>
    <input type="text" 
        readonly
        <?= ($name && $name != '') ? '' : 'disabled' ?>
        <?= ($name && $name != '') ? 'name="'.$name.'"' : '' ?>        
        if_active_name="<?= $if_active_name ?>" 
        value="<?= esc($value) ?>" 
        class="form-control <?= (isset($input_class)) ? $input_class : '' ?> <?= (isset($enabled) && $enabled) ? 'readonly_enabled disabled' : '' ?> "
        <?= (isset($placeholder)) ? ' placeholder="'.$placeholder.'" ' : '' ?> 
    />
    <?= (isset($enabled) && $enabled) ? '<button class="enable_readonly"><span class="oi oi-pencil"></span></button>' : '' ?>
</div>