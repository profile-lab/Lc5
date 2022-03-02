<?= $this->extend($base_view_folder . 'layout/body') ?>
<?= $this->section('content') ?>
<article>
    <header>
        <div class="myIn">
            <?= h1($full_nome_prodotto) ?>

        </div>
    </header>
    <div class="myIn shop_flex">
        <div class="shop_content shop_content_detail">
            <?= h2($sottotitolo) ?>
            <?= txt($testo, 'description') ?>
            <?php if (isset($modelli) && is_array($modelli)) { ?>
                <?php if (count($modelli) > 1) { ?>

                    <ul>
                        <?php foreach ($modelli as $modello) { ?>
                            <li class="<?= ($id == $modello->id) ? 'current' : '' ?>">
                                <a href="<?= $modello->permalink ?>"><?= $modello->full_nome_prodotto ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            <?php } ?>
            <?= (isset($category_obj) && $category_obj) ? '<a href="' . $category_obj->permalink . '">' . $category_obj->nome . '</a>' : '' ?>
            <?= single_img($main_img_path, '') ?>
            <?php if (isset($gallery_obj) && count($gallery_obj) > 0) { ?>
                <?= view($base_view_folder . 'components/slider', ['gallery_obj' => $gallery_obj, 'format_folder' => '']) ?>
            <?php } ?>
            <?= txt($scheda_tecnica, 'scheda_tecnica') ?>


            <form method="post" name="add_to_cart_form">

                <div class="prezzo">
                    <span class="price_coin"><?= $prezzo_coin ?></span><span class="price_spacer">/</span><span class="price_um"><?= $um ?></span>
                </div>


                <input type="hidden" name="prod_id" value="<?= $prod_id ?>">
                <input type="hidden" name="prod_model_id" value="<?= $prod_model_id ?>" />

                <div class="agg_cart_cnt">

                    <div class="qty">
                        <button type="button" class="less" onclick="this.parentNode.querySelector('.qty_input').value = (this.parentNode.querySelector('.qty_input').value - 1); return;" value="-1">-</button>
                        <input class="qty_input" name="prod_qty" type="number" min="1" max="99" step="1" value="1" \>
                        <button type="button" class="more" onclick="this.parentNode.querySelector('.qty_input').value = (parseInt( this.parentNode.querySelector('.qty_input').value) + 1 ); return;" value="+1">+</button>
                    </div>
                    <button type="submit" name="cart_action" value="ADD" class="cart_in">
                        <svg xmlns="http://www.w3.org/2000/svg" width="37" height="30" viewBox="0 0 37 30">
                            <defs>
                                <style>
                                    .cart {
                                        fill: #FFF;
                                    }
                                </style>
                            </defs>
                            <path class="cart" d="M257.042,396.3H234.391l-.569-2.967h24.5l2.974-15.165H230.949l-1.093-5.769H224.3v1.154h4.6l4.326,22.8a3.046,3.046,0,1,0,3.579,3,3.018,3.018,0,0,0-.68-1.9h18.547a3.018,3.018,0,0,0-.68,1.9,3.049,3.049,0,1,0,3.05-3.05Zm-7.974-4.121h-3l.029-12.857h3.833Zm2.016-12.857h3.829l-1.69,12.857h-3Zm-6.173,12.857h-3l-.8-12.857h3.834Zm-4.159,0h-3l-1.632-12.857h3.829Zm16.623,0h-2.989l1.69-12.857h3.82Zm-22.418-12.857,1.633,12.857H233.6l-2.435-12.857Zm.694,20.028a1.9,1.9,0,1,1-1.9-1.9A1.9,1.9,0,0,1,235.651,399.351Zm21.391,1.895a1.9,1.9,0,1,1,1.9-1.895A1.9,1.9,0,0,1,257.042,401.246Z" transform="translate(-224.298 -372.4)"></path>
                        </svg>
                    </button>

                </div>
            </form>



        </div>
        <?= view($base_view_folder . 'shop/components/sidebar') ?>
    </div>
</article>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {

    });
</script>

<?= $this->endSection() ?>