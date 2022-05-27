<?php
$fake_item = [
    'id' => null,
    'img_id' => null,
    'img_path' => null,
    'titolo' => null,
    'cta' => null,
];
extract($fake_item);
extract($item);
?>
<?php /*
<div class="vimeo_video-item">
    <div class="vimeo_video-item_body">
        <div class="row form-row">
            <?= view('Lc5\Cms\Views\form-cmp/img-single', ['item' => ['label' => 'Immagine', 'name' => 'gallery_item_img_id', 'input_class' => 'img_id_slide', 'value' => (isset($img_id)) ? $img_id : '', 'width' => 'col-12', 'src' => (isset($img_thumb)) ? $img_thumb : '']]) ?>
        </div>
        <div class="row form-row">
            <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Titolo', 'name' => 'gallery_item_titolo', 'input_class' => 'title_slide', 'value' => (isset($titolo)) ? $titolo : '', 'width' => 'col-md-12', 'placeholder' => 'Titolo']]) ?>
            <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Call to action', 'name' => 'gallery_item_cta', 'input_class' => 'cta_slide', 'value' => (isset($cta)) ? $cta : '', 'width' => 'col-md-12', 'placeholder' => 'Call to action']]) ?>
            <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Free parameter', 'name' => 'gallery_item_freeparam', 'input_class' => 'freeparam_slide', 'value' => (isset($freeparam)) ? $freeparam : '', 'width' => 'col-md-12', 'placeholder' => 'Free parameter']]) ?>
        </div>
        <a href="#" class="text-danger del_trg_cnt w_tooltip" meta-rel-trg-cnt="vimeo_video-item" data-bs-toggle="tooltip" title="Elimina slide">
            <span class="oi oi-trash"></span>
        </a>
    </div>
</div>
*/ ?>

<div class="componet-row">
    <?php if (!isset($video_entity)) { ?>
        <div id="loading_video_upload_cnt">
            <div id="loading_video_upload"></div>
            <div id="loading_video_upload_text_cnt">
                <div id="loading_video_upload_perce_text">0/100</div>
            </div>
        </div>
        <div id="upload_on_vimeo_all_form_cnt">
            <div id="upload_on_vimeo_label">Upload Video</div>
            <div id="upload_on_vimeo_input_file_cnt">
                <input class="custom-file-input" type="file" name="vimeo_video_file_up" id="vimeo_video_file_up" />
                <div id="invalid_vimeo_video_file_up"></div>
            </div>
            <div id="upload_on_vimeo_btn_cnt">
                <input type="hidden" class="form-control" name="file_size" id="file_size" value="" />
                <button class="btn btn-sm btn-success" type="button" id="upload_on_vimeo_btn" name="upload_on_vimeo" value="upload_on_vimeo">Carica video</button>
            </div>
        </div>
        <div id="set_vimeo_by_vimeo_video_url_cnt">
            <div id="get_vimeo_video_label">Collega Video</div>
            <div id="get_vimeo_video_input_cnt">
                <input type="text" class="form-control" name="vimeo_video_url" id="vimeo_video_url" value="" placeholder="Es. https://vimeo.com/0xxxxx00 / https://vimeo.com/videos/0xxxxx00 / https://vimeo.com/manage/videos/0xxxxx00" />
            </div>
            <div id="get_vimeo_video_btn_cnt">
                <button class="btn btn-sm btn-success" type="button" id="set_vimeo_by_vimeo_video_url_btn" meta-rel="vimeo_video_url" name="set_vimeo_by_vimeo_video_url" value="set_vimeo_by_vimeo_video_url">Collega video</button>
            </div>
        </div>

        

    <?php } else { ?>
        <div id="vimeo_video_row">
            <div id="vimeo_video_thumb_cnt">
                <?php /*
                <?php if (isset($video_entity) && isset($video_entity->thumb_path) && $video_entity->thumb_path != '') { ?>
                    <img id="vimeo_video_thumb" class="img-fluid" src="<?= $video_entity->thumb_path ?>" />
                <?php } ?>
                */ ?>
                <?php if (isset($video_entity) && isset($video_entity->video_path) && $video_entity->video_path != '') { ?>
                    <video controls><source src="<?= $video_entity->video_path ?>" type="video/mp4"></video>
                <?php } ?>
            </div>
            <div class="vimeo_video_status_pre_cnt">
	            <div id="vimeo_video_status_cnt">
	                <div class="<?= ($video_entity) ? $video_entity->vimeo_video_status : '' ?>" id="vimeo_video_status"><?= ($video_entity) ? $video_entity->vimeo_video_status : '' ?></div>
	            </div>
	            <div id="vimeo_video_tools_cnt">
	                <input type="hidden" id="status_video_on_vimeo" value="<?= $video_entity->vimeo_video_status ?>" />
	                <a href="#" class="btn btn-sm btn-warning" id="call_api_refresh_video_info" meta-video-code="<?= $video_entity->id ?>">Refresh</a>
	                <a href="#" class="btn btn-sm btn-danger" id="call_api_delete_video" meta-video-code="<?= $video_entity->id ?>">Elimina</a>
	            </div>
            </div>
        </div>
    <?php } ?>
</div>