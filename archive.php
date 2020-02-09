<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

$obj = get_queried_object();
if ($obj->taxonomy == "catnews" || $obj->taxonomy == "newstag") {
    $ptype = "news";
} else {
    $ptype = "post";
}
(new ThemeContext())->Archive($obj->taxonomy, $obj->term_id, $ptype, NULL, "recent", true);

?>