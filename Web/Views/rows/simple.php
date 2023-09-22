<div class="row row-<?= $row->type ?> row-<?= $row->type ?>-<?= $row->css_class ?> row-<?= $row->guid ?> <?= $row->css_class ?> <?= $row->css_color ?>">
    <div class="myIn">
        <?= h2($row->titolo) ?>
        <?= txt($row->testo) ?>
        <?= parseMediaObj($row->main_img_obj) ?>
        <?= cta($row->cta_url, $row->cta_label) ?>
        <?php if (isset($row->gallery_obj) && count($row->gallery_obj) > 0) { ?>
            <?= view($base_view_folder . 'components/slider', ['gallery_obj' => $row->gallery_obj]) ?>
        <?php } ?>
    </div>
</div>