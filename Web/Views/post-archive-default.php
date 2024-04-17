<?= $this->extend(customOrDefaultViewFragment('layout/body')) ?>
<?= $this->section('content') ?>
<article>
    <section class="post-header">
        <div class="myIn">
            <?= h1($nome, 'archive_title', 'Archivio ') ?>
        </div>
    </section>
</article>
<?php if (isset($posts_archive) && is_iterable($posts_archive) && count($posts_archive) > 0) { ?>
    <?= view(customOrDefaultViewFragment('components/posts-archive-list'), ['posts_list' => $posts_archive]) ?>
<?php } ?>
<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {



    });
</script>

<?= $this->endSection() ?>