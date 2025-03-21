<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<div class="d-md-flex">
    <h1><?= $module_name ?></h1>
    <div class="d-flex align-items-center">
        <div>
            <a class="btn btn-primary" href="<?= site_url(route_to($route_prefix . '_new', $post_type_guid)) ?>"><span class="oi oi-plus mr-1"></span>Nuovo</a>
        </div>
        <div>
            <input type="search" class="form-control search-filter" id="search-filter" placeholder="Cerca..." />
        </div>
    </div>
</div>
<?= user_mess($ui_mess, $ui_mess_type) ?>
<?php if (isset($list) && is_array($list) && count($list) > 0) { ?>
    <div class="listIndex text-light">
        <ul>
            <?php foreach ($list as $item) { ?>
                <li>
                    <div class="list_item_row">
                        <div class="list_item_id"><?= $item->id ?></div>
                        <div class="list_item_nome">
                            <a class="btn-link text-white" href="<?= site_url(route_to($route_prefix . '_edit', $post_type_guid, $item->id)) ?>"><?= $item->nome ?>
                            </a>
                            <?php if( isset( $item->category_object ) && $item->category_object  ) { ?>
                                <br />
                                <div class="my_text-light my_text-min">
                                    <?= $item->category_object->nome ?>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="list_item_tools">
                            <div class="btn-group mr-2 dropstart">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <?php if ($item->frontend_guid) { ?>
                                        <div class="dropdown-header">Preview</div>
                                        <a class="dropdown-item" target="_blank" href="<?= $item->frontend_guid ?>">Vai al Post</a>
                                        <div class="dropdown-divider"></div>
                                    <?php } ?>
                                    <div class="dropdown-header">Azioni</div>
                                    <a class="dropdown-item" href="<?= site_url(route_to($route_prefix . '_duplicate', $post_type_guid, $item->id)) ?>">Duplica</a>
                                    <?php foreach ($lc_languages as $lang) { ?>
                                        <?php if ($lang->val != $curr_lc_lang) { ?>
                                            <a class="dropdown-item" href="<?= site_url(route_to($route_prefix . '_duplicate_lang', $post_type_guid, $item->id, $lang->val)) ?>">Copia in <?= $lang->nome ?></a>
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger a_delete" href="<?= site_url(route_to($route_prefix . '_delete', $post_type_guid, $item->id)) ?>"><span class="oi oi-trash"></span> Elimina</a>
                                </div>
                            </div>
                            <?php /*
                            <a class="btn btn-primary btn-sm" href="<?= site_url(route_to($route_prefix . '_edit', $post_type_guid, $item->id)) ?>" data-bs-toggle="tooltip" title="Modifica"><span class="oi oi-pencil"></span></a>
                            */ ?>
                        </div>
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
        // $('.dropdown-toggle').dropdown();
        $('#search-filter').keyup(function() {

            var textboxVal = $(this).val().toLowerCase();
            // if(textboxVal == ''){
            //     $('.search-evidence').removeClass('search-evidence');
            // }
            $('.list_item_nome a').each(function() {
                if (textboxVal == '') {
                    $('.search-evidence').removeClass('search-evidence');
                    $(this).parents('li').show();
                } else {
                    $(this).closest('li').removeClass('search-evidence');
                    var listVal = $(this).text().toLowerCase();

                    if (listVal.indexOf(textboxVal) >= 0) {
                        $(this).closest('li').addClass('search-evidence');
                        $(this).parents('li').show();
                    } else {
                        $(this).closest('li').hide();
                    }
                }
            });
        });
    });
</script>
<style>
    .search-evidence {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }
</style>
<?= $this->endSection() ?>