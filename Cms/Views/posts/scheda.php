<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<script>
    let count_rows = 0;
</script>
<form class="form save_after_proc" method="POST" action="">
    <?= user_mess($ui_mess, $ui_mess_type) ?>
    <div class="row form-row">
        <div class="scheda_body <?= ($entity->id && $post_type_entity->has_paragraphs) ? 'has_paragraphs' : '' ?>">
            <?php if ($entity->id) { ?>
                <?php if ($post_type_entity->has_paragraphs) { ?>
                    <div id="scheda_tools">
                        <div class="container-fluid">
                            <div class="d-md-flex justify-content-between align-items-center">
                                <button type="button" meta-rel-source-id="blocco_simple_par_code" meta-rel-trg="rows_cnt" class="btn btn-sm btn-primary add_paragrafo add_row"><span class="oi oi-plus"></span><span class="oi oi-list-rich d-sm-none"></span><span class="d-none d-sm-inline">Paragrafo</span></button>
                                <button type="button" meta-rel-source-id="blocco_columns_par_code" meta-rel-trg="rows_cnt" class="btn btn-sm btn-primary add_colonne add_row"><span class="oi oi-plus"></span><span class="oi oi-image d-sm-none"></span><span class="d-none d-sm-inline">Colonne</span></button>
                                <button type="button" meta-rel-source-id="blocco_gallery_par_code" meta-rel-trg="rows_cnt" class="btn btn-sm btn-primary add_gallery add_row"><span class="oi oi-plus"></span><span class="oi oi-vertical-align-top d-sm-none"></span><span class="d-none d-sm-inline">Gallery</span></button>
                                <?php if (isset($rows_components) && is_iterable($rows_components) && count($rows_components) > 0) { ?>
                                    <button type="button" meta-rel-source-id="blocco_component_par_code" meta-rel-trg="rows_cnt" class="btn btn-sm btn-primary add_componente add_row"><span class="oi oi-plus"></span><span class="oi oi-command d-sm-none"></span><span class="d-none d-sm-inline">Componente</span></button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="first-row">
                <div class="row">
                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Nome', 'name' => 'nome', 'value' => $entity->nome, 'width' => 'col-md-12', 'placeholder' => 'Nome']]) ?>
                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Titolo', 'name' => 'titolo', 'value' => $entity->titolo, 'width' => 'col-md-12', 'placeholder' => 'Titolo']]) ?>
                    <?php if (isset($post_attributes) && isset($post_attributes['sottotitolo'])) { ?>
                        <?php $c_field =  (object) $post_attributes['sottotitolo'] ?>
                        <?= view('Lc5\Cms\Views\form-cmp/' . $c_field->type, ['item' => [
                            'label' => $c_field->label,
                            'name' => $c_field->name,
                            'value' => $entity->{$c_field->name},
                            'width' => 'col-md-' . $c_field->w,
                            'placeholder' => '',
                            'src' => (isset($c_field->src_attr)) ? $entity->{$c_field->src_attr} : null,
                            'gallery_obj' => (isset($c_field->gallery_obj)) ? $entity->{$c_field->gallery_obj} : [],
                            'sources' => (isset($c_field->sources)) ? $entity->{$c_field->sources} : [],
                        ]]) ?>
                    <?php } ?>
                </div>
                <div class="row">
                    <?= view('Lc5\Cms\Views\form-cmp/html-editor', ['item' => ['label' => 'Testo', 'name' => 'testo', 'value' => (isset($entity->testo)) ? $entity->testo : '', 'width' => 'col-md-12', 'placeholder' => '...']]) ?>
                </div>
            </div>

            <?php if ($entity->id) { ?>
                <?php if ($is_vimeo_enabled) { ?>
                    <?= view('Lc5\Cms\Views\part-cmp/vimeo-video-form', ['video_entity' => (isset($entity->vimeo_video_obj)) ? $entity->vimeo_video_obj : NULL]) ?>
                <?php } ?>
            <?php } ?>

            <?php if ($entity->id && $post_type_entity->has_paragraphs) { ?>
                <div class="my_rows_container text-dark  rounded">
                    <div id="rows_cnt" class="content-rows-cnt sortable-list-cnt">
                        <?php if (isset($entity_rows) && is_array($entity_rows) && count($entity_rows) > 0) { ?>
                            <?php foreach ($entity_rows as $row) { ?>
                                <?= view('Lc5\Cms\Views\rows-cmp/' . $row->type . '-par', ['row' => $row]) ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['name' => 'rows_to_del', 'value' => '', 'id' => 'rows_to_del']]) ?>
            <?php } ?>
            <div class="last-row show-tit-if-is-no-empty">
                <h5 class="mt-5 ">Altri strumenti</h5>
                <style>
                    .show-tit-if-is-no-empty {
                        display: none;
                    }
                </style>
                <?php if (isset($post_attributes) && is_iterable($post_attributes)) { ?>

                    <div class="row">
                        <?php $conta_in_main = 0; ?>
                        <?php foreach ($post_attributes as $c_field_a) { ?>
                            <?php if ($c_field_a['view_side'] == 'main') { ?>
                                <?php $c_field =  (object) $c_field_a ?>
                                <?= view('Lc5\Cms\Views\form-cmp/' . $c_field->type, ['item' => [
                                    'label' => $c_field->label,
                                    'name' => $c_field->name,
                                    'value' => $entity->{$c_field->name},
                                    'width' => 'col-md-' . $c_field->w,
                                    'placeholder' => '',
                                    'src' => (isset($c_field->src_attr)) ? $entity->{$c_field->src_attr} : null,
                                    'gallery_obj' => (isset($c_field->gallery_obj)) ? $entity->{$c_field->gallery_obj} : [],
                                    'sources' => (isset($c_field->sources)) ? $entity->{$c_field->sources} : [],
                                ]]) ?>
                                <?php $conta_in_main++; ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="row border badge-light mt-4 mx-1 p-3">
                    <?php foreach ($post_attributes as $c_field_a) { ?>
                        <?php if ($c_field_a['view_side'] == 'foot') { ?>
                            <?php $c_field =  (object) $c_field_a ?>
                            <?= view('Lc5\Cms\Views\form-cmp/' . $c_field->type, ['item' => [
                                'label' => $c_field->label,
                                'name' => $c_field->name,
                                'value' => $entity->{$c_field->name},
                                'width' => 'col-md-' . $c_field->w,
                                'placeholder' => '',
                                'src' => (isset($c_field->src_attr)) ? $entity->{$c_field->src_attr} : null,
                                'gallery_obj' => (isset($c_field->gallery_obj)) ? $entity->{$c_field->gallery_obj} : [],
                                'sources' => (isset($c_field->sources)) ? $entity->{$c_field->sources} : [],
                            ]]) ?>
                            <?php $conta_in_main++; ?>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($entity->id && $post_type_entity->has_custom_fields) { ?>
                        <?php if (isset($custom_fields_keys_posts) && is_array($custom_fields_keys_posts) && count($custom_fields_keys_posts) > 0) { ?>
                            <!-- CAMPI CUSTOM FIELD -->
                            <div class="entity_custom_fields">
                                <div class="row">
                                    <div class="d-flex">
                                        <h6>Campi custom</h6>
                                        <div>
                                            <button type="button" meta-rel-source-id="custom_field_item_code-posts" meta-rel-trg="entity_custom_items_cnt" class="btn btn-sm btn-primary add_entity_custom_item"><span class="oi oi-plus m-0"></span></button>
                                        </div>
                                    </div>
                                    <?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['name' => 'entity_free_values', 'value' => (isset($entity->entity_free_values)) ? $entity->entity_free_values : '', 'input_class' => 'entity_free_values']]) ?>
                                    <div class="row">
                                        <div class="entity_custom_items_cnt">
                                            <?php if (isset($entity->entity_free_values_object) && is_iterable($entity->entity_free_values_object)) { ?>
                                                <?php foreach ($entity->entity_free_values_object as $entity_free_values_item) { ?>
                                                    <?= view('Lc5\Cms\Views\part-cmp/custom-field-item', ['item' => [
                                                        'keys_source' => $custom_fields_keys_posts,
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
                            <?php $conta_in_main++; ?>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($conta_in_main > 0) { ?>
                        <style>
                            .show-tit-if-is-no-empty {
                                display: block;
                            }
                        </style>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="scheda-sb <?= ($entity->id && $post_type_entity->has_paragraphs) ? 'has_paragraphs' : 'margin-top-0' ?>">
            <div class="sticky">
                <div class="save_sb_cnt">
                    <div class="col-auto">
                        <?= (isset($frontend_guid) && trim($frontend_guid)) ? '<a class="external_link_page" href="' . $frontend_guid . '" target="_blank">Vai al post <span class="oi oi-external-link"></span></a>' : '' ?>
                    </div>
                    <button type="submit" name="save" value="save" class="btn btn-primary bottone_salva btn_save_after_proc"><span class="oi oi-check"></span>Salva</button>
                </div>
                <div class="row">
                    <?= view('Lc5\Cms\Views\form-cmp/readonly', ['item' => ['label' => 'Guid', 'value' => $entity->guid, 'width' => 'col-12', 'placeholder' => '']]) ?>
                    <?php /*
                    // NON IN USO - VEDI post_attributes
                    <?php if (isset($post_categories) && is_iterable($post_categories)) { ?>
                        <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Categoria', 'name' => 'category', 'value' => $entity->category, 'width' => 'col-12 col-xl-7', 'sources' => $post_categories, 'no_empty' => true]]) ?>
                    <?php } ?>
                    */ ?>
                </div>
                <?php if ($entity->id) { ?>
                    <div class="row">
                        <?= view('Lc5\Cms\Views\form-cmp/img-single', ['item' => [
                            'label' => 'Copertina',
                            'name' => 'main_img_id',
                            'value' => $entity->main_img_id,
                            'width' => 'col-12',
                            'src' => $entity->main_img_thumb
                        ]]) ?>
                    </div>
                    <?php if (isset($post_attributes) && isset($post_attributes['alt_img_id'])) { ?>
                        <?php $c_field =  (object) $post_attributes['alt_img_id'] ?>
                        <div class="row">
                            <?= view('Lc5\Cms\Views\form-cmp/img-single', ['item' => [
                                'label' => 'Alternativa',
                                'name' => 'alt_img_id',
                                'value' => $entity->alt_img_id,
                                'width' => 'col-12',
                                'src' => $entity->alt_img_thumb
                            ]]) ?>
                        </div>
                    <?php } ?>
                <?php } ?>
                <div class="row">
                    <?php if (isset($post_attributes) && is_iterable($post_attributes)) { ?>
                        <?php foreach ($post_attributes as $c_field_a) { ?>
                            <?php if ($c_field_a['view_side'] == 'side') { ?>
                                <?php $c_field =  (object) $c_field_a ?>
                                <?= view('Lc5\Cms\Views\form-cmp/' . $c_field->type, ['item' => [
                                    'label' => $c_field->label,
                                    'name' => $c_field->name,
                                    'value' => $entity->{$c_field->name},
                                    'width' => 'col-md-' . $c_field->w,
                                    'placeholder' => '',
                                    'src' => (isset($c_field->src_attr)) ? $entity->{$c_field->src_attr} : null,
                                    'gallery_obj' => (isset($c_field->gallery_obj)) ? $entity->{$c_field->gallery_obj} : [],
                                    'sources' => (isset($c_field->sources)) ? $entity->{$c_field->sources} : [],
                                ]]) ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

</form>

<?= $this->endSection() ?>

<?= $this->section('footer_script') ?>

<?php if ($is_vimeo_enabled) { ?>
    <?php if ($entity->id) { ?>
        <script type="text/javascript">
            const uri_api_refresh_video_info = "<?= site_url(route_to('lc_api_video_info_vimeo')) ?>";
            const uri_api_create_new_tus_vimeo = "<?= site_url(route_to('lc_api_new_tus_vimeo_w_rel', 'posts', $entity->id)) ?>";
            const uri_api_delete_vimeo_video = "<?= site_url(route_to('lc_api_video_delete_vimeo_w_rel', 'posts', $entity->id)) ?>";
        </script>
        <script src="https://cdn.jsdelivr.net/npm/tus-js-client@2.3.0/dist/tus.js"></script>
        <script src="/assets/lc-admin-assets/js/vimeo-uploader.js"></script>
    <?php } ?>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function() {
        // 
        $('.add_entity_custom_item').click(function(e) {
            e.preventDefault();
            unbindRowActions();

            // var current_par = $(this).closest('.content-row');
            var trg_cnt = $(this).attr('meta-rel-trg');
            var htmlCode = $('#' + $(this).attr('meta-rel-source-id')).html();
            var codeStrBase = htmlCode.toString();
            var codeStr = codeStrBase.replace(/###@###/g, '[]');
            var newCode = $(codeStr);
            $('.' + trg_cnt).append(newCode);
            bindRowActions();
        });
        $('form.save_after_proc').submit(function() {
            let json_free_values_str = '';
            let json_free_values_arr = [];
            let target_input = $('.entity_free_values', this);
            $('.entity_custom_items_cnt .custom_field-row_item', this).each(function() {
                let curr_item_obj = new Object();
                curr_item_obj.key = $('.custom_field_key', this).val();
                curr_item_obj.value = $('.custom_field_value', this).val();
                json_free_values_arr.push(curr_item_obj);
            });
            json_free_values_str = JSON.stringify(json_free_values_arr);
            target_input.val(json_free_values_str);
        });
        // 
        $('.select-tags').selectize({
            create: function(input, callback) {
                if (!input.length) return callback();
                $.ajax({
                    url: '<?= site_url(route_to('lc_posts_tags_data_new', $post_type_guid))  ?>',
                    type: 'POST',
                    data: {
                        nome: input
                    },
                    success: function(result) {
                        if (result) {
                            // $('.select-tags').append( '<option value="'+result.id+'" selected="selected">'+input+'</option>' );
                            callback({
                                value: result.id,
                                text: input
                            });
                        }
                    }
                });
            }
        });
        // 
        $('.sortable-list-cnt').sortable({
            // cancel: '.acc_aperto',
            placeholder: 'row-sort-placeholder',
            // axis: 'y',
            cancel: "a,button,.jodit-container,input,select",
            update: function(event, ui) {
                setOrdineRow($('.sortable-list-cnt'));
            }
        });
        $('.more-row-content').slideUp(1);
    });
</script>



<script type="text/html" id="blocco_simple_par_code" style="display: none;">
    <?= view('Lc5\Cms\Views\rows-cmp/simple-par', ['row' => (object) []]) ?>
</script>
<script type="text/html" id="blocco_columns_par_code" style="display: none;">
    <?= view('Lc5\Cms\Views\rows-cmp/columns-par', ['row' => (object) []]) ?>
</script>
<script type="text/html" id="blocco_gallery_par_code" style="display: none;">
    <?= view('Lc5\Cms\Views\rows-cmp/gallery-par', ['row' => (object) []]) ?>
</script>
<script type="text/html" id="blocco_component_par_code" style="display: none;">
    <?= view('Lc5\Cms\Views\rows-cmp/component-par', ['row' => (object) []]) ?>
</script>

<script type="text/html" id="gallery_item_code" style="display: none;">
    <?= view('Lc5\Cms\Views\part-cmp/gallery-item', ['row' => (object) []]) ?>
</script>
<script type="text/html" id="colonne_item_code" style="display: none;">
    <?= view('Lc5\Cms\Views\part-cmp/column-item', ['row' => (object) []]) ?>
</script>
<script type="text/html" id="custom_field_item_code-posts" style="display: none;">
    <?= view('Lc5\Cms\Views\part-cmp/custom-field-item', ['item' => ['keys_source' => $custom_fields_keys_posts]]) ?>
</script>
<?php /*
<script type="text/html" id="custom_field_item_code" style="display: none;">
    <?= view('Lc5\Cms\Views\part-cmp/custom-field-item', ['row' => (object) []]) ?>
</script>
*/ ?>
<?php /*
<script type="text/html" id="custom_field_item_sidebar_code" style="display: none;">
    <?= view('Lc5\Cms\Views\part-cmp/custom-field-item-sidebar', ['row' => (object) []]) ?>
*/ ?>
</script>
<?= $this->endSection() ?>