<?= $this->extend($base_view_folder . 'layout/body') ?>
<?= $this->section('content') ?>
<article>
    <section class="main_cnt">
        <div class="myIn sign_up_cnt">

            <h1 class="h1 text-center">Registrati</h1>
            <div class="form_sign_up_cnt">
                <?= getServerMessage() ?>
                <form method="post" class="form form_sign_up">
                    <div class="form_row form_row_sign_up">
                        <div class="form_field">
                            <label for="name">Nome</label>
                            <input class="form_input form_input_sign_up" type="text" name="name" id="name" value="<?= getReq('name') ?>" />
                        </div>
                        <div class="form_field">
                            <label for="surname">Cognome</label>
                            <input class="form_input form_input_sign_up" type="text" name="surname" id="surname" value="<?= getReq('surname') ?>" />
                        </div>
                    </div>
                    <div class="form_row form_row_sign_up">
                        <div class="form_field">
                            <label for="email">Email </label>
                            <input class="form_input form_input_sign_up" autocomplete="new-email" type="email" name="email" id="email" value="<?= getReq('email') ?>" />
                        </div>
                    </div>
                    <div class="form_row form_row_sign_up">
                        <div class="form_field">
                            <label for="new_password">Password</label>
                            <input class="form_input form_input_sign_up" autocomplete="new-password" type="password" name="new_password" id="new_password" value="<?= getReq('new_password') ?>" />
                        </div>
                        <div class="form_field">
                            <label for="confirm_new_password">Conferma Password</label>
                            <input class="form_input form_input_sign_up" autocomplete="confirm_new_password-2" type="password" name="confirm_new_password" id="confirm_new_password" value="<?= getReq('confirm_new_password') ?>" />
                        </div>
                    </div>
                    <div class="form_row form_row_sign_up">
                        <div class="form_field">
                            <label for="name">Indirizzo</label>
                            <input class="form_input" type="text" name="address" id="address" value="<?= getReq('address') ?>" />
                        </div>
                    </div>
                    <?php /*
                    // 

                    <div class="form_row form_row_sign_up">
                        <div class="form_field">
                            <label for="name">Codice Fiscale</label>
                            <input class="form_input" type="text" name="cf" id="cf" value="<?= getReq('cf') ?>" />
                        </div>
                        <div class="form_field">
                            <label for="surname">P. Iva</label>
                            <input class="form_input" type="text" name="piva" id="piva" value="<?= getReq('piva') ?>" />
                        </div>
                    </div>
                    // 
                   */ ?>
                    <div class="form_row form_row_sign_up form_row_checkbox">
                        <div class="form_field_checkbox">
                            <label class="label_checkbox" for="t_e_c"><input type="checkbox" name="t_e_c" id="t_e_c" value="1" <?= (getReq('t_e_c')) ? 'checked' : '' ?> /> <span>Ho letto, compreso e accettato i termini e condizioni e <a href="<?= site_url('privacy-policy') ?>">l'informativa privacy</a> relativa al trattamento dei miei dati personali (obbligatorio)</span></label>
                        </div>
                    </div>

                    <div class="form_row form_row_sign_up form_row_checkbox">
                        <div class="form_field_checkbox">
                            <label class="label_checkbox" for="autorizzo_1"><input type="checkbox" name="autorizzo_1" id="autorizzo_1" value="1" <?= (getReq('autorizzo_1')) ? 'checked' : '' ?> /> <span>Accetto di ricevere informazioni su altri prodotti e offerte esclusive basate su miei interessi</span></label>
                        </div>
                    </div>
                    <div class="form_row form_row_sign_up form_row_sign_up_btn">
                        <div class="form_field form_field_sign_up_btn">
                            <button type="submit" name="action" value="sign_up" class="btn-app-sign_up">
                                Registrati
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="register_cta_cnt">
                    <?= h4('Sei già registrato?', 'h4') ?>
                    <?= cta(route_to('web_login'), 'Accedi!') ?>
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