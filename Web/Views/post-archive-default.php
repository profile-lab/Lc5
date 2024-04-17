<?= $this->extend(customOrDefaultViewFragment('layout/body')) ?>
<?= $this->section('content') ?>
<article>
    <header>
        <div class="myIn">
            <?= h1($nome, 'archive_title', 'Archivio ') ?>
        </div>
    </header>
</article>
<?php if (isset($posts_archive) && is_iterable($posts_archive) && count($posts_archive) > 0) { ?>
    <?= view(customOrDefaultViewFragment('components/posts-archive-list'), ['posts_archive' => $posts_archive]) ?>
<?php } ?>
<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {



    });
</script>

<?= $this->endSection() ?>