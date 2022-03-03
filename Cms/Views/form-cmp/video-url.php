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
view('Lc5\Cms\Views\form-cmp/text', ['name' => 'titolo', 'value' => $entity->titolo, 'width' => 'col-md-6', 'placeholder' => 'titolo'])
*/ ?>

<div class="form-group <?= (isset($width)) ? $width : 'col-md-12' ?> form-field-<?= (isset($input_class)) ? $input_class : str_replace(['[',']'], '', $name) ?>">
    <label <?= (isset($id)) ? ' for="' . $id . '" ' : '' ?>><?= (isset($label)) ? $label : 'Campo text' ?></label>
    <input type="text" name="<?= $name ?>" value="<?= esc($value) ?>" class="form-control <?= (isset($input_class)) ? $input_class : '' ?>" <?= (isset($id)) ? ' id="' . $id . '" ' : '' ?> <?= (isset($required)) ? ' required="' . $required . '" ' : '' ?> <?= (isset($placeholder)) ? ' placeholder="' . $placeholder . '" ' : '' ?> />
    <?php if (trim($value)) { ?>
        <?php
        $remote_guid = null;
        if (strpos($value, 'youtu.be') !== false) {
            $remote_guid = str_replace('https://youtu.be/', '', trim($value));
        }
        if (strpos($value, 'youtube.com') !== false) {
            $remote_guid = str_replace(['https://www.youtube.com/watch?v=', 'https://youtube.com/watch?v='], '', trim($value));
        }
        ?>
        <?php if ($remote_guid) { ?>
            <div class="text-muted">
                <a href="https://i3.ytimg.com/vi/<?= $remote_guid ?>/maxresdefault.jpg" target="_blank">Scarica il thumbnail remoto</a>
            </div>
        <?php } ?>
    <?php } ?>
</div>