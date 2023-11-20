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
        $entity_class = pascalize($class . 'Entity');

        $mackerSearch = ['{model_class}', '{entity_class}', '{nome_modulo}', '{table}'];
        $mackerReplace = [$model_class, $entity_class, decamelize($class), decamelize('app_' . $class)];



        $this->generaPhpFile('lc_controller_front.tpl', 'Controllers', $className,  $mackerSearch, $mackerReplace);
        $this->generaPhpFile('lc_controller_back.tpl', 'Controllers' . DIRECTORY_SEPARATOR . 'LcCustom', $backClassName, $mackerSearch, $mackerReplace);
        $this->generaPhpFile('lc_model.tpl', 'Models', $model_class, $mackerSearch, $mackerReplace);
        $this->generaPhpFile('lc_entity.tpl', 'Entities', $entity_class, $mackerSearch, $mackerReplace);

        $this->call('make:migration', array_merge([$class], $options));
        //
    }




    protected function generaPhpFile(string $tpl = '', string $save_folder_name,  string $class, array $search = [], array $replace = []): string
    {
        $save_folder = APPPATH . $save_folder_name;
        if (!is_dir($save_folder)) {
            mkdir($save_folder);
        }
        // Retrieves the namespace part from the fully qualified class name.
        $namespace = trim(implode('\\', array_slice(explode('\\', $class), 0, -1)), '\\');
        $search[]  = '<@php';
        $search[]  = '{class}';
        $replace[] = '<?php';
        $replace[] = $class;
        // 
        $file_path = __DIR__ . DIRECTORY_SEPARATOR . $tpl . '.php';
        $template_string = file_get_contents($file_path);

        $file_code_string =  str_replace($search, $replace, $template_string);
        $save_path = $save_folder . DIRECTORY_SEPARATOR . $class . '.php';
        file_put_contents($save_path, $file_code_string);

        $returnStringPath = $save_folder . DIRECTORY_SEPARATOR . $class . '.php';
        CLI::write('File created: '. $returnStringPath, 'green');
        // CLI::newLine();
        return $returnStringPath;
    }
}
