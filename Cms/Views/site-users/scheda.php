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
        <div class="col-12 col-lg-9 scheda_body">
            <div class="first-row">
                <div class="row form-row">
                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Nome', 'name' => 'name', 'value' => $entity->name, 'width' => 'col-md-6', 'placeholder' => 'Nome']]) ?>
                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Cognome', 'name' => 'surname', 'value' => $entity->surname, 'width' => 'col-md-6', 'placeholder' => 'Cognome']]) ?>
                </div>
                <div class="row form-row">
                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Email', 'name' => 'email', 'value' => $entity->email, 'width' => 'col-md-12', 'placeholder' => 'info@dominio.com']]) ?>
                </div>

            </div>


        </div>
        <div class="scheda-sb margin-top-0">
            <div class="row">
                <div class="col-12">
                    <div class="bg-light rounded">
                        <div class="row">
                            <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Attivo', 'name' => 'status', 'value' => $entity->status, 'width' => 'col-md-2', 'sources' => $bool_values, 'no_empty' => true]]) ?>
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



    });
</script>

<?= $this->endSection() ?>