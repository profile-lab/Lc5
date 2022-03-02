<?php

namespace Config;

// if (file_exists(ROOTPATH.'lc5/cms/Routes/api-custom.php')) {
// 	require ROOTPATH.'lc5/cms/Routes/api-custom.php';
// }else if (file_exists(ROOTPATH.'lc5/cms/Routes/api.php')) {
// 	require ROOTPATH.'lc5/cms/Routes/api.php';
// }

if (file_exists(ROOTPATH.'lc5/Web/Routes/web-custom.php')) {
	require ROOTPATH.'lc5/Web/Routes/web-custom.php';
}else if (file_exists(ROOTPATH.'lc5/Web/Routes/web.php')) {
	require ROOTPATH.'lc5/Web/Routes/web.php';
}
