<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

global $post;
$i = 0;
$args = array("fields" => "ids", "post_type" => "post", "meta_key" => "pin");
echo "<div class=\"SlidesInner\"><div class=\"InnerGets\">";
$args["posts_per_page"] = 1;
$wp_query = new WP_Query();
$wp_query->query($args);
while ($wp_query->have_posts()) {
    $wp_query->the_post();
    $i++;
    (new ThemeContext())->SlidBlock($post, $i);
}
wp_reset_query();
echo "</div><div class=\"SmallSlider\"><div class=\"SliderTopAjax\">";
$args["posts_per_page"] = 10;
$wp_query = new WP_Query();
$wp_query->query($args);
while ($wp_query->have_posts()) {
    $wp_query->the_post();
    (new ThemeContext())->TopMiniBlock($post);
}
wp_reset_query();
echo "</div></div></div>";
echo "<div id=\"AdsDiv\" style=\"\">" . (get_option("Ad1") != "" ? get_option("Ad1") : "") . "</div>";
echo "<section class=\"RelatedPosts SingMens\"><div class=\"container\"><div class=\"TopVBar\"><div class=\"MaiButtom\"><ul><li data-filter=\"latest\" class=\"active\" data-title=\"احدث المواضيع \" data-icon=\"far fa-clock\"><i class=\"far fa-clock\"></i> <span>احدث المواضيع </span></li><li data-filter=\"views\" data-title=\"الاكثر مشاهدة \" data-icon=\"far fa-eye\"> <i class=\"far fa-eye\"></i><span>الاكثر مشاهدة </span> </li><li data-filter=\"pin\" data-title=\"المثبت \" data-icon=\"fas fa-thumbtack\"><i class=\"fas fa-thumbtack\"></i> <span>المثبت </span></li><li data-filter=\"rate\" data-title=\"الاكثر تقيما \" data-icon=\"far fa-thumbs-up\"> <i class=\"far fa-thumbs-up\"></i> <span>الاكثر تقيما </span></li></ul></div><div class=\"social-btns\">";
echo "<a class=\"btn facebook\" href=\"" . get_option("facebook") . "\">";
echo "<i class=\"fab fa-facebook-f\"></i></a>";
echo "<a class=\"btn twitter\" href=\"" . get_option("twitter") . "\">";
echo "<i class=\"fab fa-twitter\"></i></a>";
echo "<a class=\"btn google\" href=\"" . get_option("youtube") . "\">";
echo "<i class=\"fab fa-youtube\"></i></a>";
echo "<a class=\"btn instagram\" href=\"" . get_option("instagram") . "\">";
echo "<i class=\"fab fa-instagram\"></i></a></div><hr class=\"slash-1\"></div><div class=\"MainRelated\" data-loading=\"false\">";
if (get_option("Posts_perFu")) {
    if (wp_is_mobile()) {
        $postNumber = "10";
    } else {
        $postNumber = get_option("Posts_perFu");
    }
} else {
    if (wp_is_mobile()) {
        $postNumber = "10";
    } else {
        $postNumber = "24";
    }
}
$args = array("fields" => "ids", "posts_per_page" => $postNumber, "post_type" => "post", "post__not_in" => get_option("sticky_posts"));
if (0 < count(get_posts($args))) {
    $wp_query = new WP_Query();
    $wp_query->query($args);
    while ($wp_query->have_posts()) {
        $wp_query->the_post();
        (new ThemeContext())->Block($post);
    }
} else {
    echo "<div class=\"EmptyPosts\">لاتوجد مواضيع حاليا </div>";
}
echo "</div><div class=\"BTNMores\" data-filter=\"latest\">المزيد من احدث المواضيع </div></div></section>";
echo "<div id=\"AdsDiv\" style=\"\">" . (get_option("Ad2") != "" ? get_option("Ad2") : "") . "</div>";
echo "<div id=\"AdsDiv\" style=\"\">" . (get_option("Ad3") != "" ? get_option("Ad3") : "") . "</div>";
echo "<section class=\"Sections\" id=\"Sections\" data-loading=\"false\"></section><div class=\"FooterLoadedOne\"></div>";

?>