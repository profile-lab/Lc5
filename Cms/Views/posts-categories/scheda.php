<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<script>
    let count_rows = 0;
</script>
<form class="form save_after_proc" method="POST" action="">

    <?= user_mess($ui_mess, $ui_mess_type) ?>
    <div class="row form-row">
        <div class="scheda_body">
            <div id="scheda_tools" class="w-100 sticky-top mt-2">
            </div>
            <div class="first-row">
                <div class="row">
                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Nome', 'name' => 'nome', 'value' => $entity->nome, 'width' => 'col-md-12', 'placeholder' => 'Nome']]) ?>
                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Titolo', 'name' => 'titolo', 'value' => $entity->titolo, 'width' => 'col-md-12', 'placeholder' => 'Titolo']]) ?>
                </div>
                <div class="row form-row">
                    <?= view('Lc5\Cms\Views\form-cmp/html-editor', ['item' => ['label' => 'Testo', 'name' => 'testo', 'value' => (isset($entity->testo)) ? $entity->testo : '', 'width' => 'col-md-12', 'placeholder' => '...']]) ?>
                </div>
                <div class="row form-row">
                    <?= view('Lc5\Cms\Views\form-cmp/img-gallery', ['item' => ['label' => 'Gallery', 'name' => 'gallery', 'value' => (isset($entity->gallery)) ? $entity->gallery : '{}', 'width' => 'col-12', 'gallery_obj' => (isset($entity->gallery_obj)) ? $entity->gallery_obj : []]]) ?>
                </div>
                <?php if ($entity->id) { ?>
                    <div class="row">
                        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'SEO title', 'name' => 'seo_title', 'value' => $entity->seo_title, 'width' => 'col-md-12', 'placeholder' => 'seo title', 'id' => null]]) ?>
                        <?= view('Lc5\Cms\Views\form-cmp/text-area', ['item' => ['label' => 'SEO description', 'name' => 'seo_description', 'value' => $entity->seo_description, 'width' => 'col-md-12', 'placeholder' => 'SEO description', 'id' => null]]) ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="scheda-sb margin-top-0">
            <div class="save_sb_cnt">
                <button type="submit" name="save" value="save" class="btn btn-primary bottone_salva btn_save_after_proc"><span class="oi oi-check"></span>Salva</button>
            </div>
            <div class="row">
                <?= view('Lc5\Cms\Views\form-cmp/readonly', ['item' => ['label' => 'Nome', 'value' => $entity->nome, 'name' => 'nome',  'width' => 'col-12', 'placeholder' => '', 'if_active_name' => 'nome',  'enabled' => (($entity->id) ? TRUE : FALSE)]]) ?>
                <?= view('Lc5\Cms\Views\form-cmp/readonly', ['item' => ['label' => 'Guid', 'value' => $entity->guid, 'width' => 'col-12', 'placeholder' => '', 'if_active_name' => 'guid',  'enabled' => (($entity->id) ? TRUE : FALSE)]]) ?>
                <?= view('Lc5\Cms\Views\form-cmp/select', [ 'item' => ['label' => 'Public', 'name' => 'public', 'input_class' => 'public', 'value' => $entity->public, 'width' => 'col-md-12', 'sources' => $bool_values, 'no_empty' => true] ]); ?>
            </div>
            <div class="row">
                <?= view('Lc5\Cms\Views\form-cmp/img-single', ['item' => ['label' => 'Copertina', 'name' => 'main_img_id', 'value' => $entity->main_img_id, 'width' => 'col-12', 'src' => $entity->main_img_thumb]]) ?>
            </div>
        </div>
    </div>

</form>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {});
</script>



<?= $this->endSection() ?>