<div class="row row-<?= $row->type ?> row-<?= $row->type ?>-<?= $row->css_class ?> row-<?= $row->guid ?> <?= $row->css_class ?> <?= $row->css_color ?>">
    <div class="myIn">
        <?= h2($row->titolo) ?>
        <?= h3($row->sottotitolo) ?>
        <?php if (isset($row->data_object) && count($row->data_object) > 0) { ?>
            <div class="row_column_cnt row_column_cnt-<?= count($row->data_object) ?>">
                <?php foreach ($row->data_object as $col_data) { ?>
                    <?php if (isset($col_data) && $col_data != null) { ?>
                        <div class="row_column_item">
                            <?= h4($col_data->title) ?>
                            <?= single_img($col_data->img_path) ?>
                            <?= txt($col_data->testo) ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>