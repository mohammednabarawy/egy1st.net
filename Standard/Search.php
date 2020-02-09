<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

$s = get_search_query();
$schema_link = "http://data-vocabulary.org/Breadcrumb";
$home = "الرئيسية";
$homeLink = home_url();
global $post;
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
echo "</div></div></div>";
echo "<div id=\"AdsDiv\" style=\"\">" . (get_option("Ad11") != "" ? get_option("Ad11") : "") . "</div>";
echo "<section class=\"MangeMentBlocks\"><div class=\"TopVBar\"><span class=\"unInd\"><i class=\"fas fa-film\"></i>";
echo "<em>نتائج البحث عن " . $s . "</em>";
echo "</span><hr class=\"slash-1\"></div><div class=\"MainRelated\" data-loading=\"false\">";
global $post;
$args = array("fields" => "ids", "post_type" => "post", "posts_per_page" => 30, "s" => $s);
$wp_query = new WP_Query();
$wp_query->query($args);
while ($wp_query->have_posts()) {
    $wp_query->the_post();
    (new ThemeContext())->Block($post);
}
wp_reset_query();
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
echo "</div></div></div></div>";

?>