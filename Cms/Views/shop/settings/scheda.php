<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<?= view('Lc5\Cms\Views\layout/components/tools_tabs') ?>
<script>
    let count_rows = 0;
</script>
<form class="form" method="POST" enctype="multipart/form-data" action="">
    <div id="scheda_tools" class="w-100 sticky-top mt-2">
        <div class="container-fluid bg-info text-light p-3 mt-3 mb-4 rounded">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-auto">
                    <?php if ($entity->id) { ?>
                    <?php } else { ?>
                        <h5 class="p-0 m-0">Crea nuovo</h5>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>

    <div class="d-md-flex">
        <div>
            <?= view('Lc5\Cms\Views\layout/components/back-btn') ?>
            <h1><?= $module_name ?></h1>
        </div>
        <div class="d-flex align-items-center">
            <div>
                <button type="submit" name="save" value="save" class="btn bottone_salva btn-primary"><span class="oi oi-check"></span>Salva</button>
            </div>
        </div>
    </div>
    <?= user_mess($ui_mess, $ui_mess_type) ?>

    <div class="row setting_cnt">
        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['width' => 'form_1_2', 'label' => 'Email', 'name' => 'email', 'value' => $entity->email, 'placeholder' => 'info@dominio.com']]) ?>
        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['width' => 'form_1_2', 'label' => 'Phone', 'name' => 'phone', 'value' => $entity->phone, 'placeholder' => '(+39) 000 000 000']]) ?>
    </div>
    <div class="row setting_cnt">
        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['width' => 'form_1_2', 'label' => 'Shop Homepage', 'name' => 'shop_home', 'value' => $entity->shop_home]]) ?>
        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['width' => 'form_1_2', 'label' => 'Titolo SEO', 'name' => 'seo_title', 'value' => $entity->seo_title, 'placeholder' => '']]) ?>
    </div>
    <div class="row setting_cnt">
        <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['width' => 'form_1_3', 'label' => 'Tipologia sconti', 'name' => 'discount_type', 'value' => $entity->discount_type, 'sources' => $discount_type_list, 'no_empty' => true]]) ?>
        <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['width' => 'form_1_3', 'label' => 'Gestione modelli / sotto prodotti', 'name' => 'products_has_childs', 'value' => $entity->products_has_childs, 'sources' => $boolean_select, 'no_empty' => true]]) ?>
        <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['width' => 'form_1_3', 'label' => 'Solo prodotti digitali', 'name' => 'only_digitals_products', 'value' => $entity->only_digitals_products, 'sources' => $boolean_select, 'no_empty' => true]]) ?>
    </div>
    <div class="row setting_cnt">
        <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['width' => 'form_1_3', 'label' => 'Spedizioni attive', 'name' => 'shipment_active', 'value' => $entity->shipment_active, 'sources' => $boolean_select, 'no_empty' => true]]) ?>
        <?= view('Lc5\Cms\Views\form-cmp/select', ['item' => ['width' => 'form_1_3', 'label' => 'Ritiro in sede', 'name' => 'pickup_attivo', 'value' => $entity->pickup_attivo, 'sources' => $boolean_select, 'no_empty' => true]]) ?>
    </div>
    <div class="row setting_cnt">
        <?= view('Lc5\Cms\Views\form-cmp/text-area', ['item' => ['width' => 'form_1_2', 'label' => 'Stripe Account', 'name' => 'stripe_account', 'value' => $entity->stripe_account]]) ?>
        <?= view('Lc5\Cms\Views\form-cmp/text-area', ['item' => ['width' => 'form_1_2', 'label' => 'Sumup Account', 'name' => 'sumup_account', 'value' => $entity->sumup_account]]) ?>
    </div>
    <div class="row setting_cnt">
        <?= view('Lc5\Cms\Views\form-cmp/text-area', ['item' => ['width' => 'form_1_2', 'label' => 'Paypal Account', 'name' => 'paypal_account', 'value' => $entity->paypal_account]]) ?>
    </div>
    </div>







</form>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {



    });
</script>

<?= $this->endSection() ?>