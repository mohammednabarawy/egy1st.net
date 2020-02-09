<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

$curauth = get_query_var("author_name") ? get_user_by("slug", get_query_var("author_name")) : get_userdata(get_query_var("author"));
$ptype = "post";
(new ThemeContext())->Author($curauth, $ptype, NULL, "recent", true);

?>