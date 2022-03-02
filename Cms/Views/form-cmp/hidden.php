<?php 
$fake_item = [
    'id' => null,
    'name' => null,
    'value' => null,
    'input_class' => null,
    'required' => null,
];
extract($fake_item);
extract($item);
?>
<?php /*
view('Lc5\Cms\Views\form-cmp/hidden', ['name' => 'titolo', 'value' => $entity->titolo, 'id' => 'titolo'])
*/ ?>
<input type="hidden" name="<?= $name ?>" 
value="<?= esc($value) ?>" <?= (isset($id)) ? ' id="' . $id . '" ' : '' ?> <?= (isset($input_class)) ? ' class="' . $input_class . '" ' : '' ?> />