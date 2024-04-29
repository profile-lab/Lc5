<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\PoststypesModel;
use Lc5\Data\Models\PostTagsModel;
use Lc5\Data\Entities\PostTag;

use CodeIgniter\API\ResponseTrait;


class PostsTags extends MasterLc
{
	// private $post_attributes;

	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Tags Posts';
		$this->route_prefix = 'lc_posts_tags';
		// 
		$this->lc_ui_date->__set('request', $this->req);
		$this->lc_ui_date->__set('route_prefix', $this->route_prefix);
		$this->lc_ui_date->__set('module_name', $this->module_name);

	}
	
	//--------------------------------------------------------------------
	private function getPostType($post_type_val)
	{
		// 
		$poststypes_model = new PoststypesModel();
		
		if (!$post_type_entity = $poststypes_model->where('val', $post_type_val)->first()) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		// 
		$this->lc_ui_date->__set('currernt_module', 'posts_'.$post_type_entity->val);
		$this->lc_ui_date->__set('currernt_module_action', 'poststags');
		$this->lc_ui_date->__set('post_type_guid', $post_type_entity->val);
		return $post_type_entity;
	}

	
	
	//--------------------------------------------------------------------
	public function index($post_type_val)
	{
		// 
		$post_tags_model = new PostTagsModel();
		// 
		$post_type_entity = $this->getPostType($post_type_val);
		// 
		$list = $post_tags_model->where('post_type',$post_type_entity->id )->findAll();
		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\posts-tags/index', $this->lc_ui_date->toArray());
	}


	//--------------------------------------------------------------------
	use ResponseTrait;
	public function ajaxCreate($post_type_val)
	{
		$post_tags_model = new PostTagsModel();
		$curr_entity = new PostTag();
		// 
		$post_type_entity = $this->getPostType($post_type_val);
		// 
		// dd($this->post_attributes); 
		// // 
		// $validate_rules = [
		// 	'nome' => ['label' => 'Nome', 'rules' => 'required'],
		// ];
		// $is_falied = TRUE;
		if ($this->req->getPost()) {
			$my_nome = $this->req->getPost('nome');
			$my_val = url_title(trim($my_nome), '-', TRUE);
			// 
			if ($old_entity = $post_tags_model->where('val', $my_val)->where('post_type', $post_type_entity->id)->first()) {
				return $this->respondCreated($old_entity);
			}
			// 
			$curr_entity->nome = $my_nome;
			$curr_entity->val = $my_val;	
			$curr_entity->post_type = $post_type_entity->id ;
			$curr_entity->status = 1;
			$post_tags_model->insert($curr_entity);
			$new_id = $post_tags_model->getInsertID();
			if (!$new_entity = $post_tags_model->find($new_id)) {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}
			return $this->respondCreated($new_entity);
			// return $this->respond($new_entity);

		} else {
			return $this->failUnauthorized('Invalid Method');
		}

	}


	//--------------------------------------------------------------------
	public function newpost($post_type_val)
	{
		// 
		$post_tags_model = new PostTagsModel();
		$curr_entity = new PostTag();
		// 
		$post_type_entity = $this->getPostType($post_type_val);
		// 
		// dd($this->post_attributes); 
		// 
		if ($this->req->getPost()) {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				$curr_entity->status = 1;
				$curr_entity->post_type = $post_type_entity->id ;
				// $curr_entity->id_app = 1;
				if(!$this->req->getPost('val')){
					$curr_entity->val = url_title(trim($this->req->getPost('nome')), '-', TRUE);				
				}
				$post_tags_model->save($curr_entity);
				// 
				$new_id = $post_tags_model->getInsertID();
				// 
				// $this->editEntityRows($new_id, 'pages');
				// 
				return redirect()->route($this->route_prefix . '_edit', [$post_type_val, $new_id]);
			} else {
				$errMess = $this->lc_parseValidator($this->validator->getErrors());
			}
			if ($is_falied) {
				$this->lc_ui_date->ui_mess =  ((isset($errMess)) ? $errMess : 'Utente non trovato! Controlla i dati inseriti!');
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\posts-tags/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function edit($post_type_val, $id)
	{

		$post_tags_model = new PostTagsModel();
		if (!$curr_entity = $post_tags_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}

		$post_type_entity = $this->getPostType($post_type_val);
		// 
		// 
		// dd($this->post_attributes); 
		// 
		if ($this->req->getPost()) {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				$curr_entity->status = 1;
				if(!$this->req->getPost('val')){
					$curr_entity->val = url_title(trim($this->req->getPost('nome')), '-', TRUE);				
				}
				if($curr_entity->hasChanged('nome') || $curr_entity->hasChanged('val')){
					$post_tags_model->save($curr_entity);
				}
				// 
				return redirect()->route($this->route_prefix . '_edit', [$post_type_val, $curr_entity->id]);
			} else {
				$errMess = $this->lc_parseValidator($this->validator->getErrors());
			}
			if ($is_falied) {
				$this->lc_ui_date->ui_mess =  ((isset($errMess)) ? $errMess : 'Utente non trovato! Controlla i dati inseriti!');
				$this->lc_ui_date->ui_mess_type = 'alert alert-danger';
			}
		}
		// 
		$this->lc_ui_date->entity = $curr_entity;
		return view('Lc5\Cms\Views\posts-tags/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function delete($post_type_val, $id)
	{
		$post_tags_model = new PostTagsModel();
		if (!$curr_entity = $post_tags_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$post_tags_model->delete($curr_entity->id);
		return redirect()->route($this->route_prefix, [$post_type_val]);

	}
	
	//--------------------------------------------------------------------
	public function dataList($post_type_val = null)
	{
        $fake_array = [
           (object) ["text" => "Afghanistan", "value" => "Afghanistan"],
           (object) ["text" => "Albania", "value" => "Albania"],
           (object) ["text" => "Algeria", "value" => "Algeria"],
           (object) ["text" => "Angola", "value" => "Angola"]
        ];
        return $this->respond($fake_array);


		// // 
		// $post_tags_model = new PostTagsModel();
		// // 
		// $post_type_entity = $this->getPostType($post_type_val);
		// // 
		// $list = $post_tags_model->where('post_type',$post_type_entity->id )->findAll();
		// $this->lc_ui_date->list = $list;
		// // 
		// return view('Lc5\Cms\Views\posts-tags/index', $this->lc_ui_date->toArray());
	}
}
