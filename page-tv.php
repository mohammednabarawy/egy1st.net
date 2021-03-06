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
$schema_link = "";
$home = "الرئيسية";
$homeLink = home_url();
global $post;
$i = 0;
$args = array("post_type" => "post", "fields" => "ids", "meta_key" => "pin", "posts_per_page" => wp_is_mobile() ? 5 : 10, "meta_query" => array(array("key" => "number", "value" => 0, "compare" => ">")));
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
echo "<a href=\"" . get_the_permalink($post->ID) . "\" alt=\"" . get_the_title($post->ID) . "\" title=\"" . get_the_title($post->ID) . "\">";
echo "<i class=\"fas fa-film\"></i>";
echo "<em>" . get_the_title($post->ID) . "</em>";
echo "</a></span><div class=\"MaiButtom\"><ul>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "new" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/tv?key=new\">";
echo "<i class=\"far fa-video-plus\"></i><span>احدث الحلقات</span></a></li>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "latest" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/tv?key=latest\">";
echo "<i class=\"fas fa-tv-retro\"></i><span>احدث المسلسلات </span></a></li>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "newSeries" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/tv?key=newSeries\">";
echo "<i class=\"fal fa-plus\"></i><span> مسلسلات جديدة</span></a></li>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "best" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/tv?key=best\">";
echo "<i class=\"far fa-star\"></i><span> افضل المسلسلات</span></a></li>";
echo "<li " . (isset($_GET["key"]) && $_GET["key"] == "famous" ? "class=\"active\"" : "") . ">";
echo "<a href=\"" . home_url() . "/tv?key=famous\">";
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
        $series = array_slice(get_categories(array("taxonomy" => "selary")), 0, 30);
    } else {
        $series = array_slice(get_categories(array("taxonomy" => "selary", "meta_key" => $_GET["key"])), 0, 30);
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
    $args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => 30, "meta_query" => array(array("key" => "number", "value" => 0, "compare" => ">")));
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
echo "</a></span></div></div></div></div><script type=\"text/javascript\">\n  \$(function(){\n    ";
if (!wp_is_mobile()) {
    echo " \n      setTimeout(function(){\n      \$('body').addClass('loaded');\n        \$('.SliderMaster > ul.owl-carousel .owl-prev').click();\n      } ,300);\n      /* FLASH COLOR MENU In Slider Index */\n      \$('.MasterContentSlider > div > h2').hover(function(){\n          var moveWidth = \$(this).find('span').width() - \$(this).width() + 30;\n          \$(this).find('span').css('right','-'+moveWidth+'px');\n      },function(){\n          \$(this).find('span').css('right','0px');\n      });\n      setTimeout(function(){\n        \$('.SliderMaster').show();\n      },1000);\n      // Slider Edits\n      var heroSlider = \$(\".SliderMaster > ul.owl-carousel\").owlCarousel({\n        items: 1,\n        stopOnHover: true,\n        autoPlay: 10000,\n        loop:true,\n        addClassActive: true,\n        navText : ['<i class=\"fa fa-angle-right\"></i>','<i class=\"fa fa-angle-left\"></i>'],\n        nav: true,\n        smartSpeed: 600\n      });\n      heroSlider.on('changed.owl.carousel', function(property) {\n        var current = property.item.index;\n        \$(property.target).find(\".owl-item\").eq(current).prev().removeClass('PrevItem');\n        \$(property.target).find(\".owl-item\").eq(current).prev().addClass('NextItem');\n        \$(property.target).find(\".owl-item\").eq(current).next().removeClass('NextItem');\n        \$(property.target).find(\".owl-item\").eq(current).next().addClass('PrevItem');\n      });\n      heroSlider.on('load.owl.carousel', function(property) {\n        \$(\".owl-item.active\").prev().removeClass('PrevItem');\n        \$(\".owl-item.active\").prev().addClass('NextItem');\n        \$(\".owl-item.active\").next().removeClass('NextItem');\n        \$(\".owl-item.active\").next().addClass('PrevItem');\n      });\n      \$('.sliderpin-next').click(function(){\n         \$(\".SliderMaster > ul.owl-carousel .owl-prev\").click();\n      });\n      \$('.sliderpin-prev').click(function(){\n          \$(\".SliderMaster > ul.owl-carousel .owl-next\").click();\n      });\n    ";
} else {
    echo "      // Slider Block Defult\n      \$(\".MasterMobileSlider .owl-carousel\").owlCarousel({\n        rtl:true,\n        stopOnHover: true,\n        autoWidth:true,\n        autoPlay: 10000,\n        addClassActive: true,\n        margin:10,\n        navText : ['<i class=\"fa fa-angle-right\"></i>','<i class=\"fa fa-angle-left\"></i>'],\n        loop:true,\n        nav: true,\n        margin:10,\n          responsive:{\n              0:{\n                  items:1,\n                  nav:true\n              },\n              480:{\n                  items:2,\n                  nav:false\n              },\n              970:{\n                  items:4,\n                  nav:true,\n              },\n              1000:{\n                  items:5,\n                  nav:true,\n              }\n          },\n      });\n      \$('.MasterMobileSlider .left').on('click',function(){\n        \$('.MasterMobileSlider .owl-carousel .owl-prev').click();\n      });\n      \$('.MasterMobileSlider .right').on('click',function(){\n        \$('.MasterMobileSlider .owl-carousel .owl-next').click();\n      });\n    ";
}
echo "    \$(\".MainActorsSlidesInner\").owlCarousel({\n      autoWidth: true,\n      stopOnHover: true,\n      autoPlay: true,\n      singleItem: true,\n      loop: true,\n      rtl: true,\n      addClassActive: true,\n      navText : ['<a href=\"javascript:void(0);\" class=\"SliderOwl-next\"><i class=\"fa fa-angle-left\"></i></a>','<a href=\"javascript:void(0);\" class=\"SliderOwl-prev\"><i class=\"fa fa-angle-right\"></i></a>'],\n    });\n    var loadsonglast = false;\n    var offset = 30;\n    var ajaxPostloaded = \$('.MainRelated');\n    var bottomlastsong = \$('.FooterLoadedOne');\n    \$(window).scroll(function() {\n      if(\$(this).scrollTop() > bottomlastsong.offset().top - 1000  ){\n        if( loadsonglast == false ) {\n          if( \$('.MainRelated').attr('data-loading') == 'false' ) {\n            ajaxPostloaded.append('<div class=\"FucL\"><div class=\"FucL loader-wrapper\"><div class=\"loader\"><div class=\"roller\"></div><div class=\"roller\"></div></div><div id=\"loader2\" class=\"loader\"><div class=\"roller\"></div><div class=\"roller\"></div></div><div id=\"loader3\" class=\"loader\"><div class=\"roller\"></div><div class=\"roller\"></div></div></div></div>');\n            loadsonglast = true;\n            \$.ajax({\n              url: '";
echo admin_url("admin-ajax.php");
echo "',\n              type: 'POST',\n              data: {\n                \"offset\":offset,filter:'";
echo isset($_GET["key"]) ? $_GET["key"] : "new";
echo "',\n                \"action\":'tvMore'\n              },\n              success: function(msg){\n                \$('.MainRelated .FucL').remove();\n                \$('.MainRelated').append(msg);\n                \$('[data-style]').each(function(els, el){\n                  \$(el).attr('style', \$(el).data('style'));\n                  \$(el).removeAttr('data-style');\n                });\n                loadsonglast = false;\n                offset = offset + 30;\n              }\n            });\n          }\n        }\n      }\n    });\n  });\n</script> \n";
(new ThemeContext())->Footer();
echo "\n";

?>