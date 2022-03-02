<?= $this->extend($base_view_folder . 'layout/body') ?>
<?= $this->section('content') ?>
<article>
    <?= printPostRows($entity_rows) ?>
</article>
<?php if (isset($posts_archive) && is_iterable($posts_archive) && count($posts_archive) > 0) { ?>
    <div class="myIn">
        <?= h3($posts_archive_name) ?>
        <?= cta($posts_archive_index, 'Vai all\'archivio', 'btn-archive') ?>
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