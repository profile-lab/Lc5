<?php
// 
$fake_item = [
    'key' => null,
    'value' => null
];
extract($fake_item);
extract($item);
?>

<div class="custom_field-row_item">
    <div class="row justify-content-between align-items-center pt-2">
        <div class="col-10">
            <div class="row form-row">
                <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Chiave', 'name' => 'custom_field_key', 'input_class' => 'custom_field_key', 'value' => (isset($key)) ? $key : '', 'width' => 'col-md-12', 'placeholder' => 'Chiave']]) ?>
            </div>
        </div>
        <div class="col-2">
            <div class="row form-row ">
                <a href="#" class="text-danger text-right del_trg_cnt w_tooltip" meta-rel-trg-cnt="custom_field-row_item" data-bs-toggle="tooltip" title="Elimina">
                    <span class="oi oi-trash"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="row form-row">
                <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Valore', 'name' => 'custom_field_value', 'input_class' => 'custom_field_value', 'value' => (isset($value)) ? $value : '', 'width' => 'col-md-12', 'placeholder' => 'Valore']]) ?>
            </div>
        </div>
    </div>


</div>