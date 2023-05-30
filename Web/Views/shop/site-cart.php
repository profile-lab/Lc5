<?= $this->extend($base_view_folder . 'layout/body') ?>
<?= $this->section('content') ?>
<article>

    <header>
        <div class="myIn">
            <?= h1($titolo, 'shop_archive_title') ?>
        </div>
    </header>
</article>
<section class="shop_carrello">
    <div class="myIn">
        <?php if (isset($site_cart) && is_array($site_cart)) { ?>
            <?php
            // d($site_cart );    
            ?>
            <div class="cart-page">
                <?php foreach ($site_cart as $cart_item) { ?>
                    <div class="cart-page-row">
                        <div class="cart-page-col cart-page-col-name">
                            <a href="<?= $cart_item->permalink ?>">
                                <?= $cart_item->full_nome_prodotto ?>
                            </a>
                        </div>
                        <div class="cart-page-col cart-page-col-qnt">
                            <a class="cart-page-qnt-action" href="<?= route_to(__locale_uri__ . 'web_shop_cart_decrement_qnt', $cart_item->row_key) ?>">-</a>
                            <span class="cart-page-qnt-val">
                                <?= $cart_item->qnt ?>
                            </span>
                            <a class="cart-page-qnt-action" href="<?= route_to(__locale_uri__ . 'web_shop_cart_increment_qnt', $cart_item->row_key) ?>">+</a>
                        </div>
                        <div class="cart-page-col cart-page-col-price">&euro; <span class="cart-page-price-val"><?= $cart_item->prezzo_uni ?></span></div>
                        <div class="cart-page-col cart-page-col-price">&euro; <span class="cart-page-price-val"><?= $cart_item->prezzo ?></span></div>
                        <div class="cart-page-col cart-page-col-action">
                            <a class="cart-page-action" href="<?= route_to(__locale_uri__ . 'web_shop_cart_remove_row', $cart_item->row_key) ?>">&#10005;</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <h3 class="cart-page-mess no_products">Non ci sono prodotti!</h3>
        <?php } ?>
    </div>
</section>
<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {



    });
</script>

<?= $this->endSection() ?>