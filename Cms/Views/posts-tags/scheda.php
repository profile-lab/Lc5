<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<script>
    let count_rows = 0;
</script>
<form class="form save_after_proc" method="POST" action="">
    <?php /*
<div id="scheda_tools" class="w-100 sticky-top mt-2 bg-white">
    <div class="container-fluid bg-dark text-light p-3 mt-3 mb-4">
        <div class="row d-md-flex justify-content-between align-items-center">
            <div class="col-7 col-sm-auto">
                <?php if ($entity->id) { ?>
                <?php } else { ?>
                    <h5 class="p-0 m-0">Crea nuova</h5>
                <?php } ?>
            </div>
            <div class="col-5 col-sm-auto text-right">
                <button type="submit" name="save" value="save" class="btn btn-primary btn_save_after_proc"><span class="oi oi-check"></span>Salva</button>
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
        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Valore', 'name' => 'val', 'value' => $entity->val, 'width' => 'col-md-6', 'placeholder' => 'Valore assegnato']]) ?>
    </div>


</form>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {});
</script>



<?= $this->endSection() ?>