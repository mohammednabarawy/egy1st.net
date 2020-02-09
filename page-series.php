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
$args = array("post_type" => "post", "fields" => "ids", "meta_key" => "pin", "posts_per_page" => wp_is_mobile() ? 5 : 10, "meta_query" => array(array("key" => "number", "compare" => "EXISTS")));
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
    $name = " - احدث الحلقات";
    $url = get_the_permalink($post->ID) . "?key=new";
}
if (isset($_GET["key"]) && $_GET["key"] == "latest") {
    $name = " - احدث المسلسلات ";
    $url = get_the_permalink($post->ID) . "?key=latest";
}
if (isset($_GET["key"]) && $_GET["key"] == "newSeries") {
    $name = " - مسلسلات جديدة";
    $url = get_the_permalink($post->ID) . "?key=newSeries";
}
if (isset($_GET["key"]) && $_GET["key"] == "best") {
    $name = " -  افضل المسلسلات";
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
echo "<a href=\"" . home_url() . "/series?key=new\">";
echo "<i class=\"far fa-video-plus\"></i><span>احدث الحلقات</span></a></li>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "latest" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/series?key=latest\">";
echo "<i class=\"fas fa-tv-retro\"></i><span>احدث المسلسلات </span></a></li>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "newSeries" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/series?key=newSeries\">";
echo "<i class=\"fal fa-plus\"></i><span> مسلسلات جديدة</span></a></li>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "best" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/series?key=best\">";
echo "<i class=\"far fa-star\"></i><span> افضل المسلسلات</span></a></li>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "famous" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/series?key=famous\">";
echo "<i class=\"fas fa-eye\"></i><span>الاكثر شهرة</span></a></li></ul></div><hr class=\"slash-1\"></div><div class=\"MainRelated\" data-loading=\"false\">";
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
    if ($_GET["key"] == "new") {
        $args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "meta_key" => "number");
        $wp_query = new WP_Query();
        $wp_query->query($args);
        while ($wp_query->have_posts()) {
            $wp_query->the_post();
            (new ThemeContext())->Block($post);
        }
        wp_reset_query();
    }
    if ($_GET["key"] == "latest") {
        $series = array_slice(get_categories(array("taxonomy" => "selary")), 0, $postNumber);
    } else {
        $series = array_slice(get_categories(array("taxonomy" => "selary", "meta_key" => $_GET["key"])), 0, $postNumber);
    }
    foreach ($series as $ser) {
        $posts = get_posts(array("post_type" => "post", "fields" => "ids", "posts_per_page" => 1, "selary" => $ser->slug));
        foreach ($posts as $post) {
            if (wp_get_attachment_url(get_post_thumbnail_id($post))) {
                $thumb = get_the_post_thumbnail_url($post);
            } else {
                $thumb = get_option("DefultBlock")["url"];
            }
            echo "<div class=\"MovieItem\">";
            echo "<a title=\"" . $ser->name . "\" href=\"" . get_term_link($ser) . "\" data-inc=\"" . $thumb . "\" data-style=\"background-image:url(" . $thumb . ")\">";
            if (get_term_meta($ser->term_id, "shortname", 1)) {
                echo " <div class=\"MinRows\">" . get_term_meta($ser->term_id, "shortname", 1) . "</div>";
            } else {
                echo "<div class=\"MinRows\">" . $ser->name . "</div>";
            }
            echo "<div class=\"TitleMovie\">";
            echo "<h2>" . $ser->name . "</h2>";
            echo "<ul class=\"ListMacks\">";
            if (get_the_terms($post, "category", 1)) {
                foreach (array_slice(is_array(get_the_terms($post, "category", 1)) ? get_the_terms($post, "category", 1) : array(), 0, 1) as $category) {
                    echo "<li><i class=\"fas fa-th-list\"></i>";
                    echo "<span>" . $category->name . "</span>";
                    echo "</li>";
                }
            }
            if (get_the_terms($post, "genre", 1)) {
                foreach (array_slice(is_array(get_the_terms($post, "genre", 1)) ? get_the_terms($post, "genre", 1) : array(), 0, 1) as $genre) {
                    echo "<li><i class=\"fas fa-film\"></i>";
                    echo "<span>" . $genre->name . "</span>";
                    echo "</li>";
                }
            }
            echo "</ul></div><div class=\"PostMetaTar\">";
            if (get_post_meta($post, "imdbRating", true)) {
                echo "<div class=\"IMDBlock\"><span>IMDB</span><em>" . get_post_meta($post, "imdbRating", true) . "</em></div>";
            }
            if (get_the_terms($post, "Quality", 1)) {
                foreach (array_slice(is_array(get_the_terms($post, "Quality", 1)) ? get_the_terms($post, "Quality", 1) : array(), 0, 1) as $quality) {
                    echo "<div class=\"QualtBLock\">" . $quality->name . "</div>";
                }
            }
            echo "</div></a></div>";
        }
    }
} else {
    $args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "meta_key" => "number");
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