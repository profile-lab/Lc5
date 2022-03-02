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
            <?php foreach ($list as $item) { ?>
                <li>
                    <div class="list_item_row" style="display: grid; grid-template-columns: 5% 50% 15% 15% 15%; ">
                        <div class="list_item_id"><?= $item->id ?></div>
                        <div class="list_item_nome">
                            <a href="<?= site_url(route_to($route_prefix . '_edit', $item->id)) ?>"><?= $item->nome ?></a>
                        </div>
                        <div class="list_item_nome">$<?= $item->val ?></div>
                        <?php if (isset($entity_targets)) { ?>
                            <div class="list_item_nome">
                                <?= (isset($entity_targets[$item->target])) ? $entity_targets[$item->target]->nome : $item->target  ?>
                            </div>
                        <?php } ?>
                        <?php if (isset($entity_types)) { ?>
                            <div class="list_item_nome">
                                <?= (isset($entity_types[$item->type])) ? $entity_types[$item->type]->nome : $item->type  ?>
                            </div>
                        <?php } ?>
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