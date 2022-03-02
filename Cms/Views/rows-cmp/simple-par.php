<?php
$type = 'simple';
$prefix = $type . '_';
// $free_values_object
// dd($row->free_values);
// $free_values_object

$t_unique = rand(100, 1000);


?>
<div class="card paragraph_card content-row my-3 <?= $type ?>_content-row">
    <div class="card-header">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto">
                <div class="h6 m-0 p-0">Paragrafo</div>
            </div>
            <div class="col-auto">
                <a href="#" class="par_move_down w_tooltip" data-bs-toggle="tooltip" title="Sposta sotto"><span class="oi oi-chevron-bottom"></span></a>
                <a href="#" class="par_move_up ml-1 mr-3 w_tooltip" data-bs-toggle="tooltip" title="Sposta sopra"><span class="oi oi-chevron-top"></span></a>
                <a href="#" class="text-danger del_row w_tooltip" meta-rel-trg="rows_to_del" meta-rel-id="<?= (isset($row->id)) ? $row->id : '0' ?>" data-bs-toggle="tooltip" title="Elimina paragrafo"><span class="oi oi-trash"></span></a>
            </div>
        </div>
    </div>
    <div class="card-body" meta-type="<?= (isset($row->css_class)) ? $row->css_class : '' ?>">
        <div class="row form-row">
            <?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['name' => $prefix . 'id[]', 'value' => (isset($row->id)) ? $row->id : '#', 'input_class' => null]]) ?>
            <?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['name' => $prefix . 'ordine[]', 'value' => (isset($row->ordine)) ? $row->ordine : '500', 'input_class' => 'input_order_row']]) ?>
            <?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['name' => $prefix . 'type[]', 'value' => (isset($row->type)) ? $row->type : $type, 'input_class' => null]]) ?>
            <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Nome*', 'name' => $prefix . 'nome[]', 'value' => (isset($row->nome)) ? $row->nome : '', 'width' => 'col-md-12', 'placeholder' => 'Nome', 'required' => 'required']]) ?>

        </div>

        <div class="row justify-content-between more-row-content more-row-content-paragraph">
	        <div class="col_2">
	            <div class="col-12 col-md-9 main_paragraph_in">
	                <div class="row">
	                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Titolo', 'name' => $prefix . 'titolo[]', 'value' => (isset($row->titolo)) ? $row->titolo : '', 'width' => 'col-md-12', 'placeholder' => 'Titolo']]) ?>
	                </div>
	                <div class="row">
	                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Sottotitolo', 'name' => $prefix . 'sottotitolo[]', 'value' => (isset($row->sottotitolo)) ? $row->sottotitolo : '', 'width' => 'col-md-12', 'placeholder' => '']]) ?>
	                </div>
	                <div class="row">
	                    <?= view('Lc5\Cms\Views\form-cmp/html-editor', ['item' => ['label' => 'Testo', 'name' => $prefix . 'testo[]', 'value' => (isset($row->testo)) ? $row->testo : '', 'width' => 'col-md-12', 'placeholder' => '...']]) ?>
	                </div>
	                <div class="row">
	                    <?= view('Lc5\Cms\Views\form-cmp/img-gallery', ['item' => ['label' => 'Gallery', 'name' => $prefix . 'gallery[]', 'value' => (isset($row->gallery)) ? $row->gallery : '{}', 'width' => 'col-12', 'gallery_obj' => (isset($row->gallery_obj)) ? $row->gallery_obj : []]]) ?>
	                </div>
	                <div class="row">
	                    <?= view('Lc5\Cms\Views\form-cmp/video-url', ['item' => ['label' => 'URL Video', 'name' => $prefix . 'video_url[]', 'value' => (isset($row->video_url)) ? $row->video_url : '', 'width' => 'col-md-12', 'placeholder' => 'Vimeo/Youtube Video Url']]) ?>
	                </div>
	            </div>
	
	            <div class="col-12 col-md-3 sb_paragraph_in">
	                <div class="row">
	                    <?= view('Lc5\Cms\Views\form-cmp/img-single', ['item' => ['label' => 'Copertina', 'name' => $prefix . 'main_img_id[]', 'value' => (isset($row->main_img_id)) ? $row->main_img_id : '', 'width' => 'col-12', 'src' => (isset($row->main_img_thumb)) ? $row->main_img_thumb : '']]) ?>
	                </div>
	                <?php if (isset($rows_simple_styles) && is_iterable($rows_simple_styles) && count($rows_simple_styles) > 0) { ?>
	                    <div class="row">
	                        <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Tipo', 'name' => $prefix . 'css_class[]', 'value' => (isset($row->css_class)) ? $row->css_class : '', 'input_class' => 'select_css_class', 'width' => 'col-md-12', 'sources' => $rows_simple_styles, 'no_empty' => true]]) ?>
	                    </div>
	                <?php } else { ?>
	                    <?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['name' => $prefix . 'css_class[]', 'value' => (isset($row->css_class)) ? $row->css_class : '', 'input_class' => null]]) ?>
	                <?php } ?>
	                <?php if (isset($rows_colors) && is_iterable($rows_colors) && count($rows_colors) > 0) { ?>
	                    <div class="row">
	                        <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Colori', 'name' => $prefix . 'css_color[]', 'value' => (isset($row->css_color)) ? $row->css_color : '', 'width' => 'col-md-12', 'sources' => $rows_colors, 'no_empty' => true]]) ?>
	                    </div>
	                <?php } else { ?>
	                    <?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['name' => $prefix . 'css_color[]', 'value' => (isset($row->css_color)) ? $row->css_color : '', 'input_class' => null]]) ?>
	                <?php } ?>
	                
	                <?php if (isset($rows_extra_styles) && is_iterable($rows_extra_styles) && count($rows_extra_styles) > 0) { ?>
	                    <div class="row">
	                        <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Stile Extra', 'name' => $prefix . 'css_extra_class[]', 'value' => (isset($row->css_extra_class)) ? $row->css_extra_class : '', 'width' => 'col-md-12', 'sources' => $rows_extra_styles, 'no_empty' => true]]) ?>
	                    </div>
	                <?php } else { ?>
	                    <?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['name' => $prefix . 'css_extra_class[]', 'value' => (isset($row->css_extra_class)) ? $row->css_extra_class : '', 'input_class' => null]]) ?>
	                <?php } ?>
	
	                <?php if (isset($images_formats) && is_iterable($images_formats) && count($images_formats) > 0) { ?>
	                    <div class="row">
	                        <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Formato immagini', 'name' => $prefix . 'formato_media[]', 'value' => (isset($row->formato_media)) ? $row->formato_media : '', 'width' => 'col-md-12', 'sources' => $images_formats, 'no_empty' => true]]) ?>
	                    </div>
	                <?php } else { ?>
	                    <?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['name' => $prefix . 'formato_media[]', 'value' => (isset($row->formato_media)) ? $row->formato_media : '', 'input_class' => null]]) ?>
	                <?php } ?>
	
	                <div class="row">
	                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'CTA', 'name' => $prefix . 'cta_url[]', 'value' => (isset($row->cta_url)) ? $row->cta_url : '', 'width' => 'col-md-12', 'placeholder' => 'URL target della CTA']]) ?>
	                </div>
	                <div class="row">
	                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Label CTA', 'name' => $prefix . 'cta_label[]', 'value' => (isset($row->cta_label)) ? $row->cta_label : '', 'width' => 'col-md-12', 'placeholder' => 'Label link CTA']]) ?>
	                </div>
	            </div>
	        </div>
            <!-- CAMPI CUSTOM FIELD -->
			<?php if( isset($custom_fields_keys_simple_par) && is_array($custom_fields_keys_simple_par) && count($custom_fields_keys_simple_par) > 0 ) { ?>
            <div class="col-12 form-field-simple_custom_fields_rows">
                <div class="row badge-light border">
                    <div class="d-flex justify-content-between align-items-center py-3">
                        <div class="col-auto">
                            <h6 class="m-0 p-0">Campi custom</h6>
                        </div>
                        <div class="col-auto">
                            <button type="button" meta-rel-source-id="custom_field_item_code-simple_par" meta-rel-trg="custom_items_cnt" meta-rel-unique="<?= (isset($row->id)) ? 'uni_' . $row->id : 'uni_' . $t_unique ?>" class="btn btn-sm btn-primary add_custom_item"><span class="oi oi-plus m-0"></span></button>
                        </div>
                    </div>
                    <?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['name' => $prefix . 'free_values[]', 'value' => (isset($row->free_values)) ? $row->free_values : '', 'input_class' => 'free_values']]) ?>
                    <div class="row mx-0 custom_items_cnt">
                        <?php if (isset($row->free_values_object) && is_iterable($row->free_values_object)) { ?>
                            <?php foreach ($row->free_values_object as $free_values_item) { ?>
                                <?= view('Lc5\Cms\Views\part-cmp/custom-field-item', ['item' => [
									'keys_source' => $custom_fields_keys_simple_par,
                                    'key' => (isset($free_values_item->key)) ? $free_values_item->key : '',
                                    'value' => (isset($free_values_item->value)) ? $free_values_item->value : ''
                                ]]) ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
			<?php }else{ ?>
				<?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['name' => $prefix . 'free_values[]', 'value' => (isset($row->free_values)) ? $row->free_values : '', 'input_class' => 'free_values']]) ?>
			<?php } ?>
            <!-- CAMPI CUSTOM FIELD -->

        </div>
    </div>
    <div class="card-footer">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto"></div>
            <div class="col-auto">
                <a href="#" rel="more-row-content" class="par_expand w_tooltip" data-bs-toggle="tooltip" title="Espandi contenuti"><span class="oi oi-chevron-bottom"></span></a>
            </div>
            <div class="col-auto"></div>
        </div>
    </div>
</div>