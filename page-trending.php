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
$args = array("post_type" => "post", "fields" => "ids", "meta_key" => "pin", "posts_per_page" => wp_is_mobile() ? 5 : 10);
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
wp_reset_query();
echo "<div id=\"AdsDiv\" style=\"\">" . (get_option("Ad11") != "" ? get_option("Ad11") : "") . "</div>";
echo "<section class=\"MangeMentBlocks\"><div class=\"TopVBar\"><span class=\"unInd\">";
$title = get_the_title($post->ID);
$name = "";
$url = get_the_permalink($post->ID);
if (isset($_GET["key"]) && $_GET["key"] == "now") {
    $name = " - الان";
    $url = get_the_permalink($post->ID) . "?key=now";
}
if (isset($_GET["key"]) && $_GET["key"] == "today") {
    $name = " - اليوم";
    $url = get_the_permalink($post->ID) . "?key=today";
}
if (isset($_GET["key"]) && $_GET["key"] == "week") {
    $name = " - الاسبوع";
    $url = get_the_permalink($post->ID) . "?key=week";
}
if (isset($_GET["key"]) && $_GET["key"] == "month") {
    $name = " -  الشهر ";
    $url = get_the_permalink($post->ID) . "?key=month";
}
echo "<a href=\"" . $url . "\" alt=\"" . get_the_title($post->ID) . "\" title=\"" . get_the_title($post->ID) . "\">";
echo "<i class=\"fas fa-film\"></i>";
echo "<em>" . $title . "" . $name . "</em>";
echo "</a></span><div class=\"MaiButtom\"><ul>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "now" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/trending?key=now\">";
echo (isset($_GET["key"]) && $_GET["key"] == "now" || !isset($_GET["key"]) ? "<i class=\"fad fa-fire-alt\"></i>" : "<i class=\"fal fa-fire\"></i>") . "<span>الان</span>";
echo "</a></li>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "today" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/trending?key=today\">";
echo (isset($_GET["key"]) && $_GET["key"] == "today" || !isset($_GET["key"]) ? "<i class=\"fad fa-fire-alt\"></i>" : "<i class=\"fal fa-fire\"></i>") . "<span>اليوم</span>";
echo "</a></li>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "week" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/trending?key=week\">";
echo (isset($_GET["key"]) && $_GET["key"] == "week" || !isset($_GET["key"]) ? "<i class=\"fad fa-fire-alt\"></i>" : "<i class=\"fal fa-fire\"></i>") . "<span>هذا الاسبوع</span>";
echo "</a></li>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "month" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/trending?key=month\">";
echo (isset($_GET["key"]) && $_GET["key"] == "month" || !isset($_GET["key"]) ? "<i class=\"fad fa-fire-alt\"></i>" : "<i class=\"fal fa-fire\"></i>") . "<span>ذا الشهر</span>";
echo "</a></li></ul></div><hr class=\"slash-1\"></div><div class=\"MainRelated\" data-loading=\"false\">";
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
if (isset($_GET["key"]) && $_GET["key"] == "now") {
    $array = is_array(get_option(date("Y-m-d H"))) ? get_option(date("Y-m-d H")) : array();
    uasort($array, "compare");
    $arg = array();
    if (!empty($array)) {
        $posts = array();
        foreach ($array as $post => $views) {
            $posts[] = $post;
        }
        $arg = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "post__in" => $posts);
    }
} else {
    if (isset($_GET["key"]) && $_GET["key"] == "today") {
        $array = is_array(get_option(date("Y-m-d"))) ? get_option(date("Y-m-d")) : array();
        $arg = array();
        uasort($array, "compare");
        if (!empty($array)) {
            $posts = array();
            foreach ($array as $post => $views) {
                $posts[] = $post;
            }
            $arg = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "post__in" => $posts);
        }
    } else {
        if (isset($_GET["key"]) && $_GET["key"] == "week") {
            $array = is_array(get_option(date("W-Y"))) ? get_option(date("W-Y")) : array();
            $arg = array();
            uasort($array, "compare");
            if (!empty($array)) {
                $posts = array();
                foreach ($array as $post => $views) {
                    $posts[] = $post;
                }
                $arg = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "post__in" => $posts);
            }
        } else {
            if (isset($_GET["key"]) && $_GET["key"] == "month") {
                $array = is_array(get_option(date("Y-m"))) ? get_option(date("Y-m")) : array();
                $arg = array();
                uasort($array, "compare");
                if (!empty($array)) {
                    $posts = array();
                    foreach ($array as $post => $views) {
                        $posts[] = $post;
                    }
                    $arg = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "post__in" => $posts);
                }
            } else {
                $array = is_array(get_option(date("Y-m-d H"))) ? get_option(date("Y-m-d H")) : array();
                $arg = array();
                uasort($array, "compare");
                if (!empty($array)) {
                    $posts = array();
                    foreach ($array as $post => $views) {
                        $posts[] = $post;
                    }
                    $arg = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "post__in" => $posts);
                }
            }
        }
    }
}
if (0 < count(get_posts($arg))) {
    $wp_query = new WP_Query();
    $wp_query->query($arg);
    while ($wp_query->have_posts()) {
        $wp_query->the_post();
        (new ThemeContext())->Block($post);
    }
    wp_reset_query();
} else {
    echo "<h2 class=\"noMorePosts\">لا يوجد نتائج اخري</h2>        <script type=\"text/javascript\">\n          \$(function(){\n            \$('.MainRelated').attr('data-loading','true');\n          })\n        </script>\n      ";
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