<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\PagesModel;
use Lc5\Data\Models\PoststypesModel;
use Lc5\Data\Models\PostsModel;

class Dashboard extends MasterLc
{
	//--------------------------------------------------------------------
	public function __construct()
	{
        parent::__construct();
	}

	//--------------------------------------------------------------------
	public function index()
	{
		// 
		$pages_model = new PagesModel();
		$pages_row = (object)[
			'titolo' => 'Pagine',
			'count_items' => $pages_model->countAllResults(),
			'blocks' => []
		];
		// 
		$pages_list = $pages_model->select('id, nome, titolo, updated_at, is_home')->asObject()->orderBy('updated_at', 'DESC')->findAll(5);
		foreach($pages_list as $page){
			$page->edit_url = route_to('lc_pages_edit', $page->id);
		}
		$updated_pages_block = (object)[
			'nome' => 'Ultime pagine Modificate',
			'list' => $pages_list,
		];
		$pages_row->blocks[] =$updated_pages_block;
		// 
		$pages_list = $pages_model->select('id, nome, titolo, updated_at, is_home')->asObject()->orderBy('created_at', 'DESC')->findAll(5);
		foreach($pages_list as $page){
			$page->edit_url = route_to('lc_pages_edit', $page->id);
		}
		$created_pages_block = (object)[
			'nome' => 'Ultime pagine create',
			'list' => $pages_list,
		];
		$pages_row->blocks[] =$created_pages_block;
		// 
		$this->lc_ui_date->pages_row = $pages_row;
		// 
		// 
		
		$poststypes_model = new PoststypesModel();
		$posts_model = new PostsModel();
		$posts_row = (object)[
			'titolo' => 'Post',
			'count_items' => $pages_model->countAllResults(),
			'blocks' => []
		];
		// 

		$post_types = $poststypes_model->select('id, nome, val')->asObject()->orderBy('updated_at', 'DESC')->findAll();

		foreach($post_types as $post_type){
			$posts_list = $posts_model->select('id, nome, titolo, updated_at')->asObject()->orderBy('created_at', 'DESC')->findAll(5);
			foreach($posts_list as $post){
				$post->edit_url = route_to('lc_posts_edit', $post_type->val, $post->id);
			}
			$updated_pages_block = (object)[
				'nome' => 'Ultime ' .$post_type->nome . ' modificate',
				'list' => $posts_list,
			];
			$posts_row->blocks[] =$updated_pages_block;
		}

		$this->lc_ui_date->posts_row = $posts_row;
		// 
		// 



		return view('Lc5\Cms\Views\dashboard', $this->lc_ui_date->toArray());
	}
}
