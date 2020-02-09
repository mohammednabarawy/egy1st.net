<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

define("WP_USE_THEMES", false);
$parse_uri = explode("wp-content", $_SERVER["SCRIPT_FILENAME"]);
require_once $parse_uri[0] . "wp-load.php";
header("Content-type: text/javascript");
echo "\n";

?>