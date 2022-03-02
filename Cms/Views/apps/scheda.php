<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<script>
    let count_rows = 0;
</script>
<form class="form parsa_labels" method="POST" enctype="multipart/form-data" action="">
    <?php /*
    <div id="scheda_tools" class="w-100 sticky-top mt-2">
        <div class="container-fluid bg-info text-light p-3 mt-3 mb-4 rounded">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-auto">
                    <?php if ($entity->id) { ?>
                    <?php } else { ?>
                        <h5 class="p-0 m-0">Crea nuovo</h5>
                    <?php } ?>
                </div>
                <div class="col-auto">
                    <button type="submit" name="save" value="save" class="btn btn-primary"><span class="oi oi-check"></span>Salva</button>
                </div>
            </div>
        </div>
    </div>
    */ ?>
    <?= user_mess($ui_mess, $ui_mess_type) ?>
    <div class="settings_header">
        <h1><?= $module_name ?></h1>
        <button type="submit" name="save" value="save" class="btn bottone_salva btn-primary"><span class="oi oi-check"></span>Salva</button>
    </div>
    <div class="row form-row">
        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Nome', 'name' => 'nome', 'value' => $entity->nome, 'width' => 'col-md-6', 'placeholder' => 'Nome']]) ?>
        <?= view('Lc5\Cms\Views\form-cmp/readonly', ['item' => ['label' => 'Guid', 'value' => $entity->apikey, 'width' => 'col-md-6', 'placeholder' => '']]) ?>
    </div>
    <div class="row form-row">
        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Dominio', 'name' => 'domain', 'value' => $entity->domain, 'width' => 'col-md-12', 'placeholder' => 'https://...']]) ?>

    </div>

    <?php if (isset($app_languages)) { ?>
        <div class="row form-row">
            <div class="col-12">
                <h4>Labels</h4>
            </div>
        </div>
        <div id="labels-rows-cnt">
            <?php if (isset($entity->app_labels_object)) { ?>
                <?php foreach ($entity->app_labels_object as $label_key => $label_item) { ?>
                    <div class="row_app_label">
                        <div class="form-field-label_key ">
                            <label>Key</label>
                            <input type="text" name="label_key[]" value="<?= $label_key ?>" class="form-control label_key">
                        </div>
                        <div class="form-field-label_vals_cnt">
                            <?php foreach ($app_languages as $__lang) { ?>
                                <div class="form-field-label_val ">
                                    <label><?= $__lang->nome ?></label>
                                    <input type="text" name="<?= 'label_' . $__lang->val . '[]' ?>" value="<?= (isset($label_item[$__lang->val])) ? esc($label_item[$__lang->val]) : '' ?>" meta-lang="<?= $__lang->val ?>" class="form-control label_val">
                                </div>
                            <?php } ?>
                        </div>
                        <div class="delete_row_cnt">
                            <a class="btn btn-danger btn-sm mt-3 py-1 px-2 delete_row" href="#"><span class="oi oi-trash m-0"></span></a>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="row form-row">
            <div class="col-auto">
                <a class="btn btn-info  btn-primary add_label" href="#">Nuova label</a>
            </div>
        </div>
        <?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['label' => 'labels_json_object', 'id' => 'labels_json_object', 'name' => 'labels_json_object', 'value' => $entity->labels_json_object, 'width' => 'col-md-12']]) ?>
    <?php } ?>







</form>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.add_label').click(function(e) {
            e.preventDefault();
            var htmlCode = $('#empty_label_row').html();
            var codeStrBase = htmlCode.toString();
            var codeStr = codeStrBase.replace(/###@###/g, '[]');
            var newCode = $(codeStr);
            $('#labels-rows-cnt').append(newCode)
        });
        $('body').on('click', '.delete_row', function(e) {
            e.preventDefault();
            console.log('pppo')
            $(this).closest('.row_app_label').remove();
        });
        $('form.parsa_labels').submit(function() {
            let labes_form_str = '';
            let labes_form_object = new Object();
            $('#labels-rows-cnt .row_app_label').each(function() {
                let label_key = $('.label_key', this).val().toString().trim().toLowerCase().replace(/\s+/g, "_").replace(/[^\w\-]+/g, "").replace(/\-\-+/g, "-").replace(/^-+/, "").replace(/-+$/, "");
                if (label_key !== "") {
                    let label_data = new Object();
                    $('.label_val', this).each(function() {
                        let c_label_lang = $(this).attr('meta-lang');
                        label_data[`${c_label_lang}`] = $(this).val()
                    })
                    labes_form_object[`${label_key}`] = label_data;
                }
            });
            labes_form_str = JSON.stringify(labes_form_object);
            $('#labels_json_object').val(labes_form_str);
            return true;
        });
    });
</script>
<script type="text/html" id="empty_label_row" style="display: none;">
    <div class="row_app_label">
        <div class="form-field-label_key ">
            <label>Key</label>
            <input type="text" name="label_key[]" value="" class="form-control label_key">
        </div>
        <?php if (isset($app_languages)) { ?>
                <div class="form-field-label_vals_cnt">
                    <?php foreach ($app_languages as $__lang) { ?>
                        <div class="form-field-label_val ">
                            <label><?= $__lang->nome ?></label>
                            <input type="text" name="<?= 'label_' . $__lang->val . '[]' ?>" value="" meta-lang="<?= $__lang->val ?>" class="form-control label_val">
                        </div>
                    <?php } ?>
                </div>
        <?php } ?>
        <div class="delete_row_cnt">
            <a class="btn btn-danger btn-sm btn-sm mt-3 py-1 px-2 delete_row" href="#"><span class="oi oi-trash m-0"></span></a>
        </div>
    </div>
</script>


<?= $this->endSection() ?>

<?php /*
$this->lc_ui_date->__set('lc_languages', $this->getLcLanguages());
		$this->default_lc_lang = $this->getDefaultLang();
		$this->lc_ui_date->__set('default_lc_lang', $this->default_lc_lang);
		$this->curr_lc_lang = $this->getCurrLang();
		$this->lc_ui_date->__set('curr_lc_lang', $this->curr_lc_lang);
*/ ?>