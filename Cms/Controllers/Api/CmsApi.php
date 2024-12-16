<?php

namespace Lc5\Cms\Controllers\Api;

use Lc5\Cms\Controllers\MasterLc;
use CodeIgniter\API\ResponseTrait;


use Lc5\Data\Models\PagesModel;
use Lc5\Data\Models\PostsModel;
use Lc5\Data\Entities\VimeoVideo;
use Lc5\Data\Models\VimeoVideosModel;


class CmsApi extends MasterLc
{
    private $unauthorizedResult;
    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct(TRUE);
        $this->unauthorizedResult = (object)['status' => 401, 'body' => (object)['message' => 'unauthorized']];
    }


    //--------------------------------------------------------------------
    //--------------------------------------------------------------------
    //-- VIMEO API
    //--------------------------------------------------------------------
    //--------------------------------------------------------------------
    use ResponseTrait;
    public function getInfoVimeo() //($rel_item_id, $rel_item_type =null)
    {
        // 
        $video_model = new VimeoVideosModel();
        $request = \Config\Services::request();
        if ($request->getPost()) {
            $returnObject = (object)[
                'status' => 500,
                'body' => (object)[
                    'message' => 'internal server error'
                ]
            ];
            // 
            $video_id = $request->getPost('video_id');
            if (!$video_entity = $video_model->find($video_id)) {
                $returnObject = (object)[
                    'status' => 404,
                    'body' => (object)[
                        'message' => 'Video non trovato'
                    ]
                ];
                return $this->respond($returnObject);
            }
            if ($vimeo_resonse = $this->getVideoInfoOnVimeo($video_entity->vimeo_id)) {
                $video_vimeo_path = $vimeo_resonse['body']['uri'];
                $video_vimeo_id = str_replace('/videos/', '',  $vimeo_resonse['body']['uri']);
                if ($video_vimeo_id) {
                    // 

                    // 

                    // transcoding

                    $video_entity->vimeo_video_status = $vimeo_resonse['body']['status'];
                    $video_entity->nome = $vimeo_resonse['body']['name'];
                    $video_entity->titolo = $vimeo_resonse['body']['name'];
                    // 
                    if ($vimeo_resonse['body']['status'] == 'available') {
                        // 
                        $curr_vimeo_video_file_object = $this->getHighResVimeoVideo($vimeo_resonse['body']['files']);
                        $curr_vimeo_image_file_object = $this->getHighResVimeoImage($vimeo_resonse['body']['pictures']['sizes']);
                        $curr_vimeo_image_thumb_object = $this->getThumbVimeoImage($vimeo_resonse['body']['pictures']['sizes']);
                        // 
                        $video_entity->status = 1;
                        $video_entity->thumb_path = $curr_vimeo_image_thumb_object->link;
                        $video_entity->cover_path = $curr_vimeo_image_file_object->link;
                        $video_entity->video_path = $curr_vimeo_video_file_object->link;
                        $video_entity->vimeo_size = $curr_vimeo_video_file_object->size;
                        // 
                    }
                    if ($video_entity->hasChanged()) {
                        $video_model->save($video_entity);
                    }
                    // 
                    $returnObject = (object)[
                        'status' => 200,
                        'body' => (object)[
                            'video_vimeo_id' => $video_vimeo_id,
                            'video_uri' => $vimeo_resonse['body']['uri'],
                            'video_path' => $video_entity->video_path,
                            'cover_path' => $video_entity->cover_path,
                            'thumb_path' => $video_entity->thumb_path,
                            'vimeo_video_status' => $video_entity->vimeo_video_status,
                            'vimeo_pictures_satus' => $vimeo_resonse['body']['pictures']['active'],
                            'vimeo_pictures_default' => $vimeo_resonse['body']['pictures']['default_picture'],
                            // 'vimeo_body' => $vimeo_resonse['body']
                            'vimeo_resonse' => $vimeo_resonse,
                        ]
                    ];
                }
            }
            return $this->respond($returnObject);
        }
        return $this->respond($this->unauthorizedResult);
        // 
    }
    //--------------------------------------------------------------------
    private function getHighResVimeoVideo($videos_list = [])
    {
        $curr_video_height = 0;
        $vimeo_video_file_object = [
            'size' => 0,
            'width' => 0,
            'height' => 0,
            'fps' => 0,
            'size_short' => '',
            'quality' => '',
            'public_name' => '',
            'link' => '',
            'type' => '',
        ];
        foreach ($videos_list as $video_file) {
            if (isset($video_file['height'])) {
                if ($video_file['height'] > $curr_video_height) {
                    $vimeo_video_file_object['type'] = $video_file['type'];
                    $vimeo_video_file_object['size'] = $video_file['size'];
                    $vimeo_video_file_object['width'] = $video_file['width'];
                    $vimeo_video_file_object['height'] = $video_file['height'];
                    $vimeo_video_file_object['fps'] = $video_file['fps'];
                    $vimeo_video_file_object['size_short'] = $video_file['size_short'];
                    $vimeo_video_file_object['quality'] = $video_file['quality'];
                    $vimeo_video_file_object['public_name'] = $video_file['public_name'];
                    $vimeo_video_file_object['link'] = $video_file['link'];
                    $vimeo_video_file_object['type'] = $video_file['type'];
                    // 
                    $curr_video_height = $video_file['height'];
                }
            }
        }
        return (object) $vimeo_video_file_object;
    }
    //--------------------------------------------------------------------
    private function getHighResVimeoImage($pictures = [])
    {
        $curr_image_height = 0;
        $vimeo_image_file_object = [
            'width' => 0,
            'height' => 0,
            'link' => '',
        ];
        foreach ($pictures as $picture_file) {
            if ($picture_file['height'] > $curr_image_height) {
                $vimeo_image_file_object['width'] = $picture_file['width'];
                $vimeo_image_file_object['height'] = $picture_file['height'];
                $vimeo_image_file_object['link'] = $picture_file['link'];
                // 
                $curr_image_height = $picture_file['height'];
            }
        }
        return (object) $vimeo_image_file_object;
    }
    //--------------------------------------------------------------------
    private function getThumbVimeoImage($pictures = [], $image_thumb_height = 360)
    {
        $vimeo_image_file_object = [
            'width' => 0,
            'height' => 0,
            'link' => '',
        ];
        foreach ($pictures as $picture_file) {
            if ($picture_file['height'] == $image_thumb_height) {
                $vimeo_image_file_object['width'] = $picture_file['width'];
                $vimeo_image_file_object['height'] = $picture_file['height'];
                $vimeo_image_file_object['link'] = $picture_file['link'];
            }
        }
        return (object) $vimeo_image_file_object;
    }

    //--------------------------------------------------------------------
    use ResponseTrait;
    public function newVideoByUrl($rel_item_type, $rel_item_id)
    {
        $rel_item_model = null;
        $rel_item_entity = null;
        if ($rel_item_type && $rel_item_id) {
            if ($rel_item_type == 'pages') {
                $rel_item_model = new \Lc5\Data\Models\PagesModel();
            } else if ($rel_item_type == 'posts') {
                $rel_item_model = new \Lc5\Data\Models\PostsModel();
            } else if ($rel_item_type == 'corso') {
                $rel_item_model = new \App\Models\CorsiModel();
            } else if ($rel_item_type == 'lezione') {
                $rel_item_model = new \App\Models\CorsiLezioniModel();
            } else if ($rel_item_type == 'videolezione') {
                $rel_item_model = new \App\Models\CorsiVideoLezioniModel();
            } else if ($rel_item_type != '') {
                $classNameSpace = "App\Models\\$rel_item_type";
                if (class_exists($classNameSpace)) {
                    $rel_item_model = new $classNameSpace();
                }
            }
            // 
            if ($rel_item_model) {
              

                // $rel_item_entity = $rel_item_model->allowCallbacks(FALSE)->select(['id', 'nome', 'vimeo_video_id'])->find($rel_item_id);
                $rel_item_entity = $rel_item_model->find($rel_item_id);
            }
        }
        // 
        $video_model = new VimeoVideosModel();
        $video_entity = new VimeoVideo();
        $request = \Config\Services::request();
        if ($request->getPost()) {
            $returnObject = (object)[
                'status' => 500,
                'body' => (object)[
                    'message' => 'internal server error'
                ]
            ];
            // 
            $video_name = $request->getPost('video_name');
            $id_video_vimeo = $request->getPost('id_video_vimeo');

            $video_name = (trim($video_name)) ? $video_name : 'video';

            if ($id_video_vimeo && $vimeo_resonse = $this->getVideoInfoOnVimeo($id_video_vimeo)) {
                // exit(json_encode($vimeo_resonse));

                $video_vimeo_path = $vimeo_resonse['body']['uri'];
                $video_entity->vimeo_id = $id_video_vimeo;
                $video_entity->guid = $id_video_vimeo;
                $video_entity->vimeo_path = $video_vimeo_path;
                $video_entity->vimeo_video_status = $vimeo_resonse['body']['status'];
                $video_entity->vimeo_upload_form_action = $vimeo_resonse['body']['upload']['upload_link'];

                

                $video_entity->nome = $vimeo_resonse['body']['name'];
                $video_entity->titolo = $vimeo_resonse['body']['name'];
                // 
                if ($vimeo_resonse['body']['status'] == 'available') {
                    // 
                    $curr_vimeo_video_file_object = $this->getHighResVimeoVideo($vimeo_resonse['body']['files']);
                    $curr_vimeo_image_file_object = $this->getHighResVimeoImage($vimeo_resonse['body']['pictures']['sizes']);
                    $curr_vimeo_image_thumb_object = $this->getThumbVimeoImage($vimeo_resonse['body']['pictures']['sizes']);
                    // 
                    $video_entity->status = 1;
                    $video_entity->thumb_path = $curr_vimeo_image_thumb_object->link;
                    $video_entity->cover_path = $curr_vimeo_image_file_object->link;
                    $video_entity->video_path = $curr_vimeo_video_file_object->link;
                    $video_entity->vimeo_size = $curr_vimeo_video_file_object->size;
                    // 
                }
                if ($video_entity->hasChanged()) {
                    $video_model->save($video_entity);
                }





                $video_model->save($video_entity);



                
                if ($rel_item_entity) {
                    $rel_item_entity->vimeo_video_id = $id_video_vimeo;
                    // $rel_item_entity->vimeo_video_url = null;
                    $rel_item_entity->is_evi = 1;
                    if ($rel_item_entity->hasChanged()) {
                        $rel_item_model->allowCallbacks(FALSE)->save($rel_item_entity);
                    }
                }


               
                // // 
                // $video_entity->vimeo_id = $id_video_vimeo;
                // $video_entity->vimeo_path = $video_vimeo_path;
                // // $video_entity->lezione_id = $lezione_entity->id;
                // $video_entity->vimeo_video_status = $vimeo_resonse['body']['status'];
                // $video_entity->vimeo_upload_form_action = $vimeo_resonse['body']['upload']['upload_link'];
                // $video_model->save($video_entity);
                // // 
                // // 
                // $rel_item_entity->video_code = $id_video_vimeo;
                // $rel_item_model->save($rel_item_entity);
                // 
                // 
                $returnObject = (object)[
                    'status' => 201,
                    'body' => (object)[
                        'video_name' => $video_name,
                        'video_vimeo_id' => $id_video_vimeo,
                        'video_uri' => $vimeo_resonse['body']['uri'],
                        'vimeo_resonse' => $vimeo_resonse,
                        'video_path' => $video_entity->video_path,
                        'cover_path' => $video_entity->cover_path,
                        'vimeo_video_status' => $video_entity->vimeo_video_status,
                    ]
                    // 'body' => (object)[
                    //     'video_name' => $video_name,
                    //     'video_vimeo_id' => $id_video_vimeo,
                    //     'video_uri' => $vimeo_resonse['body']['uri'],
                    //     'vimeo_resonse' => $vimeo_resonse,
                    //     'video_path' => $video_entity->video_path,
                    //     'cover_path' => $video_entity->cover_path,
                    //     'vimeo_video_status' => $video_entity->vimeo_video_status,
                    // ]
                ];
            }

            return $this->respond($returnObject);
        }
        return $this->respond($this->unauthorizedResult);
    }

    //--------------------------------------------------------------------
    use ResponseTrait;
    public function newTusVimeo($rel_item_type, $rel_item_id = null)
    {
        $rel_item_model = null;
        $rel_item_entity = null;
        if ($rel_item_type && $rel_item_id) {
            if ($rel_item_type == 'pages') {
                $rel_item_model = new \Lc5\Data\Models\PagesModel();
            } else if ($rel_item_type == 'posts') {
                $rel_item_model = new \Lc5\Data\Models\PostsModel();
            } else if ($rel_item_type == 'corso') {
                $rel_item_model = new \App\Models\CorsiModel();
            } else if ($rel_item_type == 'lezione') {
                $rel_item_model = new \App\Models\CorsiLezioniModel();
            } else if ($rel_item_type != '') {
                $classNameSpace = "App\Models\\$rel_item_type";
                if (class_exists($classNameSpace)) {
                    $rel_item_model = new $classNameSpace();
                }
            }
            // 
            if ($rel_item_model) {
                $rel_item_entity = $rel_item_model->allowCallbacks(FALSE)->select(['id', 'nome', 'vimeo_video_id'])->find($rel_item_id);
            }
        }
        // 
        $video_model = new VimeoVideosModel();
        $video_entity = new VimeoVideo();
        $request = \Config\Services::request();
        if ($request->getPost()) {
            $returnObject = (object)[
                'status' => 500,
                'body' => (object)[
                    'message' => 'internal server error'
                ]
            ];
            // 
            $video_name = $request->getPost('video_name');
            $file_size = $request->getPost('file_size');
            $file_name = $request->getPost('file_name');
            $video_name = (trim($video_name)) ? $video_name : $file_name;
            if ($file_size > 0 && trim($video_name)) {
                if ($vimeo_resonse = $this->createTusOnVimeo($video_name, $file_size)) {
                    $video_vimeo_path = $vimeo_resonse['body']['uri'];
                    $video_vimeo_id = str_replace('/videos/', '',  $vimeo_resonse['body']['uri']);
                    if ($video_vimeo_id) {

                        $this->moveVideoOnVimeoFolder($video_vimeo_id);
                        // 
                        $video_entity->vimeo_id = $video_vimeo_id;
                        $video_entity->nome = $video_name;
                        $video_entity->guid = $video_vimeo_id;
                        $video_entity->vimeo_path = $video_vimeo_path;
                        $video_entity->vimeo_video_status = $vimeo_resonse['body']['status'];
                        $video_entity->vimeo_upload_form_action = $vimeo_resonse['body']['upload']['upload_link'];
                        $video_model->save($video_entity);
                        // 
                        // 
                        if ($rel_item_entity) {
                            $rel_item_entity->vimeo_video_id = $video_vimeo_id;
                            // $rel_item_entity->vimeo_video_url = null;
                            $rel_item_model->allowCallbacks(FALSE)->save($rel_item_entity);
                        }
                        // 
                        // 
                        $returnObject = (object)[
                            'status' => 201,
                            'body' => (object)[
                                'video_name' => $video_name,
                                'file_size' => $file_size,
                                'video_vimeo_id' => $video_vimeo_id,
                                'video_uri' => $vimeo_resonse['body']['uri'],
                                'vimeo_resonse' => $vimeo_resonse,
                                'video_path' => $video_entity->video_path,
                                'cover_path' => $video_entity->cover_path,
                                'vimeo_video_status' => $video_entity->vimeo_video_status,
                            ]
                        ];
                    }
                }
            }
            return $this->respond($returnObject);
        }
        return $this->respond($this->unauthorizedResult);
    }

    //--------------------------------------------------------------------
    private function getVideoInfoOnVimeo($video_vimeo_id)
    {
        if (!$this->checkVimeoSetting()) {
            return FALSE;
        }
        if (!$this->vimeo_client) {
            $this->vimeo_client = $this->VimeoClient();
        }
        $video_response = $this->vimeo_client->request(
            '/me/videos/' . $video_vimeo_id,
            [],
            'GET'
        );
        return $video_response;
    }
    //--------------------------------------------------------------------
    private function createTusOnVimeo($video_name, $size)
    {
        if (!$this->checkVimeoSetting()) {
            return FALSE;
        }
        if (!$this->vimeo_client) {
            $this->vimeo_client = $this->VimeoClient();
        }
        $video_response = $this->vimeo_client->request(
            '/me/videos',
            [
                'upload' => [
                    'approach' => 'tus',
                    'size' => $size,
                ],
                'name' => $video_name
            ],
            'POST'
        );
        return $video_response;
    }
    //--------------------------------------------------------------------
    private function moveVideoOnVimeoFolder($video_vimeo_id)
    {
        if (!$this->checkVimeoSetting()) {
            return FALSE;
        }
        if (env('custom.vimeo_proj_folder_id') && trim(env('custom.vimeo_proj_folder_id'))) {
            if (!$this->vimeo_client) {
                $this->vimeo_client = $this->VimeoClient();
            }
            $move_in_folder_response = $this->vimeo_client->request(
                '/me/projects/' . env('custom.vimeo_proj_folder_id') . '/videos/' . $video_vimeo_id,
                [],
                'PUT'
            );
            return $move_in_folder_response;
        }
        return false;
    }

    //--------------------------------------------------------------------
    use ResponseTrait;
    public function removeVideo($rel_item_type, $rel_item_id = null)
    {
        $rel_item_model = null;
        $rel_item_entity = null;
        if ($rel_item_type && $rel_item_id) {
            if ($rel_item_type == 'pages') {
                $rel_item_model = new \Lc5\Data\Models\PagesModel();
            } else if ($rel_item_type == 'posts') {
                $rel_item_model = new \Lc5\Data\Models\PostsModel();
            } else if ($rel_item_type == 'corso') {
                $rel_item_model = new \App\Models\CorsiModel();
            } else if ($rel_item_type == 'lezione') {
                $rel_item_model = new \App\Models\CorsiLezioniModel();
            } else if ($rel_item_type != '') {
                $classNameSpace = "App\Models\\$rel_item_type";
                if (class_exists($classNameSpace)) {
                    $rel_item_model = new $classNameSpace();
                }
            }
            // 
            if ($rel_item_model) {
                $rel_item_entity = $rel_item_model->allowCallbacks(FALSE)->select(['id', 'nome', 'vimeo_video_id'])->find($rel_item_id);
            }
        }
        // 
        $video_model = new VimeoVideosModel();
        $request = \Config\Services::request();
        if ($request->getPost()) {
            $returnObject = (object)[
                'status' => 500,
                'body' => (object)[
                    'message' => 'internal server error'
                ]
            ];
            // 
            $video_id = $request->getPost('video_id');
            if (!$video_entity = $video_model->find($video_id)) {
                $returnObject = (object)[
                    'status' => 404,
                    'body' => (object)[
                        'message' => 'Video non trovato'
                    ]
                ];
                return $this->respond($returnObject);
            }
            $video_entity->status = 0;
            $video_model->save($video_entity);
            $video_model->delete($video_entity->id);
            // 
            if ($rel_item_entity) {
                $rel_item_entity->vimeo_video_id = NULL;
                // $rel_item_entity->vimeo_video_url = NULL;
                $rel_item_model->allowCallbacks(FALSE)->save($rel_item_entity);
            }
            $returnObject = (object)[
                'status' => 200,
                'body' => (object)[
                    'message' => 'Video Eliminato'
                ]
            ];
            // 
            return $this->respond($returnObject);
        }
        return $this->respond($this->unauthorizedResult);
        // 
    }

    //--------------------------------------------------------------------
    //--------------------------------------------------------------------
    //-- FINE VIMEO API
    //--------------------------------------------------------------------
    //--------------------------------------------------------------------
}
