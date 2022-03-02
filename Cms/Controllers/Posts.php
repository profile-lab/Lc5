<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\PoststypesModel;
use Lc5\Data\Models\PostscategoriesModel;
use Lc5\Data\Models\PostTagsModel;
use Lc5\Data\Models\PostsModel;
use Lc5\Data\Models\RowsModel;
use Lc5\Data\Entities\Poststype;
use Lc5\Data\Entities\Post;
use CodeIgniter\I18n\Time;

class Posts extends MasterLc
{
	private $post_attributes;

	public function __construct()
	{
		parent::__construct();
		// 
		$this->module_name = 'Posts';
		$this->route_prefix = 'lc_posts';
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
		$this->post_attributes = [];
		// 
		// 
		$entity_fields_conf = [];
		$entity_fields_conf_byjson = json_decode($post_type_entity->fields_config);
		if (json_last_error() === JSON_ERROR_NONE) {
			$entity_fields_conf = $entity_fields_conf_byjson->fields;
		}
		// $entity_fields_conf = json_decode($post_type_entity->fields_config)->fields;
		foreach ($post_type_entity->post_attributes as $post_attr) {
			if (in_array($post_attr['name'], $entity_fields_conf)) {
				$this->post_attributes[$post_attr['name']] = $post_attr;
			}
		}
		// 
		// 
		// $this->lc_ui_date->__set('currernt_module', 'post_' . $post_type_entity->val);
		$this->lc_ui_date->__set('currernt_module', $this->current_lc_module.'_'.$post_type_entity->val);


		$this->lc_ui_date->__set('post_type_guid', $post_type_entity->val);
		$this->lc_ui_date->__set('post_attributes', $this->post_attributes);
		$this->lc_ui_date->__set('post_type_entity', $post_type_entity);

		$this->lc_ui_date->__set('module_name', $post_type_entity->nome);


		return $post_type_entity;
	}

