<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

(new ThemeContext())->Header();
$schema_link = "http://data-vocabulary.org/Breadcrumb";
$home = "الرئيسية";
$homeLink = home_url();
echo "<div id=\"AdsDiv\" style=\"\">" . (get_option("Ad11") != "" ? get_option("Ad11") : "") . "</div>";
echo "<section class=\"MangeMentBlocks MarGinTop\"><div class=\"TopVBar\"><span class=\"unInd\">";
echo "<a href=\"" . get_the_permalink($post->ID) . "\" alt=\"" . get_the_title($post->ID) . "\" title=\"" . get_the_title($post->ID) . "\">";
echo "<i class=\"fas fa-film\"></i>";
echo "<em>" . get_the_title($post->ID) . "</em>";
echo "</a></span><hr class=\"slash-1\"></div><div class=\"MainRelated\" data-loading=\"false\">";
global $post;
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
$args = array("posts_per_page" => $postNumber, "fields" => "ids", "post_type" => "post", "tax_query" => array("relation" => "AND"));
if (isset($_GET["cat"]) && !empty($_GET["cat"])) {
    $args["tax_query"][] = array("taxonomy" => "category", "terms" => get_term_by("slug", $_GET["cat"], "category")->term_id, "field" => "id", "include_children" => true, "operator" => "IN");
}
if (isset($_GET["release"]) && !empty($_GET["release"])) {
    $args["tax_query"][] = array("taxonomy" => "release-year", "terms" => $_GET["release"], "field" => "slug", "include_children" => true, "operator" => "IN");
}
if (isset($_GET["quality"]) && !empty($_GET["quality"])) {
    $args["tax_query"][] = array("taxonomy" => "Quality", "terms" => $_GET["quality"], "field" => "slug", "include_children" => true, "operator" => "IN");
}
if (isset($_GET["lang"]) && !empty($_GET["lang"])) {
    $args["tax_query"][] = array("taxonomy" => "language", "terms" => $_GET["lang"], "field" => "slug", "include_children" => true, "operator" => "IN");
}
if (isset($_GET["nation"]) && !empty($_GET["nation"])) {
    $args["tax_query"][] = array("taxonomy" => "country", "terms" => $_GET["nation"], "field" => "slug", "include_children" => true, "operator" => "IN");
}
if (isset($_GET["resolution"]) && !empty($_GET["resolution"])) {
    $args["tax_query"][] = array("taxonomy" => "resolution", "terms" => $_GET["resolution"], "field" => "slug", "include_children" => true, "operator" => "IN");
}
if (isset($_GET["genre"]) && !empty($_GET["genre"])) {
    $args["tax_query"][] = array("taxonomy" => "genre", "terms" => $_GET["genre"], "field" => "slug", "include_children" => true, "operator" => "IN");
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
    echo "          <script type=\"text/javascript\">\n            \$(function(){\n              \$('.MainRelated').attr('data-loading', 'true');\n            });\n          </script>\n          <h2 class=\"noMorePosts\">لا يوجد نتائج اخري</h2>\n        ";
}
echo "</div></section><div class=\"FooterLoadedOne\"></div>";
echo "<div id=\"AdsDiv\" style=\"\">" . (get_option("Ad12") != "" ? get_option("Ad12") : "") . "</div>";
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
(new ThemeContext())->Footer();

?>