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
                <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Titolo', 'name' => 'titolo', 'value' => $entity->titolo, 'width' => 'col-md-12', 'placeholder' => 'Titolo']]) ?>
                <?php if (isset($post_attributes) && isset($post_attributes['sottotitolo'])) { ?>
                    <?php $c_field =  (object) $post_attributes['sottotitolo'] ?>
                    <?= view('Lc5\Cms\Views\form-cmp/' . $c_field->type, ['item' => [
                        'label' => $c_field->label,
                        'name' => $c_field->name,
                        'value' => $entity->{$c_field->name},
                        'width' => 'col-md-' . $c_field->w,
                        'placeholder' => (isset($c_field->placeholder)) ? $c_field->placeholder : '',
                        'src' => (isset($c_field->src_attr)) ? $entity->{$c_field->src_attr} : null,
                        'gallery_obj' => (isset($c_field->gallery_obj)) ? $entity->{$c_field->gallery_obj} : [],
                        'sources' => (isset($c_field->sources)) ? $entity->{$c_field->sources} : [],
                        'no_empty' => (isset($c_field->no_empty)) ? TRUE : FALSE,
                    ]]) ?>
                <?php } ?>
                <div class="row">
                    <?= view('Lc5\Cms\Views\form-cmp/html-editor', ['item' => ['label' => 'Testo', 'name' => 'testo', 'value' => (isset($entity->testo)) ? $entity->testo : '', 'width' => 'col-md-12', 'placeholder' => '...']]) ?>
                </div>
                <?php if (isset($post_attributes) && is_iterable($post_attributes)) { ?>
                    <div class="row">
                        <?php foreach ($post_attributes as $c_field_a) { ?>
                            <?php if ($c_field_a['view_side'] == 'main') { ?>
                                <?php $c_field =  (object) $c_field_a ?>
                                <?= view('Lc5\Cms\Views\form-cmp/' . $c_field->type, ['item' => [
                                    'label' => $c_field->label,
                                    'name' => $c_field->name,
                                    'value' => $entity->{$c_field->name},
                                    'width' => 'col-md-' . $c_field->w,
                                    'placeholder' => (isset($c_field->placeholder)) ? $c_field->placeholder : '',
                                    'src' => (isset($c_field->src_attr)) ? $entity->{$c_field->src_attr} : null,
                                    'gallery_obj' => (isset($c_field->gallery_obj)) ? $entity->{$c_field->gallery_obj} : [],
                                    'sources' => (isset($c_field->sources)) ? $entity->{$c_field->sources} : [],
                                    'no_empty' => (isset($c_field->no_empty)) ? TRUE : FALSE,
                                ]]) ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($entity->id && $post_type_entity->has_custom_fields) { ?>
                    <?php if (isset($custom_fields_keys_posts) && is_array($custom_fields_keys_posts) && count($custom_fields_keys_posts) > 0) { ?>
                        <?= view('Lc5\Cms\Views\part-cmp/custom-field-module', ['item' => [
                            'custom_fields_keys' => $custom_fields_keys_posts,
                            'entity' => $entity,
                        ]]) ?>
                    <?php } ?>
                <?php } ?>
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
            <div class="last-row">
                <?php if (isset($post_attributes) && is_iterable($post_attributes)) { ?>
                    <div class="row">
                        <?php foreach ($post_attributes as $c_field_a) { ?>
                            <?php if ($c_field_a['view_side'] == 'foot') { ?>
                                <?php $c_field =  (object) $c_field_a ?>
                                <?= view('Lc5\Cms\Views\form-cmp/' . $c_field->type, ['item' => [
                                    'label' => $c_field->label,
                                    'name' => $c_field->name,
                                    'value' => $entity->{$c_field->name},
                                    'width' => 'col-md-' . $c_field->w,
                                    'placeholder' => (isset($c_field->placeholder)) ? $c_field->placeholder : '',
                                    'src' => (isset($c_field->src_attr)) ? $entity->{$c_field->src_attr} : null,
                                    'gallery_obj' => (isset($c_field->gallery_obj)) ? $entity->{$c_field->gallery_obj} : [],
                                    'sources' => (isset($c_field->sources)) ? $entity->{$c_field->sources} : [],
                                    'no_empty' => (isset($c_field->no_empty)) ? TRUE : FALSE,

                                ]]) ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
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
                    <?= view('Lc5\Cms\Views\form-cmp/readonly', ['item' => ['label' => 'Nome', 'value' => $entity->nome, 'name' => 'nome',  'width' => 'col-12', 'placeholder' => '', 'if_active_name' => 'nome',  'enabled' => (($entity->id) ? TRUE : FALSE)]]) ?>
                    <?= view('Lc5\Cms\Views\form-cmp/readonly', ['item' => ['label' => 'Guid', 'value' => $entity->guid, 'width' => 'col-12', 'placeholder' => '', 'if_active_name' => 'guid',  'enabled' => (($entity->id) ? TRUE : FALSE)]]) ?>
                    <?= view('Lc5\Cms\Views\form-cmp/select', [ 'item' => ['label' => 'Public', 'name' => 'public', 'input_class' => 'public', 'value' => $entity->public, 'width' => 'col-md-12', 'sources' => $bool_values, 'no_empty' => true] ]); ?>
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
                                    'placeholder' => (isset($c_field->placeholder)) ? $c_field->placeholder : '',
                                    'src' => (isset($c_field->src_attr)) ? $entity->{$c_field->src_attr} : null,
                                    'gallery_obj' => (isset($c_field->gallery_obj)) ? $entity->{$c_field->gallery_obj} : [],
                                    'sources' => (isset($c_field->sources)) ? $entity->{$c_field->sources} : [],
                                    'no_empty' => (isset($c_field->no_empty)) ? TRUE : FALSE,

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
            const uri_api_create_new_vimeo_by_url = "<?= site_url(route_to('lc_api_new_vimeo_by_url', 'posts', $entity->id)) ?>";

            const uri_api_delete_vimeo_video = "<?= site_url(route_to('lc_api_video_delete_vimeo_w_rel', 'posts', $entity->id)) ?>";
        </script>
        <script src="https://cdn.jsdelivr.net/npm/tus-js-client@2.3.0/dist/tus.js"></script>
        <script src="/assets/lc-admin-assets/js/vimeo-uploader.js"></script>
    <?php } ?>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function() {
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
        $('.more-row-content').slideUp(1);
    });
</script>


<?php /*

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

*/ ?>
<?php /*
<script type="text/html" id="custom_field_item_code-posts" style="display: none;">
    <?= view('Lc5\Cms\Views\part-cmp/custom-field-item', ['item' => ['keys_source' => $custom_fields_keys_posts]]) ?>
</script>
*/ ?>
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