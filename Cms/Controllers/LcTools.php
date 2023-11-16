<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\LcappsModel;
use Lc5\Data\Models\LanguagesModel;
use Lc5\Data\Entities\Lcapp as Entity;
use Mysqldump\Mysqldump as Mysqldump;

class LcTools extends MasterLc
{
    private $database_save_folder = WRITEPATH . 'uploads/dump/';
    private $files_save_folder = WRITEPATH . 'uploads/files/';
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
        $tools_list[] = (object)['nome' => 'Database Backup', 'route' => route_to($this->route_prefix . '_db')];
        $tools_list[] = (object)['nome' => 'Files Backup', 'route' => route_to($this->route_prefix . '_uploadfiles')];
        $tools_list[] = (object)['nome' => 'Aggiorna struttura Database', 'route' => route_to('lc_update_db')];
        $tools_list[] = (object)['nome' => 'Struttura database', 'route' => route_to('lc_tables_structure')];
        $this->lc_ui_date->list = $tools_list;
        // 
        return view('Lc5\Cms\Views\lc-tools/index', $this->lc_ui_date->toArray());
    }


    //--------------------------------------------------------------------
    public function filesIndex()
    {
        $this->lc_ui_date->__set('module_name', 'Lc Tools - Files');
        $dump_files_list = [];
        if (is_dir($this->files_save_folder)) {
            $scanned_directory = array_diff(scandir($this->files_save_folder), array('..', '.'));
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
        }
        $this->lc_ui_date->list = $dump_files_list;
        // 
        return view('Lc5\Cms\Views\lc-tools/files/index', $this->lc_ui_date->toArray());
    }
    //--------------------------------------------------------------------
    public function filesCreate()
    {
        dd('filesCreate function');
        $this->lc_ui_date->__set('module_name', 'Lc Tools - Files');

        if (!is_dir($this->files_save_folder)) {
            mkdir($this->files_save_folder, 0777, true);
        }

        
        $nome_zip_file = 'bkp_uploads_' . date("Y-m-d_His") . '.zip';
        $save_zip_file_path = $this->files_save_folder . $nome_zip_file;

        
        $zip = new \ZipArchive;
        // collect files you want to include in your zip file
    $filesList = [
        'imagesfolder/image1.jpg',
        'imagesfolder/image2.jpg',
        'imagesfolder/image3.jpg',
    ];

    $zip = new \ZipArchive();
    $zipFileName = 'images.zip';
    $zipFilePath = WRITEPATH . 'zips/' . $zipFileName; // Change the path as needed, dont forget to create a directory if it is not already there


    if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
        // Add files to the zip archive
        foreach ($filesList as $filePath) {
            if (file_exists($filePath)) {
                $zip->addFile($filePath, basename($filePath));
            }
        }

        $zip->close();

        // Send the zip file to the user
        return $this->response->download($zipFilePath, null)->setFileName(basename($zipFilePath));
    } else {
        return $this->response->setStatusCode(500)->setBody('Failed to create the zip file.');
    }



        // try {
        //     $zip = new \ZipArchive;
        //     // 
        //     return redirect()->route($this->route_prefix . '_db');
        // } catch (\Exception $e) {
        //     echo 'mysqldump-php error: ' . $e->getMessage();
        // }
    }


    //--------------------------------------------------------------------
    public function dbIndex()
    {
        $this->lc_ui_date->__set('module_name', 'Lc Tools - Database');
        $dump_files_list = [];
        if (is_dir($this->database_save_folder)) {
            $scanned_directory = array_diff(scandir($this->database_save_folder), array('..', '.'));
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
        }
        $this->lc_ui_date->list = $dump_files_list;
        // 
        return view('Lc5\Cms\Views\lc-tools/db/index', $this->lc_ui_date->toArray());
    }


    //--------------------------------------------------------------------
    public function dbDump()
    {
        $this->lc_ui_date->__set('module_name', 'Lc Tools - Database');

        if (!is_dir($this->database_save_folder)) {
            mkdir($this->database_save_folder, 0777, true);
        }

        $host = env('database.default.hostname');
        $database = env('database.default.database');
        $user = env('database.default.username');
        $pass = env('database.default.password');
        // 
        $nome_sql_file = $database . '_dump_' . date("Y-m-d_His") . '.sql';
        $save_sql_file_path = $this->database_save_folder . $nome_sql_file;
        $nome_zip_file = $database . '_dump_' . date("Y-m-d_His") . '.zip';
        $save_zip_file_path = $this->database_save_folder . $nome_zip_file;
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
        $file = $this->database_save_folder . $filename;
        $zip_file = $this->database_save_folder . $filename . '.zip';
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

        $file = $this->database_save_folder . $filename . '.' . $extension;

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
        $file = $this->database_save_folder . $filename . '.' . $extension;
        unlink($file);
        return redirect()->route($this->route_prefix . '_db');
    }
}
