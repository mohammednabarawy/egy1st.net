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
global $post;
$i = 0;
$args = array("post_type" => "post", "fields" => "ids", "meta_key" => "pin", "posts_per_page" => wp_is_mobile() ? 5 : 10, "meta_query" => array(array("key" => "number", "compare" => "NOT EXISTS")));
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
echo "<div id=\"AdsDiv\" style=\"\">" . (get_option("Ad11") != "" ? get_option("Ad11") : "") . "</div>";
echo "<section class=\"MangeMentBlocks\"><div class=\"TopVBar\"><span class=\"unInd\">";
$title = get_the_title($post->ID);
$name = "";
$url = get_the_permalink($post->ID);
if (isset($_GET["key"]) && $_GET["key"] == "new") {
    $name = " - افلام جديدة";
    $url = get_the_permalink($post->ID) . "?key=new";
}
if (isset($_GET["key"]) && $_GET["key"] == "latest") {
    $name = " - احدث الاضافات";
    $url = get_the_permalink($post->ID) . "?key=latest";
}
if (isset($_GET["key"]) && $_GET["key"] == "imdbRating") {
    $name = " - الاكثر تقيما";
    $url = get_the_permalink($post->ID) . "?key=imdbRating";
}
if (isset($_GET["key"]) && $_GET["key"] == "best") {
    $name = " - افضل الافلام";
    $url = get_the_permalink($post->ID) . "?key=best";
}
if (isset($_GET["key"]) && $_GET["key"] == "famous") {
    $name = " - الاكثر شهرة";
    $url = get_the_permalink($post->ID) . "?key=famous";
}
echo "<a href=\"" . $url . "\" alt=\"" . get_the_title($post->ID) . "\" title=\"" . get_the_title($post->ID) . "\">";
echo "<i class=\"fas fa-film\"></i>";
echo "<em>" . $title . "" . $name . "</em>";
echo "</a></span><div class=\"MaiButtom\"><ul>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "new" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/movies?key=new\">";
echo "<i class=\"far fa-video-plus\"></i><span>افلام جديدة</span></a></li>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "latest" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/movies?key=latest\">";
echo "<i class=\"fal fa-plus\"></i><span> احدث الاضافات</span></a></li>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "imdbRating" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/movies?key=imdbRating\">";
echo "<i class=\"fas fa-thumbs-up\"></i><span>الاكثر تقيما </span></a></li>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "best" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/movies?key=best\">";
echo "<i class=\"far fa-star\"></i><span> افضل الافلام</span></a></li>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "famous" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/movies?key=famous\">";
echo "<i class=\"fas fa-eye\"></i><span> الاكثر شهرة</span></a></li></ul></div><hr class=\"slash-1\"></div><div class=\"MainRelated\" data-loading=\"false\">";
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
if (isset($_GET["key"])) {
    if ($_GET["key"] == "latest") {
        $args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "meta_query" => array(array("key" => "number", "compare" => "NOT EXISTS")));
        $wp_query = new WP_Query();
        $wp_query->query($args);
        while ($wp_query->have_posts()) {
            $wp_query->the_post();
            (new ThemeContext())->Block($post);
        }
        wp_reset_query();
    } else {
        if ($_GET["key"] == "famous") {
            $args = array("post_type" => "post", "meta_key" => "views", "orderby" => "meta_value_num", "fields" => "ids", "posts_per_page" => $postNumber, "meta_query" => array(array("key" => "number", "compare" => "NOT EXISTS")));
            $wp_query = new WP_Query();
            $wp_query->query($args);
            while ($wp_query->have_posts()) {
                $wp_query->the_post();
                (new ThemeContext())->Block($post);
            }
            wp_reset_query();
        } else {
            $args = array("post_type" => "post", "meta_key" => $_GET["key"], "fields" => "ids", "posts_per_page" => $postNumber, "meta_query" => array(array("key" => "number", "compare" => "NOT EXISTS")));
            if (isset($_GET["key"]) && $_GET["key"] == "imdbRating") {
                $args["orderby"] = "meta_value_num";
            }
            $wp_query = new WP_Query();
            $wp_query->query($args);
            while ($wp_query->have_posts()) {
                $wp_query->the_post();
                (new ThemeContext())->Block($post);
            }
            wp_reset_query();
        }
    }
} else {
    $args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "meta_query" => array(array("key" => "number", "compare" => "NOT EXISTS")));
    $wp_query = new WP_Query();
    $wp_query->query($args);
    while ($wp_query->have_posts()) {
        $wp_query->the_post();
        (new ThemeContext())->Block($post);
    }
    wp_reset_query();
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