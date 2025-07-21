<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\MediaModel;
use Lc5\Data\Models\MediaformatModel;

use Lc5\Data\Entities\Media as MediaEntity;

use CodeIgniter\API\ResponseTrait;



class MediaTrash extends MasterLc
{
    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
        // 
        $this->module_name = 'Cestino Media';
        $this->route_prefix = 'lc_media_cestino';
        // 
        $this->lc_ui_date->__set('request', $this->req);
        $this->lc_ui_date->__set('route_prefix', $this->route_prefix);
        $this->lc_ui_date->__set('module_name', $this->module_name);
        $this->lc_ui_date->__set('currernt_module', 'media');
        $this->lc_ui_date->__set('currernt_module_action', 'mediacestino');
    }

    //--------------------------------------------------------------------
    public function index()
    {
        // 
        $media_model = new MediaModel();
        $mediaQB = $media_model->select('*');
        $mediaQB->onlyDeleted();
        // 
        $list = $mediaQB->orderBy('id', 'desc')->findAll();
        $this->lc_ui_date->list = $list;
        // 
        return view('Lc5\Cms\Views\media/cestino', $this->lc_ui_date->toArray());
    }


    //--------------------------------------------------------------------
    public function deleteAllFiles()
    {
        $media_model = new MediaModel();
        $mediaQB = $media_model->select('*');
        $mediaQB->onlyDeleted();
        // 
        $list = $mediaQB->orderBy('id', 'desc')->findAll( 20 );

        foreach ($list as $item) {
            $this->deleteFile($item->id, true);
        }

        return redirect()->route($this->route_prefix);
    }

    //--------------------------------------------------------------------
    public function deleteFile($id, $only_action = false)
    {
        $media_model = new MediaModel();
        if (!$curr_entity = $media_model->withDeleted()->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($curr_entity->is_image) {

            $formati = $this->getImgFormati();
            foreach ($formati as $formato) {
                $this->deleteImg($curr_entity->path, $formato, true);
            }
        }

        $this->deleteImg($curr_entity->path, null, false);
        $media_model->delete($curr_entity->id, true);

        if ($only_action == false) {
            $this->lc_ui_date->ui_mess = 'Elemento eliminato con successo.';
            $this->lc_ui_date->ui_mess_type = 'alert alert-success';

            return redirect()->route($this->route_prefix);
        } else {
            return true;
        }
    }
    //--------------------------------------------------------------------
    public function resetItem($id)
    {
        $media_model = new MediaModel();
        if (!$curr_entity = $media_model->allowCallbacks(false)->withDeleted()->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $curr_entity->deleted_at = NULL;
        $media_model->protect(false)->save($curr_entity);
        $media_model->protect(true);
        $this->lc_ui_date->ui_mess = 'Elemento ripristinato con successo.';
        $this->lc_ui_date->ui_mess_type = 'alert alert-success';
        return redirect()->route($this->route_prefix);
    }


    private function deleteImg($path, $formato = null, $is_public = false)
    {

        if ($formato) {
            // d($path, $formato['folder']);
            $pathSuServer = ($is_public) ? FCPATH . 'uploads/' . $formato['folder'] . '/' . $path : WRITEPATH . 'uploads/' . $formato['folder'] . '/' . $path;
        } else {
            $pathSuServer = ($is_public) ? FCPATH . 'uploads/' . $path : WRITEPATH . 'uploads/' . $path;
        }
        if (file_exists($pathSuServer)) {
            unlink($pathSuServer);
            d('Elimino ' . $pathSuServer);
        } else {
            // d('non esiste ' . $pathSuServer);
        }

        // $pathSuServer = WRITEPATH . 'uploads/' . $formato['folder'] . '/' . $path;

        // $path = str_replace('uploads/', '', $path);
        // $path = str_replace('thumbs/', '', $path);
        // $path = str_replace('.' . $formato, '', $path);
        // $path = $path . '.' . $formato;
    }
}
