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
<?php /*
view('Lc5\Cms\Views\form-cmp/select', ['name' => 'titolo', 'value' => $entity->titolo, 'width' => 'col-md-4', 'sources' => $pages_types, 'placeholder' => 'titolo', 'no_empty' => true])
// $sources = [ (object) ['key' => 'txt', 'label' => 'Txt'], ]
*/ ?>

<div class="form-group <?= (isset($width)) ? $width : 'col-md-12' ?> form-field-<?= (isset($input_class)) ? $input_class : str_replace(['[',']'], '', $name) ?>">
    <label <?= (isset($id)) ? ' for="' . $id . '" ' : '' ?>><?= (isset($label)) ? $label : 'Select' ?></label>
    <?php if (isset($sources) && is_array($sources)) { ?>
        <select name="<?= $name ?>" class="custom-select mr-sm-2 <?= (isset($input_class)) ? $input_class : '' ?>" <?= (isset($id)) ? ' id="' . $id . '" ' : '' ?> <?= (isset($required) && $required != null) ? ' required ' : '' ?>>
            <?php if (!isset($no_empty) || ($no_empty == false)) { ?>
                <option value="">Seleziona un valore</option>
            <?php } ?>
            <?php foreach ($sources as $item) { ?>
                <option value="<?= $item->val ?>" <?= ($item->val == $value) ? 'selected' : '' ?>><?= $item->nome ?></option>
                <?php if (isset($item->children) && is_array($item->children) && count($item->children) > 0) { ?>
                <?= lc_print_children_option($item->children, $value) ?>
                    <?php /*
                    
                    <?php foreach ($item->children as $sub_item) { ?>
                        <option value="<?= $sub_item->val ?>" <?= ($sub_item->val == $value) ? 'selected' : '' ?>><?= $sub_item->nome ?></option>
                    <?php } ?>
                    */ ?>
                <?php } ?>
            <?php } ?>
        </select>
    <?php } else { ?>
        <div class="alert alert-danger">
            Fornire una lista di elementi
        </div>
    <?php } ?>
</div>
