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
    'step' => null,
    'decimal' => null,
];
extract($fake_item);
extract($item);
?>
<?php /*
view('Lc5\Cms\Views\form-cmp/number', ['name' => 'titolo', 'value' => 10, 'width' => 'col-md-6', 'placeholder' => 'titolo', 'step' => '0.01', 'decimal' => 2])
*/ ?>

<div class="form-group <?= (isset($width)) ? $width : 'col-md-12' ?> form-field-<?= (isset($input_class)) ? $input_class : str_replace(['[',']'], '', $name) ?>">
    <label <?= (isset($id)) ? ' for="'.$id.'" ' : '' ?>><?= (isset($label)) ? $label : 'Campo numerico' ?></label>
    <input type="number" 
        name="<?= $name ?>" 
        value="<?= esc($value) ?>" 
        class="form-control <?= (isset($input_class)) ? $input_class : '' ?>"
        <?= (isset($id)) ? ' id="'.$id.'" ' : '' ?> 
        <?= (isset($required)) ? ' required="'.$required.'" ' : '' ?> 
        <?= (isset($placeholder)) ? ' placeholder="'.$placeholder.'" ' : '' ?> 
        <?= (isset($step)) ? ' step="'.$step.'" ' : '' ?> 
        <?= (isset($decimal)) ? ' data-decimal="'.$decimal.'" ' : '' ?> 
    />
</div>