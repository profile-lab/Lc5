<?= $this->extend($base_view_folder . 'layout/body') ?>
<?= $this->section('content') ?>
<article>
    <?php if ($rows_code =  printPostRows($entity_rows)) { ?>
        <?= $rows_code ?>
    <?php } else { ?>
        <header>
            <div class="myIn">
                <?= h1($titolo, 'shop_archive_title') ?>
            </div>
        </header>
    <?php } ?>
</article>
<section class="shop_listing"> 
    <div class="myIn shop_flex">
        <div class="shop_content shop_content_listing">
            <?php if (isset($products_archive) && is_iterable($products_archive) && count($products_archive) > 0) { ?>
                <?php foreach ($products_archive as $single) { ?>
                    <?= view($base_view_folder . 'shop/components/product-listing-card', ['single_items' => $single]) ?>
                <?php } ?>
            <?php } ?>
        </div>
        <?= view($base_view_folder . 'shop/components/sidebar') ?>
    </div>
</section>
<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {



    });
</script>

<?= $this->endSection() ?>