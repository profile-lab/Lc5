<?php
$fake_item = [
    'id' => null,
    'name' => '',
    'value' => null,
    'label' => null,
    'input_class' => null,
    'width' => null,
    'required' => null,
];
extract($fake_item); 
extract($item);
?>
<?php /*
view('Lc5\Cms\Views\form-cmp/file', ['name' => 'titolo', 'value' => $entity->titolo, 'width' => 'col-md-6', 'placeholder' => 'titolo'])
*/ ?>
<div class="form-group <?= (isset($width)) ? $width : 'col-md-12' ?> form-field-<?= (isset($input_class)) ? $input_class : str_replace(['[',']'], '', $name) ?>">
    <div class="mb-3">
        <label <?= (isset($id)) ? ' for="' . $id . '" ' : '' ?> class="form-label"><?= (isset($label)) ? $label : 'Campo text' ?></label>
        <input class="form-control <?= (isset($input_class)) ? $input_class : '' ?>" type="file" name="<?= $name ?>" 
        value="<?= esc($value) ?>" <?= (isset($id)) ? ' id="' . $id . '" ' : '' ?> <?= (isset($required)) ? ' required="' . $required . '" ' : '' ?> />
    </div>
</div>
<?php /*
   multiple
<div class="form-group col-md-6">
    <?php if (isset($formdata->cover) && trim($formdata->cover)) { ?>
        <div class="col-auto">
            <img src="<?= site_url("$formdata->cover") ?>?v=<?= rand(0, 100) ?>" style=" max-height:250px;" class="img-thumbnail" />
        </div>
        <div class="form-group pt-2 text-danger">
            <div class="form-check">
                <input class="form-check-input" name="delete_cover" id="delete_cover" type="checkbox" value="1" />
                <label class="form-check-label" for="delete_cover">Elimina immagine di corpertina</label>
            </div>
        </div>
    <?php } ?>
    <div class="w-100">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-camera"></i></span>
            </div>
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="cover_upfile" id="cover_upfile" placeholder="Seleziona immagine di corpertina" />
                <label class="custom-file-label" for="cover_upfile" aria-describedby="prodotti_csv">Seleziona immagine di corpertina</label>
            </div>
        </div>
    </div>
</div>
*/ ?>