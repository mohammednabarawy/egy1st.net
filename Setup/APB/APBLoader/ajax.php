<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

add_action("wp_ajax_APBLayoutsBuilder", "APBLayoutsBuilder");
add_action("wp_ajax_APBAddLayoutBuilder", "APBAddLayoutBuilder");
add_action("wp_ajax_APBAddGroupFields", "APBAddGroupFields");
function APBLayoutsBuilder()
{
    $APB = new APB();
    (new APBFields())->AjaxFields($_POST["layout"], $_POST["fields"], $_POST["numb"]);
    wp_die();
}
function APBAddLayoutBuilder()
{
    $APB = new APB();
    (new APBFields())->APBAddLayoutBuilder($_POST["metabox"], $_POST["numb"]);
    wp_die();
}
function APBAddGroupFields()
{
    $APB = new APB();
    (new APBFields())->APBAddGroupFields($_POST["metabox"], $_POST["group"], $_POST["numb"]);
    wp_die();
}

?>