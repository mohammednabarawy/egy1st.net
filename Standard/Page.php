<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

echo "<div class=\"SinglePost\">\n\t<div class=\"SinglePostTitle\">\n\t\t<h1>";
the_title();
echo "</h1>\n\t</div>\n\t<div class=\"PostContent\">\n\t\t";
the_content();
echo "\t</div>\n</div>";

?>