<?php

namespace Lc5\Web\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\GeneratorTrait;

class CreateCustomComponent extends BaseCommand
{
    use GeneratorTrait;

    protected $group = 'Levelcomplete';
    protected $name = 'create:custom-component';
    protected $description = '';
    protected $usage = 'command:name <module_name>';

    protected $arguments = [];

    public function run(array $params)
    {
        helper('inflector');

        CLI::write('Test command ' . $this->name, 'yellow');
        CLI::newLine();

        $this->params = $params;

        $options = [];

        $class = $params[0] ?? CLI::getSegment(2);
        $className = pascalize($class);
        $backClassName = pascalize('Lc_' . $class);
        $model_class = pascalize($class . 'Model');
        $entity_class = pascalize($class . '');

        $mackerSearch = ['{model_class}', '{entity_class}', '{nome_modulo}', '{table}', '{className_string}', '{backClassName_string}'];
        $mackerReplace = [$model_class, $entity_class, decamelize($class), decamelize('app_' . $class), $className, $backClassName];



        $this->generaPhpFile('lc_controller_front.tpl', 'Controllers', $className,  $mackerSearch, $mackerReplace);
        $this->generaPhpFile('lc_controller_back.tpl', 'Controllers' . DIRECTORY_SEPARATOR . 'LcCustom', $backClassName, $mackerSearch, $mackerReplace);
        $this->generaPhpFile('lc_model.tpl', 'Models', $model_class, $mackerSearch, $mackerReplace);
        $this->generaPhpFile('lc_entity.tpl', 'Entities', $entity_class, $mackerSearch, $mackerReplace);
        $this->generaPhpFile('lc_view_index_back.tpl', 'Views' . DIRECTORY_SEPARATOR . 'lc-custom'. DIRECTORY_SEPARATOR. decamelize($class) , 'index');
        $this->generaPhpFile('lc_view_scheda_back.tpl', 'Views' . DIRECTORY_SEPARATOR . 'lc-custom'. DIRECTORY_SEPARATOR. decamelize($class) , 'scheda');
        $route_config_string = $this->generaPhpFile('lc_routes.tpl', 'Routes', 'AppCustom', $mackerSearch, $mackerReplace);

        CLI::write('ROUTE CONFIGURATION', 'yellow');
        CLI::newLine();
        CLI::newLine();
        CLI::write($route_config_string, 'yellow');
        CLI::newLine();
        CLI::newLine();

        $this->call('make:migration', array_merge([$class], $options));
        //
    }




    protected function generaPhpFile(string $tpl = '', string $save_folder_name,  string $class, array $search = [], array $replace = []): string
    {
        $save_folder = APPPATH . $save_folder_name;
        if (!is_dir($save_folder)) {
            $folderStructure = explode(DIRECTORY_SEPARATOR, $save_folder_name);
            $path_fino_a_qui = APPPATH;
            foreach($folderStructure as $folder){
                $path_fino_a_qui.=  $folder .DIRECTORY_SEPARATOR;
                if (!is_dir($path_fino_a_qui)) {
                    mkdir($path_fino_a_qui);
                }
            }
        }
        // Retrieves the namespace part from the fully qualified class name.
        $namespace = trim(implode('\\', array_slice(explode('\\', $class), 0, -1)), '\\');
        $search[]  = '<@php';
        $search[]  = '<@=';
        $search[]  = '{class}';
        $replace[] = '<?php';
        $replace[] = '<?=';
        $replace[] = $class;
        // 
        $file_path = __DIR__ . DIRECTORY_SEPARATOR . $tpl . '.php';
        $template_string = file_get_contents($file_path);

        $file_code_string =  str_replace($search, $replace, $template_string);
        $save_path = $save_folder . DIRECTORY_SEPARATOR . $class . '.php';
        $returnStringPath = $save_folder . DIRECTORY_SEPARATOR . $class . '.php';
        
        if(is_file($save_path)){
            CLI::write('File already exists: '. $returnStringPath, 'red');
            CLI::newLine();
            return $file_code_string;
        }

        file_put_contents($save_path, $file_code_string);

        CLI::write('File created: '. $returnStringPath, 'green');
        CLI::newLine();
        return $file_code_string;
    }
}
