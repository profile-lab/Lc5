<?= $this->extend(customOrDefaultViewFragment('layout/body')) ?>
<?= $this->section('content') ?>
<article>
    <?= printPostRows($entity_rows) ?>
</article>
<?php if (isset($posts_archive) && is_iterable($posts_archive) && count($posts_archive) > 0) { ?>
    <?= view(customOrDefaultViewFragment('components/posts-archive-list'), ['posts_archive' => $posts_archive, 'show_archive_link' => true]) ?>
<?php } ?>
<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>


<?= $this->endSection() ?>