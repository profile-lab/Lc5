<?php

namespace Config;


if (file_exists(APPPATH . 'Routes/routes-config.php')) {
    require APPPATH . 'Routes/routes-config.php';
} else if (file_exists(ROOTPATH . 'Lc5/Cms/Routes/routes-config.php')) {
    require ROOTPATH . 'Lc5/Cms/Routes/routes-config.php';
}

if (file_exists(APPPATH . 'Routes/lc-install.php')) {
    require APPPATH . 'Routes/lc-install.php';
} else if (file_exists(ROOTPATH . 'Lc5/Cms/Routes/lc-install.php')) {
    require ROOTPATH . 'Lc5/Cms/Routes/lc-install.php';
}

if (file_exists(APPPATH . 'Routes/lc-admin.php')) {
    require APPPATH . 'Routes/lc-admin.php';
} else if (file_exists(ROOTPATH . 'Lc5/Cms/Routes/lc-admin.php')) {
    require ROOTPATH . 'Lc5/Cms/Routes/lc-admin.php';
}
