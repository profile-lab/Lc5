var editors_in_form = [];
let conta_editor = 0;
let conta_new_row = 0;
let conta_new_col = 0;
let conta_new_gallitem = 0;
let conta_new_custom_field_item = 0;
let row_to_del_arr = [];
// 
var clickModalImgFun = false;
var thumbs_folder = '/uploads/thumbs/';
var thumb_default = '/assets/lc/img/thumb-default.png';
let tmp_gallery_array = {};
// 
var custom_textarea_xs_toolbar = ['bold', 'italic', 'ul', 'link'];
var custom_textarea_toolbar_remove = [
    'strikethrough', 'underline', 'ol', 'font', 'fontsize', 'brush', 'outdent', 'indent', 'hr', 'image',
    'symbol', 'video', 'table', 'undo', 'redo', 'print', 'about', 'copyformat', 'cut', 'copy', 'paste',
    'selectall', 'listitem', 'find', 'preview', 'dots', 'superscript', 'subscript', 'classSpan', 'file'
];
var min_textarea_toolbar = custom_textarea_toolbar_remove.concat(['ul', 'paragraph', 'image', 'link', 'eraser', 'align', 'align']);
// 
$(document).ready(function () {
    attivaEditors();


    // $('.form-field-simple_css_class select, .form-field-gallery_css_class select, .form-field-columns_css_class select, .form-field-component_css_class select').change(function(){
    $('body').on('change', '.select_css_class', function () {
        $(this).closest('.card-body').attr('meta-type', $(this).val());
    });

    // $('.more_fields').slideUp(1)
    // $('body').on('click', '.shoh_more', function(e){
    //     e.preventDefault();
    //     let trg_rel = $(this).attr('target-rel');
    //     let trg_class = $(this).attr('target-class');
    //     if(trg_rel){
    //         $(this).closest(trg_rel).find(trg_class).slideToggle(300);

    //     }else{
    //         $(trg_class).slideToggle(300);
    //     }
    // });



});
function attivaEditors() {
    // conta_editor = 0;
    $('.text_editor').each(function (e) {
        if (!$(this).hasClass('text_editor_init')) {

            conta_editor++;
            $(this).addClass('text_editor_' + conta_editor);
            $(this).addClass('text_editor_init');
            editors_in_form[conta_editor] = new Jodit('.text_editor_' + conta_editor, {
                askBeforePasteHTML: false,
                askBeforePasteFromWord: false,
                defaultActionOnPaste: "insert_clear_html",
                removeButtons: custom_textarea_toolbar_remove,
                buttonsXS: custom_textarea_xs_toolbar,
                minHeight: 270,
                maxHeight: 600,

                sizeLG: 260,
                sizeMD: 210,
                sizeSM: 200,
                sizeSM: 199,

            });
        }
    });
    $('.text_editor_min').each(function (e) {
        if (!$(this).hasClass('text_editor_init')) {

            conta_editor++;
            $(this).addClass('text_editor_min_' + conta_editor);
            $(this).addClass('text_editor_init');
            editors_in_form[conta_editor] = new Jodit('.text_editor_min_' + conta_editor, {
                askBeforePasteHTML: false,
                askBeforePasteFromWord: false,
                defaultActionOnPaste: "insert_clear_html",
                buttonsXS: custom_textarea_xs_toolbar,
                removeButtons: min_textarea_toolbar,
                minHeight: 210,
                maxHeight: 500,

                sizeLG: 260,
                sizeMD: 210,
                sizeSM: 200,
                sizeSM: 199,

            });
        }
    });
}
// 
$('body').on('click', '.open_new_win', function (e) {
    e.preventDefault();
    var newWinUrl = $(this).attr('href');
    window.open(newWinUrl, "_blank", "width=1400,height=750");
});
// 
(function ($) {
    "use strict";
    var path = window.location.href;
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function () {
        if (this.href === path) {
            // $(this).addClass("active");
        }
    });

    $("#sidebarToggle").on("click", function (e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });

    //------------------------------------------------------------------
    $('.select_go').change(function () {
        window.location.href = $(this).val();
    });

    //------------------------------------------------------------------
    $('body').on('click', '.a_delete', function (e) {
        var isSicuro = confirm('Sei sicuro di voler procedere con l\'operazione?');
        if (isSicuro) {
        } else {
            return false;
        }
    });
    //------------------------------------------------------------------
    $('body').on('click', '.a_sicuro', function (e) {
        var isSicuro = confirm('Sei sicuro di voler procedere con l\'operazione?\n\nClicca su Annulla per tornare alla scheda, OK per procedere');
        if (isSicuro) {
        } else {
            return false;
        }
    });
    //------------------------------------------------------------------
    $('body').on('click', '.a_confirm', function (e) {
        var isSicuro = confirm('Ti sei ricordato di salvare?\nStai abandonando questa pagina e i dati non salvati andranno persi.\nSei sicuro di voler procedere con l\'operazione?\n\nClicca su Annulla per tornare alla scheda, OK per procedere');
        if (isSicuro) {
        } else {
            return false;
        }
    });
    //------------------------------------------------------------------
    $('.filtra_lista_input').keyup(function () {
        var textboxVal = $(this).val().toLowerCase();
        $($(this).attr('data-rel')).each(function () {
            var listVal = $(this).text().toLowerCase();
            if (listVal.indexOf(textboxVal) >= 0) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    //------------------------------------------------------------------


    //------------------------------------------------------------------
    //------------------------------------------------------------------
    $('.add_row').click(function (e) {
        e.preventDefault();
        unbindRowActions();
        var trg_cnt = $(this).attr('meta-rel-trg');
        var htmlCode = $('#' + $(this).attr('meta-rel-source-id')).html();
        var codeStrBase = htmlCode.toString();
        var codeStr = codeStrBase.replace(/###@###/g, '[]');
        var newCode = $(codeStr);
        newCode.attr('id', 'new_row_' + conta_new_row).addClass('isOpen');
        $('#' + trg_cnt).append(newCode);
        var newItemRow = $('#new_row_' + conta_new_row);
        newItemRow.css({ opacity: '0' }) // , 'transform' : 'scale(.5)'
        $('#new_row_' + conta_new_row + ' .card-body').attr('meta-type', $('#new_row_' + conta_new_row + ' .select_css_class').val());
        var attVelocity = 500;
        if (Math.ceil($('#new_row_' + conta_new_row).offset().top - $(window).scrollTop()) > 5500) {
            attVelocity = attVelocity * 2;
        } else if (Math.ceil($('#new_row_' + conta_new_row).offset().top - $(window).scrollTop()) > 2500) {
            attVelocity = attVelocity * 1.5;
        }
        $('html, body').animate({ scrollTop: $('#new_row_' + conta_new_row).offset().top - 80 }, attVelocity, "easeInOutCubic", function (e) {
            newItemRow.addClass('is_new_row')
        });

        attivaEditors();
        bindRowActions();
        conta_new_row++;
    });
    bindRowActions();


    //------------------------------------------------------------------
    //------------------------------------------------------------------



    // $('.gallery_items_cnt').sortable({
    //     placeholder: 'row_gallery_items-sort-placeholder',
    // });

    //------------------------------------------------------------------
    //------------------------------------------------------------------

    // $('.btn_save_after_proc').on('click', function(e){

    // });

    $('form.save_after_proc').submit(function () {

        $('.gallery_content-row').each(parseGalleryContentRow);
        $('.columns_content-row').each(parseColumsContentRow);
        $('.simple_content-row').each(parseCustomItemContentRow);
        $('.component_content-row').each(parseCustomItemContentRow);
        // alert('qui')
        return true; // return false to cancel form action
    });

    //------------------------------------------------------------------
    //------------------------------------------------------------------

    $('.go_to_select_target').change(function () {
        let base_target_url = $(this).attr('target-url');
        window.location.href = base_target_url + $(this).val();
    })

    //------------------------------------------------------------------
    //------------------------------------------------------------------



})(jQuery);

//------------------------------------------------------------------
function parseGalleryContentRow() {
    let jsonGalleryStr = '';
    let jsonGalleryArr = [];
    let target_input = $('.json_object', this);
    $('.gallery_content-row_item', this).each(function () {
        let curr_item_obj = new Object();
        // curr_item_obj.id = $('.id_slide' , this).val();
        curr_item_obj.img_id = $('.img_id_slide', this).val();
        curr_item_obj.title = $('.title_slide', this).val();
        curr_item_obj.cta = $('.cta_slide', this).val();
        curr_item_obj.freeparam = $('.freeparam_slide', this).val();
        jsonGalleryArr.push(curr_item_obj);
    });
    jsonGalleryStr = JSON.stringify(jsonGalleryArr);
    target_input.val(jsonGalleryStr);
    // 
    // CAMPI CUSTOM IN PARAGRAFI
    // 
    let json_free_values_str = '';
    let json_free_values_arr = [];
    let target_input_custom_fields = $('.free_values', this);
    $('.custom_field-row_item', this).each(function () {
        let curr_item_obj = new Object();
        curr_item_obj.key = $('.custom_field_key', this).val();
        curr_item_obj.value = $('.custom_field_value', this).val();
        json_free_values_arr.push(curr_item_obj);
    });
    json_free_values_str = JSON.stringify(json_free_values_arr);
    if(json_free_values_str != ''){
        target_input_custom_fields.val(json_free_values_str);
    }
    // 
}

//------------------------------------------------------------------
function parseColumsContentRow() {
    let jsonColumnsStr = '';
    let jsonColumnsArr = [];
    let target_input = $('.json_object', this);
    $('.colonne_content-row_item', this).each(function () {
        let curr_item_obj = new Object();
        // curr_item_obj.id = $('.id_slide' , this).val();
        curr_item_obj.img_id = $('.img_id_column', this).val();
        curr_item_obj.title = $('.title_column', this).val();
        curr_item_obj.testo = $('.txt_column', this).val();
        curr_item_obj.cta = $('.cta_column', this).val();
        curr_item_obj.cta_label = $('.cta_label_column', this).val();
        jsonColumnsArr.push(curr_item_obj);
    });
    jsonColumnsStr = JSON.stringify(jsonColumnsArr);
    target_input.val(jsonColumnsStr);
    // 
    // CAMPI CUSTOM IN PARAGRAFI
    // 
    let json_free_values_str = '';
    let json_free_values_arr = [];
    let target_input_custom_fields = $('.free_values', this);
    $('.custom_field-row_item', this).each(function () {
        let curr_item_obj = new Object();
        curr_item_obj.key = $('.custom_field_key', this).val();
        curr_item_obj.value = $('.custom_field_value', this).val();
        json_free_values_arr.push(curr_item_obj);
    });
    json_free_values_str = JSON.stringify(json_free_values_arr);
    if(json_free_values_str != ''){
        target_input_custom_fields.val(json_free_values_str);
    }
    // 

}
//------------------------------------------------------------------
function parseCustomItemContentRow() {
    // CAMPI CUSTOM IN PARAGRAFI
    let json_free_values_str = '';
    let json_free_values_arr = [];
    let target_input_custom_fields = $('.free_values', this);
    $('.custom_field-row_item', this).each(function () {
        let curr_item_obj = new Object();
        curr_item_obj.key = $('.custom_field_key', this).val();
        curr_item_obj.value = $('.custom_field_value', this).val();
        json_free_values_arr.push(curr_item_obj);
    });
    json_free_values_str = JSON.stringify(json_free_values_arr);
    if(json_free_values_str != ''){
        target_input_custom_fields.val(json_free_values_str);
    }
}
//------------------------------------------------------------------
function apriMediagallery_modal(selected_id, selected_path, targetInputField) {
    $('#mediagallery_modal').remove()
    var modal_html = $('#mediagallery_modal_code').text();
    let modal_jq_obj = $(modal_html);
    $('#selected_item_id', modal_jq_obj).val(selected_id);
    $('#selected_item_path', modal_jq_obj).val(selected_path);
    $('body').append(modal_jq_obj);
    avvia_draguploader(lc_root + '/media/ajax-upload', callback_upload_ajaxGallery);
    clickModalImgFun = selectImageSingleInModal;
    getAjaxGalleryItems($('#mediagallery_modal'), targetInputField)
    // ARPI Modale //
    // $('#mediagallery_modal').modal('show');
    // $('#mediagallery_modal').on('shown.bs.modal', function (current_modal) {
    //     avvia_draguploader(lc_root + '/media/ajax-upload', callback_upload_ajaxGallery);
    //     clickModalImgFun = selectImageSingleInModal;
    //     getAjaxGalleryItems(current_modal, targetInputField)
    // });
    // APRI Modale //
}

//------------------------------------------------------------------
function getAjaxGalleryItems(current_modal, targetInputField) {
    $('#mediagallery_modal_items', current_modal.target).html('<h4 class="modal_loading_mess">Loading...</h4>');
    var thumb_item_template = $('#files-template').text();
    let sel_value = $('#selected_item_id', current_modal.target).val();
    $('#gallery_preview', current_modal.target).remove();
    $.ajax({
        type: "get",
        url: lc_root + "/media/ajax-list",
        // data: "sel_id=" + selected_id,
        success: function (response) {
            // console.log('response', response);
            response.forEach(item => {
                template = $(thumb_item_template);
                template.addClass('media_type-' + item.tipo_file)
                template.find('.progress_cnt').remove();
                template.find('.nome_file_min').html(item.nome);
                template.find('a')
                    .attr('href', lc_root + '/media/edit/' + item.id)
                    .attr('meta-path', item.img_thumb)
                    // .attr('meta-path', item.path)
                    .attr('meta-rel', item.id);
                template.find('img').attr('src', item.img_thumb).removeClass('preview-img');
                // template.find('img').attr('src', thumbs_folder + item.path).removeClass('preview-img');
                template.attr('id', 'media_item_' + item.id);
                template.data('file-id', item.id);
                if (sel_value == item.id) {
                    template.addClass('selected');
                }
                $('#mediagallery_modal_items', current_modal.target).append(template);
            });
            $('.modal_loading_mess').remove();
            $('.media_item_img_btn').unbind('click');
            $('.media_item_img_btn').bind('click', selectImageSingleInModal);
            $('#saveByModalGallery').unbind('click');
            $('#saveByModalGallery').bind('click', function (e) {
                e.preventDefault();
                targetInputField.closest('div').addClass('hasImage');
                // 
                $(targetInputField).attr('meta-rel-id', $('#selected_item_id', current_modal.target).val());
                $(targetInputField).attr('meta-rel-path', $('#selected_item_path', current_modal.target).val());
                // $(targetInputField).attr('meta-rel-path', $('#selected_item_path', current_modal.target).val() );
                // 
                $('input', targetInputField).val($('#selected_item_id', current_modal.target).val());
                $('img', targetInputField).attr('src', $('#selected_item_path', current_modal.target).val());
                // $('img', targetInputField).attr('src', thumbs_folder + $('#selected_item_path', current_modal.target).val());
                $('.media_item_img_btn').unbind('click');
                $('#saveByModalGallery').unbind('click');
                // CHIUDI Modale //
                // $(current_modal.target).modal('hide');
                // CHIUDI Modale //
                $(this).closest('.modal').remove();
            });
        }
    });
}

//------------------------------------------------------------------
function selectImageSingleInModal(e) {
    e.preventDefault();
    $('#mediagallery_modal .media_item').removeClass('selected');
    // console.log('id', $(this).attr('meta-rel'));
    // console.log('path', $(this).attr('meta-path'));
    $(this).closest('#mediagallery_modal').find('#selected_item_id').val($(this).attr('meta-rel'));
    $(this).closest('#mediagallery_modal').find('#selected_item_path').val($(this).attr('meta-path'));
    $(this).closest('.media_item').addClass('selected');
}

//------------------------------------------------------------------
//------------------------------------------------------------------
function apriMediagallery_forMulti_modal(json_str, targetInputField) {
    tmp_gallery_array = {};
    $('#mediagallery_modal').remove()
    var modal_html = $('#mediagallery_modal_code').text();
    let modal_jq_obj = $(modal_html);
    $('#json_obj_str', modal_jq_obj).val(json_str);
    // $('#selected_item_path', modal_jq_obj).val(selected_path);
    $('body').append(modal_jq_obj);
    avvia_draguploader(lc_root + '/media/ajax-upload', null, ['jpg', 'jpeg', 'png']);
    clickModalImgFun = selectImageMultiInModal;
    getAjaxGalleryItemsFormMulti($('#mediagallery_modal'), targetInputField)
    // APRI Modale //
    // $('#mediagallery_modal').modal('show');
    // $('#mediagallery_modal').on('shown.bs.modal', function (current_modal) {
    //     avvia_draguploader(lc_root + '/media/ajax-upload', null, ['jpg', 'jpeg', 'png']);
    //     clickModalImgFun = selectImageMultiInModal;
    //     getAjaxGalleryItemsFormMulti(current_modal, targetInputField)
    // });
    // APRI Modale //
}
//------------------------------------------------------------------
function getAjaxGalleryItemsFormMulti(current_modal, targetInputField) {
    $('#mediagallery_modal_items', current_modal.target).html('<h4 class="modal_loading_mess">Loading...</h4>');
    var thumb_item_template = $('#files-template').text();
    let json_obj_str = $('#json_obj_str', current_modal.target).val();
    if (json_obj_str.length < 1) {
        json_obj_str = '{}';
    }
    // console.log('json_obj_str', json_obj_str)
    tmp_gallery_array = JSON.parse(json_obj_str);
    // console.log('tmp_gallery_array', tmp_gallery_array);
    $.ajax({
        type: "get",
        url: lc_root + "/media/ajax-list?type=img",
        // data: "sel_id=" + selected_id,
        success: function (response) {
            // console.log('response', response);
            response.forEach(item => {
                template = $(thumb_item_template);
                template.find('.progress_cnt').remove();
                template.find('.nome_file_min').html(item.nome);
                template.find('a')
                    .attr('href', lc_root + '/media/edit/' + item.id)
                    .attr('meta-path', item.img_thumb)
                    // .attr('meta-path', item.path)
                    .attr('meta-rel', item.id);
                template.find('img').attr('src', item.img_thumb).removeClass('preview-img');
                // template.find('img').attr('src', thumbs_folder + item.path).removeClass('preview-img');
                template.attr('id', 'media_item_' + item.id);
                template.data('file-id', item.id);
                if (tmp_gallery_array['i@' + item.id] != undefined) {
                    template.addClass('selected');
                }
                $('#mediagallery_modal_items', current_modal.target).append(template);
            });
            // 
            for (var key in tmp_gallery_array) {
                // $('#gallery_preview', current_modal.target).append($('<img>', { class: 'preview-img img-thumbnail img-thumbnail-for-multi', rel: key, src: tmp_gallery_array[key], path: tmp_gallery_array[key] }));
                $('#gallery_preview', current_modal.target).append($('<img>', { class: 'img-thumbnail-for-multi', rel: key, src: tmp_gallery_array[key], path: tmp_gallery_array[key] }));
            }
            // 
            //------------------------------------------------------------------
            $('#gallery_preview').sortable({
                placeholder: 'gallery_preview-sort-placeholder',
                axis: 'x',
                update: function (event, ui) {
                    setOrdineImageMultiInModal($('#gallery_preview', current_modal.target), $('#json_obj_str', current_modal.target));
                }
            });
            //------------------------------------------------------------------
            // 
            $('.modal_loading_mess').remove();
            $('.media_item_img_btn').unbind('click');
            $('.media_item_img_btn').bind('click', selectImageMultiInModal);
            $('#saveByModalGallery').unbind('click');
            $('#saveByModalGallery').bind('click', function (e) {
                e.preventDefault();
                // 
                $('input', targetInputField).val($('#json_obj_str', current_modal.target).val());
                targetInputField.find('.gallery_imgs_container').removeClass('gallery_imgs_container_w_img').html('');
                for (var key in tmp_gallery_array) {
                    targetInputField.find('.gallery_imgs_container').addClass('gallery_imgs_container_w_img').append($('<img>', { class: 'preview-img img-thumbnail', rel: key, src: tmp_gallery_array[key] }));
                    // targetInputField.find('.gallery_imgs_container').addClass('gallery_imgs_container_w_img').append($('<img>', { class: 'preview-img img-thumbnail', rel: key, src: thumbs_folder + tmp_gallery_array[key] }));
                }
                $('.media_item_img_btn').unbind('click');
                $('#saveByModalGallery').unbind('click');
                // CHIUDI Modale //
                // $(current_modal.target).modal('hide');
                // CHIUDI Modale //
                $(this).closest('.modal').remove();
                tmp_gallery_array = null;
            });
        }
    });
}
//------------------------------------------------------------------
function selectImageMultiInModal(e) {
    e.preventDefault();
    if (tmp_gallery_array['i@' + $(this).attr('meta-rel')] != undefined) {
        delete tmp_gallery_array['i@' + $(this).attr('meta-rel')];
        $(this).closest('#mediagallery_modal').find('#json_obj_str').val(JSON.stringify(tmp_gallery_array));
        $(this).closest('.media_item').removeClass('selected');
    } else {
        tmp_gallery_array['i@' + $(this).attr('meta-rel')] = $(this).attr('meta-path');
        $(this).closest('#mediagallery_modal').find('#json_obj_str').val(JSON.stringify(tmp_gallery_array));
        $(this).closest('.media_item').addClass('selected');
    }
    //
    $(this).closest('#mediagallery_modal').find('#gallery_preview').html('');
    for (var key in tmp_gallery_array) {
        // $(this).closest('#mediagallery_modal').find('#gallery_preview').append($('<img>', { class: 'preview-img img-thumbnail img-thumbnail-for-multi', rel: key, src: tmp_gallery_array[key], path: tmp_gallery_array[key] }));
        $(this).closest('#mediagallery_modal').find('#gallery_preview').append($('<img>', { class: 'img-thumbnail-for-multi', rel: key, src: tmp_gallery_array[key], path: tmp_gallery_array[key] }));
    }
}
//------------------------------------------------------------------
function setOrdineImageMultiInModal(container_row, modal_imput) {
    tmp_gallery_array = {};
    // console.log('container_row', container_row);
    $('img', container_row).each(function (e) {
        console.log('path', $(this).attr('path'));
        console.log('rel', $(this).attr('rel'));
        tmp_gallery_array[$(this).attr('rel')] = $(this).attr('path');
    });
    modal_imput.val(JSON.stringify(tmp_gallery_array));
}


//------------------------------------------------------------------
//------------------------------------------------------------------




//------------------------------------------------------------------
function removeRow(e) {
    e.preventDefault();
    let target_input = $(this).attr('meta-rel-trg');
    let curr_id_to_del = $(this).attr('meta-rel-id');
    $(this).closest('.content-row').remove();
    if (curr_id_to_del > 0) {
        row_to_del_arr.push(curr_id_to_del);
        $('#' + target_input).val(row_to_del_arr.join('#'));
    }
}
//------------------------------------------------------------------
function moveRowUp(e) {
    e.preventDefault();
    let curr_row = $(this).closest('.content-row');
    let container = curr_row.parent();
    let swap_row = curr_row.prev();
    curr_row.insertBefore(swap_row);
    setOrdineRow(container);
    // 
    $('html, body').animate({ scrollTop: curr_row.offset().top - 130 }, 100);
    // 
}
//------------------------------------------------------------------
function moveRowDown(e) {
    e.preventDefault();
    let curr_row = $(this).closest('.content-row');
    let container = curr_row.parent();
    let swap_row = curr_row.next();
    curr_row.insertAfter(swap_row);
    setOrdineRow(container);
    // 
    $('html, body').animate({ scrollTop: curr_row.offset().top - 130 }, 100);
    // 
}
//------------------------------------------------------------------
function expandRowContent(e) {
    e.preventDefault();
    let curr_row = $(this).closest('.content-row');
    let rel_trg = $(this).attr('rel');
    // console.log('rel_trg', rel_trg)
    $('.' + rel_trg, curr_row).slideToggle(400);
    curr_row.toggleClass('isOpen');
    editors_in_form.forEach(textarea_item => {
        textarea_item.events.fire('resize');
    });


}
//------------------------------------------------------------------
function setOrdineRow(container_row) {
    let nuovo_ordine_row = 1;
    $('.form-row', container_row).each(function () {
        // $(this).addClass('p-5')
        $('.input_order_row', this).val(nuovo_ordine_row);
        // input_order_row
        nuovo_ordine_row++;
    });
}
//------------------------------------------------------------------
//------------------------------------------------------------------
function delItemTargetCNT(e) {
    e.preventDefault();

    var trg_cnt = $(this).attr('meta-rel-trg-cnt');
    var current_target_cnt = $(this).closest('.' + trg_cnt);
    current_target_cnt.remove();
}
//------------------------------------------------------------------
//------------------------------------------------------------------
function addGalleryItem(e) {
    e.preventDefault();
    unbindRowActions();

    var btn_copiato = $(this).closest('.a_like_card_cnt');

    var current_par = $(this).closest('.content-row');
    var trg_cnt = $(this).attr('meta-rel-trg');
    var htmlCode = $('#' + $(this).attr('meta-rel-source-id')).html();
    var codeStrBase = htmlCode.toString();
    var codeStr = codeStrBase.replace(/###@###/g, '[]');
    var newCode = $(codeStr);
    newCode.attr('id', 'new_gallitem_' + conta_new_gallitem);
    $('.' + trg_cnt, current_par).append(newCode);
    $('.' + trg_cnt, current_par).append(btn_copiato);
    bindRowActions();
    conta_new_gallitem++;

}
//------------------------------------------------------------------
//------------------------------------------------------------------
function addCustomItemRow(e) {
    e.preventDefault();
    unbindRowActions();
    var current_par = $(this).closest('.content-row');
    var trg_cnt = $(this).attr('meta-rel-trg');
    var htmlCode = $('#' + $(this).attr('meta-rel-source-id')).html();
    var codeStrBase = htmlCode.toString();
    var codeStr = codeStrBase.replace(/###@###/g, '[]');
    var newCode = $(codeStr);
    newCode.attr('id', 'new_customfilditem_' + conta_new_custom_field_item);
    $('.' + trg_cnt, current_par).append(newCode);
    bindRowActions();
    conta_new_custom_field_item++;

}
//------------------------------------------------------------------
//------------------------------------------------------------------
function addColumnsItem(e) {
    e.preventDefault();
    unbindRowActions();
    var btn_copiato = $(this).closest('.a_like_card_cnt');

    var current_par = $(this).closest('.content-row');
    var trg_cnt = $(this).attr('meta-rel-trg');
    var htmlCode = $('#' + $(this).attr('meta-rel-source-id')).html();
    var codeStrBase = htmlCode.toString();
    var codeStr = codeStrBase.replace(/###@###/g, '[]');
    var newCode = $(codeStr);
    newCode.attr('id', 'new_col_' + conta_new_col);
    $('.' + trg_cnt, current_par).append(newCode);
    $('.' + trg_cnt, current_par).append(btn_copiato);
    attivaEditors();
    bindRowActions();
    conta_new_col++;
}
//------------------------------------------------------------------
//------------------------------------------------------------------
function bindRowActions() {
    $('.del_row').bind('click', removeRow);
    $('.par_move_up').bind('click', moveRowUp);
    $('.par_move_down').bind('click', moveRowDown);
    $('.par_expand').bind('click', expandRowContent);
    // 
    $('.add_gallery_item').bind('click', addGalleryItem);
    $('.add_colonne_item').bind('click', addColumnsItem);
    $('.add_custom_item').bind('click', addCustomItemRow);
    // 
    // 

    $('.del_trg_cnt').bind('click', delItemTargetCNT); //meta-rel-trg-cnt

    //
    $('.open-modal-mediagallery-gallery').bind('click', function (e) {
        e.preventDefault();
        let json_str = $(this).find('input').val();
        apriMediagallery_forMulti_modal(json_str, $(this));
    });
    //
    $('.open-modal-mediagallery-single').bind('click', function (e) {
        e.preventDefault();
        let selected_id = $(this).attr('meta-rel-id');
        let selected_path = $(this).attr('meta-rel-path');
        // let selected_path = $('img', this).attr('src');
        apriMediagallery_modal(selected_id, selected_path, $(this));
    });
    //
    $('.remove-single-img').bind('click', function (e) {
        e.preventDefault();
        var singleImgItem = $(this).closest('div');
        singleImgItem.removeClass('hasImage');
        singleImgItem.find('input').val('');
        singleImgItem.find('img').attr('src', thumb_default);
    });
    // 
    $('.gallery_items_cnt').sortable({
        cancel: "a,button,.jodit-container,input,select,.a_like_card_cnt",
        placeholder: 'row_gallery_items-sort-placeholder',
    });
    // 
    // 
    $('.colonne_items_cnt').sortable({
        cancel: "a,button,.jodit-container,input,select",
        placeholder: 'row_columns_items-sort-placeholder',
    });
    // 


}
//------------------------------------------------------------------
function unbindRowActions() {
    $('.del_row').unbind('click');
    $('.par_move_up').unbind('click');
    $('.par_move_down').unbind('click');
    $('.par_expand').unbind('click');
    // 
    $('.add_gallery_item').unbind('click');
    $('.add_colonne_item').unbind('click');
    $('.add_custom_item').unbind('click');
    // 
    $('.del_trg_cnt').unbind('click');
    //
    $('.open-modal-mediagallery-gallery').unbind('click');
    $('.open-modal-mediagallery-single').unbind('click');
    $('.remove-single-img').unbind('click');

}
//------------------------------------------------------------------


//------------------------------------------------------------------
// fissa toolbar schede
// document.addEventListener("DOMContentLoaded", function () {
//     window.addEventListener('scroll', function () {
//         if (document.getElementById('scheda_tools')) {
//             if (window.scrollY > 35) {
//                 document.getElementById('scheda_tools').classList.add('pt-5');
//             } else {
//                 document.getElementById('scheda_tools').classList.remove('pt-5');
//             }
//         }
//     });
// });
//------------------------------------------------------------------
//------------------------------------------------------------------





//------------------------------------------------------------------
//------------------------------------------------------------------
function avvia_draguploader(upload_endpoint, f_callback, typesAccettati) {
    var function_callback = null;
    if (f_callback) {
        function_callback = f_callback;
    }
    // var fileTypesAccettati = ['jpg', 'jpeg', 'png', 'mp4'];
    var fileTypesAccettati = ['jpg', 'jpeg', 'png', 'mp4', 'pdf', 'svg'];

    if (typesAccettati) {
        fileTypesAccettati = typesAccettati;
    }
    $('#drag-and-drop-zone').dmUploader({ //
        url: upload_endpoint,
        maxFileSize: 10000000, // 3 Megs 
        onDragEnter: function () {
            this.addClass('active');
        },
        onDragLeave: function () {
            this.removeClass('active');
        },
        onNewFile: function (id, file) {
            if (typeof FileReader !== "undefined") {
                var fileTypes = fileTypesAccettati;
                var extension = file.name.split('.').pop().toLowerCase();
                var isSuccess = fileTypes.indexOf(extension) > -1;
                if (!isSuccess) {
                    alert('Tipo di file non accettato')
                } else {
                    ui_multi_add_file(id, file);
                    var reader = new FileReader();
                    var img = $('#uploaderFile' + id).find('img');
                    reader.onload = function (e) {
                        img.attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            }
        },
        onBeforeUpload: function (id) {
            upload_update_status(id, 'uploading', 'Upload in corso...');
            upload_update_progress(id, 0, '', true);
        },
        onUploadProgress: function (id, percent) {
            upload_update_progress(id, percent);
        },
        onUploadSuccess: function (id, data) {
            console.log('data', data);

            upload_update_status(id, 'success', 'Upload completato');
            upload_update_progress(id, 100, 'success', false);
            upload_completato(id, data, function_callback);
        },
        onUploadError: function (id, xhr, status, message) {
            console.log('error', message);
            upload_update_status(id, 'danger', message);
            upload_update_progress(id, 0, 'danger', false);
        },
        onFileSizeError: function (file) {
            console.log('error', file);
        }
    });
}
// 
function ui_multi_add_file(id, file) {
    var template = $('#files-template').text();
    template = $(template);
    template.prop('id', 'uploaderFile' + id);
    template.data('file-id', id);
    template.addClass('in_upload');
    var progress_html = $('<div class="progress_cnt"><span class="">Waiting</span><div class="progress"><div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div></div>');
    template.append(progress_html);

    $('.target_dropUpload_CNT').find('h3.list_error').fadeOut();
    $('.target_dropUpload_CNT').prepend(template);
}
//

//
function upload_completato(id, data, f_callback) {
    // console.log('data', data);
    $('#uploaderFile' + id + ' .progress_cnt').remove();
    $('#uploaderFile' + id + '').find('.nome_file_min').html(data.nome);
    $('#uploaderFile' + id + '').removeClass('in_upload');
    $('#uploaderFile' + id + '').addClass('media_type-' + data.tipo_file)
    $('#uploaderFile' + id + ' a').attr('href', lc_root + '/media/edit/' + data.id).attr('meta-path', data.img_thumb).attr('meta-rel', data.id);
    $('#uploaderFile' + id + ' img').attr('src', data.img_thumb).removeClass('preview-img');
    $('#uploaderFile' + id + '').attr('meta-rel', data.id);
    $('#uploaderFile' + id + '').attr('id', 'media_item_' + data.id);
    //	
    if (clickModalImgFun) {
        $('.media_item_img_btn').unbind('click');
        $('.media_item_img_btn').bind('click', clickModalImgFun);
    }
    //
    if (f_callback) {
        f_callback(data.id);
    }
}
function upload_update_status(id, status, message) {
    $('#uploaderFile' + id).find('span').html(message).prop('class', 'status text-' + status);
}
function upload_update_progress(id, percent, color, active) {
    var bar = $('#uploaderFile' + id).find('div.progress-bar');
    bar.width(percent + '%').attr('aria-valuenow', percent);
    bar.toggleClass('progress-bar-striped progress-bar-animated', active);
    if (percent === 0) {
        bar.html('');
    } else {
        bar.html(percent + '%');
    }
}

function callback_upload_ajaxGallery(id) {
    $('#media_item_' + id + ' a.media_item_img_btn').click();
    // console.log('callback_upload_ajaxGallery: ' , '#media_item_' + id + ' a.media_item_img_btn')
}
//



// function upload_update_status(id, status, message) {
// 	$('#uploaderFile' + id).find('span').html(message).prop('class', 'status text-' + status);
// }
// function upload_update_progress(id, percent, color, active) {
// 	var bar = $('#uploaderFile' + id).find('div.progress-bar');
// 	bar.width(percent + '%').attr('aria-valuenow', percent);
// }








//------------------------------------------------------------------
//------------------------------------------------------------------