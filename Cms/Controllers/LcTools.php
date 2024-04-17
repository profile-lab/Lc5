<?php

namespace Lc5\Cms\Controllers;

use Lc5\Data\Models\LcappsModel;
use Lc5\Data\Models\LanguagesModel;
use Lc5\Data\Entities\Lcapp as Entity;
use Mysqldump\Mysqldump as Mysqldump;

class LcTools extends MasterLc
{
    private $pages_structure_save_folder = WRITEPATH . 'uploads/pages-structure/';
    private $fileformats_save_folder = WRITEPATH . 'uploads/file-formats/';
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
        $tools_list[] = (object)['nome' => 'File Formats', 'route' => route_to($this->route_prefix . '_file_format')];
        $tools_list[] = (object)['nome' => 'Struttura pagine', 'route' => route_to($this->route_prefix . '_page_structure')];
        $this->lc_ui_date->list = $tools_list;
        // 
        return view('Lc5\Cms\Views\lc-tools/index', $this->lc_ui_date->toArray());
    }


    //--------------------------------------------------------------------
    //------------- UPLOADS ---------------------------------------------
    //--------------------------------------------------------------------


    //--------------------------------------------------------------------
    public function uploadFilesBkpIndex()
    {
        $this->lc_ui_date->__set('module_name', 'Lc Tools - Files');
        $dump_files_list = [];
        if (is_dir($this->files_save_folder)) {
            $scanned_directory = array_diff(scandir($this->files_save_folder), array('..', '.'));
            foreach ($scanned_directory as $key => $value) {
                $file = new \CodeIgniter\Files\File($this->files_save_folder . $value);
                $megabytes = $file->getSizeByUnit('mb');
                $extension = strtolower(pathinfo($value, PATHINFO_EXTENSION));
                $nome_file_str = str_replace('.' . $extension, '', $value);
                $dump_files_list[] = (object)[
                    'value' => $value,
                    'megabytes' => $megabytes,
                    'make_zip' => null,
                    'download' => route_to($this->route_prefix . '_uploadfiles_download_item', $nome_file_str, $extension),
                    'delete' => route_to($this->route_prefix . '_uploadfiles_delete_item', $nome_file_str, $extension),
                ];
            }
        }
        $this->lc_ui_date->list = $dump_files_list;
        // 
        return view('Lc5\Cms\Views\lc-tools/files/index', $this->lc_ui_date->toArray());
    }

    //--------------------------------------------------------------------
    public function uploadFilesBkpCreate()
    {
        $nome_zip_file = 'bkp_uploads_' . date("Y-m-d_His") . '.zip';
        $save_zip_file_path = $this->files_save_folder . $nome_zip_file;


        helper('filesystem');
        $public_root_folder = ROOTPATH . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR;
        // $WRITEPATH_upload_files = WRITEPATH . 'uploads/files/';
        if (!is_dir(ROOTPATH . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR)) {
            $public_root_folder = ROOTPATH . DIRECTORY_SEPARATOR . 'public_html' . DIRECTORY_SEPARATOR;
            if (!is_dir($public_root_folder)) {
                throw new \Exception('public folder not found');
            }
        }

        $public_uploads_folder = $public_root_folder . 'uploads' . DIRECTORY_SEPARATOR;
        $map_uploads_folder = directory_map($public_uploads_folder);

        if (!is_array($map_uploads_folder)) {
            throw new \Exception('uploads folder vuota');
        }
        $zip = new \ZipArchive;

        if ($zip->open($save_zip_file_path, \ZipArchive::CREATE) === TRUE) {
            $currentDir = $public_uploads_folder;
            $localDir = 'uploads' . DIRECTORY_SEPARATOR;
            $zip->addEmptyDir('uploads');
            foreach ($map_uploads_folder as $folderKey => $currentFile) {
                if (is_array($currentFile)) {
                    $folder_name = $folderKey . DIRECTORY_SEPARATOR;
                    $zip->addEmptyDir($localDir . $folder_name);
                    foreach ($currentFile as $currentSubFile) {
                        $zip->addFile($currentDir . $folder_name . $currentSubFile, $localDir . $folder_name . $currentSubFile);
                    }
                } else {
                    $zip->addFile($currentDir . $currentFile, $localDir . $currentFile);
                }
            }
            $this->lc_ui_date->__set('module_name', 'Lc Tools - Files');
            if (!is_dir($this->files_save_folder)) {
                mkdir($this->files_save_folder, 0777, true);
            }
            $zip->close();
            echo 'Archiving is sucessful!';
            return redirect()->route($this->route_prefix . '_uploadfiles');
        } else {
            echo 'Error, can\'t create a zip file!';
        }
    }

    //--------------------------------------------------------------------
    public function uploadFilesBkpDownload($filename)
    {
        $file = $this->files_save_folder . $filename . '.zip';

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
    public function uploadFilesBkpDelete($filename)
    {
        $file = $this->files_save_folder . $filename . '.zip';
        unlink($file);
        return redirect()->route($this->route_prefix . '_uploadfiles');
    }



    //--------------------------------------------------------------------
    //------------- DATABASE ---------------------------------------------
    //--------------------------------------------------------------------

    //--------------------------------------------------------------------
    public function dbIndex()
    {
        $this->lc_ui_date->__set('module_name', 'Lc Tools - Database');
        $dump_files_list = [];
        if (is_dir($this->database_save_folder)) {
            $scanned_directory = array_diff(scandir($this->database_save_folder), array('..', '.'));
            foreach ($scanned_directory as $key => $value) {
                $file = new \CodeIgniter\Files\File($this->database_save_folder . $value);
                $megabytes = $file->getSizeByUnit('mb');
                $extension = strtolower(pathinfo($value, PATHINFO_EXTENSION));
                $nome_file_str = str_replace('.' . $extension, '', $value);
                $dump_files_list[] = (object)[
                    'value' => $value,
                    'megabytes' => $megabytes,
                    'download' => route_to($this->route_prefix . '_db_dump_download_item', $nome_file_str, $extension),
                    'make_zip' => ($extension != 'zip') ? route_to($this->route_prefix . '_db_dump_zip', $nome_file_str, $extension) : null,
                    'delete' => route_to($this->route_prefix . '_db_dump_delete_item', $nome_file_str, $extension),
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
    public function comprimiSingleDumpFiles($filename, $extension)
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
    public function scaricaSingleBumpFiles($filename, $extension)
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
    public function eliminaSingleDumpFiles($filename, $extension)
    {
        $file = $this->database_save_folder . $filename . '.' . $extension;
        unlink($file);
        return redirect()->route($this->route_prefix . '_db');
    }



    //--------------------------------------------------------------------
    //------------- FILE FORMATS -----------------------------------------
    //--------------------------------------------------------------------

    //--------------------------------------------------------------------
    public function fileFormats()
    {
        $this->lc_ui_date->__set('module_name', 'Lc Tools - File Formats');
        $dump_files_list = [];
        if (is_dir($this->fileformats_save_folder)) {
            $scanned_directory = array_diff(scandir($this->fileformats_save_folder), array('..', '.'));
            foreach ($scanned_directory as $key => $value) {
                $file = new \CodeIgniter\Files\File($this->fileformats_save_folder . $value);
                $megabytes = $file->getSizeByUnit('mb');
                $extension = strtolower(pathinfo($value, PATHINFO_EXTENSION));
                $nome_file_str = str_replace('.' . $extension, '', $value);
                $dump_files_list[] = (object)[
                    'value' => $value,
                    'megabytes' => $megabytes,
                    'download' => route_to($this->route_prefix . '_file_format_export_download_item', $nome_file_str, $extension),
                    'importa' => route_to($this->route_prefix . '_file_format_export_import', $nome_file_str),
                    'delete' => route_to($this->route_prefix . '_file_format_export_delete_item', $nome_file_str, $extension),
                ];
            }
        }
        $this->lc_ui_date->list = $dump_files_list;
        // 
        return view('Lc5\Cms\Views\lc-tools/file-formats/index', $this->lc_ui_date->toArray());
    }

    //--------------------------------------------------------------------
    public function fileFormatsExport()
    {
        $this->lc_ui_date->__set('module_name', 'Lc Tools - File Formats');

        if (!is_dir($this->fileformats_save_folder)) {
            mkdir($this->fileformats_save_folder, 0777, true);
        }
        $table_name = 'mediaformats';
        $database = env('database.default.database');
        // 
        $file_content_str = '';
        $db = \Config\Database::connect();
        if ($table_name) {
            if ($db->tableExists($table_name)) {
                $fields = $db->getFieldData($table_name);
                if (count($fields) > 0) {
                    $file_content_str .= 'INSERT INTO `' . $table_name . '` (';
                }
                $contaFields = 0;
                foreach ($fields as $field) {
                    $file_content_str .= ($contaFields > 0 ? ', ' : '') . '`' . $field->name . '`';
                    $contaFields++;
                }

                $file_content_str .= ') VALUES' . "\n";
                $query = $db->table($table_name)->get();

                $contaRows = 0;
                foreach ($query->getResult() as $row) {
                    $file_content_str .= (($contaRows > 0) ? ",\n" : "") . '(';
                    $contaFields = 0;
                    foreach ($fields as $field) {
                        $file_content_str .= ($contaFields > 0 ? ', ' : '');
                        if ($field->type == 'int') {
                            $file_content_str .= $row->{$field->name};
                        } else if ($field->type == 'timestamp') {
                            if (trim($row->{$field->name}) && $row->{$field->name} != '0000-00-00 00:00:00') {
                                $file_content_str .= "'" . $row->{$field->name} . "'";
                            } else {
                                $file_content_str .= "NULL";
                            }
                        } else {
                            $file_content_str .= "'" . $row->{$field->name} . "'";
                        }
                        $contaFields++;
                    }
                    $file_content_str .= ")";
                    $contaRows++;
                }
                $file_content_str .= ";";
            }
        }
        // 
        $nome_sql_file = 'file_formats_' . date("Y-m-d_His") . '-' . $database . '.sql';
        $save_sql_file_path = $this->fileformats_save_folder . $nome_sql_file;
        try {
            $fp = fopen($save_sql_file_path, 'a+');
            fwrite($fp, $file_content_str);
            fclose($fp);
            // 
            return redirect()->route($this->route_prefix . '_file_format');
        } catch (\Exception $e) {
            echo 'error on file write error: ' . $e->getMessage();
        }
    }

    //--------------------------------------------------------------------
    public function fileFormatsElimina($filename, $extension)
    {
        $file = $this->fileformats_save_folder . $filename . '.' . $extension;
        unlink($file);
        return redirect()->route($this->route_prefix . '_file_format');
    }

    //--------------------------------------------------------------------
    public function fileFormatsScarica($filename, $extension)
    {
        $file = $this->fileformats_save_folder . $filename . '.' . $extension;

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
    public function fileFormatsImport($filename)
    {
        $table_name = 'mediaformats';

        $this->lc_ui_date->__set('module_name', 'Lc Tools - File Formats');
        $file = $this->fileformats_save_folder . $filename . '.sql';
        if (file_exists($file)) {
            $sql = file_get_contents($file);
            $db = \Config\Database::connect();
            // $db->transStart();
            $db->query('TRUNCATE TABLE `' . $table_name . '`;');
            $db->query('ALTER TABLE `' . $table_name . '` AUTO_INCREMENT = 1;');
            $db->query($sql);
            $db->transComplete();
            if ($db->transStatus() === FALSE) {
                dd('error on import');
            } else {
                // unlink($file);
                return redirect()->route($this->route_prefix . '_file_format');
            }
        }
        dd('file not found');
        return redirect()->route($this->route_prefix . '_file_format');
    }


    //--------------------------------------------------------------------
    //------------- PAGE STRUCTURE ---------------------------------------
    //--------------------------------------------------------------------

    // pages_structure_save_folder
    // pages-structure

    //--------------------------------------------------------------------
    public function pagesStructure()
    {
        $this->lc_ui_date->__set('module_name', 'Lc Tools - Pages Structure');
        $dump_files_list = [];
        if (is_dir($this->pages_structure_save_folder)) {
            $scanned_directory = array_diff(scandir($this->pages_structure_save_folder), array('..', '.'));
            foreach ($scanned_directory as $key => $value) {
                $file = new \CodeIgniter\Files\File($this->pages_structure_save_folder . $value);
                $megabytes = $file->getSizeByUnit('mb');
                $extension = strtolower(pathinfo($value, PATHINFO_EXTENSION));
                $nome_file_str = str_replace('.' . $extension, '', $value);
                $dump_files_list[] = (object)[
                    'value' => $value,
                    'megabytes' => $megabytes,
                    'download' => route_to($this->route_prefix . '_page_structure_export_download_item', $nome_file_str, $extension),
                    'importa' => route_to($this->route_prefix . '_page_structure_export_import', $nome_file_str),
                    'delete' => route_to($this->route_prefix . '_page_structure_export_delete_item', $nome_file_str, $extension),
                ];
            }
        }
        $this->lc_ui_date->list = $dump_files_list;
        // 
        return view('Lc5\Cms\Views\lc-tools/pages-structure/index', $this->lc_ui_date->toArray());
    }
    //--------------------------------------------------------------------
    public function pagesStructureExport()
    {
        $this->lc_ui_date->__set('module_name', 'Lc Tools - File Formats');

        if (!is_dir($this->pages_structure_save_folder)) {
            mkdir($this->pages_structure_save_folder, 0777, true);
        }
        $table_names = ['pagestypes', 'rowsstyles', 'rows_extra_styles', 'rowscolors', 'rowcomponents', 'poststypes', 'custom_fields_keys'];
        $database = env('database.default.database');
        // 
        $file_content_str = '';
        $db = \Config\Database::connect();
        if ($table_names && is_array($table_names) && count($table_names) > 0) {
            foreach ($table_names as $table_name) {
                if ($table_name) {
                    if ($db->tableExists($table_name)) {
                        $fields = $db->getFieldData($table_name);
                        $query = $db->table($table_name)->get();
                        $table_query_result = $query->getResult();
                        if (count($fields) > 0 && count($table_query_result) > 0) {
                            $file_content_str .= 'INSERT INTO `' . $table_name . '` (';
                            $contaFields = 0;
                            foreach ($fields as $field) {
                                $file_content_str .= ($contaFields > 0 ? ', ' : '') . '`' . $field->name . '`';
                                $contaFields++;
                            }

                            $file_content_str .= ') VALUES' . "\n";

                            $contaRows = 0;
                            foreach ($table_query_result as $row) {
                                $file_content_str .= (($contaRows > 0) ? ",\n" : "") . '(';
                                $contaFields = 0;
                                foreach ($fields as $field) {
                                    $file_content_str .= ($contaFields > 0 ? ', ' : '');
                                    if ($field->type == 'int') {

                                        if (trim($row->{$field->name}) && $row->{$field->name} != '') {
                                            $file_content_str .= $row->{$field->name};
                                        } else {
                                            $file_content_str .= "NULL";
                                        }

                                    } else if ($field->type == 'timestamp') {
                                        if (trim($row->{$field->name}) && $row->{$field->name} != '0000-00-00 00:00:00') {
                                            $file_content_str .= "'" . $row->{$field->name} . "'";
                                        } else {
                                            $file_content_str .= "NULL";
                                        }
                                    } else {
                                        $file_content_str .= "'" . $row->{$field->name} . "'";
                                    }
                                    $contaFields++;
                                }
                                $file_content_str .= ")";
                                $contaRows++;
                            }
                            $file_content_str .= ";\n";
                        }
                    }
                }
            }
        }
        // 
        $nome_sql_file = 'pages_structure_' . date("Y-m-d_His") . '-' . $database . '.sql';
        $save_sql_file_path = $this->pages_structure_save_folder . $nome_sql_file;
        try {
            $fp = fopen($save_sql_file_path, 'a+');
            fwrite($fp, $file_content_str);
            fclose($fp);
            // 
            return redirect()->route($this->route_prefix . '_page_structure');
        } catch (\Exception $e) {
            echo 'error on file write error: ' . $e->getMessage();
        }
    }
    //--------------------------------------------------------------------
    public function pagesStructureElimina($filename, $extension)
    {
        $file = $this->pages_structure_save_folder . $filename . '.' . $extension;
        unlink($file);
        return redirect()->route($this->route_prefix . '_page_structure');
    }

    //--------------------------------------------------------------------
    public function pagesStructureScarica($filename, $extension)
    {
        $file = $this->pages_structure_save_folder . $filename . '.' . $extension;

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
    public function pagesStructureImport($filename)
    {
        $table_names = ['pagestypes', 'rowsstyles', 'rows_extra_styles', 'rowscolors', 'rowcomponents', 'poststypes', 'custom_fields_keys'];


        $this->lc_ui_date->__set('module_name', 'Lc Tools - File Formats');
        $file = $this->pages_structure_save_folder . $filename . '.sql';
        if (file_exists($file)) {
            $all_sql = file_get_contents($file);
            $db = \Config\Database::connect();
            
            if($table_names && is_array($table_names) && count($table_names) > 0){
                foreach($table_names as $table_name){
                    $db->query('TRUNCATE TABLE `' . $table_name . '`;');
                    $db->query('ALTER TABLE `' . $table_name . '` AUTO_INCREMENT = 1;');
                }
            }
            $errors= [];
            $all_sql_array = explode(';', $all_sql);
            foreach ($all_sql_array as $sql) {
                $sql = trim($sql);
                if ($sql) {
                    $db->transStart();
                    $db->query($sql);
                    $db->transComplete();
                    if ($db->transStatus() === FALSE) {
                        $errors[] = $sql;
                    }
                }
            }
            // $db->transStart();
            // $db->query($sql);
            // $db->transComplete();
            if ($errors && count($errors) > 0){
                dd('error on import');
            } else {
                // unlink($file);
                return redirect()->route($this->route_prefix . '_page_structure');
            }
        }
        dd('file not found');
        return redirect()->route($this->route_prefix . '_page_structure');
    }
}
