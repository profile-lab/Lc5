<?= $this->extend($base_view_folder . 'layout/body') ?>
<?= $this->section('content') ?>
<article>
    <header> <?= h1('NEWS') ?>
        <div class="myIn">
            <?= h1($nome, 'archive_title', 'Archivio ') ?>
        </div>
    </header>
</article>
<?php if (isset($posts_archive) && is_iterable($posts_archive) && count($posts_archive) > 0) { ?>
    <div class="myIn">
        <div class="card_listing_cnt">
            <?php foreach ($posts_archive as $single) { ?>
                <?= view($base_view_folder . 'components/post-listing-card', ['single_items' => $single]) ?>
            <?php } ?>
        </div>
        <?php if (isset($pager)) { ?>
            <?= $pager->links() ?>
        <?php } ?>
    </div>
<?php } ?>
<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {



    });
</script>

<?= $this->endSection() ?>