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
    <div class="listIndex">
        <ul>
            <li>
                <div class="list_item_row" style="display: grid; grid-template-columns: 5% 30% 30% 15% 15% 5%; font-weight:bold;  ">
                    <div class="list_item_id" style="fon">ID</div>
                    <div class="list_item_nome">Nome</div>
                    <div class="list_item_nome">Email</div>
                    <div class="list_item_nome">Stato</div>
                    <div class="list_item_nome">Ultimo Login</div>

                    <div class="list_item_tools"></div>
                </div>
            </li>
            <?php foreach ($list as $item) { ?>
                <li>
                    <div class="list_item_row" style="display: grid; grid-template-columns: 5% 30% 30% 15% 15% 5%; ">
                        <div class="list_item_id"><?= $item->id ?></div>
                        <div class="list_item_nome">
                            <a class="btn-link" href="<?= site_url(route_to($route_prefix . '_edit', $item->id)) ?>"><?= $item->name ?> <?= $item->surname ?></a>
                        </div>
                        <div class="list_item_nome"><?= $item->email ?></div>
                        <div class="list_item_nome"><?= ($item->status) ? 'ATTIVO' : 'NON ATTIVO' ?></div>
                        <div class="list_item_nome">
                            <?= humanData($item->last_login) ?>
                        </div>

                        <div class="list_item_tools"><a class="btn btn-danger btn-sm a_delete" href="<?= site_url(route_to($route_prefix . '_delete', $item->id)) ?>" data-bs-toggle="tooltip" title="Elimina Pagina"><span class="oi oi-trash"></span></a></div>
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