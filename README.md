# Levelcomplete 5 Corebase Module

## New project - Codeigniter 4

#### Create new project in work folder
        composer create-project codeigniter4/appstarter <project_name>  --no-dev
        cd <project_name>

        - rename folder "public" -> "public_html"
        - replace "public" -> "public_html" in spark file 

        Add to .gitignore
        composer.lock
        *.env
        public_html/uploads/*
        public_html/uploads/*/*

#### Init git

        git init

#### Install git submodule

        git submodule add https://github.com/profile-lab/Lc5
        git submodule add https://github.com/profile-lab/lc5-admin-assets public_html/assets/lc-admin-assets


### Alternative - Clone repository from git

        - git clone <repository link>
        - composer update
        - git submodule update --init --recursive 
        (or git submodule update --recursive)

#### Update/Download submodules 

        git submodule update --init --recursive

#
# Base Configuration 

#### Add Supported Lang in App\Config\App.php

        public array $supportedLocales = ['en','it','fr','es','de'];

#### Add LC5 psr4 namespace in App\Config\Autoload.php
        
        public $psr4 = [
            ...
            //
            'Lc5\Cms'   => ROOTPATH . 'Lc5/Cms',
            'Lc5\Data'   => ROOTPATH . 'Lc5/Data',
            'Lc5\Web'   => ROOTPATH . 'Lc5/Web',
            //
            'Vimeo'    => ROOTPATH . 'Lc5/Cms/ThirdParty/Vimeo',
            'Mysqldump'    => ROOTPATH . 'Lc5/Cms/ThirdParty/Mysqldump',
            'PHPMailer\PHPMailer'    => ROOTPATH . 'Lc5/Web/ThirdParty/PHPMailer/src',
            //
        ];

#### Add LC5 helpers in App\Config\Autoload.php
        
        public $helpers =  ['html', 'text', 'form', 'profile', 'lc_view', 'web_view', 'custom_frontend'];


#### Add LC5 Admin filter in App\Config\Filters.php
        
        public $aliases = [
           ...
           //
           'admin_auth'	=> \Lc5\Cms\Filters\AdminAuth::class,
        ];


#### Add LC5 services in App\Config\Services.php

        public static function admins($getShared = true)
        {
            if ($getShared){
                    return static::getSharedInstance('admins');
            }
            return new \Lc5\Cms\Controllers\Admins();
        }

#### Add LC5 AppCustom routes in App\Config\Routes.php

        // $routes->get('/', 'Home::index');

        if (is_file(APPPATH . 'Routes/AppCustom.php')) {
            require APPPATH . 'Routes/AppCustom.php';
        }

#
# ENV and Database

## .env variables

        app.appName = 'APP NAME'
        app.baseURL = "http://localhost:8081"
        app.indexPage = ""
        app.defaultLocale = "it"
        app.appTimezone = 'Europe/Rome'

        database.default.hostname = 'hostname'
        database.default.database = 'database'
        database.default.username = 'username'
        database.default.password = 'password'
        database.default.DBDriver = 'MySQLi'

        custom.web_app_id = 1
        custom.media_root_path = "/uploads/"
        custom.post_per_page = 12

## Database variables

##### Add db connection info in .env 

##### Create/Update Database tables structure 
https://domain.com/lc-admin/update-db

##### Create first admin user
https://domain.com/lc-admin/first-login

#
# Custom Components

#### Create CustomAppContoller.php in App/Controllers

        <?php
        namespace App\Controllers;

        class CustomAppContoller extends BaseController
        {
            //--------------------------------------------------------------------
            public function __construct(&$master_app_controller)
            {
                // $master_app_controller->web_ui_date->__set('seo_title', env('custom.nome_app'));
            }
    
            //--------------------------------------------------------------------
            public function customSampleMethod(&$master_app_controller)
            {
                // $custom_sample_model = new  App\Models\CustomModel();
                // $master_app_controller->web_ui_date->page_data = $custom_sample_model->asObject()->findAll();
            }
        }


#
# Install on remote server by composer
#### *- All files are avalables on Lc5/composer-install-files*

- Copy cmpsr-install.php file to /public_html (app public folder)
- Copy composer.phar to / (root folder)

*Codeigniter 4 composer.json file is mandatory* 

Run: https://domain.com/cmpsr-install.php
 
*If doesn't works, checke /writable folder permission*



#
# Server Requirements

PHP version 8.2 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)

## SE HTACCESS GENERA Errore 500 
#### disabilita -> Restrict the ability to follow symbolic links di Apache Ngix 