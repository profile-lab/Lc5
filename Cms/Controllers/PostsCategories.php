<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\PoststypesModel;
use Lc5\Data\Models\PostscategoriesModel;
use Lc5\Data\Entities\Postscategory;

class PostsCategories extends MasterLc
{
	// private $post_attributes;

	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Categorie Posts';
		$this->route_prefix = 'lc_posts_cat';
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
		$this->lc_ui_date->__set('currernt_module', 'posts_' . $post_type_entity->val);
		$this->lc_ui_date->__set('currernt_module_action', 'postscategories');
		$this->lc_ui_date->__set('post_type_guid', $post_type_entity->val);
		return $post_type_entity;
	}

	//--------------------------------------------------------------------
	public function index($post_type_val)
	{
		// 
		$postscat_model = new PostscategoriesModel();
		// 
		$post_type_entity = $this->getPostType($post_type_val);
		// 
		$list = $postscat_model->where('post_type', $post_type_entity->id)->findAll();
		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\posts-categories/index', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function newpost($post_type_val)
	{
		// 
		$postscat_model = new PostscategoriesModel();
		$curr_entity = new Postscategory();
		// 
		$post_type_entity = $this->getPostType($post_type_val);
		// 
		// dd($this->post_attributes); 
		// 
		if ($this->req->getMethod() == 'post') {
			$validate_rules = [
				// 'nome' => ['label' => 'Nome', 'rules' => 'required'],
				'titolo' => ['label' => 'Titolo', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				$curr_entity->nome = $curr_entity->titolo;
				$curr_entity->status = 0;
				$curr_entity->public = 0;
				$curr_entity->post_type = $post_type_entity->id;
				// $curr_entity->id_app = 1;
				$postscat_model->save($curr_entity);
				// 
				$new_id = $postscat_model->getInsertID();
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
		return view('Lc5\Cms\Views\posts-categories/new', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function edit($post_type_val, $id)
	{

		$postscat_model = new PostscategoriesModel();
		if (!$curr_entity = $postscat_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$post_type_entity = $this->getPostType($post_type_val);
		// 
		// 
		if ($curr_entity->created_at == $curr_entity->updated_at) {
			$curr_entity->public = 1;
		}
		// 
		if ($this->req->getMethod() == 'post') {
			$validate_rules = [
				// 'nome' => ['label' => 'Nome', 'rules' => 'required'],
				'titolo' => ['label' => 'Titolo', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			if ($this->validate($validate_rules)) {
				if ($curr_entity->created_at == $curr_entity->updated_at) {
					$curr_entity->status = 1;
				}
				$curr_entity->public = $this->req->getPost('public') ? 1 : 0 ;
				if ($curr_entity->hasChanged()) {
					$postscat_model->save($curr_entity);
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
		return view('Lc5\Cms\Views\posts-categories/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function delete($post_type_val, $id)
	{
		$postscat_model = new PostscategoriesModel();
		if (!$curr_entity = $postscat_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		$postscat_model->delete($curr_entity->id);
		return redirect()->route($this->route_prefix, [$post_type_val]);
	}

	// //--------------------------------------------------------------------
	// private function getListParents($post_type_id, $exclude_id = null)
	// {
	// 	// 
	// 	$posts_model = new PostsModel();
	// 	// 
	// 	$list_qb = $posts_model->select('id as val, nome')->asObject()->where('post_type',$post_type_id );
	// 	if($exclude_id){
	// 		$list_qb->where('id !=',$exclude_id );
	// 	}
	// 	return $list_qb->findAll();
	// }
	// //--------------------------------------------------------------------
	// private function getListPoststypeCategories($post_type_id)
	// {
	// 	// 
	// 	$posts_model = new PostsModel();
	// 	// 
	// 	$list_qb = $posts_model->select('id as val, nome')->asObject()->where('post_type',$post_type_id );
	// 	return $list_qb->findAll();
	// }
}
