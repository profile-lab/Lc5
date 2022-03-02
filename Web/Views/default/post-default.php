<?= $this->extend($base_view_folder . 'layout/body') ?>
<?= $this->section('content') ?>
<article>
    <header>
        <div class="myIn">
            <?= h1($titolo) ?>
            <?= h2($sottotitolo) ?>
        </div>
    </header>
    <div class="myIn">
        <?= single_img($main_img_path) ?>
        <?= txt($testo) ?>
        <?php if (isset($gallery_obj) && count($gallery_obj) > 0) { ?>
            <?= view($base_view_folder . 'components/slider', ['gallery_obj' => $gallery_obj]) ?>
        <?php } ?>
    </div>
</article>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {



    });
</script>

<?= $this->endSection() ?>