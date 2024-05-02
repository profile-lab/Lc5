<?php

namespace Config;

// if (file_exists(ROOTPATH.'lc5/cms/Routes/api-custom.php')) {
// 	require ROOTPATH.'lc5/cms/Routes/api-custom.php';
// }else if (file_exists(ROOTPATH.'lc5/cms/Routes/api.php')) {
// 	require ROOTPATH.'lc5/cms/Routes/api.php';
// }

if (file_exists(APPPATH . 'Routes/api.php')) {
	require APPPATH . 'Routes/api.php';
}else if (file_exists(ROOTPATH.'Lc5/Api/Routes/api.php')) {
	require ROOTPATH.'Lc5/Api/Routes/api.php';
}
