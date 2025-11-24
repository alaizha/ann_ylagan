<?php
define('ROOTPATH', dirname(__DIR__) . '/');

require_once ROOTPATH . 'vendor/autoload.php';
require_once ROOTPATH . 'system/core/boot.php';

$app = new System\Core\Application();
$app->run();
