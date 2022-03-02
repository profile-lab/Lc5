<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<script>
    let count_rows = 0;
</script>
<form class="form" method="POST" enctype="multipart/form-data" action="">
    <div id="media_page" class="w-100  sticky-top mt-2">
        <div class="col-auto">
            <?php if ($entity->id) { ?>
            <?php } else { ?>
                <h5 class="p-0 m-0">Crea nuovo media</h5>
            <?php } ?>
        </div>
        
    </div>
    <h1><?= $module_name ?></h1>
    <?= user_mess($ui_mess, $ui_mess_type) ?>
    
 <div class="media_cnt">   
        <?php if (isset($img_formati) && is_array($img_formati) && isset($entity->path) && trim($entity->path) && trim($entity->is_image)) { ?>
        <div class="row formati_items_cnt">
	        <div class="formati_items_in">
	            <?php foreach ($img_formati as $formato) { ?>
	
	                <div class="formato_item">
		                <div class="colonne_content-row_item_body">
		                    <?php if (mediaExist(lc_fileFormat($entity->path, $formato['folder']))) { ?>
		                        <a href="#" class="image_pop formato_item_img_a">
		                            <img src="<?= lc_fileFormat($entity->path, $formato['folder']) ?>?v=<?= rand(0, 100) ?>" class="img-fluid bg-nero p-3 img-thumbnail img-fit" />
		                        </a>
		                    <?php } else { ?>
		                        <div class="no-img-text">File non trovato nel formato <i>"<?= $formato['nome'] ?>"</i> (/<?= $formato['folder'] ?>)</div>
		                    <?php } ?>
		                    <div class="info-formato formato_item_extra">
		                        <div class="formato_item_info">
		                            <div class="formato_item_info_block">
		                                <div class="col-6">
		                                    <span class="val"><strong>Name:</strong> <?= $formato['nome'] ?></span>
		                                </div>
		                                <div class="col-6 text-right">
		                                    <span class="val"><strong>Folder:</strong> /<?= (trim($formato['folder']) ? $formato['folder'] . '/' : '') ?></span>
		                                </div>
		                            </div>
		                            <div class="formato_item_info_block">
		                                <div class="col-4">
		                                    <span class="val"><strong>Type:</strong> <?= $formato['rule'] ?></span>
		                                </div>
		                                <div class="col-8 text-right">
		                                    <span class="val"><strong>Size:</strong> <?= ($formato['w'] > 0) ? $formato['w'] : 'auto' ?></span> X <span class="val"><?= ($formato['h'] > 0) ? $formato['h'] : 'auto' ?></span>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="formato_item_tools">
		                            <a href="<?= site_url(route_to($route_prefix . '_crop', $entity->id, $formato['id'])) ?>" class="btn btn-sm btn-primary"><span class="oi oi-crop"></span>Edit</a>
		                            <a href="<?= site_url(route_to($route_prefix . '_rotate', $entity->id, $formato['id'])) ?>" class="btn btn-sm btn-primary"><span class="oi oi-reload"></span>Ruota</a>
		                            <a href="<?= site_url(route_to($route_prefix . '_rebase', $entity->id, $formato['id'])) ?>" class="btn btn-sm btn-primary"><span class="oi oi-x"></span>Reset</a>
		                        </div>
		                    </div>
		                </div>
	                </div>
	
	            <?php } ?>
	        </div>   
        </div>
        
        <div class="media_sb">
        <div class="media_sb_in">
            <div class="row">
	            <button type="submit" name="save" value="save" class="btn bottone_salva btn-primary"><span class="oi oi-check"></span>Salva</button>
	            <?php if (isset($entity->path) && trim($entity->path) && trim($entity->is_image)) { ?>
		            <div class="form-group col-md-2">
		                <div class="col-auto">
		                    <a href="<?= lc_fileFullPath($entity->path) ?>?v=<?= rand(0, 100) ?>">
		                        <img src="<?= lc_fileFormat($entity->path, 'thumbs') ?>?v=<?= rand(0, 100) ?>" class="img-thumbnail" />
		                    </a>
		                </div>
		            </div>
		        <?php } else { ?>
		        <?php } ?>
                <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Nome', 'name' => 'nome', 'value' => $entity->nome, 'width' => 'col-md-8', 'placeholder' => 'Nome']]) ?>
                <?= view('Lc5\Cms\Views\form-cmp/readonly', ['item' => ['label' => 'Filename', 'value' => $entity->guid, 'width' => 'col-md-4', 'placeholder' => '']]) ?>
                <?= view('Lc5\Cms\Views\form-cmp/file', ['item' => ['label' => 'File da caricare', 'name' => 'file_up', 'value' => $entity->file_up, 'width' => 'col-md-12', 'placeholder' => 'Seleziona un file']]) ?>
                 <a href="<?= site_url(route_to($route_prefix . '_rebase_all', $entity->id)) ?>" class="btn btn-reset btn-danger"><span class="oi oi-x"></span>Reset formati</a>
            </div>
        </div>
    </div>


        
        
        
 </div>



        <!-- Creates the bootstrap modal where the image will appear -->
        <div class="modal fade" id="imagemodal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="" id="imagepreview" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default close_modal_img" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>


    <?php } ?>


</form>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<style>
    .modal {
        z-index: -1;
        /* display: flex !important; */
        display: none;
        justify-content: center;
        align-items: center;
    }

    .modal.show {
        display: flex !important;
        z-index: 100;
    }

    .modal-dialog {
        /* Width */
        max-width: 100%;
        width: auto !important;
        display: inline-block;
    }



    .modal-open .modal {
        z-index: 1050;
    }

    .modal img {
        max-width: 95vw;
        max-height: 82vh;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {

        $('.close_modal_img').on('click', function() {
            // $('#imagemodal').modal('hide');
            $('#imagemodal').removeClass('show');

        });
        $('.image_pop').on('click', function(e) {
            e.preventDefault();

            $('#imagepreview').attr('src', $('img', this).attr('src')); // here asign the image to the modal when the user click the enlarge link
            $('#imagemodal').addClass('show');
            // $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        });

    });
</script>

<?= $this->endSection() ?>