<?php

define('VG_ACCESS',true);

header('Content-Type: text/html;charset=utf-8');
session_start();

require_once 'config.php';
require_once 'core/base/settings/interal_settings.php';
require_once 'libraries/functions.php';

use core\base\exceptions\RouteException;
use core\base\controller\RouteController;
use core\base\settings\Settings;

 $s = Settings::get('routed');
$s1 = Settings::get('temlateArr');



try {
    RouteController::instance()->route();
}catch(RouteException $e) {
    exit($e->getMessage());
}