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
];
extract($fake_item);
extract($item);
?>
<?php /*
view('Lc5\Cms\Views\form-cmp/password', ['label' => 'Password', 'name' => 'password', 'value' => $entity->password, 'width' => 'col-md-4', 'placeholder' => 'email'])
*/ ?>

<div class="form-group <?= (isset($width)) ? $width : 'col-md-12' ?> form-field-<?= (isset($input_class)) ? $input_class : str_replace(['[',']'], '', $name) ?>">
    <label <?= (isset($id)) ? ' for="'.$id.'" ' : '' ?>><?= (isset($label)) ? $label : 'Campo password' ?></label>
    <input type="password" 
        name="<?= $name ?>" 
        value="<?= esc($value) ?>" 
        class="form-control <?= (isset($input_class)) ? $input_class : '' ?>"
        <?= (isset($id)) ? ' id="'.$id.'" ' : '' ?> 
        <?= (isset($required)) ? ' required="'.$required.'" ' : '' ?> 
        <?= (isset($placeholder)) ? ' placeholder="'.$placeholder.'" ' : '' ?> 
    />
</div>