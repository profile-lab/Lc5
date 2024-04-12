<?= $this->extend($base_view_folder . 'layout/body') ?>
<?= $this->section('content') ?>
<article>
    <div class="row">
        <div class="myIn">
            <h2><?= lang('Errors.pageNotFound') ?>
        </div>
</article>


<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {



    });
</script>
<?= $this->endSection() ?>