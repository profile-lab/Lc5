<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<script>
    let count_rows = 0;
</script>
<form class="form save_after_proc" method="POST" action="">
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

    <h1><?= $module_name ?></h1>
    <?= user_mess($ui_mess, $ui_mess_type) ?>
    <div class="row form-row">
        <div class="col-12 col-lg-9 scheda_body">
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
                <div class="row form-row border badge-light mt-4 mx-1 p-3">
                    <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'SEO title', 'name' => 'seo_title', 'value' => $entity->seo_title, 'width' => 'col-md-12', 'placeholder' => 'seo title', 'id' => null]]) ?>
                    <?= view('Lc5\Cms\Views\form-cmp/text-area', ['item' => ['label' => 'SEO description', 'name' => 'seo_description', 'value' => $entity->seo_description, 'width' => 'col-md-12', 'placeholder' => 'SEO description', 'id' => null]]) ?>
                </div>
            <?php } ?>


        </div>
        <div class="col-12 col-lg-3 mt-4 pl-lg-5 text-dark scheda-sb">
            <div class="row">
                <div class="col-12">
                    <div class="bg-light p-4 px-lg-2 py-lg-3 rounded">
                        <div class="col-sm-8 col-lg-12">
                            <div class="row">
                                <?= view('Lc5\Cms\Views\form-cmp/readonly', ['item' => ['label' => 'Guid', 'value' => $entity->guid, 'width' => 'col-12', 'placeholder' => '']]) ?>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-12">
                            <div class="row">
                                <?= view('Lc5\Cms\Views\form-cmp/img-single', ['item' => ['label' => 'Copertina', 'name' => 'main_img_id', 'value' => $entity->main_img_id, 'width' => 'col-12', 'src' => $entity->main_img_thumb]]) ?>
                            </div>
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
    $(document).ready(function() {});
</script>



<?= $this->endSection() ?>