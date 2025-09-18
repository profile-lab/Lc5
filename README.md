# Levelcomplete 5 Corebase Module

## New project - Codeigniter 4

#### Create new project in work folder

        composer create-project codeigniter4/appstarter <project_name>  --no-dev
        cd <project_name>

        - rename folder "public" -> "public_html"
        - replace "public" -> "public_html" in spark file

        *Add to .gitignore*
        composer.lock
        *.env
        !env-local.env
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

#### Add Lc5 modules on git repository on plesk

        - add new Git Repositories for each active submodules in the project 
        - add Webhooks on github remote project setting 
                
                - Payload URL: copy from server git componet and check domain mame replace (https://domain.ext:8443 -> https://subdomanin.domain.ext:8443)
                - Content type application/json
                - disable SSL verification


#

# Install on remote server by composer

#### _- All files are avalables on Lc5/composer-install-files_

- Copy cmpsr-install.php file to /public_html (app public folder)
- Copy composer.phar to / (root folder)

_Codeigniter 4 composer.json file is mandatory_

Run: https://domain.com/cmpsr-install.php

_If doesn't works, checke /writable folder permission_

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
            'Lc5\Api'   => ROOTPATH . 'Lc5/Api',
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

        public array $globals = [
           ...
           'after' => [
            'toolbar' => ['except' => ['lc-admin/*']],
          ],
        ];

#### Add LC5 services in App\Config\Services.php

        //--------------------------------------------------------------------
        public static function admins($getShared = true)
        {
                if ($getShared) {
                return static::getSharedInstance('admins');
                }
                return new \Lc5\Cms\Controllers\Admins();
        }
       

#### Add LC5 AppCustom routes in App\Config\Routes.php

        // $routes->get('/', 'Home::index');

        if (is_file(APPPATH . 'Routes/AppCustom.php')) {
            require APPPATH . 'Routes/AppCustom.php';
        }

### Add Class variables in App\Controllers\BaseController.php

        protected $custom_app_modules = [];
        protected $lc_plugin_modules = [];

#

# ENV and Database

## .env variables

        CI_ENVIRONMENT = development

        app.appName = 'APP NAME'
        app.baseURL = "https://domain.com"
        app.indexPage = ""
        app.defaultLocale = "it"
        app.appTimezone = 'Europe/Rome'
        app.forceGlobalSecureRequests = true

        database.default.hostname = 'hostname'
        database.default.database = 'database'
        database.default.username = 'username'
        database.default.password = 'password'
        database.default.DBDriver = 'MySQLi'
        database.default.DBPrefix = ''

        custom.web_app_id = 1
        custom.media_root_path = "/uploads/"
        custom.post_per_page = 12

        cookie.domain = 'domain.com'
        cookie.prefix = 'domain_com_'
        cookie.expires = 0
        cookie.path = '/'
        cookie.secure = true
        cookie.httponly = true
        cookie.samesite = 'Lax'
        cookie.raw = false

## Database variables

##### Add db connection info in .env

##### Create/Update Database tables structure

https://domain.com/lc-admin/update-db

##### Create first admin user

https://domain.com/lc-admin/first-login

#

# Custom Components

#### Create CustomAppContoller.php in App/Controllers to extends default module data

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

## Custom App Lc Modules

#### Run this command in terminal

        php spark create:custom-component <COMPONENT_NAME>

#### Edit the Migration file to generate custum database table

#### Create AppCustom.php in App/Routes

        // Custom LcModule
        $routes->group('lc-admin', ['namespace' => 'App\Controllers\LcCustom', 'filter' => 'admin_auth'], function ($routes) {
            $routes->group('component-name-route', function ($routes) {
                $routes->match(['GET', 'POST'], 'newpost', 'ComponentCotrollerName::method', ['as' => 'lc_conponent_name_new']);
                $routes->match(['GET', 'POST'], '', 'ComponentCotrollerName::index', ['as' => 'lc_conponent_name']);
            });
        });

        // Frontend Module
        $routes->group('component-name-route', ['namespace' => 'App\Controllers' ], function ($routes) {
            $routes->match(['GET', 'POST'], 'newpost', 'ComponentCotrollerName::method', ['as' => 'lc_conponent_name_new']);
            $routes->match(['GET', 'POST'], '', 'ComponentCotrollerName::index', ['as' => 'lc_conponent_name']);
        });

#### Add Lc Menu items in App\Controllers\BaseController->lc_plugin_modules

       protected $lc_plugin_modules = [
                'component' =>  [
                        'label' => 'Component Name',
                        'route' => 'lc_conponent_name',
                        'module' => 'conponent_name',
                        'ico' => 'basket',
                        'items' => [
                                [
                                        'label' => 'List',
                                        'route' => 'lc_conponent_name_index',
                                        'module_action' => 'index',
                                ],
                                [
                                        'label' => 'New',
                                        'route' => 'lc_conponent_name_new',
                                        'module_action' => 'new',
                                ]
                        ]
                ],
                'other-component' =>  [
                        'label' => 'Other Component',
                        'route' => 'lc_other_component',
                        'module' => 'other_component',
                        'ico' => 'cog'
                ],
        ];


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

#
# Bug conosciuti

## 500 Error for subpages (mod_rewrite)
Se l'applicazione genera errore 500 al primo avvio protrebbe dipendere dal *mod_rewrite.c* nel file .htaccess.

Disabilitare restrizioni per i link simbolici 

*In Plesk* disattivare **Restrict the ability to follow symbolic links** nelle configurazioni di Apache Ngix.

## 403 / 500 Error */?debugbar_time=*
Se in console trovi un errore 403 per la chiamata GET di */?debugbar_time=* potrebbe dipendere dal modulo **ModSecurity**.

Spegnere la regola che blocca questa chiamata in fase di debug potrebbe risolvere il problema.

*In Plesk* **Tools & Settings / Web Application Firewall** - **Switch off security rules**:
Provare ad aggiungere l'eccezione per la regola **214120** nel campo **Security rule IDs** 

#### *NB: se il problema persiste consultare i log del modulo **ModSecurity Log File***

Cercare tra i log il path interessato dall'errore *(?debugbar_time)*, Intercettare l'ID dell'errore (codice 8 caratteri preceduti da -- con suffisso -A-- dove A sta per indentificativo dell'informazione sull'errore).

        es: --69375927-A- --69375927-B- ... --69375927-H-

Cercare il codice errore con suffisso -H-- e tra i vari parametri della riga di debug intercettare **[id "000000"]**. Questo è l'ID della regola del ModSecurity violata.

Aggiungere l'ID della regola intercettata alle **Security rule IDs** nelle direttive **Switch off security rules**

#### *Se l'errore è 500 protrebbe dipendere dalla dimensione della risposta.*

*In Plesk* **Tools & Settings / Web Application Firewall / settings** 


##### Custom directives:

        SecResponseBodyLimit 536870912


Oppure come configurazione direttiva di Apache & nginx Settings

##### Custom directives:

        <IfModule mod_security2.c>
                SecResponseBodyLimit 536870912
        </IfModule>