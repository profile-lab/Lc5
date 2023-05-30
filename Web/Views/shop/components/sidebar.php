<aside class="sidebar shop_sidebar">
    <?= view($base_view_folder . 'shop/components/mini-cart') ?>
    <h4>Categorie</h4>
    <?php if (isset($categories) && is_array($categories)) { ?>
        <ul class="shop_category_list">
            <?php foreach ($categories as $category) { ?>
                <li>
                    <a href="<?= $category->permalink ?>"><?= $category->nome ?></a>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</aside>