<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<script>
    let count_rows = 0;
</script>
<form class="form" method="POST" enctype="multipart/form-data" action="">
    <?php /*   
    <div id="scheda_tools" class="w-100 sticky-top mt-2">
        <div class="container-fluid bg-info text-light p-3 mt-3 mb-4 rounded">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-auto">
                    <?php if ($entity->id) { ?>
                    <?php } else { ?>
                        <h5 class="p-0 m-0">Crea nuovo</h5>
                    <?php } ?>
                </div>
                <div class="col-auto">
                    <button type="submit" name="save" value="save" class="btn btn-primary"><span class="oi oi-check"></span>Salva</button>
                </div>
            </div>
        </div>
    </div>
    */ ?>
    <?= user_mess($ui_mess, $ui_mess_type) ?>
    <div class="settings_header">
        <h1><?= $module_name ?></h1>
        <button type="submit" name="save" value="save" class="btn bottone_salva btn-primary"><span class="oi oi-check"></span>Salva</button>
    </div>
    <div class="row form-row">
        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Nome', 'name' => 'nome', 'value' => $entity->nome, 'width' => 'col-md-6', 'placeholder' => 'Nome']]) ?>
        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Valore', 'name' => 'val', 'value' => $entity->val, 'width' => 'col-md-4', 'placeholder' => 'Valore assegnato']]) ?>
        <?php if (isset($entities_types)) { ?>
            <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Tipo', 'name' => 'type', 'value' => $entity->type, 'width' => 'col-md-2', 'sources' => $entities_types, 'no_empty' => false]]) ?>
        <?php } ?>

    </div>
    <div class="checkboxs_cnt_flex">
        <?php if (isset($post_attributes) && is_iterable($post_attributes)) { ?>
            <?php foreach( $post_attributes as $post_attr ) { ?>
                <?= view('Lc5\Cms\Views\form-cmp/checkbox', ['item' => ['label' => $post_attr['label'], 'name' => $post_attr['name'], 'value' => $post_attr['active'], 'width' => 'col-md-3']]) ?>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="row form-row">
        <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Archivio', 'name' => 'has_archive', 'value' => $entity->has_archive, 'width' => 'col-md-2', 'sources' => $has_setting_select_value, 'no_empty' => true]]) ?>
        <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Gestione paragrafi', 'name' => 'has_paragraphs', 'value' => $entity->has_paragraphs, 'width' => 'col-md-2', 'sources' => $has_setting_select_value, 'no_empty' => true]]) ?>
        <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Gestione Custom fields', 'name' => 'has_custom_fields', 'value' => $entity->has_custom_fields, 'width' => 'col-md-2', 'sources' => $has_setting_select_value, 'no_empty' => true]]) ?>
        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'URL Pagina Archivio', 'name' => 'archive_root', 'value' => $entity->archive_root, 'width' => 'col-md-4', 'placeholder' => 'Valore assegnato']]) ?>
    </div>
    <div class="row form-row">
    
    <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Ordina per', 'name' => 'post_order', 'value' => $entity->post_order, 'width' => 'col-md-2', 'sources' => $post_ordine_keys_values , 'no_empty' => true]]) ?>
    <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Ordina dal', 'name' => 'post_sort', 'value' => $entity->post_sort, 'width' => 'col-md-2', 'sources' => $post_ordine_directions_values, 'no_empty' => true]]) ?>
    
    <?= view('Lc5\Cms\Views\form-cmp/number', ['item' => ['label' => 'Post per pagina', 'name' => 'post_per_page', 'value' => $entity->post_per_page, 'width' => 'col-md-2', 'placeholder' => '']]) ?>



    </div>



</form>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {



    });
</script>

<?= $this->endSection() ?>