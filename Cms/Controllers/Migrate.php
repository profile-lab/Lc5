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

                return redirect()->to(route_to('lc_dashboard').'?action_result=DatabaseUpdateOK' );

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
}
