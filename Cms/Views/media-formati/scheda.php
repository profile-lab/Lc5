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
                    <button type="submit" class="btn btn-primary"><span class="oi oi-check"></span>Salva</button>
                </div>
            </div>
        </div>
    </div>
    */ ?>
    <div class="settings_header">
        <h1><?= $module_name ?></h1>
        <button type="submit" class="btn bottone_salva btn-primary"><span class="oi oi-check"></span>Salva</button>
    </div>
    <?= user_mess($ui_mess, $ui_mess_type) ?>
    <div class="row setting_cnt">
        <div class="settings_half">
            <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Nome', 'name' => 'nome', 'value' => $entity->nome, 'width' => 'col-md-4', 'placeholder' => 'Nome']]) ?>
            <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Cartella', 'name' => 'folder', 'value' => $entity->folder, 'width' => 'col-md-4', 'placeholder' => 'Cartella formato']]) ?>
            <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => '&nbsp;', 'name' => 'rule', 'value' => $entity->rule, 'width' => 'col-md-2', 'sources' => $rules, 'no_empty' => false]]) ?>
        </div>
        <div class="settings_half">
            <?= view('Lc5\Cms\Views\form-cmp/number', ['item' => ['label' => 'Width', 'name' => 'w', 'value' => $entity->w, 'width' => 'col-md-1', 'placeholder' => '']]) ?>
            <?= view('Lc5\Cms\Views\form-cmp/number', ['item' => ['label' => 'Height', 'name' => 'h', 'value' => $entity->h, 'width' => 'col-md-1', 'placeholder' => '']]) ?>
        </div>
    </div>



</form>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {



    });
</script>

<?= $this->endSection() ?>