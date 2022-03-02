<?php
//--------------------------------------------------
function lc_print_children_option($children, $c_value)
{
    $returnString = '';
    if (isset($children) && is_array($children) && count($children) > 0) {
        foreach ($children as $sub_item) {
            $returnString .= '
            <option value="' . $sub_item->val . '" ' . (($sub_item->val == $c_value) ? 'selected' : '') . '>' . $sub_item->nome . '</option>
            ';
            $returnString .= lc_print_children_option($sub_item->children, $c_value);
        }
    }
    return $returnString;
}


//--------------------------------------------------
function lc_print_pages_index_children_sublist($children, $route_prefix)
{
    $___curr_lc_lang = session()->get('curr_lc_lang');

    $languages_model = new \Lc5\Data\Models\LanguagesModel();
    $___lc_languages = $languages_model->asObject()->findAll();
    $returnString = '';
    if (isset($children) && is_array($children) && count($children) > 0) {
        $returnString .= '<div class="list_item_children"><ul>';
        foreach ($children as $s_item) {
            $returnString .= '<li>';
            $returnString .= '<div class="list_item_row">';
            $returnString .= '
                <div class="list_item_id">' . $s_item->id . '</div>
                <div class="list_item_nome">
                    <a class="btn-link text-white" href="' . site_url(route_to($route_prefix . '_edit', $s_item->id)) . '">' . $s_item->nome . '</a>
                </div>
                <div class="list_item_tools">
                    <div class="btn-group mr-2 dropstart">
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu">
            ';
            if ($s_item->frontend_guid) {
                $returnString .= '                
                            <div class="dropdown-header">Preview</div>
                            <a class="dropdown-item" target="_blank" href="' . $s_item->frontend_guid . '">Vai alla pagina</a>
                            <div class="dropdown-divider"></div>
                ';
            }
            $returnString .= '                
                            <div class="dropdown-header">Azioni</div>
                            <a class="dropdown-item" href="' . site_url(route_to($route_prefix . '_duplicate', $s_item->id)) . '">Duplica</a>
            ';
            foreach ($___lc_languages as $lang) {
                if ($lang->val != $___curr_lc_lang) {
                    $returnString .= '<a class="dropdown-item" href="' . site_url(route_to($route_prefix . '_duplicate_lang', $s_item->id, $lang->val)) . '">Copia in ' . $lang->nome . '</a>';
                }
            }
            $returnString .= '      
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger a_delete" href="' . site_url(route_to($route_prefix . '_delete', $s_item->id)) . '"><span class="oi oi-trash"></span> Elimina</a>
                        </div>
                    </div>
                    </div>
                    ';
                    /*   
                    <a class="btn btn-primary btn-sm" href="' . site_url(route_to($route_prefix . '_edit', $s_item->id)) . '" data-bs-toggle="tooltip" title="Modifica Pagina"><span class="oi oi-pencil"></span></a>
                    <a class="btn btn-danger btn-sm a_delete" href="' . site_url(route_to($route_prefix . '_delete', $s_item->id)) . '" data-bs-toggle="tooltip" title="Elimina Pagina"><span class="oi oi-trash"></span></a> */
            $returnString .= '</div>';
            $returnString .= lc_print_pages_index_children_sublist($s_item->children, $route_prefix);
            $returnString .= '</li>';
        }
        $returnString .= '</ul></div>';
    }

    return $returnString;
}
//--------------------------------------------------
function lc_print_children_sublist($children, $type = 'page')
{
    $returnString = '';
    if (isset($children) && is_array($children) && count($children) > 0) {
        $returnString .= '<ul>';
        foreach ($children as $sub_item) {
            $returnString .= '<li>';
            $returnString .= '
            <a 
                class="add_to_menu page_' . $sub_item->id . '"
                id="page_' . $sub_item->id . '"
                href="#"
                meta-name="' . $sub_item->nome . '" 
                meta-label="' . $sub_item->label . '" 
                meta-param="' . $sub_item->guid . '" 
                meta-parent="' . $sub_item->parent . '" 
                meta-type="' . $type . '" 
                meta-content-id="' . $sub_item->id . '"
                >' . $sub_item->nome . ' <span class="oi oi-plus"></span></a>
            ';
            $returnString .= lc_print_children_sublist($sub_item->children, $type);
            $returnString .= '</li>';
        }
        $returnString .= '</ul>';
    }

    return $returnString;
}

function mediaExist(string $path)
{
    if (is_file(FCPATH . $path)) {
        return TRUE;
    }
    return FALSE;
}

function lc_fileFormat($__img_path, $__formato = null)
{
    return lc_fileFullPath($__img_path, $__formato);
}
function lc_fileFullPath($__img_path, $__formato = null)
{
    if ($__img_path && $__img_path != '') {
        return env('custom.media_root_path') . (($__formato && trim($__formato)) ? $__formato . '/' : '') . $__img_path;
    }
    return false;
}
