<?php

function isJson($string) {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
 }

function getML($mlString, $request_lang = null)
{
    $return_str = '';
    if (!$request_lang) {
        $request_lang = service('request')->getLocale();
    }
    //
    $campo_ml_arr = json_decode($mlString);
    if (!is_array($campo_ml_arr)) {
        return $mlString;
    }
    foreach ($campo_ml_arr as $c_label) {
        if (isset($c_label->lang)) {
            if ($c_label->lang == $request_lang) {
                $return_str = $c_label->txt;
            }
        } else {
            return $mlString;
        }
    }
    //
    return $return_str;
}

function getML_basic($mlString, $request_lang = null)
{
    $return_str = '';
    if (!$request_lang) {
        $request_lang = service('request')->getLocale();
    }
    //
    $campo_ml_arr = json_encode($mlString);
    echo (json_decode($mlString));
    if (!is_array($campo_ml_arr)) {
        return '' . $mlString;
    }
    // foreach ($campo_ml_arr as $c_label) {
    //     if (isset($c_label->lang)) {
    //         if ($c_label->lang == $request_lang) {
    //             $return_str = $c_label->txt;
    //         }
    //     } else {
    //         return $mlString;
    //     }
    // }
    //
    return '------' . $return_str;
}

function formato($imgPath, $formato_folder = '')
{
    if ($formato_folder != '') {
        $formato_folder .= '/';
    }
    return str_replace(env('custom.media_folder_key'), '/' . $formato_folder, $imgPath);
}
function image_root($imgPath = null)
{
    if ($imgPath && $imgPath != '') {
        return env('custom.media_root_image') . $imgPath;
    }
    return false;
}

function coin($number)
{
    return number_format($number, 2, '.', '');
}

function number_to_currency(float $num, string $currency, string $locale = null, int $fraction = 2): string
{
    return format_number($num, 1, $locale, [
        'type'     => NumberFormatter::CURRENCY,
        'currency' => $currency,
        'fraction' => $fraction,
    ]);
}

function user_mess($_ui_mess = '', $_ui_mess_type = null)
{
    $htmlCode = '';
    if (trim($_ui_mess)) {
        $htmlCode = '<div class="alert user_mess ' . (($_ui_mess_type) ? 'alert-' . $_ui_mess_type . ' user_mess_' . $_ui_mess_type . ' ' . $_ui_mess_type : '') . '">' . $_ui_mess . '</div>';
    }

    return $htmlCode;
}


function humanData($date_str = null, $d_format = "d-m-Y")
{

    if (!$date_str) {
        $date_str = date("Y-m-d H:i:s");
    }
    return date($d_format, strtotime($date_str));
}


function pre_print($to_print_r)
{
    echo '<pre>';
    print_r($to_print_r);
    echo '</pre>';
}

//--------------------------------------------------
//--------------------------------------------------
//--------------------------------------------------

function wrapTag($html = null, $tag = 'div', $cssClass = '',  $pre_txt = '', $add_txt = '')
{
    $return_html = '';
    if (isset($html) && $html != '') {
        $return_html = '<' . $tag . ' class="' . $cssClass . '">' . $pre_txt . $html . $add_txt . '</' . $tag . '>';
    }
    return $return_html;
}

//--------------------------------------------------

function hTag($txt = null, $cssClass = '', $hT = '1', $pre_txt = '', $add_txt = '')
{
    $return_html = '';
    if (isset($txt) && $txt != '') {
        $return_html = '<h' . $hT . ' class="' . $cssClass . '">' . (($pre_txt != '') ? '<span class="txt_pre">'.$pre_txt.'</span> ' : '') . $txt . (($add_txt != '') ? ' <span class="txt_add">'.$add_txt.'</span>' : '') . '</h' . $hT . '>';
    }
    return $return_html;
}

//--------------------------------------------------

function h1($txt = null, $cssClass = '', $pre_txt = '', $add_txt = '')
{
    $return_html = '';
    if (isset($txt) && $txt != '') {
        $return_html = hTag($txt, $cssClass, '1', $pre_txt, $add_txt);
    }
    return $return_html;
}

//--------------------------------------------------

