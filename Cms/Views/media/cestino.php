<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<div class="d-md-flex justify-content-between align-items-center">
    <h1><?= $module_name ?></h1>
    <div class="d-flex align-items-center">
        <a class="btn btn-danger" href="<?= route_to($route_prefix . '_delete_all_files') ?>">Elimina tutti i file</a>
    </div>
</div>

<?= user_mess($ui_mess, $ui_mess_type) ?>








<?php if (count($list) > 0) { ?>

    <div class="listIndexTableCnt">
        <table class="listIndexTable">
            <thead>
                <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Path</th>
                    <th>Tipo</th>
                    <th style="text-align: right;"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $item) { ?>
                    <tr>
                        <td style="width: 80px;">
                            <img src="<?= env('custom.media_root_path') . 'thumbs/' . $item->path ?>" alt="<?= $item->nome ?>" style="width: 70px; height: 70px;">
                        </td>
                        <td>(<?= $item->id ?>) <?= $item->nome ?></td>
                        <td><?= $item->path ?></td>
                        <td><?= $item->tipo_file ?></td>
                        <td style="text-align: right;">
                            <a class="btn btn-danger" href="<?= route_to($route_prefix . '_delete_file', $item->id) ?>">Elimina definitivamente</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>


<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<style>
    .listIndexTableCnt{
        padding: 1rem 1.5rem;
    }
    .listIndexTable {
        width: 100%;
        margin: 0;
    }

    .listIndexTable thead th {
        text-align: left;
        background-color: #5cb5ff;
        color: #FFF;
        padding: 0.8rem .8rem;
        border-bottom: 1px solid #FFF;

    }

    .listIndexTable tbody td {
        padding: 0.8rem .8rem; vertical-align: middle;
    }

    .listIndexTable tbody tr:nth-child(odd) td {
        background-color: #FFF;
        border: none;
        border-bottom: 1px solid #f2f3f7;
    }

    .listIndexTable tbody tr:nth-child(even) td {
        background-color: #d6e9f8;
        border-bottom: 1px solid #FFF;
    }

    .listIndexTable .btn {
        padding: 0.5rem 1rem;
        margin: 0;
    }
</style>
<?= $this->endSection() ?>