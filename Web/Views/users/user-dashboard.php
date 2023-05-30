<?= $this->extend($base_view_folder . 'layout/body') ?>
<?= $this->section('content') ?>
<article>
    <section class="main_cnt">
        <div class="myIn user_mess_cnt">
            <h1 class="h1 text-center"><?= (isset($titolo)) ? $titolo : 'Errore' ?></h1>
            <div class="h3 text-center"><?= (isset($descrizione)) ? $descrizione : '' ?></div>

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