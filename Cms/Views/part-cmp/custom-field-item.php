<?php
// 
$fake_item = [
    'key' => null,
    'value' => null,
    'keys_source' => null,
];
extract($fake_item);
extract($item);
?>

<div class="custom_field-row_item">
    <?php if ($keys_source  && is_array($keys_source) && count($keys_source) > 0) { ?>
        <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Chiave', 'name' => 'custom_field_key', 'required' => true, 'input_class' => 'custom_field_key col-key', 'value' => (isset($key)) ? $key : '', 'width' => 'col-md-12', 'sources' => $keys_source]]) ?>
    <?php } else { ?>
        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Chiave', 'name' => 'custom_field_key', 'input_class' => 'custom_field_key col-key', 'value' => (isset($key)) ? $key : '', 'width' => 'col-md-12', 'placeholder' => 'Chiave']]) ?>
    <?php } ?>
    <?= view('Lc5\Cms\Views\form-cmp/text-area', ['item' => ['label' => 'Valore', 'name' => 'custom_field_value', 'input_class' => 'custom_field_value col-val', 'value' => (isset($value)) ? $value : '', 'width' => 'col-md-12', 'placeholder' => 'Valore']]) ?>
    <div class="col-1">
        <div class="row form-row ">
            <a href="#" class="text-danger text-right del_trg_cnt w_tooltip" meta-rel-trg-cnt="custom_field-row_item" data-bs-toggle="tooltip" title="Elimina">
                <span class="oi oi-trash"></span>
            </a>
        </div>
    </div>
</div>