<?php
//--------------------------------------------------
function printLangsMenu($menu, $menu_name = 'languages-menu')
{
    $return_html = '';
    if (isset($menu) && is_array($menu) && count($menu) > 0) {
        $return_html .= '<ul class="' . $menu_name . '" id="' . $menu_name . '">';
        foreach ($menu as $lang) {
            $return_html .= '<li>';
            $return_html .= '<a class="' . (($lang->is_default) ? 'default_lang' : '') . ' ' . (($lang->is_current) ? 'current_lang' : '') . ' ' . $menu_name . '-' . $lang->id . '" href="' . $lang->parameter . '">' . $lang->label . '</a>';
            $return_html .= '</li>';
        }
        $return_html .= '</ul>';
    }
    return $return_html;
}
//--------------------------------------------------
function appLabel($label, $labels, $force_return = false)
{
    // isset($app->app_labels)
    $label_key = url_title(trim($label), '_', TRUE);	
    if (isset($label_key) && trim($label_key) && isset($labels) && is_array($labels) && isset($labels[$label_key])) {
        return $labels[$label_key];
    }else if(isset($label) && trim($label) && $force_return){
        return $label;
    }
    return '';
}
//--------------------------------------------------
function printSiteMenu($menu, $menu_name = null, $menu_id = null)
{
    if (!$menu_name) {
        if (!isset($menu->guid)) {
            $menu_name = 'menu';
        } else {
            $menu_name = $menu->guid;
        }
    }
    if (!$menu_id) {
        $menu_id = $menu_name;
    }
    $return_html = '';
    if (isset($menu) && isset($menu->data) && is_array($menu->data) && count($menu->data) > 0) {
        $return_html .= printChildrenMenuItems($menu->data, $menu_name, 0, $menu_id);
    }
    return $return_html;
}
//--------------------------------------------------
function printChildrenMenuItems($childrens, $menu_name, $depth = 0, $menu_id = null)
{
    $return_html = '';
    if (isset($childrens) &&  is_array($childrens) && count($childrens) > 0) {
        $return_html .= '<ul class="' . $menu_name . '-depth-' . $depth . ' ' . $menu_name . ' menu-depth-' . $depth . '" ' . (($menu_id) ? 'id="' . $menu_id . '"' : '') . ' >';
        foreach ($childrens as $c_row) {
            $has_submenu = false;
            $sub_menu_code  = '';
            if((isset($c_row->children) && is_iterable($c_row->children))){
                $has_submenu = true;
                $sub_menu_code  =  printChildrenMenuItems($c_row->children, $menu_name, $depth + 1) ;
            }
            $return_html .= '<li class="'.(($has_submenu == true) ? 'has_submenu' : 'last_child_depth').'">';
            $return_html .= '<a class="menu-item-' . $c_row->id . ' menu-item-type-' . $c_row->type . ' ' . ((isset($c_row->is_home) && $c_row->is_home == 1) ? 'link_home' : '') . ' ' . $menu_name . '-' . $c_row->id . '" href="' . site_url(__locale_uri__ . $c_row->parameter) . '">' . $c_row->label . '</a>';
            $return_html .= $sub_menu_code;
            $return_html .= '</li>';
        }
        $return_html .= '</ul>';
    }
    return $return_html;
}
//--------------------------------------------------
function printPostRows($entity_rows, $view_area = null)
{
    $return_html = '';
    if (isset($entity_rows) && is_array($entity_rows) && count($entity_rows) > 0) {
        foreach ($entity_rows as $c_row) {
            if ($view_area) {
                if (isset($c_row->view_area) && $c_row->view_area == $view_area) {
                    $return_html .= view($c_row->view, ['row' => $c_row]);
                }
            } else {
                $return_html .= view($c_row->view, ['row' => $c_row]);
            }
        }
    } else {
        return false;
    }
    return (trim($return_html)) ? $return_html : FALSE;
}

//--------------------------------------------------
function checkNotNull($field = null)
{
    if (isset($field) && $field != null) {
        if (is_string($field) && !trim($field)) {
            return false;
        }
        if (is_array($field) && count($field) <= 0) {
            return false;
        }
        return true;
    }
    return false;
}



