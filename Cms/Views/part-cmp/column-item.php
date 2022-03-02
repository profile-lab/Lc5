<?php
// 
$fake_item = [
    'id' => null,
    'img_id' => null,
    'img_path' => null,
    'titolo' => null,
    'testo' => null,
    'cta' => null,
    'cta_label' => null,
];
extract($fake_item);
extract($item);
?>
<div class="colonne_content-row_item">
    <div class="colonne_content-row_item_body">
        <div class="row">
            <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Titolo', 'name' => 'colonne_item_titolo', 'input_class' => 'title_column', 'value' => (isset($titolo)) ? $titolo : '', 'width' => 'col-md-12', 'placeholder' => 'Titolo']]) ?>
        </div>
        <div class="row">
            <?= view('Lc5\Cms\Views\form-cmp/html-editor', ['item' => ['label' => 'Testo', 'name' => 'colonne_item_testo', 'editor' => 'text_editor_min', 'input_class' => 'txt_column', 'value' => (isset($testo)) ? $testo : '', 'width' => 'col-md-12', 'placeholder' => '...']]) ?>
        </div>
        <div class="row myFlex">
            <div class="col-12 col-md-4">
                <div class="row">
                    <?= view('Lc5\Cms\Views\form-cmp/img-single', ['item' => ['label' => 'Immagine', 'name' => 'colonne_item_img_id', 'input_class' => 'img_id_column', 'value' => (isset($img_id)) ? $img_id : '', 'width' => 'col-12', 'src' => (isset($img_thumb)) ? $img_thumb : '']]) ?>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="row">
                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'CTA Action', 'name' => 'colonne_item_cta', 'input_class' => 'cta_column', 'value' => (isset($cta)) ? $cta : '', 'width' => 'col-md-12', 'placeholder' => 'Call to action']]) ?>
                </div>
                <div class="row">
                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'CTA Label', 'name' => 'colonne_item_cta_label', 'input_class' => 'cta_label_column', 'value' => (isset($cta_label)) ? $cta_label : '', 'width' => 'col-md-12', 'placeholder' => 'Label CTA']]) ?>
                </div>
            </div>
        </div>
        <a href="#" class="text-danger del_trg_cnt w_tooltip" meta-rel-trg-cnt="colonne_content-row_item" data-bs-toggle="tooltip" title="Elimina slide">
            <span class="oi oi-trash"></span>
        </a>
    </div>
</div>