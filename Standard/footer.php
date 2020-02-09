<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

echo "<script type=\"text/javascript\">";
require get_template_directory() . "/Standard/UI/js/jquery-1.8.3.js";
require get_template_directory() . "/Standard/UI/js/owl.carousel.min.js";
echo "setTimeout(function(){ (function() { var css = document.createElement('link'); css.href = 'https://kit-pro.fontawesome.com/releases/v5.12.0/css/pro.min.css'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css);})();}, 5000);";
if (get_option("Posts_perFu")) {
    $postdubl = get_option("Posts_perFu") + get_option("Posts_perFu") + get_option("Posts_perFu");
    if (wp_is_mobile()) {
        echo "var postNumber = 10; var postDubl = 20;";
    } else {
        echo "var postNumber = " . get_option("Posts_perFu") . "; var postDubl = " . $postdubl . ";";
    }
} else {
    if (wp_is_mobile()) {
        echo "var postNumber = 10; var postDubl = 20;";
    } else {
        echo "var postNumber = 24; var postDubl = 72;";
    }
}
echo wp_is_mobile() ? "var MobileTest = true;" : "var MobileTest = false;";
if (is_user_logged_in()) {
    echo "var userTese = true;";
} else {
    echo "var userTese = false;";
}
echo "var ajaxurl=\"" . admin_url("admin-ajax.php") . "\";";
echo "var homeurl= \"" . home_url() . "\";";
if (is_home()) {
    echo "var ishome = true;";
} else {
    echo "var ishome = false;";
}
if (is_single()) {
    wp_reset_query();
    echo "var postID =" . get_the_ID() . ";";
}
if (is_singular("post")) {
    $postID = get_the_ID();
    echo "var thesingle = true;";
    if (get_the_terms($postID, "assemblies", 1)) {
        echo "var assemblies = true;";
    } else {
        echo "var assemblies = false;";
    }
    if (get_post_meta($postID, "trailer", 1)) {
        echo "var trailer = true;";
    } else {
        echo "var trailer = false;";
    }
} else {
    echo "var thesingle = false;";
}
if (is_archive()) {
    echo "var isArchive = true;";
    $obj = get_queried_object();
    echo "arcSlug = \"" . $obj->slug . "\";";
    echo "arcTaxonomy =\"" . $obj->taxonomy . "\";";
    echo "arcid =\"" . $obj->term_id . "\";";
} else {
    echo "var isArchive = false;";
}
if ($obj->taxonomy == "catnews" || $obj->taxonomy == "newstag") {
    echo "var catnews = true;";
} else {
    echo "var catnews = false;";
}
if (is_page()) {
    echo "var isPage = true;";
} else {
    echo "var isPage = false;";
}
if (is_page("tvshow")) {
    echo "var tvshow = true;";
    echo "var pageType = \"" . (isset($_GET["key"]) ? $_GET["key"] : "new") . "\";";
} else {
    echo "var tvshow = false;";
}
if (is_page("trending")) {
    echo "var trending = true;";
    echo "var trendType = \"" . (isset($_GET["key"]) ? $_GET["key"] : "new") . "\";";
} else {
    echo "var trending = false;";
}
if (is_page("movies")) {
    echo "var movies = true;";
    echo "var moviType = \"" . (isset($_GET["key"]) ? $_GET["key"] : "new") . "\";";
} else {
    echo "var movies = false;";
}
if (is_page("series")) {
    echo "var series = true;";
    echo "var serType = \"" . (isset($_GET["key"]) ? $_GET["key"] : "new") . "\";";
} else {
    echo "var series = false;";
}
if (is_page("advanced-search")) {
    echo "var advsearch = true;";
    if (isset($_GET["cat"]) && !empty($_GET["cat"])) {
        echo "var catData=\"" . $_GET["cat"] . "\";";
    } else {
        echo "var catData = \"\";";
    }
    if (isset($_GET["release"]) && !empty($_GET["release"])) {
        echo "var releaseData =\"" . $_GET["release"] . "\";";
    } else {
        echo "var releaseData = \"\";";
    }
    if (isset($_GET["quality"]) && !empty($_GET["quality"])) {
        echo "var qualityData =\"" . $_GET["quality"] . "\";";
    } else {
        echo "var qualityData = \"\";";
    }
    if (isset($_GET["lang"]) && !empty($_GET["lang"])) {
        echo "var langData  =\"" . $_GET["lang"] . "\";";
    } else {
        echo "var langData = \"\";";
    }
    if (isset($_GET["nation"]) && !empty($_GET["nation"])) {
        echo "var nationData =\"" . $_GET["nation"] . "\";";
    } else {
        echo "var nationData = \"\";";
    }
    if (isset($_GET["resolution"]) && !empty($_GET["resolution"])) {
        "var resolutionData =\"" . $_GET["resolution"] . "\";";
    } else {
        echo "var resolutionData = \"\";";
    }
    if (isset($_GET["genre"]) && !empty($_GET["genre"])) {
        echo "var genreData =\"" . $_GET["genre"] . "\";";
    } else {
        echo "var genreData = \"\";";
    }
} else {
    echo "var advsearch = false;";
}
if (is_singular("sections")) {
    echo "var sections = true;";
} else {
    echo "var sections = false;";
}
if (is_singular("customlink")) {
    echo "var customlink = true;";
} else {
    echo "var customlink = false;";
}
if (is_page("latestnew")) {
    echo "var latestnew = true;";
} else {
    echo "var latestnew = false;";
}
if (is_search()) {
    echo "var issearch = true;";
} else {
    echo "var issearch = true;";
}
require get_template_directory() . "/Standard/UI/js/ycscript.js";
echo "</script> ";
echo "<div id=\"FootCodes\" style=\"display: none\">" . (get_option("FooterCodes") != "" ? get_option("FooterCodes") : "") . "</div>";
echo "</div><div class=\"clearfix\"></div><div class=\"scrollTop\"><i class=\"fa fa-chevron-up\"></i></div><footer><div class=\"container\"><p class=\"rights\">تصميم وبرمجة <a target=\"_blank\" rel=\"nofollow\" href=\"https://www.yourcolor.net\">ورشة لونك | YourColor </a></p></div></footer><script>if(window.history.replaceState){window.history.replaceState(null,null,window.location.href);}</script>";
wp_footer();
echo "</body></html>\n";

?>