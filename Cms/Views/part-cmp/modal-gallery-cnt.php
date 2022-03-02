<?php /*
<div class="modal fade" id="mediagallery_modal" tabindex="-1" aria-labelledby="modal_cerca_prodotti_label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-block">
                    <h6 class="modal-title">Gallery</h6>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="container-fluid">
                    <div id="mediagallery_modal_items" class="row list_media_items target_dropUpload_CNT___">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>

*/ ?>
<div class="modal fade" id="mediagallery_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gallery</h5>
                <button type="button" class="btn-close close_modal" data-bs-dismiss="modal" aria-label="Close"><span class="oi oi-x"></span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">

                    <div id="drag-and-drop-zone" class="dm-uploader">
                        <h3>Trascina qui i tuoi Files</h3>
                        <div class="btn">
                            <span>Oppure selezionali cliccando qui</span>
                            <input type="file" title="Seleziona" multiple="">
                        </div>
                    </div>


                    <div id="mediagallery_modal_items" class="row list_media_items target_dropUpload_CNT">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" value="" id="json_obj_str" />
                <input type="hidden" value="" id="selected_item_id" />
                <input type="hidden" value="" id="selected_item_path" />
                <div class="w-100 rounded border-dark bg-light d-flex flex-wrap p-2" id="gallery_preview" style="min-height: 5em;">
                </div>

                <button type="button" id="saveByModalGallery" class="btn bottone_salva btn-primary"><span class="oi oi-check"></span>Save</button>
            </div>
        </div>
    </div>
</div>