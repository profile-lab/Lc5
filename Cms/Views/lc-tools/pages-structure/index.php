<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<div class="d-md-flex">
    <h1><?= $module_name ?></h1>
    <div class="d-flex align-items-center">
        <div>
            <a class="btn btn-primary" href="<?= site_url(route_to('lc_tools_page_structure_export')) ?>">Crea Backup adesso</a>
        </div>
    </div>
</div>
<?= user_mess($ui_mess, $ui_mess_type) ?>
<?php if (count($list) > 0) { ?>
    <div class="listIndex">
        <ul>
            <?php foreach ($list as $item) { ?>
                <li>
                    <div class="list_item_row">
                        <div class="list_item_nome">
                            <span><?= $item->value ?></span>
                        </div>
                        <div class="list_item_tools">
                            <?php if (isset($item->megabytes) && $item->megabytes) { ?>
                                <div class="list_item_megabytes"><b><?= $item->megabytes ?></b> Mb</div>
                            <?php } ?>
                            <?php if (isset($item->download) && $item->download) { ?>
                                <a class="btn btn-sm btn-primary" href="<?= site_url($item->download) ?>">Scarica</a>
                            <?php } ?>
                            <?php if (isset($item->importa) && $item->importa) { ?>
                                <a class="btn btn-sm btn-primary a_sicuro" href="<?= site_url($item->importa) ?>">Importa</a>
                            <?php } ?>
                            <?php if (isset($item->make_zip) && $item->make_zip) { ?>
                                <a class="btn btn-sm btn-primary" href="<?= site_url($item->make_zip) ?>">Crea Zip</a>
                            <?php } ?>
                            <?php if (isset($item->delete) && $item->delete) { ?>
                                <a class="btn btn-sm btn-danger a_delete" href="<?= site_url($item->delete) ?>">Elimina</a>
                            <?php } ?>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } else { ?>
<?php } ?>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
<?= $this->endSection() ?>