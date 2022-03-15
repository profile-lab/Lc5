<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<article class="dashboard-main-content">

    <h1><?= $curr_lc_app_data->nome ?></h1>
    <?= user_mess($ui_mess, $ui_mess_type) ?>
    <?php if (isset($_GET['action_result']) && $_GET['action_result'] == 'DatabaseUpdateOK') { ?>
        <?= user_mess('La struttura del Database è stata aggiornata con successo', 'success') ?>
    <?php } ?>
    <?php if (isset($pages_row)) { ?>
        <section class="dashboard-section">
            <div class="dashboard-section-header">
                <h3><?= $pages_row->titolo ?></h3>
                <?php /*
                <div class="dashboard-section-header-count"><?= $posts_row->count_items ?></div>
                */ ?>
            </div>
            <div class="dashboard-row">
    
                <?php foreach ($pages_row->blocks as $blocco) { ?>
                    <div class="dashboard-block">
                        <h3><?= $blocco->nome ?></h3>
                        <?php if (isset($blocco->list) && is_array($blocco->list)) { ?>
                            <ul>
                                <?php foreach ($blocco->list as $blocco_item) { ?>
                                    <li><a class="dashboard-block-item-link" href="<?=  $blocco_item->edit_url ?>">
                                            <h5>
                                                <?= $blocco_item->nome ?>
                                            </h5>
                                            <div class="updated_at"><?= humanData($blocco_item->updated_at) ?></div>
                                        </a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </section>
    <?php } ?>
    
    <?php if (isset($posts_row)) { ?>
        <section class="dashboard-section">
            <div class="dashboard-section-header">
                <h3><?= $posts_row->titolo ?></h3>
                
            </div>
            <div class="dashboard-row">
    
                <?php foreach ($posts_row->blocks as $blocco) { ?>
                    <div class="dashboard-block">
                        <h3><?= $blocco->nome ?></h3>
                        <?php if (isset($blocco->list) && is_array($blocco->list)) { ?>
                            <ul>
                                <?php foreach ($blocco->list as $blocco_item) { ?>
                                    <li><a class="dashboard-block-item-link" href="<?= $blocco_item->edit_url ?>">
                                            <h5>
                                                <?= $blocco_item->nome ?>
                                            </h5>
                                            <div class="updated_at"><?= humanData($blocco_item->updated_at) ?></div>
                                        </a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
    
                <?php } ?>
            </div>
        </section>
    <?php } ?>
</article>



<footer class="" style="position:absolute; bottom: 10px; left:10px; right:10px">
    <div class="footer_flex">
        <div class="col">
            <p class="copy_dashboard">Level Complete - Copyright &copy; 2009 - <script>
                    document.write(new Date().getFullYear())
                </script> PRO.file</p>
        </div>
        <div class="col">
            <a href="<?= route_to('lc_update_db') ?>" class="btn btn-danger btn-check-db">Check database</a>
        </div>
    </div>

</footer>
<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
<?= $this->endSection() ?>