<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

$schema_link = "http://data-vocabulary.org/Breadcrumb";
$home = "الرئيسية";
$homeLink = home_url();
wp_reset_query();
echo "<div class=\"ActorsShape\"><div class=\"MainActorsSlides\"><div class=\"MainActorsSlidesInner\">";
global $post;
$args = array("fields" => "ids", "post_type" => "customlink", "posts_per_page" => 20, "meta_key" => "views", "orderby" => "meta_value_num");
$wp_query = new WP_Query();
$wp_query->query($args);
while ($wp_query->have_posts()) {
    $wp_query->the_post();
    echo "<a href=\"" . get_the_permalink($post) . "\" class=\"ActorItem\" title=\"" . get_the_title($post) . "\">";
    echo "<h2> # " . get_the_title($post) . "</h2>";
    echo "</a>";
}
wp_reset_query();
echo "</div></div></div><section class=\"MangeMentBlocks\"><div class=\"TopVBar\"><span class=\"unInd\">";
echo "<a href=\"" . get_the_permalink($post->ID) . "\" alt=\"" . get_the_title($post->ID) . "\" title=\"" . get_the_title($post->ID) . "\">";
echo "<i class=\"fas fa-film\"></i>";
echo "<em>" . get_the_title($post->ID) . "</em>";
echo "</a></span><hr class=\"slash-1\"></div><div class=\"MainRelated\" data-loading=\"false\">";
global $post;
$args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => 30, "tax_query" => array("relation" => "AND"));
if (get_post_meta($post->ID, "tag_category", true) != "") {
    $args["tax_query"][] = array("taxonomy" => "category", "terms" => get_post_meta($post->ID, "tag_category", true), "field" => "id", "include_children" => true, "operator" => "IN");
}
if (get_post_meta($post->ID, "actor_category", true) != "") {
    $args["tax_query"][] = array("taxonomy" => "actor", "terms" => get_post_meta($post->ID, "actor_category", true), "field" => "id", "include_children" => true, "operator" => "IN");
}
if (get_post_meta($post->ID, "director_category", true) != "") {
    $args["tax_query"][] = array("taxonomy" => "director", "terms" => get_post_meta($post->ID, "director_category", true), "field" => "id", "include_children" => true, "operator" => "IN");
}
if (get_post_meta($post->ID, "genre_category", true) != "") {
    $args["tax_query"][] = array("taxonomy" => "genre", "terms" => get_post_meta($post->ID, "genre_category", true), "field" => "id", "include_children" => true, "operator" => "IN");
}
if (get_post_meta($post->ID, "quality_category", true) != "") {
    $args["tax_query"][] = array("taxonomy" => "Quality", "terms" => get_post_meta($post->ID, "quality_category", true), "field" => "id", "include_children" => true, "operator" => "IN");
}
if (get_post_meta($post->ID, "escritor_category", true) != "") {
    $args["tax_query"][] = array("taxonomy" => "escritor", "terms" => get_post_meta($post->ID, "escritor_category", true), "field" => "id", "include_children" => true, "operator" => "IN");
}
if (get_post_meta($post->ID, "year_category", true) != "") {
    $args["tax_query"][] = array("taxonomy" => "release-year", "terms" => get_post_meta($post->ID, "year_category", true), "field" => "id", "include_children" => true, "operator" => "IN");
}
if (0 < count(get_posts($args))) {
    $wp_query = new WP_Query();
    $wp_query->query($args);
    while ($wp_query->have_posts()) {
        $wp_query->the_post();
        (new ThemeContext())->Block($post);
    }
    wp_reset_query();
} else {
    echo "<h2 class=\"noMorePosts\">لا يوجد نتائج اخري</h2>        <script type=\"text/javascript\">\n          \$(function(){\n            \$('.MainRelated').attr('data-loading', 'true');\n          });\n        </script>\n      ";
}
echo "</div></section><div class=\"FooterLoadedOne\"></div>";
wp_reset_query();
echo "<div class=\"BreadcrumbMasteriv\" style=\"opacity:1\"><div class=\"breadcrumbs\"><div class=\"breadcrumb clearfix\"><div id=\"mpbreadcrumbs\">";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "\">";
echo "<span itemprop=\"title\">" . $home . "</span>";
echo "</a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/movies\">";
echo "# <span itemprop=\"title\">افلام </span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/movies?key=new\">";
echo "# <span itemprop=\"title\">افلام جديدة </span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/movies?key=latest\">";
echo "# <span itemprop=\"title\">الافلام المضافة حديثا </span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/movies?key=imdbRating\">";
echo "# <span itemprop=\"title\">الافلام الاكثر تقيما</span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/movies?key=best\">";
echo "# <span itemprop=\"title\">افضل الافلام</span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/movies?key=best\">";
echo "# <span itemprop=\"title\">الافلام الاكثر شهرة</span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/series\">";
echo "# <span itemprop=\"title\">مسلسلات </span></a> </span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/series?key=new\">";
echo "# <span itemprop=\"title\">احدث الحلقات</span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/series?key=latest\">";
echo "# <span itemprop=\"title\">احدث المسلسلات</span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/series?key=newSeries\">";
echo "# <span itemprop=\"title\">مسلسلات جديدة</span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/series?key=best\">";
echo "# <span itemprop=\"title\">افضل المسلسلات</span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/series?key=famous\">";
echo "# <span itemprop=\"title\">المسلسلات  الاكثر شهرة</span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/tvshow\">";
echo "# <span itemprop=\"title\">برامج </span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/tvshow?key=new\">";
echo "# <span itemprop=\"title\">احدث الحلقات البرامج </span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/tvshow?key=latest\">";
echo "# <span itemprop=\"title\">احدث البرامج</span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/tvshow?key=newSeries\">";
echo "# <span itemprop=\"title\">برامج جديدة</span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/tvshow?key=best\">";
echo "# <span itemprop=\"title\">افضل البرامج</span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/tvshow?key=famous\">";
echo "# <span itemprop=\"title\">البرامج الاكثر شهرة</span></a></span> ";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/trending\">";
echo "# <span itemprop=\"title\">ترندي</span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/trending/?key=now\">";
echo "# <span itemprop=\"title\">ترندي الان </span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/trending?key=today\">";
echo "# <span itemprop=\"title\">ترندي اليوم</span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/trending?key=week\">";
echo "# <span itemprop=\"title\">ترندي الاسبوع </span></a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/trending?key=month\">";
echo "# <span itemprop=\"title\">ترندي الشهر </span></a></span>";
wp_reset_query();
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . get_the_permalink($post->ID) . "\">";
echo "# <span itemprop=\"title\">" . get_the_title($post->ID) . "</span>";
echo "</a></span></div></div></div></div>";

?>