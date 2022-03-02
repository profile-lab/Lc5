<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
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
    <div class="settings_header">
	    <h1><?= $module_name ?></h1>
        <button type="submit" name="save" value="save" class="btn bottone_salva btn-primary"><span class="oi oi-check"></span>Salva</button>
    </div>
    <?= user_mess($ui_mess, $ui_mess_type) ?>
   
    <div class="row setting_cnt">
	    <div class="settings_half">
	        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Claim', 'name' => 'app_claim', 'value' => $entity->app_claim, 'width' => 'col-md-12', 'placeholder' => '']]) ?>
	        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Copy', 'name' => 'copy', 'value' => $entity->copy, 'width' => 'col-md-12', 'placeholder' => '']]) ?>
	        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Email', 'name' => 'email', 'value' => $entity->email, 'width' => 'col-md-4', 'placeholder' => 'info@dominio.com']]) ?>
	        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Phone', 'name' => 'phone', 'value' => $entity->phone, 'width' => 'col-md-4', 'placeholder' => '(+39) 000 000 000']]) ?>
	        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Shop', 'name' => 'shop', 'value' => $entity->shop, 'width' => 'col-md-4', 'placeholder' => 'Eventuale ecommerce esterno']]) ?>
	        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Indirizzo', 'name' => 'address', 'value' => $entity->address, 'width' => 'col-md-8', 'placeholder' => 'Via Roma 10']]) ?>
	        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Partita iva', 'name' => 'piva', 'value' => $entity->piva, 'width' => 'col-md-4', 'placeholder' => '']]) ?>
	        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Titolo SEO', 'name' => 'seo_title', 'value' => $entity->seo_title, 'width' => 'col-md-12', 'placeholder' => '']]) ?>
	        <?= view('Lc5\Cms\Views\form-cmp/html-editor', ['item' => ['label' => 'Testo', 'name' => 'app_description', 'value' => (isset($entity->app_description)) ? $entity->app_description : '', 'width' => 'col-md-12', 'placeholder' => '...']]) ?>
    	</div> 
    	<div class="settings_half">   
	        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Pagina Facebook', 'name' => 'facebook', 'value' => $entity->facebook, 'width' => 'col-md-6', 'placeholder' => 'https://facebook.com/...']]) ?>
	        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Pagina Instagram', 'name' => 'instagram', 'value' => $entity->instagram, 'width' => 'col-md-6', 'placeholder' => 'https://instagram.com/...']]) ?>
	        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Pagina Twitter', 'name' => 'twitter', 'value' => $entity->twitter, 'width' => 'col-md-6', 'placeholder' => 'https://twitter.com/...']]) ?>
	        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Google Maps', 'name' => 'maps', 'value' => $entity->maps, 'width' => 'col-md-6', 'placeholder' => 'Codice iframe google Maps']]) ?>
	       
	        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Youtube', 'name' => 'youtube', 'value' => $entity->youtube, 'width' => 'col-md-6', 'placeholder' => 'https://youtube.com/...']]) ?>
	        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Linkedin', 'name' => 'linkedin', 'value' => $entity->linkedin, 'width' => 'col-md-6', 'placeholder' => 'linkedin.com...']]) ?>
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