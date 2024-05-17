<@= $this->extend('Lc5\Cms\Views\layout/body') ?>
<@= $this->section('content') ?>
<script>
    let count_rows = 0;
</script>
<form class="form save_after_proc" method="POST" action="">
    <@= user_mess($ui_mess, $ui_mess_type) ?>
    <div class="row form-row">
        <div class="scheda_body new page_new">
            <div id="scheda_tools">
            <h1><@= $module_name ?></h1>
            </div>
            <div class="row first-row">
                <@= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Titolo', 'name' => 'titolo', 'value' => $entity->titolo, 'width' => 'col-md-12', 'placeholder' => 'Titolo']]) ?>
                <button type="submit" class="btn btn-primary bottone_salva"><span class="oi oi-check"></span>Crea</button>
            </div>
        </div>
    </div>

</form>


<@= $this->endSection() ?>