<?= $this->extend($base_view_folder . 'layout/body') ?>
<?= $this->section('content') ?>
<article>
    <section class="main_cnt">
        <div class="myIn login_cnt">
            <div class="form_login">
                <?= user_mess($ui_mess, $ui_mess_type) ?>

                <form method="POST" class="loginform">
                    <div class="form_row">
                        <div class="form_item form_item_full">
                            <label for="email">Indirizzo Email</label>
                            <input type="email" name="email" value="<?= $request->getPost('email') ?>" />
                        </div>
                    </div>
                    <div class="form_row">
                        <div class="form_item form_item_full">
                            <label for="password">Password</label>
                            <input type="password" name="password" value="<?= $request->getPost('password') ?>" />
                        </div>
                    </div>
                    <div class="form_row">
                        <div class="form_item">
                            <button type="submit" name="login" value="logi">Entra</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="register_cta_cnt">
                <h4>Non sei ancora registrato?</h4>
                <h3><a class="registrati_cta" href="<?= site_url(route_to('signup')) ?><?= ($request->getGet('returnTo')) ? '?returnTo=' . urlencode($request->getGet('returnTo')) : ''  ?>">registrati ora</a></h3>
            </div>
        </div>
    </section>
</article>


<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>

<script type="text/javascript">
    $(document).ready(function() {



    });
</script>
<?= $this->endSection() ?>