# Levelcomplete 5 Corebase Module


## Install git submodule

        composer create-project codeigniter4/appstarter <project_name>  --no-dev
        cd <project_name>
        git init
        git submodule add https://github.com/profile-lab/Lc5
        git submodule add https://github.com/profile-lab/lc5-admin-assets public/assets/lc-admin-assets


## Base Configuration 

Add Supported Lang in App\Config\App.php

        public $supportedLocales = ['en','it','fr','es','de'];

Add LC5 psr4 namespace in App\Config\Autoload.php
        
        public $psr4 = [
                ...
                'Lc5\Cms'   => ROOTPATH . 'Lc5/Cms',
                'Lc5\Data'   => ROOTPATH . 'Lc5/Data',
                'Lc5\Web'   => ROOTPATH . 'Lc5/Web',
        ];

Add LC5 Admin filter in App\Config\Filters.php
        
        public $aliases = [
                ...
                'admin_auth'	=> \Lc5\Cms\Filters\AdminAuth::class,
        ];


Add LC5 services in App\Config\Services.php

        public static function admins($getShared = true)
        {
                if ($getShared)
                {
                return static::getSharedInstance('admins');
                }

                return new \Lc5\Cms\Controllers\Admins();
        }

        public static function shopcart($getShared = true)
        {
                if ($getShared)
                {
                return static::getSharedInstance('shopcart');
                }

                return new \Lc5\Web\Controllers\Shop\Cart();
        }

## Base Controller 

Add helpers requirements in App\Controllers\BaseController.php

        protected $helpers = ['html', 'text', 'form', 'profile', 'lc_view', 'web_view', 'custom_frontend'];

Add getShopSettings method in App\Controllers\BaseController.php

        //--------------------------------------------------------------------
        protected function getShopSettings()
        {
                // 
                $shop_settings_model = new \Lc5\Data\Models\ShopSettingsModel();
                if (!$shop_settings_entity = $shop_settings_model->asObject()->where('id_app', __web_app_id__ )->first()) {
                        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
                }
                // 
                return $shop_settings_entity;
        }


## Server Requirements

PHP version 7.4 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)
