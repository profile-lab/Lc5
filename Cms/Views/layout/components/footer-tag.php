<?php if (isset($custom_fields_keys_simple_par)) { ?>
    <script type="text/html" id="custom_field_item_code-simple_par" style="display: none;">
        <?= view('Lc5\Cms\Views\part-cmp/custom-field-item', ['item' => ['keys_source' => $custom_fields_keys_simple_par]]) ?>
    </script>
<?php } ?>
<?php if (isset($custom_fields_keys_gallery_par)) { ?>
    <script type="text/html" id="custom_field_item_code-gallery_par" style="display: none;">
        <?= view('Lc5\Cms\Views\part-cmp/custom-field-item', ['item' => ['keys_source' => $custom_fields_keys_gallery_par]]) ?>
    </script>
<?php } ?>
<?php if (isset($custom_fields_keys_columns_par)) { ?>
    <script type="text/html" id="custom_field_item_code-columns_par" style="display: none;">
        <?= view('Lc5\Cms\Views\part-cmp/custom-field-item', ['item' => ['keys_source' => $custom_fields_keys_columns_par]]) ?>
    </script>
<?php } ?>
<?php if (isset($custom_fields_keys_component_par)) { ?>
    <script type="text/html" id="custom_field_item_code-component_par" style="display: none;">
        <?= view('Lc5\Cms\Views\part-cmp/custom-field-item', ['item' => ['keys_source' => $custom_fields_keys_component_par]]) ?>
    </script>
<?php } ?>

<script type="text/html" id="blocco_simple_par_code" style="display: none;">
    <?= view('Lc5\Cms\Views\rows-cmp/simple-par', ['row' => (object) []]) ?>
</script>
<script type="text/html" id="blocco_columns_par_code" style="display: none;">
    <?= view('Lc5\Cms\Views\rows-cmp/columns-par', ['row' => (object) []]) ?>
</script>
<script type="text/html" id="blocco_gallery_par_code" style="display: none;">
    <?= view('Lc5\Cms\Views\rows-cmp/gallery-par', ['row' => (object) []]) ?>
</script>
<script type="text/html" id="blocco_component_par_code" style="display: none;">
    <?= view('Lc5\Cms\Views\rows-cmp/component-par', ['row' => (object) []]) ?>
</script>
<script type="text/html" id="gallery_item_code" style="display: none;">
    <?= view('Lc5\Cms\Views\part-cmp/gallery-item', ['row' => (object) []]) ?>
</script>
<script type="text/html" id="colonne_item_code" style="display: none;">
    <?= view('Lc5\Cms\Views\part-cmp/column-item', ['row' => (object) []]) ?>
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jodit/3.24.7/jodit.min.js" integrity="sha512-W8OsAH1/u8SZ4Zx8favP2fRUx2X4rYdfrSLVwsOchE0ngWJoP99J0iRJSuNKiFkAIamWtpE2DGIaKL7xfreJYw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="<?= '/assets/lc-admin-assets/js/jquery.dm-uploader.min.js' ?>"></script>
<script src="<?= '/assets/lc-admin-assets/js/selectize.min.js' ?>"></script>
<script src="<?= '/assets/lc-admin-assets/js/script.js' ?>"></script>
<script src="<?= '/assets/lc-admin-assets/js/pf-script.js' ?>"?v=11-32></script>
<script>
    $(document).ready(function() {});
</script>
