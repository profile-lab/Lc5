<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<script>
    let count_rows = 0;
</script>
<form class="form save_after_proc" method="POST" action="">

    <?= user_mess($ui_mess, $ui_mess_type) ?>
    <div class="d-md-flex">
        <div class="d-flex align-items-center">
            <?= view('Lc5\Cms\Views\layout/components/back-btn') ?>
            <div class="titoli_scheda">
                <?php if ($entity->id) { ?>
                    <h3><?= ($entity->modello) ? $entity->modello : $entity->nome ?></h3>
                <?php } else { ?>
                    <h3>Crea nuovo prodotto</h3>
                <?php } ?>
                <?php if (isset($entity->parent_entity)) { ?>
                    <h6>&Egrave; un modello di <a class="go_to_parent ask_before_leave" href="<?= site_url(route_to($route_prefix . '_edit', $entity->parent_entity->id)) ?>"><span class="oi oi-arrow-top" style="font-size: .8em;"></span> <?= $entity->parent_entity->nome ?></a></h6>
                <?php } ?>
            </div>
        </div>
        <div class="d-flex align-items-center ">
            <div>
                <button type="submit" name="save" value="save" class="btn bottone_salva btn-primary"><span class="oi oi-check"></span>Salva</button>
            </div>
        </div>
    </div>

    <div class="row form-row">
        <div class="col-12 col-lg-9 scheda_body">
            <div class="first-row">
                <div class="row">
                    <?php if (!isset($entity->parent_entity)) { ?>
                        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Nome', 'name' => 'nome', 'value' => $entity->nome,  'placeholder' => 'Nome']]) ?>
                        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Prodotto', 'name' => 'titolo', 'value' => $entity->titolo, 'placeholder' => 'Nome prodotto']]) ?>
                    <?php } ?>
                    <?php /*
                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Sottotitolo', 'name' => 'sottotitolo', 'value' => $entity->sottotitolo, 'placeholder' => '']]) ?>
                    */ ?>
                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Modello', 'name' => 'modello', 'value' => $entity->modello, 'placeholder' => 'Nome modello']]) ?>
                </div>
                <div class="row form-row row-colore">
                    <?= view('Lc5\Cms\Views\form-cmp/select-search', ['item' => ['label' => 'Colore', 'input_class' => 'select-tags-colore', 'name' => 'colore', 'value' => (isset($entity->colore)) ? $entity->colore : null,  'sources' => $entity->colors_list]]) ?>
                    <?= view('Lc5\Cms\Views\form-cmp/select-search', ['item' => ['label' => 'Misura', 'input_class' => 'select-tags-misura', 'name' => 'misura', 'value' => (isset($entity->misura)) ? $entity->misura : null,  'sources' => $entity->sizes_list]]) ?>
                </div>
                <div class="row">
                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Stile', 'name' => 'stile', 'value' => $entity->stile, 'placeholder' => '']]) ?>
                </div>
                <div class="row">
                    <?= view('Lc5\Cms\Views\form-cmp/html-editor', ['item' => ['label' => 'Descrizione', 'name' => 'testo', 'value' => (isset($entity->testo)) ? $entity->testo : '', 'placeholder' => '...']]) ?>
                </div>
                <div class="row">
                    <?= view('Lc5\Cms\Views\form-cmp/html-editor', ['item' => ['label' => 'Scheda tecnica', 'name' => 'scheda_tecnica', 'value' => (isset($entity->scheda_tecnica)) ? $entity->scheda_tecnica : '', 'placeholder' => '...']]) ?>
                </div>
                <div class="row">
                    <?= view('Lc5\Cms\Views\form-cmp/img-gallery', ['item' => ['label' => 'Gallery', 'name' => 'gallery', 'value' => (isset($entity->gallery)) ? $entity->gallery : '{}',  'gallery_obj' => (isset($entity->gallery_obj)) ? $entity->gallery_obj : []]]) ?>
                </div>
                <?php if (!isset($entity->parent_entity)) { ?>
                    <div class="row">
                        <?= view('Lc5\Cms\Views\form-cmp/tags', ['item' => ['label' => 'Tags', 'input_class' => 'select-tags-tags', 'name' => 'tags', 'value' => (isset($entity->tags)) ? $entity->tags : '',  'sources' => $entity->tags_list]]) ?>
                    </div>
                <?php } ?>
                <?php if ($current_shop_setting->products_has_childs == 1) { ?>
                    <?php if ($entity->id && ($entity->id && $entity->parent == 0)) { ?>
                        <div class="row row-modelli">
                            <div class="row-modelli-header">
                                <h6>Modelli</h6>
                                <a class="btn btn-primary" href="<?= site_url(route_to($route_prefix . '_new_sub', $entity->id)) ?>"><span class="oi oi-plus mr-1"></span>Nuovo Modello</a>
                            </div>
                            <?php if (isset($entity->childs_entities)) { ?>
                                <div class="row-modelli-list">
                                    <?php foreach ($entity->childs_entities as $child_entity) { ?>
                                        <a class="row-modelli-list-item" href="<?= site_url(route_to($route_prefix . '_edit', $child_entity->id)) ?>"><span><?= $child_entity->modello ?></span></a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <?php if ($entity->id) { ?>
                <?php if (!isset($entity->parent_entity)) { ?>
                    <div class="last-row">
                        <h5 class="mt-5 ">Altri strumenti</h5>
                        <div class="row border badge-light mt-4 mx-1 p-3">
                            <?php /* <div class="col-md-12"><h5>SEO &amp; Options</h5></div> */ ?>
                            <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'SEO title', 'name' => 'seo_title', 'value' => $entity->seo_title, 'placeholder' => 'seo title', 'id' => null]]) ?>
                            <?= view('Lc5\Cms\Views\form-cmp/text-area', ['item' => ['label' => 'SEO description', 'name' => 'seo_description', 'value' => $entity->seo_description, 'placeholder' => 'SEO description', 'id' => null]]) ?>
                            <?php if (isset($custom_fields_keys_pages) && is_array($custom_fields_keys_pages) && count($custom_fields_keys_pages) > 0) { ?>
                                <!-- CAMPI CUSTOM FIELD -->
                                <div class="entity_custom_fields">
                                    <div class="row">
                                        <div class="d-flex">
                                            <h6>Campi custom</h6>
                                            <div>
                                                <button type="button" meta-rel-source-id="custom_field_item_code-prodotti" meta-rel-trg="entity_custom_items_cnt" class="btn btn-sm btn-primary add_entity_custom_item"><span class="oi oi-plus m-0"></span></button>
                                            </div>
                                        </div>
                                        <?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['name' => 'entity_free_values', 'value' => (isset($entity->entity_free_values)) ? $entity->entity_free_values : '', 'input_class' => 'entity_free_values']]) ?>
                                        <div class="row">
                                            <div class="entity_custom_items_cnt">
                                                <?php if (isset($entity->entity_free_values_object) && is_iterable($entity->entity_free_values_object)) { ?>
                                                    <?php foreach ($entity->entity_free_values_object as $entity_free_values_item) { ?>
                                                        <?= view('Lc5\Cms\Views\part-cmp/custom-field-item', ['item' => [
                                                            'keys_source' => $custom_fields_keys_prodotti,
                                                            'key' => (isset($entity_free_values_item->key)) ? $entity_free_values_item->key : '',
                                                            'value' => (isset($entity_free_values_item->value)) ? $entity_free_values_item->value : ''
                                                        ]]) ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- CAMPI CUSTOM FIELD -->
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

        </div>
        <div class="scheda-sb margin-top-0">
            <div class="row">
                <div class="col-12">
                    <div class="bg-light rounded">
                        <?php if (!isset($entity->parent_entity)) { ?>
                            <div class="row">
                                <?= view('Lc5\Cms\Views\form-cmp/readonly', ['item' => ['label' => 'Guid', 'value' => $entity->guid,  'placeholder' => '']]) ?>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Barcode', 'name' => 'barcode', 'value' => $entity->barcode, 'placeholder' => '']]) ?>
                            <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'SKU', 'name' => 'sku', 'value' => $entity->sku, 'placeholder' => '']]) ?>
                            <?php if (isset($entity->categories_list) && is_iterable($entity->categories_list)) { ?>
                                <?php if (!isset($entity->parent_entity)) { ?>
                                    <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Categoria', 'name' => 'category', 'value' => $entity->category,  'sources' => $entity->categories_list, 'no_empty' => false]]) ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <?= view('Lc5\Cms\Views\form-cmp/img-single', ['item' => ['label' => 'Copertina', 'name' => 'main_img_id', 'value' => $entity->main_img_id, 'src' => $entity->main_img_thumb]]) ?>
                        </div>
                        <div class="row">
                            <hr />
                        </div>
                        <div class="row">
                            <?= view('Lc5\Cms\Views\form-cmp/number', ['item' => ['label' => 'Imponibile', 'name' => 'price', 'value' => $entity->price,  'placeholder' => 'Prezzo imponibile € 0,00', 'step' => '0.01', 'decimal' => 2]]) ?>
                        </div>
                        <?php if (!isset($entity->parent_entity)) { ?>
                            <div class="row">
                                <?php if (isset($entity->aliquote_list) && is_iterable($entity->aliquote_list)) { ?>
                                    <?php if (count($entity->aliquote_list) > 1) { ?>
                                        <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Aliquota', 'name' => 'ali', 'value' => $entity->ali, 'sources' => $entity->aliquote_list, 'no_empty' => true]]) ?>
                                    <?php } else { ?>
                                        <?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['name' => 'ali', 'value' => $entity->aliquote_list[0]->val]]) ?>
                                    <?php }  ?>
                                <?php } else { ?>
                                    <?= view('Lc5\Cms\Views\form-cmp/number', ['item' => ['label' => 'Aliquota', 'name' => 'ali', 'value' => $entity->ali, 'placeholder' => '%']]) ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <?php if ($current_shop_setting->discount_type == 'PRICE') { ?>
                                <?= view('Lc5\Cms\Views\form-cmp/number', ['item' => ['label' => 'Imponibile in promo', 'name' => 'promo_price', 'value' => $entity->promo_price, 'placeholder' => 'Imponibile in promo € 0,00', 'step' => '0.01', 'decimal' => 2]]) ?>
                            <?php } else if ($current_shop_setting->discount_type == 'PERCENTAGE') { ?>
                                <?= view('Lc5\Cms\Views\form-cmp/number', ['item' => ['label' => '% sconto promo', 'name' => 'discount_perc', 'value' => $entity->discount_perc, 'placeholder' => '%']]) ?>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <?= view('Lc5\Cms\Views\form-cmp/checkbox', ['item' => ['label' => 'In promo', 'name' => 'in_promo', 'value' => $entity->in_promo]]) ?>
                        </div>
                        <div class="row">
                            <hr />
                        </div>
                        <div class="row">
                            <?= view('Lc5\Cms\Views\form-cmp/number', ['item' => ['label' => 'Giacenza', 'name' => 'giacenza', 'value' => $entity->giacenza]]) ?>
                            <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Unità di misura', 'name' => 'um', 'value' => $entity->um, 'sources' => $entity->um_list, 'no_empty' => TRUE]]) ?>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {
        // 
        $('.select-tags-tags').selectize({
            create: function(input, callback) {
                if (!input.length) return callback();
                $.ajax({
                    url: '<?= site_url(route_to('lc_shop_prod_tags_data_new'))  ?>',
                    type: 'POST',
                    data: {
                        nome: input
                    },
                    success: function(result) {
                        if (result) {
                            callback({
                                value: result.val,
                                text: input
                            });
                        }
                    }
                });
            }
        });
        $('.select-tags-colore').selectize({
            create: function(input, callback) {
                if (!input.length) return callback();
                $.ajax({
                    url: '<?= site_url(route_to('lc_shop_prod_colors_data_new'))  ?>',
                    type: 'POST',
                    data: {
                        nome: input
                    },
                    success: function(result) {
                        if (result) {
                            callback({
                                value: result.val,
                                text: input
                            });
                        }
                    }
                });
            }
        });
        $('.select-tags-misura').selectize({
            sortField: "text",
            // render: {
            //     option_create:function(data,escape){
            //         return'<div class="create">Crea nuova <strong>'+escape(data.input)+"</strong>&hellip;</div>"
            //     },
            // },
            create: function(input, callback) {
                if (!input.length) return callback();
                $.ajax({
                    url: '<?= site_url(route_to('lc_shop_prod_sizes_data_new'))  ?>',
                    type: 'POST',
                    data: {
                        nome: input
                    },
                    success: function(result) {
                        if (result) {
                            callback({
                                value: result.val,
                                text: input
                            });
                        }
                    }
                });
            }
        });



    });
</script>

<script type="text/html" id="custom_field_item_code-prodotti" style="display: none;">
    <?= view('Lc5\Cms\Views\part-cmp/custom-field-item', ['item' => ['keys_source' => $custom_fields_keys_prodotti]]) ?>
</script>

<?= $this->endSection() ?>