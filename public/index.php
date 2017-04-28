<?php
// application entry
define("DOCUMENT_ROOT", dirname(dirname(__FILE__)));
define("APP_PATH", DOCUMENT_ROOT . '/app/');
define("CONF_PATH", DOCUMENT_ROOT . '/conf/');
define("ENV_MODE", false === ini_get('yaf.environ') ? 'product' : ini_get('yaf.environ'));

$app = new Yaf\Application(CONF_PATH . '/application.ini', ENV_MODE);
$app->bootstrap()->run();
