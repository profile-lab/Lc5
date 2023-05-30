<div class="mini-cart-cnt">
    <?php if (isset($site_cart) && is_array($site_cart)) { ?>
        <h4 class="mini-cart-title">
            <a href="<?= route_to(__locale_uri__ . 'web_shop_cart') ?>">
                Il tuo carrello
            </a>
        </h4>
        <?php
        // d($site_cart );    
        ?>
        <div class="mini-cart">
            <?php foreach ($site_cart as $cart_item) { ?>
                <div class="mini-cart-row">
                    <div class="mini-cart-col mini-cart-col-name">
                        <?= $cart_item->full_nome_prodotto ?>
                    </div>
                    <div class="mini-cart-col mini-cart-col-qnt">
                        <a class="mini-cart-qnt-action" href="<?= route_to(__locale_uri__ . 'web_shop_cart_decrement_qnt', $cart_item->row_key) ?>">-</a>
                        <span class="mini-cart-qnt-val">
                            <?= $cart_item->qnt ?>
                        </span>
                        <a class="mini-cart-qnt-action" href="<?= route_to(__locale_uri__ . 'web_shop_cart_increment_qnt', $cart_item->row_key) ?>">+</a>
                    </div>
                    <div class="mini-cart-col mini-cart-col-price">&euro; <span class="mini-cart-price-val"><?= $cart_item->prezzo ?></span>
                    </div>
                    <div class="mini-cart-col mini-cart-col-action">
                        <a class="mini-cart-action" href="<?= route_to(__locale_uri__ . 'web_shop_cart_remove_row', $cart_item->row_key) ?>">&#10005;</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <h5 class="mini-cart-mess no_products">Non ci sono prodotti!</h5>
    <?php } ?>

</div>