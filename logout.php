<?php
require_once(__DIR__ . '/classes/access_user/db_config.php');

require_once(__DIR__ . '/includes/adl_features.php');
require_once(__DIR__ . '/includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

header('Location: /index.php?action=log_out'); die;
?>