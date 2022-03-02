<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<script>
    let count_rows = 0;
</script>
<form class="form" method="POST">
    <?= user_mess($ui_mess, $ui_mess_type) ?>
    <div class="settings_header">
        <h1><?= $module_name ?></h1>
        <button type="submit" name="save" value="save" class="btn bottone_salva btn-primary"><span class="oi oi-check"></span>Salva</button>
    </div>
    <div class="row form-row">
        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Nome', 'name' => 'nome', 'value' => $entity->nome, 'width' => 'col-md-6', 'placeholder' => 'Nome']]) ?>
        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Valore', 'name' => 'val', 'value' => $entity->val, 'width' => 'col-md-4', 'placeholder' => 'Nome var']]) ?>
        <?php if (isset($entity_targets)) { ?>
            <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Target', 'name' => 'target', 'value' => $entity->target, 'width' => 'col-md-2', 'sources' => $entity_targets, 'no_empty' => true]]) ?>
        <?php } ?>
        <?php if (isset($entity_types)) { ?>
            <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['label' => 'Tipo', 'name' => 'type', 'value' => $entity->type, 'width' => 'col-md-2', 'sources' => $entity_types, 'no_empty' => true]]) ?>
        <?php } ?>
    </div>

</form>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {



    });
</script>

<?= $this->endSection() ?>