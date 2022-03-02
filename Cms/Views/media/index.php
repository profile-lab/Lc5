<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<div class="d-md-flex justify-content-between align-items-center">
    <h1><?= $module_name ?></h1>
    <div class="d-flex align-items-center">
        <div>
            <a class="btn btn-primary" href="<?= site_url(route_to($route_prefix . '_new')) ?>"><span class="oi oi-plus mr-1"></span>Crea nuovo media</a>
        </div>
    </div>
</div>

<?= user_mess($ui_mess, $ui_mess_type) ?>
<div class="first-row">
    <div id="drag-and-drop-zone" class="dm-uploader">
        <h3>Trascina qui i tuoi Files</h3>
        <div class="btn">
            <span>Oppure selezionali cliccando qui</span>
            <input type="file" title="Seleziona" multiple="">
        </div>
    </div>
    <div id="list_media_items" class="list_media_items target_dropUpload_CNT">
        <?php if (count($list) > 0) { ?>
            <?php foreach ($list as $item) { ?>
                <?= view('Lc5\Cms\Views\part-cmp/media-list-item', [
                    'item' => (object) [
                        'id' => $item->id,
                        'path' => $item->path,
                        'href' => site_url(route_to($route_prefix . '_edit', $item->id)),
                        'nome' => $item->nome,
                        'is_image' => $item->is_image,
                        'tipo_file' => $item->tipo_file,
                        'src' => site_url('uploads/thumbs/' . $item->path),
                        'img_thumb' => $item->img_thumb,
                        'del_link' => site_url(route_to($route_prefix . '_delete', $item->id)),
                    ]
                ]) ?>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {
        avvia_draguploader('<?= route_to('lc_media_ajax_upload') ?>', null);
    });
</script>
<?= $this->endSection() ?>