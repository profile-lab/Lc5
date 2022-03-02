<?php if (isset($col_data) && $col_data != null) { ?>
    <div class="row_column_item">
        <?= h4($col_data->title) ?>
        <?= single_img($col_data->img_path) ?>
        <?= txt($col_data->testo) ?>
    </div>
<?php } ?>