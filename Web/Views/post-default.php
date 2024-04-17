<?= $this->extend(customOrDefaultViewFragment('layout/body')) ?>
<?= $this->section('content') ?>
<article>
    <section class="post-header">
        <div class="myIn">
            <?= h1($titolo) ?>
            <?= h2($sottotitolo) ?>
        </div>
    </section>
    <section class="post-content">
        <div class="myIn">
            <?= single_img($main_img_path) ?>
            <?= txt($testo) ?>
            <?php if (isset($gallery_obj) && count($gallery_obj) > 0) { ?>
                <?= view(customOrDefaultViewFragment('components/slider'), ['gallery_obj' => $gallery_obj]) ?>
            <?php } ?>
        </div>
    </section>
</article>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {



    });
</script>

<?= $this->endSection() ?>