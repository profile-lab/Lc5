<@= $this->extend('Lc5\Cms\Views\layout/body') ?>
<@= $this->section('content') ?>
<form class="form" method="POST" enctype="multipart/form-data" action="">
    <@= user_mess($ui_mess, $ui_mess_type) ?>
    <div class="settings_header">
        <h1><@= $module_name ?></h1>
    </div>
    <div class="row form-row">
        <div class="col-12 col-lg-9 scheda_body">
            <div class="first-row">
                QUI CONTENUTO
            </div>
        </div>
        <div class="scheda-sb margin-top-0">
            <div class="row">
                <div class="col-12">
                    <div class="bg-light rounded">
                    <button type="submit" name="save" value="save" class="btn bottone_salva btn-primary"><span class="oi oi-check"></span>Salva</button>

                    
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

<@= $this->endSection() ?>