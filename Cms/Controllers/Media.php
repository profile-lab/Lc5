<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\MediaModel;
use Lc5\Data\Models\MediaformatModel;

use Lc5\Data\Entities\Media as MediaEntity;

use CodeIgniter\API\ResponseTrait;



class Media extends MasterLc
{
	//--------------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Media';
		$this->route_prefix = 'lc_media';
		// 
		$this->lc_ui_date->__set('request', $this->req);
		$this->lc_ui_date->__set('route_prefix', $this->route_prefix);
		$this->lc_ui_date->__set('module_name', $this->module_name);
		// 
	}

	//--------------------------------------------------------------------
	public function index()
	{
		// 
		$media_model = new MediaModel();
		// 
		$list = $media_model->orderBy('id', 'desc')->findAll();
		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\media/index', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function delete($id)
	{
		$media_model = new MediaModel();
		if (!$curr_entity = $media_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$media_model->delete($curr_entity->id);
		return redirect()->route($this->route_prefix);

	}

	//--------------------------------------------------------------------
	public function newpost()
	{
		// 
		$media_model = new MediaModel();
		$curr_entity = new MediaEntity();
		// 
		if ($this->req->getPost()) {
			// dd($_FILES['file_up']);
			$file_up = $this->request->getFile('file_up');
			$validate_rules = [
				// 'nome' => ['label' => 'Nome', 'rules' => 'required'],
				// 'file_up' => ['label' => 'File da caricare', 'rules' => 'required'],
				// 'file_up' => ['label' => 'File da caricare', 'rules' => 'uploaded[file_up]|max_size[file_up,5000]|ext_in[file_up,jpeg,jpg,docx,pdf]'],
				'file_up' => ['label' => 'File da caricare', 'rules' => 'uploaded[file_up]|max_size[file_up,10000]|ext_in[file_up,jpeg,jpg,png,gif,svg,docx,pdf,mp4]'],

			];

			$err_mess = NULL;
			$curr_entity->fill($this->req->getPost());


			if ($this->validate($validate_rules)) {

				if ($file_up) {
					if ($file_up->isValid() && !$file_up->hasMoved()) {
						$curr_entity->nome = str_replace('.' . $file_up->getExtension(), '', $file_up->getName());
						$curr_entity->tipo_file = $file_up->getExtension();
						$curr_entity->mime = $file_up->getMimeType();
						$curr_entity->is_image = ($this->fileType($curr_entity->tipo_file) == 'image');
						if ($file_path = $this->uploadFile($file_up, NULL, $curr_entity->is_image, $curr_entity->mime)) {
							$curr_entity->path = $file_path['path'];
							if ($curr_entity->is_image) {
								$curr_entity->image_width = $file_path['image_width'];
								$curr_entity->image_height = $file_path['image_height'];
							}
						} else {
							$err_mess = 'Errore durante l\'upload del file';
						}
					}
				}
				if (!$err_mess) {
					$curr_entity->status = 1;
					$curr_entity->id_app = 1;

					$media_model->save($curr_entity);
					// 
					$new_id = $media_model->getInsertID();
					// 
					return redirect()->route($this->route_prefix . '_edit', [$new_id]);
				}
			} else {
				$err_mess = $this->lc_parseValidator($this->validator->getErrors());
			}

			if ($err_mess) {
				$this->lc_ui_date->ui_mess = $this->lc_parseValidator($this->validator->getErrors()) . '<br />Filetype: ' . $file_up->getMimeType();
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\media/new', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function rigeneraAllFormati($id)
	{	
		// 
		$media_model = new MediaModel();
		if (!$curr_entity = $media_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// $mediaformat_model = new MediaformatModel();

		$formati =  $this->getImgFormati();
		foreach($formati as $formato){
			$this->makeFormato($curr_entity->path, $formato, 'uploads');
		}

		// 
		return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);

	}

	//--------------------------------------------------------------------
	public function rigeneraFormato($id, $format_id)
	{
		// 
		$media_model = new MediaModel();
		if (!$curr_entity = $media_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$mediaformat_model = new MediaformatModel();
		if (!$formato = $mediaformat_model->asArray()->find($format_id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// 
		$this->makeFormato($curr_entity->path, $formato, 'uploads');

		// 
		return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);
	}
	//--------------------------------------------------------------------
	public function rotate($id, $format_id)
	{
		// 
		$media_model = new MediaModel();
		if (!$curr_entity = $media_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$mediaformat_model = new MediaformatModel();
		if (!$formato = $mediaformat_model->asArray()->find($format_id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// 

		$folder = 'uploads';
		// 
		$image = \Config\Services::image()->withFile(FCPATH . '' . $folder . '/' . $curr_entity->path)->rotate(270);
		if (trim($formato['folder'])) {
			if (!is_dir(FCPATH . $folder . '/' . $formato['folder'])) {
				mkdir(FCPATH . $folder . '/' . $formato['folder'], 0755, true);
			}
		}

		$image->save(FCPATH . $folder . '/' . (trim($formato['folder']) ? $formato['folder'] . '/' : '') . $curr_entity->path, 90);
		// 




		// 
		return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);
	}

	//--------------------------------------------------------------------
	public function crop($id, $format_id)
	{
		// 
		$media_model = new MediaModel();
		if (!$curr_entity = $media_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$mediaformat_model = new MediaformatModel();
		if (!$formato = $mediaformat_model->asArray()->find($format_id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// 

		// dd($curr_entity);

		if ($this->req->getPost()) {
			$validate_rules = [
				'naturalWidth' => ['rules' => 'required'],
				'naturalHeight' => ['rules' => 'required'],
				'dataX' => ['rules' => 'required'],
				'dataY' => ['rules' => 'required'],
				'dataWidth' => ['rules' => 'required'],
				'dataHeight' => ['rules' => 'required'],

			];

			$folder = 'uploads';
			if ($this->validate($validate_rules)) {
				if (trim($formato['folder'])) {
					if (!is_dir(FCPATH . $folder . '/' . $formato['folder'])) {
						mkdir(FCPATH . $folder . '/' . $formato['folder'], 0755, true);
					}
				}
				$dataX		 	= $this->req->getPost('dataX');
				$dataY		 	= $this->req->getPost('dataY');
				$dataWidth	 	= $this->req->getPost('dataWidth');
				$dataHeight 	= $this->req->getPost('dataHeight');

				$imageFile = WRITEPATH . '' . $folder . '/' . $curr_entity->path;
				$final_img = imagecreatetruecolor($dataWidth, $dataHeight);
				if ($curr_entity->mime == 'image/png') {
					imagesavealpha($final_img, true);
					$color = imagecolorallocatealpha($final_img, 0, 0, 0, 127);
					imagefill($final_img, 0, 0, $color);
					// imagealphablending($final_img, true);
					$image_2 = imagecreatefrompng($imageFile);
					imagecopy($final_img, $image_2, ceil($dataX * -1), ceil($dataY * -1) + 2, 0, 0, $curr_entity->image_width, $curr_entity->image_height);
					imagepng($final_img, FCPATH . '' . $folder . '/' . (trim($formato['folder']) ? $formato['folder'] . '/' : '') . $curr_entity->path);
				} elseif ($curr_entity->mime == 'image/gif') {
					$color = imagecolorallocate($final_img, 255, 255, 255);
					imagefill($final_img, 0, 0, $color);
					$image_2 = imagecreatefromgif($imageFile);
					imagecopy($final_img, $image_2, ceil($dataX * -1), ceil($dataY * -1) + 2, 0, 0, $curr_entity->image_width, $curr_entity->image_height);
					imagegif($final_img, FCPATH . '' . $folder . '/' . (trim($formato['folder']) ? $formato['folder'] . '/' : '') . $curr_entity->path);
				} else {
					$color = imagecolorallocate($final_img, 255, 255, 255);
					imagefill($final_img, 0, 0, $color);
					$image_2 = imagecreatefromjpeg($imageFile);
					imagecopy($final_img, $image_2, ceil($dataX * -1), ceil($dataY * -1) + 2, 0, 0, $curr_entity->image_width, $curr_entity->image_height);
					imagejpeg($final_img, FCPATH . '' . $folder . '/' . (trim($formato['folder']) ? $formato['folder'] . '/' : '') . $curr_entity->path);
				}

				

				$image = \Config\Services::image()->withFile(FCPATH . '' . $folder . '/' . (trim($formato['folder']) ? $formato['folder'] . '/' : '') . $curr_entity->path);
				if ($formato['w'] > 0 && $formato['h'] > 0) {
					$image->resize($formato['w'], $formato['h'], true, 'auto');
				} elseif ($formato['w'] > 0) {
					$image->resize($formato['w'], $formato['h'], true, 'auto');
				} elseif ($formato['h'] > 0) {
					$image->resize($formato['w'], $formato['h'], true, 'auto');
				} else {
				}
				$image->save(FCPATH . $folder . '/' . (trim($formato['folder']) ? $formato['folder'] . '/' : '') . $curr_entity->path, 90);

				// ob_start();
				// imagepng($final_img);
				// $watermarkedImg = ob_get_contents();
				// ob_end_clean(); 
				// header('Content-Type: image/png');
				// echo $watermarkedImg;
				// exit();

				//------------------------------------------------
				// versione solo libreria codeigniter
				// versione solo libreria codeigniter
				//------------------------------------------------
				// 	$image = \Config\Services::image()->withFile(WRITEPATH . '' . $folder . '/' . $curr_entity->path);
				// 	$image->crop($dataWidth, $dataHeight, $dataX, $dataY,  false, 'auto');
				// 	if ($formato['w'] > 0 && $formato['h'] > 0) {
				// 		$image->resize($formato['w'], $formato['h'], true, 'auto');
				// 	} elseif ($formato['w'] > 0) {
				// 		$image->resize($formato['w'], $formato['h'], true, 'auto');
				// 	} elseif ($formato['h'] > 0) {
				// 		$image->resize($formato['w'], $formato['h'], true, 'auto');
				// 	} else {
				// 	}
				// 	$image->save(FCPATH . $folder . '/' . (trim($formato['folder']) ? $formato['folder'] . '/' : '') . $curr_entity->path, 90);
				//------------------------------------------------
				// versione solo libreria codeigniter
				// versione solo libreria codeigniter
				//------------------------------------------------


				return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);
			}
		}





		// 
		$this->lc_ui_date->formato = $formato;
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\media/crop', $this->lc_ui_date->toArray());
	}
	//--------------------------------------------------------------------
	public function getOriginal($id)
	{
		// 
		$media_model = new MediaModel();
		if (!$curr_entity = $media_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// 

		// $file = new \CodeIgniter\Files\File( WRITEPATH.'uploads/'.$curr_entity->path );
		// dd($file );
		$image = file_get_contents(WRITEPATH . 'uploads/' . $curr_entity->path);
		header('Content-type: ' . $curr_entity->mime . ';');
		header("Content-Length: " . strlen($image));
		header('Content-Disposition: inline; filename="' . $curr_entity->path . '";'); // sends filename header

		exit($image);
	}

	//--------------------------------------------------------------------
	public function edit($id)
	{
		// 
		$media_model = new MediaModel();
		if (!$curr_entity = $media_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// 

		// 
		if ($this->req->getPost()) {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
				// 'file_up' => ['label' => 'File da caricare', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			// 
			if ($this->validate($validate_rules)) {
				if ($file_up = $this->request->getFile('file_up')) {
					if ($file_up->isValid() && !$file_up->hasMoved()) {
						$curr_entity->nome = str_replace('.' . $file_up->getExtension(), '', $file_up->getName());
						$curr_entity->tipo_file = $file_up->getExtension();
						$curr_entity->mime = $file_up->getMimeType();
						$curr_entity->is_image = ($this->fileType($curr_entity->tipo_file) == 'image');
						if ($file_path = $this->uploadFile($file_up, NULL, $curr_entity->is_image, $curr_entity->mime)) {
							$curr_entity->path = $file_path['path'];
							$curr_entity->guid = $curr_entity->path;

							if ($curr_entity->is_image) {
								$curr_entity->image_width = $file_path['image_width'];
								$curr_entity->image_height = $file_path['image_height'];
							}
						} else {
							$err_mess = 'Errore durante l\'upload del file';
						}
					}
				}
				$media_model->save($curr_entity);
				// 
				return redirect()->route($this->route_prefix . '_edit', [$curr_entity->id]);
			} else {
				$this->lc_ui_date->ui_mess = $this->lc_parseValidator($this->validator->getErrors());
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->img_formati = null;
		if ($curr_entity->is_image) {
			$this->lc_ui_date->img_formati = $this->getImgFormati();
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\media/scheda', $this->lc_ui_date->toArray());
	}

	use ResponseTrait;
	//--------------------------------------------------------------------
	public function ajaxList()
	{
		$media_model = new MediaModel();
		$qb = $media_model->select('id, status, nome, path, tipo_file, mime, is_image'); //->orderBy('id', 'desc')->findAll();
		if ($this->req->getGet('type') == 'img') {
			$qb->where('is_image', 1);
		}
		$list = $qb->orderBy('id', 'desc')->findAll();
		return $this->respond($list);
	}
	//--------------------------------------------------------------------
	public function ajaxUpload()
	{

		// 
		$media_model = new MediaModel();
		$curr_entity = new MediaEntity();
		// 
		if ($this->req->getPost()) {
			$validate_rules = [
				'file' => ['label' => 'File da caricare', 'rules' => 'uploaded[file]|max_size[file,10000]|ext_in[file,jpeg,jpg,png,gif,svg,docx,pdf,mp4]'],
			];

			$err_mess = NULL;
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {

				if ($file_up = $this->request->getFile('file')) {
					if ($file_up->isValid() && !$file_up->hasMoved()) {
						$curr_entity->nome = str_replace('.' . $file_up->getExtension(), '', $file_up->getName());
						$curr_entity->tipo_file = $file_up->getExtension();
						$curr_entity->mime = $file_up->getMimeType();
						$curr_entity->is_image = ($this->fileType($curr_entity->tipo_file) == 'image');
						if ($file_path = $this->uploadFile($file_up, NULL, $curr_entity->is_image, $curr_entity->mime)) {
							$curr_entity->path = $file_path['path'];
							if ($curr_entity->is_image) {
								$curr_entity->image_width = $file_path['image_width'];
								$curr_entity->image_height = $file_path['image_height'];
								$curr_entity->formati = $file_path['formati'];
							}
						} else {
							$err_mess = 'Errore durante l\'upload del file';
						}
					}
				}
				if (!$err_mess) {
					$curr_entity->status = 1;
					$curr_entity->id_app = 1;

					$media_model->save($curr_entity);
					// 
					$new_id = $media_model->getInsertID();
					$curr_entity->id = $new_id;
					// 
					$new_entity = $media_model->find($new_id);
					// 
					return $this->respondCreated($new_entity);
					// return $this->respondCreated();
				}
			} else {
				$err_mess = $this->lc_parseValidator($this->validator->getErrors());
				return $this->failValidationError($err_mess);
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return $this->respondNoContent();
		// return view('Lc5\Cms\Views\media/scheda', $this->lc_ui_date->toArray());


		/*
		$config['upload_path']          = $this->config->item('upload_folder');
		$config['allowed_types']        = 'gif|jpg|jpeg|png';
		$config['max_size']             = 0;
		$config['max_width']            = 0;
		$config['max_height']           = 0;

		$this->load->library('upload', $config);

		if (! $this->upload->do_upload('file')) {
			$this->ui_data->status = 'error';
			$this->ui_data->error_mess = $this->upload->display_errors();
			$this->ui_data->upload_data = $this->upload->data();
			$this->ui_data->fileid = null;
		} else {
			$uploadedImage = $this->upload->data();
// 			$formati = $this->config->item('file_format');
			$formati_all = $this->config->item('file_format');
			$formati = $formati_all[id_app];
			foreach ($formati as $formato) {
				$this->resizeImage($uploadedImage['file_name'], $formato, $uploadedImage['file_type']);
			}
			$this->ui_data->status = 'ok';
			$this->ui_data->error_mess = $this->upload->display_errors();
			$this->ui_data->upload_data = $this->upload->data();
			if (!$insId = $this->model->createROW($uploadedImage)) {
				$this->ui_data->error_mess = 'DB write error!';
			}
			$this->ui_data->fileid = $insId;
		}
		$this->load->view($this->views_base_folder.'/upload_success', $this->ui_data);
		*/
	}


	//--------------------------------------------------------------------
	private function fileType($ext)
	{
		$mime_types = array(
			'png' => 'image',
			'jpeg' => 'image',
			'jpg' => 'image',
			'gif' => 'image',
			'svg' => 'svg',

			'zip' => 'archive',
			'rar' => 'archive',

			'mp3' => 'audio',
			'qt' => 'video',
			'mov' => 'video',

			'pdf' => 'pdf',

			'doc' => 'doc',
			'rtf' => 'doc',
			'txt' => 'doc',
			'html' => 'doc',
			'json' => 'doc',
			'xml' => 'doc',
			'css' => 'doc',
			'js' => 'doc',
		);

		if (isset($mime_types[$ext])) {
			return $mime_types[$ext];
		}
		return FALSE;
	}
}
