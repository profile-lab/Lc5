<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
    <h1>Benvenuto in LevelComplete 5</h1>
    <?= user_mess($ui_mess, $ui_mess_type) ?>
    <?php if( isset($_GET['action_result']) && $_GET['action_result'] == 'DatabaseUpdateOK' ) { ?>
        <?= user_mess('La struttura del Database è stata aggiornata con successo', 'success') ?>
    <?php } ?>
    <p class="copy_dashboard">Level Complete - Copyright &copy; 2009 - <script>document.write(new Date().getFullYear())</script> PRO.file</p>
    <footer class="" style="position:absolute; bottom: 10px; left:10px; right:10px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10">
                    <a href="<?= route_to('lc_update_db') ?>" class="btn btn-danger">Check database</a>
                </div>
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