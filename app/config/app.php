<?php
require_once __DIR__ . '/../../vendor/autoload.php';
ini_set('max_execution_time', 18000);
ini_set('memory_limit', '512M');
ini_set('allow_url_fopen',1);
date_default_timezone_set('Asia/Kolkata');
if (!isset($_SESSION))
{
    session_start();
}

error_reporting(-1);
ini_set('display_errors', 1);
$config_current_dir                            = dirname(dirname(dirname(__FILE__)));
$env_current_dir                               = dirname(dirname(dirname(dirname(__FILE__))));
$env_jwt_full_path                             = $env_current_dir.'/itl-dashboard-v4-app-config/';
$full_path                                     = $config_current_dir.'/';
$dotenv = Dotenv\Dotenv::createImmutable($env_jwt_full_path, '.env');
$dotenv->safeLoad();
require_once $full_path."app/Config/logging.php";
global $logger;
$logger = get_logger();