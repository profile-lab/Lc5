<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\LcappsModel;
use Lc5\Data\Models\LanguagesModel;
use Lc5\Data\Entities\Lcapp as Entity;
use Mysqldump\Mysqldump as Mysqldump;

class LcTools extends MasterLc
{
    private $save_folder = WRITEPATH . 'uploads/dump/';
    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
        // 
        $this->module_name = 'Lc Tools';
        $this->route_prefix = 'lc_tools';
        // 
        $this->lc_ui_date->__set('request', $this->req);
        $this->lc_ui_date->__set('route_prefix', $this->route_prefix);
        $this->lc_ui_date->__set('module_name', $this->module_name);
        // 
        $this->lc_ui_date->__set('currernt_module', 'tools');
        $this->lc_ui_date->__set('currernt_module_action', 'lc_tools_index');
    }

    //--------------------------------------------------------------------
    public function index()
    {

        $tools_list = [];
        $tools_list[] = (object)['nome' => 'Database', 'route' => route_to($this->route_prefix . '_db')];
        $this->lc_ui_date->list = $tools_list;
        // 
        return view('Lc5\Cms\Views\lc-tools/index', $this->lc_ui_date->toArray());
    }


    //--------------------------------------------------------------------
    public function dbIndex()
    {
        $this->lc_ui_date->__set('module_name', 'Lc Tools - Database');


        $scanned_directory = array_diff(scandir($this->save_folder), array('..', '.'));

        $dump_files_list = [];

        foreach ($scanned_directory as $key => $value) {
            $extension = strtolower(pathinfo($value, PATHINFO_EXTENSION));
            $nome_file_str = str_replace('.' . $extension, '', $value);
            $dump_files_list[] = (object)[
                'value' => $value,
                'download' => route_to($this->route_prefix . '_db_dump_download_item', $nome_file_str, $extension),
                'make_zip' => ($extension != 'zip') ? route_to($this->route_prefix . '_db_dump_zip', $nome_file_str, $extension) : null,
                'delete' => route_to($this->route_prefix . '_db_dump_delete_file', $nome_file_str, $extension),
            ];
        }

        $this->lc_ui_date->list = $dump_files_list;
        // 
        return view('Lc5\Cms\Views\lc-tools/db/index', $this->lc_ui_date->toArray());
    }


    //--------------------------------------------------------------------
    public function dbDump()
    {
        $this->lc_ui_date->__set('module_name', 'Lc Tools - Database');

        if (!is_dir($this->save_folder)) {
            mkdir($this->save_folder, 0777, true);
        }

        $host = env('database.default.hostname');
        $database = env('database.default.database');
        $user = env('database.default.username');
        $pass = env('database.default.password');
        // 
        $nome_sql_file = $database . '_dump_' . date("Y-m-d_His") . '.sql';
        $save_sql_file_path = $this->save_folder . $nome_sql_file;
        $nome_zip_file = $database . '_dump_' . date("Y-m-d_His") . '.zip';
        $save_zip_file_path = $this->save_folder . $nome_zip_file;
        try {
            $dump = new Mysqldump("mysql:host={$host};dbname={$database}", $user, $pass);
            $dump->start($save_sql_file_path);
            // 
            return redirect()->route($this->route_prefix . '_db');
        } catch (\Exception $e) {
            echo 'mysqldump-php error: ' . $e->getMessage();
        }
    }

    //--------------------------------------------------------------------
    public function comprimiSingleFiles($filename, $extension)
    {
        $file = $this->save_folder . $filename;
        $zip_file = $this->save_folder . $filename . '.zip';
        // 
        $zip = new \ZipArchive;
        if ($zip->open($zip_file, \ZipArchive::CREATE) !== TRUE) {
            exit("cannot open <$zip_file>\n");
        }
        $zip->addFile($file . '.' . $extension, "/" . $filename);
        $zip->close();
        return redirect()->route($this->route_prefix . '_db');
    }


    //--------------------------------------------------------------------
    public function scaricaSingleFiles($filename, $extension)
    {

        $file = $this->save_folder . $filename . '.' . $extension;

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }

    //--------------------------------------------------------------------
    public function eliminaSingleFiles($filename, $extension)
    {
        $file = $this->save_folder . $filename . '.' . $extension;
        unlink($file);
        return redirect()->route($this->route_prefix . '_db');
    }
}
