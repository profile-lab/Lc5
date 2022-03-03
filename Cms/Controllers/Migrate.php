<?php

namespace Lc5\Cms\Controllers;

class Migrate extends \CodeIgniter\Controller
{
	public function update()
	{
		$migrate = \Config\Services::migrations();
		// $migrate->latest();
		$migrate->setNamespace('Lc5\Cms')->latest();
		$migrate->setNamespace('App')->latest();
		$this->datiBase();

		return redirect()->to(route_to('lc_dashboard') . '?action_result=DatabaseUpdateOK');
	}
	//
	public function datiBase()
	{
		$seeder = \Config\Database::seeder();

		$seeder->call('\Lc5\Cms\Database\Seeds\Lcapps');
		$seeder->call('\Lc5\Cms\Database\Seeds\LcappSettings');
		$seeder->call('\Lc5\Cms\Database\Seeds\Pagestype');
		$seeder->call('\Lc5\Cms\Database\Seeds\Rowsstyle');
		$seeder->call('\Lc5\Cms\Database\Seeds\Mediaformats');
		$seeder->call('\Lc5\Cms\Database\Seeds\Poststypes');
		$seeder->call('\Lc5\Cms\Database\Seeds\Language');
		$seeder->call('\Lc5\Cms\Database\Seeds\Sitemenus');
		$seeder->call('\Lc5\Cms\Database\Seeds\ShopAliquote');
	}

	//
	public function tableStructure($table_name = null)
	{	
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
				
				$entity_string = 'protected $attributes = [';
				$model_string = 'protected $attributes = [';
					
					
				$table_structure = [];
				$fields = $db->getFieldData($table_name);
				foreach ($fields as $field) {
					$table_structure[$field->name] = [
						'type' => $field->type,
						'constraint' => $field->max_length,
						'null' => ($field->nullable) ? true : false,
						'default' => $field->default,
					];
					$entity_string .="
	'".$field->name."' => null, ";
					$model_string .="
	'".$field->name."', ";
				}
				$entity_string .='

];';
				$model_string .='
				
];';
				echo '<h3>Table structure</h3>';
				echo '<pre>';
				print_r($table_structure);
				echo '</pre>';
				echo '<h3>Entity Base Code</h3>';
				echo '<pre>'. $entity_string . '</pre>';
				echo '<h3>Model Base Code</h3>';
				echo '<pre>'. $model_string . '</pre>';
			}
		} else {
			$tables = $db->listTables();
			echo '<ul>';
			foreach ($tables as $table) {
				echo '<li><a href="'.route_to('lc_table_structure', $table).'">'.$table.'</li>';
			}
			echo '</ul>';
		}
		echo '</body>
		</html>
		';

		return ;
	}
}
