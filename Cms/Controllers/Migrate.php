<?php

namespace Lc5\Cms\Controllers;

use Mysqldump\Mysqldump;
// use Ifsnop\Mysqldump as IMysqldump;


class Migrate extends \CodeIgniter\Controller
{
	public function update()
	{
		$migrate = \Config\Services::migrations();

		try {
			$migrate->setNamespace('Lc5\Data')->latest();
			$this->datiBase();
			return redirect()->to(route_to('lc_dashboard') . '?action_result=DatabaseUpdateOK');
		} catch (\Throwable $e) {
			// Do something with the error here...
		}


		// $migrate->latest();
		// $migrate->setNamespace('Lc5\Cms')->latest();
		// $migrate->setNamespace('App')->latest();
		// $this->datiBase();

	}
	//
	public function datiBase()
	{
		$seeder = \Config\Database::seeder();

		$seeder->call('\Lc5\Data\Database\Seeds\Lcapps');
		$seeder->call('\Lc5\Data\Database\Seeds\LcappSettings');
		$seeder->call('\Lc5\Data\Database\Seeds\Pagestype');
		$seeder->call('\Lc5\Data\Database\Seeds\Rowsstyle');
		$seeder->call('\Lc5\Data\Database\Seeds\Mediaformats');
		$seeder->call('\Lc5\Data\Database\Seeds\Poststypes');
		$seeder->call('\Lc5\Data\Database\Seeds\Language');
		$seeder->call('\Lc5\Data\Database\Seeds\Sitemenus');
		$seeder->call('\Lc5\Data\Database\Seeds\ShopAliquote');
	}

	//
	public function tableStructure($table_name = null)
	{
		helper('inflector');

		echo '<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Document</title>
		</head>
		<body>';
		$db = \Config\Database::connect();
		if ($table_name) {
			if ($db->tableExists($table_name)) {

				$entity_string = '<?php
namespace App\Entities;
use CodeIgniter\Entity\Entity;

class ' . pascalize(singular($table_name)) . '  extends Entity
{
	protected $attributes = [';
				$model_string = '<?php
namespace App\Models;
use CodeIgniter\Model;

class ' . pascalize(plural($table_name)) . 'Model  extends Model
{
	protected $table				= \'' . $table_name . '\';
	protected $primaryKey			= \'id\';
	protected $useSoftDeletes		= true;
	protected $createdField			= \'created_at\';
	protected $updatedField			= \'updated_at\';
	protected $deletedField			= \'deleted_at\';

	protected $returnType           = \'' . ("App\Entities\\" . pascalize(singular($table_name))) . '\';
	protected $allowedFields = [';

				$table_structure = [];
				$fields = $db->getFieldData($table_name);
				foreach ($fields as $field) {
					$table_structure[$field->name] = [
						'type' => $field->type,
						'constraint' => $field->max_length,
						'null' => ($field->nullable) ? true : false,
						'default' => $field->default,
					];
					if ($field->name != "created_at" && $field->name != "updated_at" && $field->name != "deleted_at") {

						$entity_string .= "
		'" . $field->name . "' => null, ";
						$model_string .= "
		'" . $field->name . "', ";
					}
				}
				$entity_string .= '

	];
}';
				$model_string .= '

	];
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

}';

				echo '<h3>Entity Base Code</h3>';
				echo '<textarea cols="100" rows="40">' . $entity_string . '</textarea>';
				echo '<hr /><hr />';
				echo '<h3>Model Base Code</h3>';
				echo '<textarea cols="100" rows="40">' . $model_string . '</textarea>';
				echo '<hr /><hr />';
				echo '<h3>Table structure</h3>';
				echo '<pre>';
				print_r($table_structure);
				echo '</pre>';
			}
		} else {
			$tables = $db->listTables();
			echo '<ul>';
			foreach ($tables as $table) {
				echo '<li><a href="' . route_to('lc_table_structure', $table) . '">' . $table . '</li>';
			}
			echo '</ul>';
		}
		echo '</body>
		</html>
		';

		return;
	}
}
