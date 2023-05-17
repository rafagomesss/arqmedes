<?php

define('DEFAULT_CONTROLLER', 'HomeController');
define('DEFAULT_ACTION', 'index');

define('DIR_ROOT', dirname($_SERVER['DOCUMENT_ROOT']));
define('BASE_DIR', '');

define('ASSETS_PATH', '/assets');
define('CSS_PATH', ASSETS_PATH . '/css');
define('JS_PATH', ASSETS_PATH . '/js');
define('IMG_PATH', ASSETS_PATH . '/img');
define('RESOURCES_PATH', DIR_ROOT . '/resources');
define('VIEWS_PATH', RESOURCES_PATH . '/views');
define('VIEWS_INCLUDES_PATH', VIEWS_PATH . '/includes');
define('VIEWS_TEMPLATES', VIEWS_PATH . '/template');