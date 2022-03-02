<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<?= view('Lc5\Cms\Views\layout/components/tools_tabs') ?>
<script>
    let count_rows = 0;
</script>
<form class="form" method="POST" action="">


    <?= user_mess($ui_mess, $ui_mess_type) ?>
    <div class="d-md-flex">
        <div class="d-flex align-items-center">
            <?= view('Lc5\Cms\Views\layout/components/back-btn') ?>
            <h1><?= $module_name ?></h1>
        </div>
        <div class="d-flex align-items-center">
            <div>
                <button type="submit" name="save" value="save" class="btn bottone_salva btn-primary"><span class="oi oi-check"></span>Salva</button>
            </div>
        </div>
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