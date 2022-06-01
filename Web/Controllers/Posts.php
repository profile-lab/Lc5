<?php

namespace Lc5\Web\Controllers;

use Lc5\Data\Models\PoststypesModel;
use Lc5\Data\Models\PostscategoriesModel;
use Lc5\Data\Models\PostsModel;
use Lc5\Data\Models\PostTagsModel;

// use Lc5\Data\Entities\Poststype;
// use Lc5\Data\Entities\Post;

class Posts extends MasterWeb
{
    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
        // 
        $this->web_ui_date->__set('request', $this->req);
        // $this->web_ui_date->__set('route_prefix', $this->route_prefix);
        // $this->web_ui_date->__set('module_name', $this->module_name);
        // 
    }

    //--------------------------------------------------------------------
    public function archivioDefault()
    {
        $poststypes_model = new PoststypesModel();
        $poststypes_model->setForFrontemd();
        if (!$curr_entity = $poststypes_model->asObject()->first()) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return redirect()->to(uri_string() . '/' . $curr_entity->val);
    }

    //--------------------------------------------------------------------
    public function index($post_type_val)
    {
        // 
        $cur_post_cat_obj = null;
        $__curr_p_cat_guid = $this->req->getGet('p-cat') ?: null;
        $cur_post_tag_obj = null;
        $__curr_p_tag_guid = $this->req->getGet('p-tag') ?: null;
        // 


        $poststypes_model = new PoststypesModel();
        $poststypes_model->setForFrontemd();
        $postscategory_model = new PostscategoriesModel();
        $postscategory_model->setForFrontemd();
        $posttags_model = new PostTagsModel();
        $posttags_model->setForFrontemd();
        if (!$curr_entity = $poststypes_model->where('val', $post_type_val)->asObject()->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // REDIRECT TO ARCHIVE WEB PAGE 
        if(isset($curr_entity->archive_root) && trim($curr_entity->archive_root)){
            return redirect()->to(route_to(__locale_uri__ . 'web_page', $curr_entity->archive_root));
        }
        // REDIRECT TO ARCHIVE WEB PAGE 
        // 
        $this->getPoststypesFieldsConfig($curr_entity); 
        $orderby =  (isset($curr_entity->post_order) && $curr_entity->post_order != '') ? $curr_entity->post_order : 'id';
        $sortby =  (isset($curr_entity->post_sort) && $curr_entity->post_sort != '') ? $curr_entity->post_sort : 'DESC';
        $pagination_limit =  (isset($curr_entity->post_per_page) && $curr_entity->post_per_page != '') ? $curr_entity->post_per_page : __post_per_page__;
        // 
        $curr_entity->posts_archive_name = $curr_entity->nome;
        $curr_entity->posts_archive_index = route_to(__locale_uri__ . 'web_posts_archive', $curr_entity->val);
        // 
        $curr_entity->posts_castegories = $postscategory_model->where('post_type', $curr_entity->id)->asObject()->findAll();
        if ($__curr_p_cat_guid) {
            $cur_post_cat_obj = $postscategory_model->where('guid', $__curr_p_cat_guid)->asObject()->first();
        }
        // 
        $curr_entity->posts_tags = $posttags_model->where('post_type', $curr_entity->id)->asObject()->findAll();
        if ($__curr_p_tag_guid) {
            $cur_post_tag_obj = $posttags_model->where('val', $__curr_p_tag_guid)->asObject()->first();
        }
        // 
        $posts_model = new PostsModel();
        $posts_model->setForFrontemd();
        $posts_qb = $posts_model->where('post_type', $curr_entity->id);
        if ($cur_post_cat_obj) {
            $posts_qb->where('category', $cur_post_cat_obj->id);
        }
        if ($cur_post_tag_obj) {
            $posts_qb->like('tags', '"' . $cur_post_tag_obj->id . '"', 'both');
        }

       
        

        // if(isset($curr_entity->post_attributes['data_pub']) && $curr_entity->post_attributes['data_pub']){
        //     $orderby = 'data_pub';
        //     $sortby = 'DESC';
        // }


        // $data = [
        //     'users' => $model->paginate(10),
        //     'pager' => $model->pager,
        // ];


        if ($posts_archive = $posts_qb->asObject()->orderby('ordine', $sortby)->orderby($orderby, $sortby)->orderby('id', $sortby)->paginate($pagination_limit)) {
            foreach ($posts_archive as $post) {
                $post->abstract = word_limiter(strip_tags($post->testo), 20);
                // $post->abstract = character_limiter(strip_tags( $post->testo ), 100);
                $post->permalink = route_to(__locale_uri__ . 'web_posts_single', $curr_entity->val, $post->guid);
                if (isset($post->category) && $post->category > 0) {
                    $post->curr_category = $postscategory_model->asObject()->find($post->category);
                }
            }
            $curr_entity->posts_archive = $posts_archive;
        }
        if($posts_qb->pager->getTotal() > $posts_qb->pager->getPerPage() ){
            $curr_entity->pager =  $posts_qb->pager;
        }
        $this->web_ui_date->fill((array)$curr_entity);


        //
        if (appIsFile('Views/' .  $this->base_view_folder . 'post-archive-' . $curr_entity->val . '.php')) {
            return view($this->base_view_folder . 'post-archive-' .  $curr_entity->val, $this->web_ui_date->toArray());
        }

        return view($this->base_view_folder . 'post-archive-default', $this->web_ui_date->toArray());
    }

    //--------------------------------------------------------------------
    public function post($post_type_val, $guid) // = false, $seg2 = false, $seg3 = false, $seg4 = false, $seg5 = false)
    {
        // 
        $poststypes_model = new PoststypesModel();
        $poststypes_model->setForFrontemd();
        $postscategory_model = new PostscategoriesModel();
        $postscategory_model->setForFrontemd();
        $posttags_model = new PostTagsModel();
        $posttags_model->setForFrontemd();
        $posts_model = new PostsModel();
        $posts_model->setForFrontemd();
        if (!$curr_post_type = $poststypes_model->where('val', $post_type_val)->asObject()->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $qb = $posts_model->asObject()->orderBy('id', 'DESC');
        $qb->where('guid', $guid);
        $qb->where('post_type', $curr_post_type->id);
        if (!$curr_entity = $qb->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // 
        $curr_entity->posts_archive_name = $curr_post_type->nome;
        $curr_entity->posts_archive_index = route_to(__locale_uri__ . 'web_posts_archive', $curr_post_type->val);
        $curr_category = null;
        if ($curr_entity->category) {
            $curr_category = $postscategory_model->asObject()->find($curr_entity->category);
        }
        // 
        $curr_tags = null;
        if (isset($curr_entity->tags) && count($curr_entity->tags) > 0) {
            $ids_tags = [];
            foreach ($curr_entity->tags as $tag_item) {
                $ids_tags[] = $tag_item;
            }
            $curr_tags = $posttags_model->whereIn('id', $ids_tags)->asObject()->findAll();
        }

        // 
        $custom_parameters = null;
        if (isset($curr_entity->entity_free_values_object) && is_array($curr_entity->entity_free_values_object) && count($curr_entity->entity_free_values_object) > 0) {
            $custom_parameters = new \stdClass();
            foreach ($curr_entity->entity_free_values_object as $free_val) {
                $curr_entity->{url_title($free_val->key, '_', TRUE)} =  $free_val->value;
                $custom_parameters->{url_title($free_val->key, '_', TRUE)} =  $free_val->value;
            }
        }
        $curr_entity->entity_custom_parameters = $custom_parameters;
        // 
        $curr_entity->post_type_obj = $curr_post_type;
        $curr_entity->category_obj = $curr_category;
        $curr_entity->tags_obj = $curr_tags;
        $this->web_ui_date->fill((array)$curr_entity);
        // 
        $this->web_ui_date->entity_rows = $this->getEntityRows($curr_entity->id, 'posts');
        //
        if (appIsFile('Views/' .  $this->base_view_folder . 'post-' . $curr_post_type->val . '.php')) {
            return view($this->base_view_folder . 'post-' .  $curr_post_type->val, $this->web_ui_date->toArray());
        }
        return view($this->base_view_folder . 'post-default', $this->web_ui_date->toArray());
    }

    //--------------------------------------------------------------------
    //--------------------------------------------------------------------
    // ---- TOOLS ----
    //--------------------------------------------------------------------
    //--------------------------------------------------------------------


}
