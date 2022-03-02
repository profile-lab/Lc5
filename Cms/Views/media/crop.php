<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<script>
    let count_rows = 0;
</script>
<form class="form" method="POST" enctype="multipart/form-data" action="">
    <div id="scheda_tools" class="w-100 header_crop sticky-top mt-2">
        <div class="col-auto">
            <h5 class="p-0 m-0">Modifica il formato <?= $formato['nome'] ?> (<?= $formato['w'] . ' x ' . $formato['h'] ?>)</h5>
        </div>
        <div class="myFlex">
            <a href="<?= site_url(route_to($route_prefix . '_edit', $entity->id)) ?>" class="btn btn-danger"><span class="oi oi-x"></span>Annulla</a>
            <button type="submit" id="ritaglia" name="save" value="save" class="btn bottone_salva btn-primary"><span class="oi oi-check"></span>Salva</button>
        </div>
    </div>
    <h1><?= $module_name ?></h1>
    <?= user_mess($ui_mess, $ui_mess_type) ?>
    <div class="row form-row">
        <?php if (isset($entity->path) && trim($entity->path) && trim($entity->is_image)) { ?>
            <div class="crop_container">
                <section class="row">
                    <div class="col-12">
                        <div class="zoom_cnt" style="padding: 0; margin:10px  0; ">
                            <button type="button" class="btn btn-primary btn-zoom" data-method="zoom" data-option="0.1" title="Zoom In">
                                <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.zoom(0.1)">
                                    <span class="oi oi-zoom-in" style="padding: 0; margin:0; "></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary btn-zoom" data-method="zoom" data-option="-0.1" title="Zoom Out">
                                <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.zoom(-0.1)">
                                    <span class="oi oi-zoom-out" style="padding: 0; margin:0; "></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </section>

                <section class="row">
                    <div class="col-12">
                        <div id="scheda_media_info">
                            <div id="cropper_artboard" class="cropper_artboard <?php echo ($entity->image_height > $entity->image_width) ? 'cropper_artboard_vertical' : '' ?>">
                                <div id="media_original" class="media_original img-container">
                                    <img id="source_image" class="" src="<?= route_to('lc_media_original', $entity->id) . '?v=' . rand(99, 999) ?>" meta-w="<?php echo $entity->image_width ?>" meta-h="<?php echo $entity->image_height ?>" alt="<?php echo $entity->image_width . 'x' . $entity->image_height ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="naturalWidth" id="naturalWidth" value="" />
                    <input type="hidden" name="naturalHeight" id="naturalHeight" value="" />
                    <input type="hidden" name="dataX" id="dataX" value="" />
                    <input type="hidden" name="dataY" id="dataY" value="" />
                    <input type="hidden" name="dataWidth" id="dataWidth" value="" />
                    <input type="hidden" name="dataHeight" id="dataHeight" value="" />
                    <input type="hidden" name="dataScaleX" id="dataScaleX" value="" />
                </section>
                
            </div>
            <div class="crop_preview_container">
                <div class="crop_preview_in">
                    <div id="media_crop_preview" class="media_crop_preview border shadow"></div>
                </div>
            </div>
        <?php } ?>
    </div>
</form>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>
<link rel="stylesheet" href="<?= '/assets/lc-admin-assets/js/cropper.min.css' ?>" />

<style>
    #media_original {
        width: 100%;
        height: auto;
        padding: 0;
        margin: 0;
    }

    #media_original img {
        width: 100%;
        height: auto;
        padding: 0;
        margin: 5px 0;
    }

    #media_crop_preview {
        width: 100%;
        height: auto;
        padding: 0;
        margin: 0 0 15px 0;
        overflow: hidden
    }

    /*
#media_crop_preview img{ width: 100%; height: auto; padding: 0; margin: 0;} 
*/
    #cropper_artboard {
        margin: 0 auto;
    }

    .cropper_artboard {
        max-width: 900px;
    }

    .cropper_artboard.cropper_artboard_vertical {
        max-width: 380px;
    }

    #form-sidebar.media-sidebar {
        margin: 0;
        width: 300px;
    }
</style>

<script src="<?= '/assets/lc-admin-assets/js/cropper.min.js' ?>"></script>
<script type="text/javascript">
    let zoomate = 0;
    let zoomByClick = false;
    window.addEventListener('DOMContentLoaded', function() {
        var isReadyToCrop = false;
        var image = document.getElementById('source_image');
        var previewItem = document.getElementById('media_crop_preview');
        var cropper = new Cropper(image, {
            aspectRatio: <?php echo $formato['w'] . '/' . $formato['h'] ?>,
            viewMode: 0,
            ready: function() {
                var clone = this.cloneNode();
                clone.className = '';
                clone.style.cssText = (
                    'display: block;' +
                    'width: 100%;' +
                    'min-width: 0;' +
                    'min-height: 0;' +
                    'max-width: none;' +
                    'max-height: none;'
                );
                previewItem.appendChild(clone.cloneNode());
                // cropper.zoomTo(1);
                isReadyToCrop = true;
            },

            crop: function(event) {
                if (isReadyToCrop) {
                    if ($('#media_crop_preview').css('display') == 'none') {
                        $('#media_crop_preview').show(0);
                        $('#ritaglia').show(0);
                    }
                    var data = event.detail;
                    var cropper = this.cropper;
                    var imageData = cropper.getImageData();
                    var previewAspectRatio = data.width / data.height;
                    var previewImage = previewItem.getElementsByTagName('img').item(0);
                    var previewWidth = previewItem.offsetWidth;
                    var previewHeight = previewWidth / previewAspectRatio;
                    var imageScaledRatio = data.width / previewWidth;
                    if (previewItem != null) {
                        previewItem.style.height = previewHeight + 'px';
                        previewImage.style.width = imageData.naturalWidth / imageScaledRatio + 'px';
                        previewImage.style.height = imageData.naturalHeight / imageScaledRatio + 'px';
                        previewImage.style.marginLeft = -data.x / imageScaledRatio + 'px';
                        previewImage.style.marginTop = -data.y / imageScaledRatio + 'px';
                        if ($('#media_crop_preview').height() > 400) {
                            $('#media_crop_preview').css({
                                transform: 'scale(.5)',
                                marginTop: ((previewHeight / 4) * -1),
                                marginBottom: ((previewHeight / 4) * -1) + 10
                            });
                        }
                    }
                    var datiImgSele = cropper.getData();
                    $('#naturalWidth').val((imageData.naturalWidth));
                    $('#naturalHeight').val((imageData.naturalHeight));
                    $('#dataX').val((datiImgSele.x));
                    $('#dataY').val((datiImgSele.y));
                    $('#dataWidth').val((datiImgSele.width));
                    $('#dataHeight').val((datiImgSele.height));
                } else {
                    $('#media_crop_preview').hide(0);
                    $('#ritaglia').hide(0);
                }
            },
            zoom: function(event) {
                if(!zoomByClick){
                    event.preventDefault();
                }
            },
        });
        // 
        $('.btn-zoom').click(function(e){
            console.log('zoomate', zoomate);
            e.preventDefault();
            const incr = $(this).attr('data-option');
            if(incr == '-0.1' && zoomate > -5){
                zoomate--;
                zoomByClick = true;
                result = cropper.zoom(incr);
            }else if(incr == '0.1' && zoomate < 5){
                zoomate++;
                zoomByClick = true;
                result = cropper.zoom(incr);
            }
            zoomByClick = false;
        });

    });
</script>
<script type="text/javascript">
    $(document).ready(function() {});
</script>

<?= $this->endSection() ?>