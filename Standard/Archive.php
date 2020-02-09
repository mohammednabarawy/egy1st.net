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
$obj = get_queried_object();
global $post;
$MarGinTop = false;
if ($ptype == "news") {
    $MarGinTop = true;
} else {
    $i = 0;
    $SlidHead = array("fields" => "ids", "post_type" => "post", "posts_per_page" => 10, "post__in" => get_option("sticky_posts"), "meta_key" => "pin", "ignore_sticky_posts" => 1, "tax_query" => array("relation" => "AND"));
    if ($obj->taxonomy == "category") {
        $SlidHead["tax_query"][] = array("taxonomy" => "category", "terms" => $obj->term_id, "field" => "id", "include_children" => true, "operator" => "IN");
    } else {
        if ($obj->taxonomy == "post_tag") {
            $SlidHead["tax_query"][] = array("taxonomy" => "post_tag", "terms" => $obj->term_id, "field" => "id", "include_children" => true, "operator" => "IN");
        } else {
            $SlidHead["tax_query"][] = array("taxonomy" => $obj->taxonomy, "terms" => $obj->slug, "field" => "slug", "include_children" => true, "operator" => "IN");
        }
    }
    if (0 < count(get_posts($SlidHead))) {
        echo "<div class=\"SlidesInner\"><div class=\"InnerGets\">";
        $args["posts_per_page"] = 1;
        $wp_query = new WP_Query();
        $wp_query->query($SlidHead);
        while ($wp_query->have_posts()) {
            $wp_query->the_post();
            $i++;
            (new ThemeContext())->SlidBlock($post, $i);
        }
        wp_reset_query();
        echo "</div><div class=\"SmallSlider\"><div class=\"SliderTopAjax\">";
        $args["posts_per_page"] = 10;
        $wp_query = new WP_Query();
        $wp_query->query($SlidHead);
        while ($wp_query->have_posts()) {
            $wp_query->the_post();
            (new ThemeContext())->TopMiniBlock($post);
        }
        wp_reset_query();
        echo "</div></div></div>";
        wp_reset_query();
    }
}
echo "<section class=\"MangeMentBlocks " . (count(get_posts($SlidHead)) <= 0 ? "MarGinTop" : "") . "" . ($MarGinTop == true ? "MarGinTop" : "") . "\">";
echo "<div class=\"TopVBar\">";
if (get_queried_object()->taxonomy == "actor" || get_queried_object()->taxonomy == "director" || get_queried_object()->taxonomy == "escritor") {
    echo "<span class=\"unInd fuctsd \">";
    echo "<a href=\"" . get_term_meta($obj) . "\" alt=\"" . $obj->name . "\" title=\"" . $obj->name . "\">";
    echo "<div class=\"actIm\">";
    if (get_term_meta(get_queried_object()->term_id, "image", 1) != "") {
        echo "<img src=\"" . get_term_meta(get_queried_object()->term_id, "image", 1)["url"] . "\">";
    } else {
        echo "<img src=\"" . get_template_directory_uri() . "/Standard/UI/img/user.png\">";
    }
    echo "</div><em>";
    echo "كل اعمال  " . $obj->name;
    echo "<em>";
    echo count(get_posts(array("post_type" => "post", "posts_per_page" => -1, get_queried_object()->taxonomy => get_queried_object()->slug)));
    echo "</em></em>";
    echo "<p>" . get_queried_object()->description . "</p>";
    echo "</a></span>";
} else {
    if ($obj->parent == 0) {
        echo "<span class=\"unInd\">";
        echo "<a href=\"" . get_term_meta($obj) . "\" alt=\"" . $obj->name . "\" title=\"" . $obj->name . "\">";
        echo "<i class=\"fas fa-film\"></i>";
        echo "<em>" . $obj->name . "</em>";
        echo "</a></span>";
    } else {
        $parent = get_term($obj->parent, get_queried_object()->taxonomy);
        echo "<span class=\"unInd\">";
        echo "<a  class=\"ParentSer\" href=\"" . get_term_link($parent) . "\" alt=\"" . $parent->name . "\" title=\"" . $parent->name . "\">";
        if ($obj->taxonomy == "catnews" || $obj->taxonomy == "newstag") {
            echo "<i class=\"fal fa-newspaper\"></i>";
        } else {
            echo "<i class=\"fas fa-film\"></i>";
        }
        echo "<em>" . $parent->name . "</em>";
        echo "</a> - ";
        echo "<a class=\"AnParent\" href=\"" . get_term_link($obj) . "\" alt=\"" . $obj->name . "\" title=\"" . $obj->name . "\"><em>" . $obj->name . "</em></a>";
        echo "</span>";
    }
}
if ($obj->taxonomy == "category") {
    echo "<div class=\"MaiButtom\">";
    if (strpos($obj->name, "مسلسلات") !== false || strpos($obj->name, "مسلسل") !== false || strpos($obj->name, "المسلسلات") !== false || strpos($obj->name, "ألمسلسلات") !== false || strpos($obj->name, "المسلسل") !== false || strpos($obj->name, "ألمسلسل") !== false) {
        echo "<ul><li>";
        echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "new" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/series?key=new\">";
        echo "<i class=\"far fa-video-plus\"></i><span>احدث الحلقات</span></a></li><li>";
        echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "latest" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/series?key=latest\">";
        echo "<i class=\"fas fa-tv-retro\"></i><span>احدث المسلسلات </span></a></li><li>";
        echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "newSeries" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/series?key=newSeries\">";
        echo "<i class=\"fal fa-plus\"></i><span> مسلسلات جديدة</span></a></li><li>";
        echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "best" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/series?key=best\">";
        echo "<i class=\"far fa-star\"></i><span> افضل المسلسلات</span></a></li><li>";
        echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "famous" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/series?key=famous\">";
        echo "<i class=\"fas fa-eye\"></i><span> الاكثر شهرة</span></a></li></ul>";
    } else {
        if (strpos($obj->name, "البرامج ") !== false || strpos($obj->name, "برنامج") !== false || strpos($obj->name, "ألبرامج") !== false || strpos($obj->name, "برامج تليفزيونة") !== false || strpos($obj->name, "برامج تليفزيونه") !== false) {
            echo "<ul><li>";
            echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "new" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/tv?key=new\">";
            echo "<i class=\"far fa-video-plus\"></i><span>احدث الحلقات</span></a></li><li>";
            echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "latest" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/tv?key=latest\">";
            echo "<i class=\"fal fa-plus\"></i><span>احدث البرامج </span></a></li><li>";
            echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "newSeries" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/tv?key=newSeries\">";
            echo "<i class=\"fal fa-plus\"></i><span>برامج جديدة</span></a></li><li>";
            echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "best" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/tv?key=best\">";
            echo "<i class=\"far fa-star\"></i><span>افضل البرامج</span></a></li><li>";
            echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "famous" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/tv?key=famous\">";
            echo "<i class=\"fas fa-eye\"></i><span> الاكثر شهرة</span></a></li></ul>";
        } else {
            echo "<ul><li>";
            echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "new" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/movies?key=new\">";
            echo "<i class=\"far fa-video-plus\"></i><span>افلام جديدة</span></a></li><li>";
            echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "latest" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/movies?key=latest\">";
            echo "<i class=\"fal fa-plus\"></i><span> احدث الاضافات</span></a></li><li>";
            echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "imdbRating" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/movies?key=imdbRating\">";
            echo "<i class=\"fas fa-thumbs-up\"></i><span>الاكثر تقيما </span></a></li><li>";
            echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "best" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/movies?key=best\">";
            echo "<i class=\"far fa-star\"></i><span> افضل الافلام</span></a></li><li>";
            echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "famous" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/movies?key=famous\">";
            echo "<i class=\"fas fa-eye\"></i><span> الاكثر شهرة</span></a></li></ul>";
        }
    }
    echo "</div>";
} else {
    if (!($obj->taxonomy == "catnews" || $obj->taxonomy == "newstag")) {
        echo "<div class=\"MaiButtom\"><ul><li>";
        echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "new" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/movies?key=new\">";
        echo "<i class=\"far fa-video-plus\"></i><span>افلام جديدة</span></a></li><li>";
        echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "latest" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/movies?key=latest\">";
        echo "<i class=\"fal fa-plus\"></i><span> احدث الاضافات</span></a></li><li>";
        echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "imdbRating" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/movies?key=imdbRating\">";
        echo "<i class=\"fas fa-thumbs-up\"></i><span>الاكثر تقيما </span></a></li><li>";
        echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "best" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/movies?key=best\">";
        echo "<i class=\"far fa-star\"></i><span> افضل الافلام</span></a></li><li>";
        echo "<a " . (isset($_GET["key"]) && $_GET["key"] == "famous" ? "class=\"active\"" : "") . "href=\"" . home_url() . "/movies?key=famous\">";
        echo "<i class=\"fas fa-eye\"></i><span> الاكثر شهرة</span></a></li></ul></div>";
    }
}
echo "<hr class=\"slash-1\"></div><div class=\"MainRelated\" data-loading=\"false\">";
if ($ptype == "news") {
    $found = false;
    global $post;
    $args = array("post_type" => "news", "fields" => "ids", "posts_per_page" => 30, "tax_query" => array("relation" => "AND"));
    $args["tax_query"][] = array("taxonomy" => $obj->taxonomy, "terms" => $obj->slug, "field" => "slug", "include_children" => true, "operator" => "IN");
    $wp_query = new WP_Query();
    $wp_query->query($args);
    while ($wp_query->have_posts()) {
        $wp_query->the_post();
        (new ThemeContext())->NewsBlock($post);
    }
    wp_reset_query();
} else {
    $found = false;
    global $post;
    $args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => 30, "tax_query" => array("relation" => "AND"));
    if (isset($_GET["key"]) && $_GET["key"] != "latest") {
        $args["meta_key"] = $_GET["key"];
    }
    if ($obj->taxonomy == "category") {
        $args["tax_query"][] = array("taxonomy" => "category", "terms" => $obj->term_id, "field" => "id", "include_children" => true, "operator" => "IN");
    } else {
        if ($obj->taxonomy == "post_tag") {
            $args["tax_query"][] = array("taxonomy" => "post_tag", "terms" => $obj->term_id, "field" => "id", "include_children" => true, "operator" => "IN");
        } else {
            $args["tax_query"][] = array("taxonomy" => $obj->taxonomy, "terms" => $obj->slug, "field" => "slug", "include_children" => true, "operator" => "IN");
        }
    }
    $wp_query = new WP_Query();
    $wp_query->query($args);
    while ($wp_query->have_posts()) {
        $wp_query->the_post();
        (new ThemeContext())->Block($post);
    }
    wp_reset_query();
}
echo "</div></section><div class=\"FooterLoadedOne\"></div><div class=\"BreadcrumbMasteriv\" style=\"opacity:1\"><div class=\"breadcrumbs\"><div class=\"breadcrumb clearfix\"><div id=\"mpbreadcrumbs\">";
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
if ($obj->parent == 0) {
    echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
    echo "<a itemprop=\"url\" href=\"" . get_term_link($obj) . "\">";
    echo "# <span itemprop=\"title\">" . $obj->name . "</span>";
    echo "</a></span>";
} else {
    $parent = get_term($obj->parent, get_queried_object()->taxonomy);
    echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
    echo "<a itemprop=\"url\" href=\"" . get_term_link($parent) . "\">";
    echo "# <span itemprop=\"title\">" . $parent->name . "</span>";
    echo "</a></span>";
    echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
    echo "<a itemprop=\"url\" href=\"" . get_term_link($obj) . "\">";
    echo "# <span itemprop=\"title\">" . $obj->name . "</span>";
    echo "</a></span> ";
}
echo "</div></div></div></div>";

?>