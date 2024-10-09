<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<div class="d-md-flex">
    <h1><?= $module_name ?></h1>
    <div class="d-flex align-items-center">
        <div>
            <a class="btn btn-primary" href="<?= site_url(route_to($route_prefix . '_new')) ?>"><span class="oi oi-plus mr-1"></span>Crea nuovo</a>
        </div>
    </div>
</div>
<?= user_mess($ui_mess, $ui_mess_type) ?>
<?php if (count($list) > 0) { ?>
    <div class="listIndexTableCnt">
        <table class="listIndexTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>W</th>
                    <th>H</th>
                    <th>path</th>
                    <th>Tipo</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $item) { ?>
                    <tr>
                        <td><?= $item->id ?></td>
                        <td>
                            <a href="<?= site_url(route_to($route_prefix . '_edit', $item->id)) ?>"><?= $item->nome ?></a>
                        </td>
                        <td><?= $formato->w ?></td>
                        <td><?= $formato->h ?></td>
                        <td><?= (trim($item->path))  ? '<i>'.trim($item->path).'</i>'  : '' ?></td>
                        <td><?= $formato->nome . '/' . $formato->rule ?></td>
                        <td><?= ($item->rigenerato) ? 'Rigenerato' : 'Non Rigenerato' ?></td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
       <?php if( isset($netxPageUrl) && $netxPageUrl && $netxPageUrl != '' ) { ?>
       <a class="btn btn-primary generaNextBlock"  href="<?= $netxPageUrl ?>">Next</a>

       <?php } ?>
    </div>
<?php } else { ?>
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
        padding: 0.8rem .8rem;
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
<script type="text/javascript">
    var btnNext = document.querySelector('.generaNextBlock');
    if (btnNext) {
        btnNext.click();
    }
    // document.getElementById("deepakkamat").click()​​​;​

    // $(document).ready(function() {
    //     $('.generaNextBlock').click();
    // });
</script>
<?= $this->endSection() ?>