<?= $this->extend('Lc5\Cms\Views\layout/body') ?>
<?= $this->section('content') ?>
<script>
    let count_rows = 0;
</script>
<form class="form" method="POST" enctype="multipart/form-data" action="">
    <div id="scheda_tools" class="w-100 sticky-top mt-2">
        <div class="container-fluid bg-info text-light p-3 mt-3 mb-4 rounded">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-auto">
                    <?php if ($entity->id) { ?>
                    <?php } else { ?>
                        <h5 class="p-0 m-0">Crea nuovo</h5>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="settings_header">
    	<h1><?= $module_name ?></h1>
    	<button type="submit" name="save" value="save" class="btn bottone_salva btn-primary"><span class="oi oi-check"></span>Salva</button>
    </div>
    <?= user_mess($ui_mess, $ui_mess_type) ?>
    <div class="row form-row">
        <?= view('Lc5\Cms\Views\form-cmp/text', ['item' => ['label' => 'Nome', 'name' => 'nome', 'value' => $entity->nome, 'width' => 'col-md-12', 'placeholder' => 'Nome']]) ?>
    </div>

    <div class="menu_scheda_cnt">
        <div class="arrange_menu">
            <div id="site_menu_nestable" class="dd nestable_menu"></div>
        </div>
        <div class="menu_list">
            <?php if (isset($all_page_list) && is_iterable($all_page_list)) { ?>
                <h5>Pagine</h5>
                <ul>
                    <?php foreach ($all_page_list as $key => $page) { ?>
                        <li>
                            <a class="add_to_menu page_<?= $page->id ?>" id="page_<?= $page->id ?>" href="#" meta-name="<?= $page->nome ?>" meta-label="<?= $page->label ?>" meta-param="<?= $page->guid ?>" meta-parent="<?= $page->parent ?>" meta-type="page" meta-ishome="<?= $page->is_home ?>" meta-content-id="<?= $page->id ?>"><?= $page->nome ?> <?= ($page->is_home) ? '<i class="oi oi-home"></i>' : '' ?> <span class="oi oi-plus"></span></a>
                            <?php if (isset($page->children) && is_iterable($page->children)) { ?>
                                <?= lc_print_children_sublist($page->children, 'page') ?>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>

            <hr />
            <h5>Link Personalizzato</h5>
            <button type="button" class="btn btn-primary add_custom_link">Add</button>

        </div>
    </div>

    <input type="hidden" name="json_data" class="form-control" id="nestable-output" value="<?= (isset($entity->json_data)) ? $entity->json_data : '[]' ?>" />



</form>

<?= $this->endSection() ?>
<?= $this->section('footer_script') ?>
<script src="<?= '/assets/lc-admin-assets/js/jquery.nestable.min.js' ?>"></script>
<link rel="stylesheet" href="<?= '/assets/lc-admin-assets/js/jquery.nestable.min.css' ?>" />
<script type="text/javascript">
    $(document).ready(function() {
        $('.add_custom_link').on('click', function(e) {
            e.preventDefault();


            $('#modal_custom_item').remove()
            var modal_html = $('#modal_custom_item_code').text();
            let modal_jq_obj = $(modal_html);
            $('body').append(modal_jq_obj);
            // $('#modal_custom_item').modal('show');
            // $('#modal_custom_item').on('shown.bs.modal', function(current_modal) {
                $('#add_custom_item').unbind('click');
                $('#add_custom_item').bind('click', function (e) {
                    e.preventDefault();
                    var current_modal = $('#modal_custom_item');
                    // 
                    let nome = $('#__nome', current_modal.target).val()
                    let url = $('#__url', current_modal.target).val()
                    var newItem = {
                        "id": "custom_" + (1000+ Math.floor(Math.random() * (500 - 99 + 1) + 99)),
                        "content": "" + nome,
                        "label": "" + nome,
                        "type": "custom",
                        "is_home": 0,
                        "parameter": "" + url
                    };
                    
                    $('#site_menu_nestable').nestable('add', newItem);
                    updateOutput($('#site_menu_nestable').data('output', $('#nestable-output')));

                    $('#add_custom_item').unbind('click');
                    // $(current_modal.target).modal('hide');
                    $(this).closest('.modal').remove();

                });
            // });





        });



        $('.add_to_menu').on('click', function(e) {
            e.preventDefault();
            let target = $(this);
            if (target.hasClass('is_in_menu')) {
                console.log('già presente')
            } else {
                addItemInNasted(target);
                updateOutput($('#site_menu_nestable').data('output', $('#nestable-output')));
            }
        });
        // 
        function addItemInNasted(target) {
            // let content_id = target.attr('meta-content-id');
            let content_id = target.attr('id');
            let content = target.attr('meta-label');
            let parameter = target.attr('meta-param');
            let is_home = target.attr('meta-ishome');
            let parent_id = target.attr('meta-parent');
            let content_type = target.attr('meta-type');
            var newItem = {
                "id": "" + content_id,
                "content": "" + content,
                "label": "" + content,
                "type": "" + content_type,
                "is_home": is_home,
                "parameter": "" + parameter
            };
            if (is_home == 1) {
                newItem.parameter = '/';
            }
            if (parent_id > 0) {
                newItem.parent_id = content_type + "_" + parent_id;
                let parent_container = $('#site_menu_nestable li[data-id="' + newItem.parent_id + '"]').html();
                if (parent_container == undefined) {
                    $('a#' + newItem.parent_id + '').click();
                }
            }
            $('#site_menu_nestable').nestable('add', newItem);
        };
        // 
        var json = <?= (isset($entity->json_data)) ? $entity->json_data : '[]' ?>;
        var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            updateSourceList(list.nestable('serialize'));
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
            $('.remove_from_menu').unbind('click');
            $('.remove_from_menu').bind('click',
                function(e) {
                    e.preventDefault();
                    let target = $(this);
                    let content_id = target.attr('meta-rel');
                    $('#' + content_id).removeClass('is_in_menu');
                    $('#site_menu_nestable').nestable('remove', content_id);
                    updateOutput($('#site_menu_nestable').data('output', $('#nestable-output')));
                });
            $('.edit_custom_link').unbind('click');
            $('.edit_custom_link').bind('click',
                function(e) {
                    e.preventDefault();
                    let target = $(this);
                    let content_id = target.attr('meta-rel');
                    let parameter = target.attr('meta-parameter');
                    let label = target.attr('meta-label');


                    $('#modal_custom_item').remove()
                    var modal_html = $('#modal_custom_item_code').text();
                    let modal_jq_obj = $(modal_html);
                    $('body').append(modal_jq_obj);
                    
                    // $('#modal_custom_item').modal('show');
                    // $('#modal_custom_item').on('shown.bs.modal', function(current_modal) {
                        var current_modal = $('#modal_custom_item');

                        $('#__nome', current_modal.target).val(label);
                        $('#__url', current_modal.target).val(parameter);
                        $('#add_custom_item').unbind('click');
                        $('#add_custom_item').bind('click', function (e) {
                            e.preventDefault();
                            // 
                            let nome = $('#__nome', current_modal.target).val()
                            let url = $('#__url', current_modal.target).val()
                            var newItem = {
                                "id":content_id,
                                "content": "" + nome,
                                "label": "" + nome,
                                "type": "custom",
                                "is_home": 0,
                                "parameter": "" + url
                            };
                            
                            $('#site_menu_nestable').nestable('replace', newItem);
                            updateOutput($('#site_menu_nestable').data('output', $('#nestable-output')));

                            $('#add_custom_item').unbind('click');
                            // $(current_modal.target).modal('hide');
                            $(this).closest('.modal').remove();

                        });
                    // });
                    updateOutput($('#site_menu_nestable').data('output', $('#nestable-output')));
                });
        };

        function updateSourceList(selectObj) {
            $('.add_to_menu').removeClass('is_in_menu');
            $.each(selectObj, function(indexInArray, valueOfElement) {
                $('#' + valueOfElement.id).addClass('is_in_menu');
                if (valueOfElement.children != undefined) {
                    updateSourceChildList(valueOfElement.children);
                }
            });
        }

        function updateSourceChildList(children) {
            $.each(children, function(indexInArray, valueOfElement) {
                $('#' + valueOfElement.id).addClass('is_in_menu');
                if (valueOfElement.children != undefined) {
                    updateSourceChildList(valueOfElement.children);
                }
            });
        }
        var nest = $('#site_menu_nestable').nestable({
            group: 1,
            json: json,
            contentCallback: function(item) {
                var content = '';
                content += item.label || '' ? item.label : item.id;
                if(item.type == 'custom') {
                    content += '<i style="margin:0 .7em 0 1em ; font-size:.7em" class="oi oi-external-link"></i> ( <i>' + item.parameter + '</i> )' ;
                    content += ' <a href="#" class="dd-nodrag edit_custom_link" meta-rel="' + item.id + '"  meta-parameter="' + item.parameter + '" meta-label="' + item.label + '"><i class="oi oi-pencil"></i></a>';

                } else{
                    if(item.is_home == 1) {
                        content += '<i style="margin:0 .7em 0 1em ; font-size:.7em" class="oi oi-home"></i> ( <i>' + item.parameter + '</i> )' ;
                    } else{
                        content += '<i style="margin:0 .7em 0 1em ; font-size:.7em" class="oi oi-link-intact"></i> ( <i>' + item.parameter + '</i> )' ;
                    }
                }
                content += ' <a href="#" class="dd-nodrag remove_from_menu" meta-rel="' + item.id + '"><i class="oi oi-x"></i></a>';
                return content;
            }
        }).on('change', updateOutput);
        updateOutput($('#site_menu_nestable').data('output', $('#nestable-output')));
    });
</script>




<!-- MODAL MOVIMENTI -->
<script type="text/html" id="modal_custom_item_code">
    <div class="modal fade" id="modal_custom_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Link personalizzato</h5>
                    <button type="button" class="btn-close close_modal" data-bs-dismiss="modal" aria-label="Close"><span class="oi oi-x"></span></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Label</label>
                                <input type="text" name="__nome" value="" class="form-control" id="__nome" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Url</label>
                                <input type="text" name="__url" value="" class="form-control" id="__url" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">


                    <button type="button" id="add_custom_item" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
</script>

<!-- fine MODAL MOVIMENTI -->



<?= $this->endSection() ?>