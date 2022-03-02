<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?= $this->include('Lc5\Cms\Views\layout/components/header-tag') ?>
</head>

<body class="bg-dark my_main_container">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
	                <img class="logo_login" src="/assets/lc-admin-assets/img/lc5_logo_vertical.svg" />
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header bg-dark text-white">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body pt-4">
                                    <?= user_mess($ui_mess, $ui_mess_type) ?>
                                    <form class="form " method="POST" action="">
                                        <div class="form-group">
                                            <label class="mb-1" for="email">Indirizzo email</label>
                                            <input type="text" class="form-control" name="email" value="<?= $formdata->email ?>" placeholder="Indirizzo email" />
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1" for="password">Password</label>
                                            <input type="password" class="form-control" name="password" value="<?= $formdata->password ?>" placeholder="Password" />
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-3">
                                            <button type="submit" class="btn btn-primary" name="login">Entra</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <?= $this->include('Lc5\Cms\Views\layout/components/footer') ?>
        </div>
    </div>
</body>
<?= $this->include('Lc5\Cms\Views\layout/components/footer-tag') ?>
<?= $this->renderSection('footer_script') ?>
</body>

</html>