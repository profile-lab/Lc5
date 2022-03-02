<div class="media media_item <?= (isset($item->tipo_file)) ? 'media_type-' . $item->tipo_file : '' ?> position-relative">
    <a class="media_item_img_btn" href="<?= (isset($item->href) ? $item->href : '') ?>" meta-id="<?= (isset($item->id) ? $item->id : '') ?>" meta-path="<?= (isset($item->path) ? $item->path : '') ?>"><img class="preview-img img-thumbnail" src="<?= (isset($item->img_thumb) ? $item->img_thumb : '') ?>" alt="<?= (isset($item->nome) ? $item->nome : 'placeholder') ?>" /></a>
    <div class="nome_file_cut_cnt">
        <div class="nome_file_min"><?= (isset($item->nome) ? $item->nome : 'Nome file...') ?></div>
     </div>
    <?php if (isset($item->del_link)) { ?>
        <div class="media_item_trash">
            <a href="<?= $item->del_link ?>" class="btn a_delete"><span class="oi oi-trash"></span></a>
        </div>
    <?php } ?>
</div>