<?php

namespace Config;

// if (file_exists(ROOTPATH.'lc5/cms/Routes/api-custom.php')) {
// 	require ROOTPATH.'lc5/cms/Routes/api-custom.php';
// }else if (file_exists(ROOTPATH.'lc5/cms/Routes/api.php')) {
// 	require ROOTPATH.'lc5/cms/Routes/api.php';
// }

if (file_exists(APPPATH . 'Routes/web.php')) {
	require APPPATH . 'Routes/web.php';
}else if (file_exists(ROOTPATH.'Lc5/Web/Routes/web.php')) {
	require ROOTPATH.'Lc5/Web/Routes/web.php';
}
