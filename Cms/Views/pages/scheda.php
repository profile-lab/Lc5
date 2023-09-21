<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<script>
    let count_rows = 0;
</script>
<form class="form save_after_proc" method="POST" action="">
    <?= user_mess($ui_mess, $ui_mess_type) ?>
    <div class="row form-row">
        <div class="scheda_body <?= ($entity->id) ? 'has_paragraphs' : '' ?>">
            <div id="scheda_tools">
                <?php if ($entity->id) { ?>
                    <div class="container-fluid">
                        <div class="d-md-flex justify-content-between align-items-center">
                            <button type="button" meta-rel-source-id="blocco_simple_par_code" meta-rel-trg="rows_cnt" class="btn btn-sm btn-primary add_paragrafo add_row"><span class="oi oi-list-rich d-sm-none"></span><span class="d-none d-sm-inline">Paragrafo</span></button>
                            <button type="button" meta-rel-source-id="blocco_columns_par_code" meta-rel-trg="rows_cnt" class="btn btn-sm btn-primary add_colonne add_row"><span class="oi oi-image d-sm-none"></span><span class="d-none d-sm-inline">Colonne</span></button>
                            <button type="button" meta-rel-source-id="blocco_gallery_par_code" meta-rel-trg="rows_cnt" class="btn btn-sm btn-primary add_gallery add_row"><span class="oi oi-vertical-align-top d-sm-none"></span><span class="d-none d-sm-inline">Gallery</span></button>
                            <?php if (isset($rows_components) && is_iterable($rows_components) && count($rows_components) > 0) { ?>
                                <button type="button" meta-rel-source-id="blocco_component_par_code" meta-rel-trg="rows_cnt" class="btn btn-sm btn-primary add_componente add_row"><span class="oi oi-command d-sm-none"></span><span class="d-none d-sm-inline">Componente</span></button>
                            <?php } ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <h5 class="crea_tit">Crea nuova pagina</h5>
                <?php } ?>
            </div>
            <div class="row first-row">
                <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Titolo', 'name' => 'titolo', 'value' => $entity->titolo, 'width' => 'col-md-12', 'placeholder' => 'Titolo']]) ?>

                <?php if ($entity->id) { ?>
                    <?php if (isset($custom_fields_keys_pages) && is_array($custom_fields_keys_pages) && count($custom_fields_keys_pages) > 0) { ?>
                        <?= view('Lc5\Cms\Views\part-cmp/custom-field-module', ['item' => [
                            'custom_fields_keys' => $custom_fields_keys_pages,
                            'entity' => $entity,
                        ]]) ?>
                    <?php } ?>
                <?php } ?>


            </div>
            <?php if ($entity->id) { ?>
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
                <!-- -->

                <?php if ($is_vimeo_enabled) { ?>
                    <?= view('Lc5\Cms\Views\part-cmp/vimeo-video-form', ['video_entity' => (isset($entity->vimeo_video_obj)) ? $entity->vimeo_video_obj : NULL]) ?>
                <?php } ?>

                <div class="last-row">
                    <h5 class="mt-5 ">Altri strumenti</h5>
                    <div class="row border badge-light mt-4 mx-1 p-3">
                        <?php /* <div class="col-md-12"><h5>SEO &amp; Options</h5></div> */ ?>
                        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'SEO title', 'name' => 'seo_title', 'value' => $entity->seo_title, 'width' => 'col-md-12', 'placeholder' => 'seo title', 'id' => null]]) ?>
                        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'SEO Keyword', 'name' => 'seo_keyword', 'value' => $entity->seo_keyword, 'width' => 'col-md-12', 'placeholder' => 'seo keyword', 'id' => null]]) ?>
                        <?= view('Lc5\Cms\Views\form-cmp/text-area', ['item' => ['label' => 'SEO description', 'name' => 'seo_description', 'value' => $entity->seo_description, 'width' => 'col-md-12', 'placeholder' => 'SEO description', 'id' => null]]) ?>

                    </div>
                </div>

            <?php } ?>
        </div>
        <div class="scheda-sb margin-top">
            <div class="sticky">
                <div class="col-12">
                    <div class="bg-light p-4 px-lg-1 py-lg-1 rounded">
                        <div class="col-5 col-sm-auto text-right save_sb_cnt">
                            <?= (isset($frontend_guid) && trim($frontend_guid)) ? '<a class="external_link_page" href="' . $frontend_guid . '" target="_blank">Vai alla pagina <span class="oi oi-external-link"></span></a>' : '' ?>
                            <button type="submit" name="save" value="save" class="btn btn-primary bottone_salva btn_save_after_proc"><span class="oi oi-check"></span>Salva</button>
                        </div>

                        <div class="col-sm-8 col-lg-12">
                            <div class="row">
                                <?= view('Lc5\Cms\Views\form-cmp/readonly', ['item' => ['label' => 'Nome', 'value' => $entity->nome, 'name' => 'nome',  'width' => 'col-12', 'placeholder' => '', 'if_active_name' => 'nome',  'enabled' => (($entity->id) ? TRUE : FALSE)]]) ?>
                                <?= view('Lc5\Cms\Views\form-cmp/readonly', ['item' => ['label' => 'Guid', 'value' => $entity->guid, 'width' => 'col-12', 'placeholder' => '', 'if_active_name' => 'guid',  'enabled' => (($entity->id) ? TRUE : FALSE)]]) ?>
                                <?= view('Lc5\Cms\Views\form-cmp/select', [ 'item' => ['label' => 'Public', 'name' => 'public', 'input_class' => 'public', 'value' => $entity->public, 'width' => 'col-md-12', 'sources' => $bool_values, 'no_empty' => true] ]); ?>
                                <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Tipo', 'name' => 'type', 'value' => $entity->type, 'width' => 'col-12 col-xl-12', 'sources' => $pages_types, 'no_empty' => true]]) ?>
                                <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Genitore', 'name' => 'parent', 'value' => $entity->parent, 'width' => 'col-12 col-xl-12', 'sources' => $parents, 'no_empty' => false]]) ?>
                                <?= view('Lc5\Cms\Views\form-cmp/number', ['item' => ['label' => 'Ordine', 'name' => 'ordine', 'value' => $entity->ordine, 'width' => 'col-12 col-xl-12', 'placeholder' => 'titolo', 'step' => '0.01']]) ?>
                                <?php if (isset($poststypes) && is_array($poststypes) && count($poststypes) > 0) { ?>
                                    <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => '&Egrave; archivio di', 'name' => 'is_posts_archive', 'value' => $entity->is_posts_archive, 'width' => 'col-12 col-xl-12', 'sources' => $poststypes]]) ?>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if ($entity->id) { ?>
                            <div class="col-sm-4 col-lg-12">
                                <div class="row">
                                    <?= view('Lc5\Cms\Views\form-cmp/img-single', ['item' => ['label' => 'Copertina', 'name' => 'main_img_id', 'value' => $entity->main_img_id, 'width' => 'col-12', 'src' => $entity->main_img_thumb]]) ?>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
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
            const uri_api_create_new_tus_vimeo = "<?= site_url(route_to('lc_api_new_tus_vimeo_w_rel', 'pages', $entity->id)) ?>";
            const uri_api_create_new_vimeo_by_url = "<?= site_url(route_to('lc_api_new_vimeo_by_url',  'pages', $entity->id)) ?>";

            const uri_api_delete_vimeo_video = "<?= site_url(route_to('lc_api_video_delete_vimeo_w_rel', 'pages', $entity->id)) ?>";
        </script>
        <script src="https://cdn.jsdelivr.net/npm/tus-js-client@2.3.0/dist/tus.js"></script>
        <script src="/assets/lc-admin-assets/js/vimeo-uploader.js"></script>
    <?php } ?>
<?php } ?>


<script type="text/javascript">
    $(document).ready(function() {
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
<script type="text/html" id="custom_field_item_code-pages" style="display: none;">
    <?= view('Lc5\Cms\Views\part-cmp/custom-field-item', ['item' => ['keys_source' => $custom_fields_keys_pages]]) ?>
</script>
*/ ?>
<?php /*
<script type="text/html" id="custom_field_item_code" style="display: none;">
    <?= view('Lc5\Cms\Views\part-cmp/custom-field-item', ['item' =>  []]) ?>
</script>
*/ ?>
<?php /*
<script type="text/html" id="custom_field_item_sidebar_code" style="display: none;">
    <?= view('Lc5\Cms\Views\part-cmp/custom-field-item-sidebar', ['row' => (object) []]) ?>
</script>
*/ ?>
<?= $this->endSection() ?>