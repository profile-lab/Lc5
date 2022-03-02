<?php
// 
$fake_item = [
    'id' => null,
    'img_id' => null,
    'img_path' => null,
    'titolo' => null,
    'cta' => null,
];
extract($fake_item);
extract($item);
?>
<div class="gallery_content-row_item">
    <div class="gallery_content-row_item_body">
        <div class="row form-row">
            <?= view('Lc5\Cms\Views\form-cmp/img-single', ['item' => ['label' => 'Immagine', 'name' => 'gallery_item_img_id', 'input_class' => 'img_id_slide', 'value' => (isset($img_id)) ? $img_id : '', 'width' => 'col-12', 'src' => (isset($img_thumb)) ? $img_thumb : '']]) ?>
        </div>
        <div class="row form-row">
            <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Titolo', 'name' => 'gallery_item_titolo', 'input_class' => 'title_slide', 'value' => (isset($titolo)) ? $titolo : '', 'width' => 'col-md-12', 'placeholder' => 'Titolo']]) ?>
            <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Call to action', 'name' => 'gallery_item_cta', 'input_class' => 'cta_slide', 'value' => (isset($cta)) ? $cta : '', 'width' => 'col-md-12', 'placeholder' => 'Call to action']]) ?>
            <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Free parameter', 'name' => 'gallery_item_freeparam', 'input_class' => 'freeparam_slide', 'value' => (isset($freeparam)) ? $freeparam : '', 'width' => 'col-md-12', 'placeholder' => 'Free parameter']]) ?>
        </div>
        <a href="#" class="text-danger del_trg_cnt w_tooltip" meta-rel-trg-cnt="gallery_content-row_item" data-bs-toggle="tooltip" title="Elimina slide">
            <span class="oi oi-trash"></span>
        </a>
    </div>
</div>