//--------------------------------------------------
function parseMediaObj($__media_obj, $format_folder = null, $css_class = '', $alt_label = 'image', $def_image = null)
{
    $return_html = '';
    if (checkNotNull($__media_obj)) {
        if ($__media_obj->is_image) {
            $return_html = single_img($__media_obj->path, $format_folder, $css_class, $alt_label, $def_image);
        } else if ($__media_obj->tipo_file == 'svg') {
            $return_html = single_img($__media_obj->path, '', $css_class, $alt_label, $def_image);
        } else {
            $return_html = getMediaByType($__media_obj->path, $__media_obj->tipo_file, $css_class);
        }
        return $return_html;
    } else if ($def_image) {
        $return_html = single_img('', $format_folder, $css_class, $alt_label, $def_image);
        return $return_html;
    }
    return FALSE;
}



//--------------------------------------------------
function getMediaByType($media_path, $media_type = null, $css_class = '')
{
    $return_html = '';
    if (isset($media_path) && $media_path != '' && $media_path != null) {
        if ($media_type == 'mp4') {
            $return_html .= '
            <video playsinline autoplay muted loop class="' . $css_class . '">
					<source src="' . env('custom.media_root_path') . $media_path . '" type="video/mp4">
				</video>
            ';
        } else if ($media_type == 'svg') {
            $return_html = single_img($media_path, '', $css_class);
        } else {
            $return_html .= '<a target="_blank" class="download_file download_file_' . $media_type . ' ' . $css_class . '" href="' . env('custom.media_root_path') . $media_path . '" title=""><span class="label-download">Download</span></a>';
        }
    }
    return $return_html;
}
//--------------------------------------------------
function single_img($image_path, $format_folder = null, $css_class = '', $alt_label = 'image', $def_image = null)
{
    $return_html = '';
    if ($img_src = single_img_url($image_path, $format_folder, $def_image)) {
        return '<figure class="'.$css_class.'"><img src="' . $img_src . '" alt="' . $alt_label . '" /></figure>';
    }
    // if (isset($image_path) && $image_path != '' && $image_path != null ) {
    //     $return_html.=''. env('custom.media_root_path') .  (($format_folder)? $format_folder .'/' : '') . $image_path .'" alt="img" />';

    // }else if( $def_image ){

    //     $return_html.='<img src="'. site_url(  'assets/web/img/default' . '-' . $format_folder.'.png' ).'" alt="img" />';
    // }
    return FALSE;
}
//--------------------------------------------------
function single_img_url($image_path, $format_folder = null, $def_image = null)
{
    if (isset($image_path) && $image_path != '' && $image_path != null) {
        $ext = getFileExt($image_path);
        if($ext && $ext == 'svg'){
            $format_folder = null; 
        }
        return '' . env('custom.media_root_path') .  (($format_folder) ? $format_folder . '/' : '') . $image_path . '';
    } else if ($def_image) {
        return '' . __base_assets_folder__ . 'img/default' .  '-' . $format_folder . '.png' . '';
    }
    return FALSE;
}
//--------------------------------------------------
function getFileExt(string $filepath)
{
    $filename_path = explode(".", $filepath);
    $ext = end($filename_path);
    return  $ext;
}
//--------------------------------------------------
function embedYoutube($url = '', $auto_play = true, $container_class = 'yt_embed_cnt', $container_tag = 'div')
{
    if ($embend_src = getYoutubeEmbed_url($url)) {
        $return_html = '<' . $container_tag . ' class="'.$container_class.'"><iframe src="https://www.youtube.com/embed/' . $embend_src . '" frameborder="0" allow="' . (($auto_play) ? 'autoplay;' : '') . ' encrypted-media;" allowfullscreen></iframe></' . $container_tag . '>';
        return $return_html;
    }
    return '';
}
//--------------------------------------------------
function getYoutubeEmbed_url($url = '')
{
    if (trim($url)) {
        $remote_guid = null;
        if (strpos($url, 'youtu.be') !== false) {
            $remote_guid = str_replace('https://youtu.be/', '', trim($url));
        }
        if (strpos($url, 'youtube.com') !== false) {
            $remote_guid = str_replace(['https://www.youtube.com/watch?v=', 'https://youtube.com/watch?v='], '', trim($url));
        }
        if ($remote_guid) {
            return '' . $remote_guid;
        }
    }
    return FALSE;
}