	//--------------------------------------------------------------------
	public function index($post_type_val)
	{
		// 
		$posts_model = new PostsModel();
		// 
		$post_type_entity = $this->getPostType($post_type_val);
		// 
		$list = $posts_model->where('post_type', $post_type_entity->id)->findAll();
		foreach ($list as $s_post) {
			$s_post->frontend_guid = null;
			if ($app_domain = $this->getAppDataField('domain')) {
				$s_post->frontend_guid = reduce_double_slashes( $app_domain . '/' .
					(($this->curr_lc_lang != $this->default_lc_lang) ? $this->curr_lc_lang . '/' : '') .
					$this->current_archive_base_root . $post_type_entity->val . '/' .
					$s_post->guid );
			}
		}



		$this->lc_ui_date->list = $list;
		// 
		return view('Lc5\Cms\Views\posts/index', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function newpost($post_type_val)
	{
		// 
		$posts_model = new PostsModel();
		$curr_entity = new Post();
		// 
		$post_type_entity = $this->getPostType($post_type_val);
		$curr_entity->poststype_categories_list = $this->getListPoststypeCategories($post_type_entity->id);
		$curr_entity->poststype_tags_list = $this->getListPoststypeTags($post_type_entity->id);
		$curr_entity->parents_list = $this->getListParents($post_type_entity->id);

		// 
		// dd($this->post_attributes); 
		// 
		if ($this->req->getMethod() == 'post') {
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
				// 'titolo' => ['label' => 'Titolo', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			$curr_entity->multi_categories = json_encode($this->req->getPost('multi_categories'));
			$curr_entity->tags = json_encode($this->req->getPost('tags'));
			if ($this->validate($validate_rules)) {
				// 
				if (!$this->req->getPost('titolo')) {
					$curr_entity->titolo = $curr_entity->nome;
				}
				// 
				if (!$this->req->getPost('ordine')) {
					$curr_entity->ordine = 500;
				}
				// 
				if (!$this->req->getPost('data_pub')) {
					$myTime = Time::today('Europe/Rome', 'en_US');
					$curr_entity->data_pub = $myTime;
				}
				// 



				$curr_entity->status = 1;
				$curr_entity->post_type = $post_type_entity->id;
				$posts_model->save($curr_entity);
				// 
				$new_id = $posts_model->getInsertID();
				// 
				$this->editEntityRows($new_id, 'posts');
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
		return view('Lc5\Cms\Views\posts/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function edit($post_type_val, $id)
	{
		$posts_model = new PostsModel();
		if (!$curr_entity = $posts_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}

		$post_type_entity = $this->getPostType($post_type_val);
		$curr_entity->poststype_categories_list = $this->getListPoststypeCategories($post_type_entity->id);
		$curr_entity->poststype_tags_list = $this->getListPoststypeTags($post_type_entity->id);
		$curr_entity->parents_list = $this->getListParents($post_type_entity->id, $id);
		// 
		$this->lc_ui_date->rows_simple_styles = $this->getRowStyles('simple');
		$this->lc_ui_date->rows_gallery_styles = $this->getRowStyles('gallery');
		$this->lc_ui_date->rows_colonne_styles = $this->getRowStyles('columns');
		$this->lc_ui_date->rows_colors = $this->getRowColors();
		$this->lc_ui_date->rows_extra_styles = $this->getRowExtraStyles();
		$this->lc_ui_date->images_formats = $this->getImgFormatiSelect();
		$this->lc_ui_date->rows_components = $this->getRowComponents();
		$this->lc_ui_date->entity_rows = $this->getEntityRows($curr_entity->id, 'posts');
		if ($app_domain = $this->getAppDataField('domain')) {
			$this->lc_ui_date->frontend_guid = reduce_double_slashes($app_domain . '/' . (($this->curr_lc_lang != $this->default_lc_lang) ? $this->curr_lc_lang . '/' : '') . $this->current_archive_base_root . $post_type_entity->val . '/' . $curr_entity->guid);
		}
		// 
		// if($curr_entity->vimeo_video_id){
		// 	$vimeo_video_model = new VimeoVideosModel();
		// }
		// 
		if ($this->req->getMethod() == 'post') {
			// echo '<pre>' , var_dump($_POST) , '</pre>';
			// exit();
			// dd($this->req->getPost('multi_categories'));
			$validate_rules = [
				'nome' => ['label' => 'Nome', 'rules' => 'required'],
				'titolo' => ['label' => 'Titolo', 'rules' => 'required'],
			];
			$is_falied = TRUE;
			$curr_entity->fill($this->req->getPost());
			$curr_entity->multi_categories = json_encode($this->req->getPost('multi_categories'));
			$curr_entity->tags = json_encode($this->req->getPost('tags'));
			if ($this->validate($validate_rules)) {
				$curr_entity->status = 1;
				// $curr_entity->post_type = $post_type_entity->id;
				$posts_model->save($curr_entity);
				// 
				$this->editEntityRows($curr_entity->id, 'posts');
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
		return view('Lc5\Cms\Views\posts/scheda', $this->lc_ui_date->toArray());
	}

	//--------------------------------------------------------------------
	public function duplicate($post_type_val, $id, $lang = null)
	{
		// 
		$posts_model = new PostsModel();
		$rows_model = new RowsModel();
		if (!$current_base_entity = $posts_model->allowCallbacks(FALSE)->asArray()->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		//
		// $post_type_entity = $this->getPostType($post_type_val);

		$current_base_entity['id'] = null;
		$current_base_entity['parent'] = 0;
		$current_base_entity['nome'] .= '-copy';
		$current_base_entity['guid'] .= '-copy';
		// $current_base_entity['post_type'] = $post_type_entity->id;

		if ($lang) {
			$current_base_entity['lang'] = $lang;
			$current_base_entity['nome'] .= '-' . $lang;
			$current_base_entity['guid'] .= '-' . $lang;
		}
		// dd($current_base_entity);
		if ($posts_model->insert($current_base_entity)) {
			$new_id = $posts_model->getInsertID();
			// 
			$current_base_entity_rows = $rows_model
				->allowCallbacks(FALSE)
				->asArray()
				->orderBy('ordine', 'ASC')
				->where('parent', $id)
				->where('modulo', 'posts')
				->findAll();
			if ($current_base_entity_rows) {
				foreach ($current_base_entity_rows as $old_entity_row) {
					$old_entity_row['id'] = null;
					$old_entity_row['parent'] = $new_id;
					if ($lang) {
						$old_entity_row['lang'] = $lang;
					}
					$rows_model->save($old_entity_row);
				}
			}
		}
		$this->lc_setErrorMess('Contenuto duplicato con successo', 'alert-success');
		return redirect()->route($this->route_prefix, [$post_type_val]);
	}

	//--------------------------------------------------------------------
	public function delete($post_type_val, $id)
	{
		$rows_model = new RowsModel();
		$posts_model = new PostsModel();
		if (!$curr_entity = $posts_model->find($id)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}

		if ($entity_rows = $this->getEntityRows($curr_entity->id, 'posts')) {
			foreach ($entity_rows as $entity_row) {
				$rows_model->delete($entity_row->id);
			}
		}

		$posts_model->delete($curr_entity->id);
		$this->lc_setErrorMess('Contenuto eliminato con successo', 'alert-warning');
		return redirect()->route($this->route_prefix, [$post_type_val]);
	}


	//--------------------------------------------------------------------
	private function getListParents($post_type_id, $exclude_id = null)
	{
		// 
		$posts_model = new PostsModel();
		// 
		$list_qb = $posts_model->select('id as val, nome')->asObject()->where('post_type', $post_type_id);
		if ($exclude_id) {
			$list_qb->where('id !=', $exclude_id);
		}
		return $list_qb->findAll();
	}
	//--------------------------------------------------------------------
	private function getListPoststypeCategories($post_type_id)
	{
		// 
		$posts_cat_model = new PostscategoriesModel();
		// 
		$list_qb = $posts_cat_model->select('id as val, nome')->asObject()->where('post_type', $post_type_id);
		return $list_qb->findAll();
	}
	//--------------------------------------------------------------------
	private function getListPoststypeTags($post_type_id)
	{
		// 
		$posts_tags_model = new PostTagsModel();
		// 
		$list_qb = $posts_tags_model->select('id as val, nome')->asObject()->where('post_type', $post_type_id);
		return $list_qb->findAll();
	}
}
