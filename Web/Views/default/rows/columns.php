<div class="row row-columns row-<?= $row->guid ?> <?= $row->css_class ?> <?= $row->css_color ?> <?= $row->css_extra_class ?>">
    <div class="myIn">
        <?= h2($row->titolo) ?>
        <?= h3($row->sottotitolo) ?>
        <?php if (isset($row->data_object) && count($row->data_object) > 0) { ?>
            <div class="row_column_cnt row_column_cnt-<?= count($row->data_object) ?>">
                <?php foreach ($row->data_object as $col_item) { ?>
                    <?= view($base_view_folder . 'components/column', ['col_data' => $col_item]) ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>