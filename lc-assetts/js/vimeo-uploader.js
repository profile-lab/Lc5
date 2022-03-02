let file_name = '';
let vimeo_form_input_file = null;
let upload_url = null;
let checkIntervall = null;
let volte_test = 0;
//------------------------------------------------------------
function avviaCheckVideoStatus() {
    // $('#status_video_on_vimeo').val()
    if ($('#status_video_on_vimeo').val() == 'available') {
        clearInterval(checkIntervall);
    } else {
        updateVimeoVideoStatus($('#call_api_refresh_video_info').attr('meta-video-code'));
    }
    // volte_test++
    // console.log('video c è' + volte_test);
    // if (volte_test == 10) {
    //     clearInterval(checkIntervall);
    // }
}
//------------------------------------------------------------
function updateVimeoVideoStatus(__video_id) {
    $('#vimeo_video_thumb_cnt').html('<div class="loader_cnt"><div class="loader">Loading...</div></div>');

    // const __video_id = $(this).attr('meta-video-code');
    $.ajax({
        url: uri_api_refresh_video_info,
        method: 'POST',
        data: {
            video_id: __video_id,
        },
        success: function (response) {
            if (response.status == 200) {
                console.log('response', response);
                const body_data = response.body;

                $('#vimeo_video_status').removeClass().addClass('' + body_data.vimeo_video_status + '').html('' + body_data.vimeo_video_status + '');
                $('#status_video_on_vimeo').val('' + body_data.vimeo_video_status + '');

                if (response.body.video_path != '' && response.body.video_path != null) {
                    $('#vimeo_video_thumb_cnt').html('<video width="320" height="240" controls><source src="' + body_data.video_path + '" type="video/mp4"></video>');
                }
                // if (response.body.thumb_path != '' && response.body.thumb_path != null) {
                //     $('#vimeo_video_thumb_cnt').html('<img id="vimeo_video_thumb" class="img-fluid"  src="' + body_data.thumb_path + '" />');
                // }
            }
        },
        error: function (err) {
            console.log("error", err);
        }
    });
}

//------------------------------------------------------------



$(document).ready(function () {
    // $('#loading_video_upload_cnt').hide(1);
    $('#upload_on_vimeo_btn').attr('disabled', true);

    if ($('#status_video_on_vimeo').val()) {
        if ($('#status_video_on_vimeo').val() != 'available') {
            checkIntervall = setInterval(avviaCheckVideoStatus, 2500);
        }
    }

    $('#vimeo_video_file_up').bind('change', function () {
        $('#upload_on_vimeo_btn').attr('disabled', true);

        vimeo_form_input_file = null;
        $('#invalid_vimeo_video_file_up').css('display', 'none').html('');
        $('#file_size').val('');
        // 
        vimeo_form_input_file = this.files[0];
        console.log('vimeo_form_input_file', vimeo_form_input_file);
        console.log('vimeo_form_input_file.name', vimeo_form_input_file.name);
        console.log('vimeo_form_input_file.type', vimeo_form_input_file.type);

        const filename_parts = vimeo_form_input_file.name.split('.');
        const file_ext = filename_parts[filename_parts.length - 1].toLowerCase();
        console.log('file_ext', file_ext);
        switch (file_ext) {
            case 'm4v':
            case 'avi':
            case 'mpg':
            case 'mp4':
            case 'mov':
                $('#file_size').val(vimeo_form_input_file.size);
                file_name = vimeo_form_input_file.name;
                $('#upload_on_vimeo_btn').attr('disabled', false);

                break;
            default:
                $('#invalid_vimeo_video_file_up').css('display', 'block').html('Seleziona un file video valido');
                $('#upload_on_vimeo_btn').attr('disabled', true);

                break;
        }


    });
    //------------------------------------------------------------
    //------------------------------------------------------------
    $('#upload_on_vimeo_btn').bind('click', function (evt) {// .submit(function (evt) {
        evt.preventDefault();
        $('#upload_on_vimeo_all_form_cnt').children().css('display', 'none');
        $('#upload_on_vimeo_all_form_cnt').append('<div id="connessione_in_corso_mess" />');
        $('#connessione_in_corso_mess').append('<div class="loader_cnt"><div class="loader">Loading...</div></div>');
        $('#connessione_in_corso_mess').append('<div class="p-3">Connessione in corso...</div>');

        if (vimeo_form_input_file) {
            $.ajax({
                url: uri_api_create_new_tus_vimeo,
                method: 'POST',
                data: {
                    video_name: $('#nome').val(),
                    file_size: $('#file_size').val(),
                    file_name: file_name,
                },
                success: function (response) {
                    console.log('response', response);
                    if (response.status == 201) {
                        if (vimeo_new_video_resp = response.body.vimeo_resonse) {
                            if (upload_url = vimeo_new_video_resp.body.upload.upload_link) {
                                caricaTus(upload_url);
                            }
                        }
                    }
                },
                error: function () {
                    alert("error");
                }
            });
        }
    });
    //------------------------------------------------------------
    //------------------------------------------------------------
    $('#call_api_refresh_video_info').bind('click', function (evt) {
        evt.preventDefault();
        const __video_id = $(this).attr('meta-video-code');
        updateVimeoVideoStatus(__video_id);
    });
    //------------------------------------------------------------
    //------------------------------------------------------------
    $('#call_api_delete_video').bind('click', function (evt) {
        evt.preventDefault();
        const __video_id = $(this).attr('meta-video-code');
        $.ajax({
            url: uri_api_delete_vimeo_video,
            method: 'POST',
            data: {
                video_id: __video_id,
            },
            success: function (response) {
                console.log('response', response);
                // $('#main_form').submit();
                $('.form').submit();
            },
            error: function () {
                alert("error");
            }
        });
    });
    //------------------------------------------------------------
    //------------------------------------------------------------

});
//------------------------------------------------------------
function caricaTus(__upload_url) {
    if (vimeo_form_input_file) {
        var upload = new tus.Upload(vimeo_form_input_file, {
            uploadUrl: __upload_url,
            retryDelays: [0, 3000, 5000, 10000, 20000],
            metadata: {
                filename: vimeo_form_input_file.name,
                filetype: vimeo_form_input_file.type
            },
            onError: function (error) {
                console.log("Failed because: " + error)
            },
            onProgress: function (bytesUploaded, bytesTotal) {
                var percentage = (bytesUploaded / bytesTotal * 100).toFixed(2)
                // console.log(bytesUploaded, bytesTotal, percentage + "%");
                $('#loading_video_upload').css("width", "" + percentage + "%");
                $('#loading_video_upload_perce_text').html(Math.ceil(percentage) + "%");

            },
            onSuccess: function () {
                // $('#main_form').submit();
                $('.form').submit();
                console.log("Download %s from %s", upload.file.name, upload.url)
            },
        });
        upload.start();
        $('#loading_video_upload_cnt').show(1);
        $('#upload_on_vimeo_all_form_cnt').hide(1);
    }

    // // Start the upload
    // 

}
//------------------------------------------------------------