function h2($txt = null, $cssClass = '', $pre_txt = '', $add_txt = '')
{
    $return_html = '';
    if (isset($txt) && $txt != '') {
        $return_html = hTag($txt, $cssClass, '2', $pre_txt, $add_txt);
    }
    return $return_html;
}

//--------------------------------------------------

function h3($txt = null, $cssClass = '', $pre_txt = '', $add_txt = '')
{
    $return_html = '';
    if (isset($txt) && $txt != '') {
        $return_html = hTag($txt, $cssClass, '3', $pre_txt, $add_txt);
    }
    return $return_html;
}

//--------------------------------------------------

function h4($txt = null, $cssClass = '', $pre_txt = '', $add_txt = '')
{
    $return_html = '';
    if (isset($txt) && $txt != '') {
        $return_html = hTag($txt, $cssClass, '4', $pre_txt, $add_txt);
    }
    return $return_html;
}

//--------------------------------------------------

function h5($txt = null, $cssClass = '', $pre_txt = '', $add_txt = '')
{
    $return_html = '';
    if (isset($txt) && $txt != '') {
        $return_html = hTag($txt, $cssClass, '5', $pre_txt, $add_txt);
    }
    return $return_html;
}

//--------------------------------------------------

function h6($txt = null, $cssClass = '', $pre_txt = '', $add_txt = '')
{
    $return_html = '';
    if (isset($txt) && $txt != '') {
        $return_html = hTag($txt, $cssClass, '6', $pre_txt, $add_txt);
    }
    return $return_html;
}

//--------------------------------------------------
//--------------------------------------------------

function txt($txt = null, $cssClass = '', $tag = 'div', $container_open = null, $container_close = null, $nl2br = false)
{
    $return_html = '';
    if (isset($txt) && $txt != '') {
        $return_html = '<' . $tag . ' class="' . $cssClass . '">' . (($nl2br) ? my_nl2br($txt) : $txt) . '</' . $tag . '>';
        if ($container_open && $container_close) {
            $return_html = '<' . $container_open . '>' . $return_html . '</' . $container_close . '>';
        }
    }
    return $return_html;
}

//--------------------------------------------------

function cta($url = null, $btn_label = 'Scopri', $cssClass = 'cta', $trg = '')
{
    $return_html = '';
    if ($btn_label == '') {
        $btn_label = 'Scopri';
    }
    if (isset($url) && $url != '') {
        $return_html = '<div class="' . $cssClass . '_cnt"><a class="' . $cssClass . '_btn" target="' . $trg . '" href="' . $url . '">' . $btn_label . '</a></div>';
    }
    return $return_html;
}
//--------------------------------------------------

function urlSegment(int $s_index)
{
    $uri = service('uri');
    $returnstr = $uri->setSilent()->getSegment($s_index);
    return (trim($returnstr)) ?: NULL;
}

//--------------------------------------------------

function appIsFile(string $path)
{
    if (is_file(APPPATH.$path)) {
        return TRUE;
    }
    return FALSE;
}

//--------------------------------------------------
//--------------------------------------------------
//--------------------------------------------------

//--------------------------------------------------
function my_nl2br($text)
{
    $html = nl2br($text);
    
    $html = str_replace(['<table><br>','<table><br />'], '<table>',  $html);
    $html = str_replace(['</table><br>','</table><br />'], '</table>',  $html);
   
    $html = str_replace(['<tbody><br>','<tbody><br />'], '<tbody>',  $html);
    $html = str_replace(['</tbody><br>','</tbody><br />'], '</tbody>',  $html);
    
    $html = str_replace(['<tr><br>','<tr><br />'], '<tr>',  $html);
    $html = str_replace(['</tr><br>','</tr><br />'], '</tr>',  $html);
    
    $html = str_replace(['<td><br>','<td><br />'], '<td>',  $html);
    $html = str_replace(['</td><br>','</td><br />'], '</td>',  $html);




    return $html;
}
//--------------------------------------------------



// function titolo($tOpen = '<h1>', $tClose = '</h1>')
// {
//     $return_html = null;
//     if (isset($titolo)) {
//         if ($titolo != '') {

//             $return_html = $tOpen . $titolo . $tClose . '';
//         }
//     }
//     return $return_html;
// }





// function paragrafo(array $params=[])
// {
    

//     return view($params['inc_file'], ['paragrafo' => $params['paragrafo']]);
// }