<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

add_action("wp_ajax_YTSLayoutsBuilder", "YTSLayoutsBuilder");
add_action("wp_ajax_YTSAddLayoutBuilder", "YTSAddLayoutBuilder");
add_action("wp_ajax_YTSAddGroupFields", "YTSAddGroupFields");
function YTSLayoutsBuilder()
{
    $YTS = new YTS();
    (new YTSFields())->AjaxFields($_POST["layout"], $_POST["fields"], $_POST["numb"]);
    wp_die();
}
function YTSAddLayoutBuilder()
{
    $YTS = new YTS();
    (new YTSFields())->YTSAddLayoutBuilder($_POST["metabox"], $_POST["numb"]);
    wp_die();
}
function YTSAddGroupFields()
{
    $YTS = new YTS();
    (new YTSFields())->YTSAddGroupFields($_POST["metabox"], $_POST["group"], $_POST["numb"]);
    wp_die();
}

?>