<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<script>
    let count_rows = 0;
</script>
<form class="form" method="POST" enctype="multipart/form-data" action="">
    <div id="scheda_tools" class="w-100 sticky-top mt-2">
        <div class="container-fluid bg-info text-light p-3 mt-3 mb-4 rounded">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-auto">
                    <?php if ($entity->id) { ?>
                    <?php } else { ?>
                        <h5 class="p-0 m-0">Crea nuovo media</h5>
                    <?php } ?>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary"><span class="oi oi-check"></span>Salva</button>
                </div>
            </div>
        </div>
    </div>
    <h1><?= $module_name ?></h1>
    <?= user_mess($ui_mess, $ui_mess_type) ?>
    <div class="row form-row">
        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Nome', 'name' => 'nome', 'value' => $entity->nome, 'width' => 'col-md-7', 'placeholder' => 'Nome']]) ?>
        <?= view('Lc5\Cms\Views\form-cmp/readonly', ['item' => ['label' => 'Guid', 'value' => $entity->guid, 'width' => 'col-md-5', 'placeholder' => '']]) ?>
    </div>
    <div class="row form-row">
        <?php if (isset($entity->path) && trim($entity->path) && trim($entity->is_image)) { ?>
            <div class="form-group col-md-4">
                <div class="col-auto">
                    <a href="<?= env('custom.media_root_path') ?><?= $entity->path ?>?v=<?= rand(0, 100) ?>">
                        <img src="<?= env('custom.media_root_path') ?>thumbs/<?= $entity->path ?>?v=<?= rand(0, 100) ?>" class="img-thumbnail" />
                    </a>
                </div>
            </div>
        <?php } else { ?>
        <?php } ?>
        <?= view('Lc5\Cms\Views\form-cmp/file', ['item' => ['label' => 'File da caricare', 'name' => 'file_up', 'value' => $entity->file_up, 'width' => 'col-md-8', 'placeholder' => 'Seleziona un file']]) ?>
    </div>


</form>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {



    });
</script>

<?= $this->endSection() ?>