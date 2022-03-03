<?php 
$fake_item = [
    'id' => null,
    'name' => '',
    'value' => null,
    'label' => null,
    'editor' => null,
    'rows' => null,
    'input_class' => null,
    'width' => null,
    'required' => null,
    'placeholder' => null,
];
extract($fake_item);
extract($item);
?>
<?php /*
view('Lc5\Cms\Views\form-cmp/html-editor', ['name' => 'titolo', 'value' => $entity->titolo, 'width' => 'col-md-12', 'placeholder' => 'titolo'])
*/ ?>
<div class="<?= (isset($width)) ? $width : 'col-md-12' ?> form-field-<?= (isset($input_class)) ? $input_class : str_replace(['[',']'], '', $name) ?>">
    <label <?= (isset($id)) ? ' for="'.$id.'" ' : '' ?>><?= (isset($label)) ? $label : 'Campo text' ?></label>
    <textarea type="text" 
        name="<?= $name ?>" 
        class="form-control <?= (isset($editor)) ? $editor : 'text_editor' ?>  <?= (isset($input_class)) ? $input_class : '' ?>"
        <?= (isset($rows)) ? ' rows="'.$rows.'" ' : '' ?> 
        <?= (isset($id)) ? ' id="'.$id.'" ' : '' ?> 
        <?= (isset($required)) ? ' required="'.$required.'" ' : '' ?> 
        <?= (isset($placeholder)) ? ' placeholder="'.$placeholder.'" ' : '' ?> 
    ><?= esc($value) ?></textarea>
</div>