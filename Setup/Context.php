<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

class ThemeContext extends ThemeTree
{
    private $args = NULL;
    private $_GET = NULL;
    private $_POST = NULL;
    public function __construct($args = array())
    {
        $this->args = $args;
        $this->Method = array("GETs" => $_GET, "POSTs" => $_POST);
        $this->CanonicalURL = $this->GetCanonicalURL();
        if (wp_is_mobile()) {
            $this->DataSrcAttr = "src=\"" . home_url() . "/lodynet.jpg\" data-src";
        } else {
            $this->DataSrcAttr = "src";
        }
    }
    public function RatingsStar($id)
    {
        echo "<div class=\"BackStars\"></div>";
        $ratings = get_post_meta($id, "ratings_score", true);
        echo "<div class=\"FrontStars\" style=\"width:" . $ratings . "%;\">";
        echo "</div>";
    }
    public function RateNow()
    {
        $rates = is_array(get_post_meta($_POST["id"], "rating", true)) ? get_post_meta($_POST["id"], "rating", true) : array();
        if (!isset($rates[1])) {
            $rates[1] = 0;
        }
        if (!isset($rates[2])) {
            $rates[2] = 0;
        }
        if (!isset($rates[3])) {
            $rates[3] = 0;
        }
        if (!isset($rates[4])) {
            $rates[4] = 0;
        }
        if (!isset($rates[5])) {
            $rates[5] = 0;
        }
        if ($_POST["rate"] == "1") {
            $rates[$_POST["rate"]] = $rates[$_POST["rate"]] + 0.2;
        } else {
            if ($_POST["rate"] == "2") {
                $rates[$_POST["rate"]] = $rates[$_POST["rate"]] + 0.4;
            } else {
                if ($_POST["rate"] == "3") {
                    $rates[$_POST["rate"]] = $rates[$_POST["rate"]] + 0.6;
                } else {
                    if ($_POST["rate"] == "4") {
                        $rates[$_POST["rate"]] = $rates[$_POST["rate"]] + 0.8;
                    } else {
                        if ($_POST["rate"] == "5") {
                            $rates[$_POST["rate"]] = $rates[$_POST["rate"]] + 1;
                        }
                    }
                }
            }
        }
        update_post_meta($_POST["id"], "rating", $rates);
        update_post_meta($_POST["id"], "votes_count", get_post_meta($_POST["id"], "votes_count", true) + 1);
        $ratings = get_post_meta($_POST["id"], "rating", true);
        $star1 = isset($ratings[1]) ? $ratings[1] : "0";
        $star2 = isset($ratings[2]) ? $ratings[2] : "0";
        $star3 = isset($ratings[3]) ? $ratings[3] : "0";
        $star4 = isset($ratings[4]) ? $ratings[4] : "0";
        $star5 = isset($ratings[5]) ? $ratings[5] : "0";
        $tot_stars = $star1 + $star2 + $star3 + $star4 + $star5;
        $total = $tot_stars * 100 / get_post_meta($_POST["id"], "votes_count", true);
        $RateAVG = sprintf("%u", $total);
        update_post_meta($_POST["id"], "ratings_score", $RateAVG);
        echo "<div class=\"Back\"><span data-rate=\"1\"><i class=\"far fa-star\"></i></span><span data-rate=\"2\"><i class=\"far fa-star\"></i></span><span data-rate=\"3\"><i class=\"far fa-star\"></i></span><span data-rate=\"4\"><i class=\"far fa-star\"></i></span><span data-rate=\"5\"><i class=\"far fa-star\"></i></span></div>";
        echo "<div class=\"Front\" style=\"width: " . $RateAVG . "%;\">";
        echo "<div class=\"InsideFrontRate\">";
        for ($i = 0; $i < 5; $i++) {
            echo "<span><i class=\"fa fa-star\"></i></span>";
        }
        echo "</div></div>";
        wp_die();
    }
    public function EpisodesList()
    {
        echo "<table><thead><tr><td><i class=\"fa fa-sort\"></i> رقم الحلقة</td><td><svg aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fas\" data-icon=\"popcorn\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\" class=\"svg-inline--fa fa-popcorn fa-w-16 fa-2x\"><path fill=\"currentColor\" d=\"M443.62 138.88a42.72 42.72 0 0 0-33.09-20.79 37.89 37.89 0 0 0-.33-37.43c-9.11-16-28-23.69-45.55-20.17-.33-16.64-11.47-32-29-37.43a43.36 43.36 0 0 0-39.14 6.4 4.25 4.25 0 0 0-.68-1.92C288.73 6.42 264.77-4.78 242.5 2a41.66 41.66 0 0 0-27.32 27.19 43.4 43.4 0 0 0-38.82-6.08c-17.54 5.44-28.66 20.79-29 37.43-17.56-3.54-36.46 4.12-45.57 20.12a37.18 37.18 0 0 0-.33 37.43c-13.46 1.28-26.32 8.64-33.06 20.79-3.92 6.74-4.77 14-4.27 21.12h383.73c.52-7.12-.33-14.37-4.24-21.12zM366.4 192l-28 256h-45.01L315 192H197.05l21.56 256h-45.05l-28-256H64l43.91 292.75A32 32 0 0 0 139.56 512h232.88a32 32 0 0 0 31.65-27.25L448 192z\" class=\"\"></path></svg> عنوان الحلقة</td>";
        if (!wp_is_mobile()) {
            echo "<td><i class=\"fa fa-tv\"></i> الجودة</td><td><i class=\"fa fa-eye\"></i> المشاهدات</td><td><i class=\"fa fa-calendar\"></i> مُضافة منذ</td><td><i class=\"fa fa-play\"></i> مشاهدة</td>";
        }
        echo "</tr></thead><tbody>";
        foreach (get_posts(array("post_type" => "post", "series" => get_term($_POST["serie"], "series")->slug, "posts_per_page" => wp_is_mobile() ? 5 : 30, "meta_key" => "number", "order" => "ASC", "orderby" => "meta_value_num")) as $episode) {
            echo "<tr>";
            echo "<td>" . get_post_meta($episode->ID, "number", true) . "</td>";
            echo "<td><a href=\"" . get_the_permalink($episode->ID) . "\">" . $episode->post_title . "</a></td>";
            if (!wp_is_mobile()) {
                echo "<td>";
                foreach (get_the_terms($episode->ID, "Quality", "") as $quality) {
                    echo "<a href=\"" . get_term_link($quality) . "\">" . $quality->name . "</a>";
                }
                echo "</td>";
                echo "<td>" . (get_post_meta($episode->ID, "views", true) == "" ? "0" : get_post_meta($episode->ID, "views", true)) . "</td>";
                echo "<td>منذ " . human_time_diff(date("U", strtotime($episode->post_date)), current_time("timestamp")) . "</td>";
                echo "<td>";
                echo "<a href=\"" . get_the_permalink($episode->ID) . "\" class=\"GotoEpisode\">الذهاب الى الحلقة <i class=\"fa fa-angle-left\"></i></a>";
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody></table>";
        $args = array("post_type" => "post", "series" => get_term($_POST["serie"], "series")->slug, "posts_per_page" => wp_is_mobile() ? 5 : 30, "meta_key" => "number", "order" => "ASC", "orderby" => "meta_value_num");
        $wp_query = new WP_Query();
        $wp_query->query($args);
        echo "<a href=\"" . get_term_link(get_term($_POST["serie"], "series")) . "\" class=\"MoreSingleLoads\"><i class=\"fa fa-plus\"></i> باقي الحلقات</a>";
        wp_die();
    }
    public function filterTab()
    {
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
        $args = array("fields" => "ids", "posts_per_page" => $postNumber, "ignore_sticky_posts" => 1);
        if ($_POST["filter"] == "latest") {
            $args["post__not_in"] = get_option("sticky_posts");
        }
        if ($_POST["filter"] == "pin") {
            $args["meta_key"] = "pin";
            $args["post__in"] = get_option("sticky_posts");
        }
        if ($_POST["filter"] == "views") {
            $args["meta_key"] = "views";
            $args["orderby"] = "meta_value_num";
        }
        if ($_POST["filter"] == "rate") {
            $args["meta_key"] = "imdbRating";
            $args["orderby"] = "meta_value_num";
        }
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
        wp_die();
    }
    public function MoreTab()
    {
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
        $args = array("fields" => "ids", "posts_per_page" => $postNumber, "ignore_sticky_posts" => 1, "offset" => $_POST["offset"]);
        if ($_POST["filter"] == "latest") {
            $args["post__not_in"] = get_option("sticky_posts");
        }
        if ($_POST["filter"] == "pin") {
            $args["meta_key"] = "pin";
            $args["post__in"] = get_option("sticky_posts");
        }
        if ($_POST["filter"] == "views") {
            $args["meta_key"] = "views";
            $args["orderby"] = "meta_value_num";
        }
        if ($_POST["filter"] == "rate") {
            $args["meta_key"] = "imdbRating";
            $args["orderby"] = "meta_value_num";
        }
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
        wp_die();
    }
    public function GenreBlock($genre)
    {
        echo "<li>";
        echo "<a href=\"" . get_term_link($genre) . "\">";
        foreach (get_posts(array("post_type" => "post", "genre" => $genre->category_nicename, "posts_per_page" => 1)) as $postgen) {
            echo get_the_post_thumbnail($postgen->ID, "defaultgenre", array("alt" => $genre->cat_name));
        }
        echo "<div class=\"GenreTitle\">" . $genre->cat_name . "</div>";
        echo "</a><div class=\"Popover\">";
        foreach (get_posts(array("post_type" => "post", "genre" => $genre->category_nicename, "posts_per_page" => 1)) as $postgen) {
            echo "<div class=\"PinMovie\">";
            echo "<a href=\"" . get_the_permalink($postgen->ID) . "\">";
            echo "<div class=\"PosterPin\">";
            echo get_the_post_thumbnail($postgen->ID, "defaultgenre1", array("alt" => $postgen->post_title));
            echo "<em>1</em></div><div class=\"DetailsPinMovie\">";
            echo "<h1>أفضل فيلم \"" . $genre->cat_name . "\"</h1>";
            echo "<h2>" . get_the_title($postgen->ID) . "</h2>";
            echo "<p>" . wp_trim_words(get_the_content(), 20, "...") . "</p>";
            echo "</div></a></div>";
        }
        echo "<div class=\"MoviesList\">";
        $i = 1;
        foreach (get_posts(array("post_type" => "post", "genre" => $genre->category_nicename, "posts_per_page" => 4, "offset" => 1)) as $postgen) {
            $i++;
            echo "<div class=\"MovieNumber\">";
            echo "<a href=\"" . get_the_permalink($postgen->ID) . "\">";
            echo "<div class=\"PosterMoviesList\">";
            echo get_the_post_thumbnail($postgen->ID, "defaultgenre2", array("alt" => $postgen->post_title));
            echo "<em>" . $i . "</em>";
            echo "</div><div class=\"DetailsMoviesList\">";
            echo "<time><i class=\"fa fa-clock\"></i> منذ " . human_time_diff(date("U", strtotime($postgen->post_date)), current_time("timestamp")) . "</time>";
            echo "<h2>" . get_the_title($postgen->ID) . "</h2>";
            echo "<span class=\"WatchNow\">شاهد الآن</span></div></a></div>";
        }
        echo "</div>";
        echo "<a class=\"ShowMoreButton\" target=\"_blank\" href=\"" . get_term_link($genre) . "\"><i class=\"fa fa-th\"></i> مشاهدة المزيد من " . $genre->cat_name . "</a>";
        echo "</div></li>";
    }
    public function MiniSetion($id, $section)
    {
        if (wp_get_attachment_url(get_post_thumbnail_id())) {
            $thumb = get_the_post_thumbnail_url($id, "TopSlider");
        } else {
            $thumb = get_option("DefultBlock")["url"];
        }
        echo "<div class=\"InAjaxBlock\" data-id=\"" . $id . "\" data-secid=\"" . $section . "\">";
        echo "<img data-src=\"" . $thumb . "\">";
        echo "<h2>" . get_the_title($id) . "</h2>";
        echo "</div>";
    }
    public function FullBlock($id)
    {
        if (wp_get_attachment_url(get_post_thumbnail_id())) {
            $thumb = get_the_post_thumbnail_url($id, "SecSingleBlock");
        } else {
            $thumb = get_option("DefultBlock")["url"];
        }
        echo "<div class=\"TrOver\" data-open=\"" . $id . "\"></div>";
        echo "<div class=\"TillerBlock\" data-open=\"" . $id . "\"><div class=\"ClossTr\"><span>الرجوع للتفاصيل </span><i class=\"fas fa-backspace\"></i></div><div class=\"TrilHere\" data-open=\"" . $id . "\"></div></div>";
        echo "<li>";
        echo "<div class=\"ImageStyle\" style=\"background-image:url(" . $thumb . ")\"></div>";
        if (get_post_meta($id, "imdbRating", 1)) {
            echo "<div class=\"IMDBBB\"><div class=\"Ratese\"><h3>IMDB</h3>";
            echo "<span>" . get_post_meta($id, "imdbRating", 1) . "</span>";
            echo "<span>" . (get_post_meta($id, "imdbVotes", 1) ? get_post_meta($id, "imdbVotes", 1) : "") . "</span>";
            echo "</div></div>";
        }
        echo "<div class=\"TheContnetLeftDiv\">";
        if (get_post_meta($id, "title2", 1)) {
            echo "<h2>" . get_post_meta($id, "title2", 1) . "</h2>";
        } else {
            echo "<h2>" . get_the_title($id) . "</h2>";
        }
        echo "</div></a></li><div class=\"MasterBtnUl\"><div class=\"OpenServers BTNMaster\">";
        echo "<a href=\"" . get_the_permalink($id) . "\" title=\"" . get_the_title($id) . "\">";
        echo "<i class=\"fal fa-tv-retro\"></i><span>المشاهدة والتحميل </span></a></div>";
        if (get_post_meta($id, "trailer", 1)) {
            echo "<div class=\"OpenTriller BTNMaster DivTriller\" data-id=\"" . $id . "\">";
            echo "<i class=\"fal fa-play-circle\"></i><span>مشاهدة الاعلان</span></div>";
        }
        echo "</div>";
    }
    public function SetionOpen()
    {
        $id = $_POST["id"];
        if (wp_get_attachment_url(get_post_thumbnail_id($id))) {
            $thumb = get_the_post_thumbnail_url($id, "SecSingleBlock");
        } else {
            $thumb = get_option("DefultBlock")["url"];
        }
        echo "<div class=\"TrOver\" data-open=\"" . $id . "\"></div>";
        echo "<div class=\"TillerBlock\" data-open=\"" . $id . "\"><div class=\"ClossTr\"><span>الرجوع للتفاصيل </span><i class=\"fas fa-backspace\"></i></div><div class=\"TrilHere\" data-open=\"" . $id . "\"></div></div>";
        echo "<li>";
        echo "<div class=\"ImageStyle\" style=\"background-image:url(" . $thumb . ")\"></div>";
        if (get_post_meta($id, "imdbRating", 1)) {
            echo "<div class=\"IMDBBB\"><div class=\"Ratese\"><h3>IMDB</h3>";
            echo "<span>" . get_post_meta($id, "imdbRating", 1) . "</span>";
            echo "<span>" . (get_post_meta($id, "imdbVotes", 1) ? get_post_meta($id, "imdbVotes", 1) : "") . "</span>";
            echo "</div></div>";
        }
        echo "<div class=\"TheContnetLeftDiv\">";
        if (get_post_meta($id, "title2", 1)) {
            echo "<h2>" . get_post_meta($id, "title2", 1) . "</h2>";
        } else {
            echo "<h2>" . get_the_title($id) . "</h2>";
        }
        echo "</div></a></li><div class=\"MasterBtnUl\"><div class=\"OpenServers BTNMaster\">";
        echo "<a href=\"" . get_the_permalink($id) . "\" title=\"" . get_the_title($id) . "\">";
        echo "<i class=\"fal fa-tv-retro\"></i><span>المشاهدة والتحميل </span></a></div>";
        if (get_post_meta($id, "trailer", 1)) {
            echo "<div class=\"OpenTriller BTNMaster DivTriller\" data-id=\"" . $id . "\">";
            echo "<i class=\"fal fa-play-circle\"></i><span>مشاهدة الاعلان</span></div>";
        }
        echo "</div>";
        wp_die();
    }
    public function sectionLoadMore()
    {
        $nums = 0;
        $argssections = array("post_type" => "sections", "fields" => "ids", "posts_per_page" => 3);
        if (0 < $_POST["offset"]) {
            $argssections["offset"] = $_POST["offset"];
        }
        foreach (get_posts($argssections) as $section) {
            $nums++;
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
            $args = array("post_type" => "post", "posts_per_page" => $postNumber, "fields" => "ids", "tax_query" => array("relation" => "AND"));
            if (get_post_meta($section, "filteringby", true) == "imdb") {
                $args["orderby"] = "meta_value_num";
                $args["meta_key"] = "imdbRating";
            } else {
                if (get_post_meta($section, "filteringby", true) == "views") {
                    $args["orderby"] = "meta_value_num";
                    $args["meta_key"] = "views";
                } else {
                    if (get_post_meta($section, "filteringby", true) == "ratings") {
                        $args["orderby"] = "meta_value_num";
                        $args["meta_key"] = "ratings_average";
                    } else {
                        if (get_post_meta($section, "filteringby", true) == "pin") {
                            $args["meta_key"] = "pin";
                        }
                    }
                }
            }
            if (get_post_meta($section, "category", true) != "") {
                $args["tax_query"][] = array("taxonomy" => "category", "terms" => get_post_meta($section, "category", true), "field" => "term_id", "include_children" => true, "operator" => "IN");
            }
            if (get_post_meta($section, "ser", true) != "") {
                $args["tax_query"][] = array("taxonomy" => "selary", "terms" => get_post_meta($section, "ser", true), "field" => "term_id", "include_children" => true, "operator" => "IN");
            }
            if (get_post_meta($section, "movseries", true) != "") {
                $args["tax_query"][] = array("taxonomy" => "assemblies", "terms" => get_post_meta($section, "movseries", true), "field" => "term_id", "include_children" => true, "operator" => "IN");
            }
            if (get_post_meta($section, "genre", true) != "") {
                $args["tax_query"][] = array("taxonomy" => "genre", "terms" => get_post_meta($section, "genre", true), "field" => "term_id", "include_children" => true, "operator" => "IN");
            }
            if (get_post_meta($section, "quality", true) != "") {
                $args["tax_query"][] = array("taxonomy" => "Quality", "terms" => get_post_meta($section, "quality", true), "field" => "term_id", "include_children" => true, "operator" => "IN");
            }
            if (get_post_meta($section, "language", true) != "") {
                $args["tax_query"][] = array("taxonomy" => "language", "terms" => get_post_meta($section, "language", true), "field" => "term_id", "include_children" => true, "operator" => "IN");
            }
            if (get_post_meta($section, "year", true) != "") {
                $args["tax_query"][] = array("taxonomy" => "release-year", "terms" => get_post_meta($section, "year", true), "field" => "term_id", "include_children" => true, "operator" => "IN");
            }
            echo "<div class=\"TheSection\"><div class=\"SectionTitle\"><div class=\"container\"><h2><div class=\"TitleMasterImg\">";
            if (!empty(get_post_meta($section, "SecIcon", 1)["url"])) {
                $sec = get_post_meta($section, "SecIcon", 1)["url"];
                echo "<img data-src=\"" . $sec . "\">";
            } else {
                $sec = get_option("DefultSec")["url"];
                echo "<img data-src=\"" . $sec . "\">";
            }
            echo "</div>";
            echo "<span class=\"TitleSection\">" . get_the_title($section) . "</span>";
            echo "<span class=\"MiniSection\">" . get_post_meta($section, "desc", 1) . "</span>";
            echo "<div class=\"OpenGenere noGenre\">";
            echo "<a href=\"" . get_the_permalink($section) . "\">";
            echo "<i class=\"far fa-chevron-double-left\"></i><span>المزيد </span></a></div> </h2></div></div>";
            echo "<div class=\"SectionContent datasection\" data-section=\"" . $section . "\">";
            echo "<div class=\"container\">";
            echo "<div class=\"OneSection active\" data-exist=\"" . $section . "\">";
            global $post;
            $args["posts_per_page"] = 1;
            $wp_query = new WP_Query();
            $wp_query->query($args);
            while ($wp_query->have_posts()) {
                $wp_query->the_post();
                (new ThemeContext())->FullBlock($post);
            }
            echo "</div>";
            wp_reset_query();
            echo "<div class=\"MultyBlocks MultyBlocks" . $section . "\" data-section=\"" . $section . "\">";
            global $post;
            $args["posts_per_page"] = 10;
            $wp_query = new WP_Query();
            $wp_query->query($args);
            while ($wp_query->have_posts()) {
                $wp_query->the_post();
                (new ThemeContext())->MiniSetion($post, $section);
            }
            wp_reset_query();
            echo "</div></div></div>\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$('.SectionContent .MultyBlocks";
            echo $section;
            echo "').owlCarousel({\n\t\t\t        loop:true,\n\t\t\t        //nav:true,\n\t\t\t        items:1,\n\t\t\t        rtl:true,\n\t\t\t        singleItem: true,\n\t\t\t        slideBy: 1,\n\t\t\t        navText : ['<a href=\"javascript:void(0);\" class=\"DoneClick SliderOwl-next\" data-section=\"";
            echo $section;
            echo "\"><i class=\"far fa-arrow-left\"></i>','<a href=\"javascript:void(0);\" data-section=\"";
            echo $section;
            echo "\" class=\"DoneClick SliderOwl-prev\"><i class=\"far fa-arrow-right\"></i></a>'],\n\t\t\t    });\n\t\t\t\t</script>\n\t\t\t\t</div>";
            wp_reset_query();
        }
        wp_die();
    }
    public function moviesMore()
    {
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
        if ($_POST["filter"] == "latest") {
            $args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "offset" => $_POST["offset"], "meta_query" => array(array("key" => "number", "compare" => "NOT EXISTS")));
            if (0 < count(get_posts($args))) {
                $wp_query = new WP_Query();
                $wp_query->query($args);
                while ($wp_query->have_posts()) {
                    $wp_query->the_post();
                    (new ThemeContext())->Block($post);
                }
                wp_reset_query();
            } else {
                echo "<h2 class=\"noMorePosts\">لا يوجد نتائج اخري</h2>";
            }
        } else {
            if ($_POST["filter"] == "best") {
                $args = array("post_type" => "post", "posts_per_page" => $postNumber, "fields" => "ids", "offset" => $_POST["offset"], "meta_key" => $_POST["filter"], "meta_query" => array(array("key" => "number", "compare" => "NOT EXISTS")));
                if (0 < count(get_posts($args))) {
                    $wp_query = new WP_Query();
                    $wp_query->query($args);
                    while ($wp_query->have_posts()) {
                        $wp_query->the_post();
                        (new ThemeContext())->Block($post);
                    }
                    wp_reset_query();
                } else {
                    echo "<h2 class=\"noMorePosts\">لا يوجد نتائج اخري</h2>\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t\t})\n\t\t\t\t</script>\n\t\t\t";
                }
            } else {
                if ($_POST["filter"] == "new") {
                    $args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "offset" => $_POST["offset"], "meta_key" => $_POST["filter"], "meta_query" => array(array("key" => "number", "compare" => "NOT EXISTS")));
                    if (0 < count(get_posts($args))) {
                        $wp_query = new WP_Query();
                        $wp_query->query($args);
                        while ($wp_query->have_posts()) {
                            $wp_query->the_post();
                            (new ThemeContext())->Block($post);
                        }
                        wp_reset_query();
                    } else {
                        echo "<h2 class=\"noMorePosts\">لا يوجد نتائج اخري</h2>\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t\t})\n\t\t\t\t</script>\n\t\t\t";
                    }
                } else {
                    if ($_POST["filter"] == "famous") {
                        $args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "meta_key" => "views", "orderby" => "meta_value_num", "offset" => $_POST["offset"], "meta_query" => array(array("key" => "number", "compare" => "NOT EXISTS")));
                        if (0 < count(get_posts($args))) {
                            $wp_query = new WP_Query();
                            $wp_query->query($args);
                            while ($wp_query->have_posts()) {
                                $wp_query->the_post();
                                (new ThemeContext())->Block($post);
                            }
                            wp_reset_query();
                        } else {
                            echo "<h2 class=\"noMorePosts\">لا يوجد نتائج اخري</h2>\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t\t})\n\t\t\t\t</script>\n\t\t\t";
                        }
                    } else {
                        if ($_POST["filter"] == "imdbRating") {
                            $args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "meta_key" => "imdbRating", "orderby" => "meta_value_num", "offset" => $_POST["offset"], "meta_query" => array(array("key" => "number", "compare" => "NOT EXISTS")));
                            if (0 < count(get_posts($args))) {
                                $wp_query = new WP_Query();
                                $wp_query->query($args);
                                while ($wp_query->have_posts()) {
                                    $wp_query->the_post();
                                    (new ThemeContext())->Block($post);
                                }
                                wp_reset_query();
                            } else {
                                echo "<h2 class=\"noMorePosts\">لا يوجد نتائج اخري</h2>\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t\t})\n\t\t\t\t</script>\n\t\t\t";
                            }
                        }
                    }
                }
            }
        }
        wp_die();
    }
    public function TreangingMore()
    {
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
        if (isset($_POST["filter"]) && $_POST["filter"] == "now") {
            $array = is_array(get_option(date("Y-m-d H"))) ? get_option(date("Y-m-d H")) : array();
            uasort($array, "compare");
            $arg = array();
            if (!empty($array)) {
                $posts = array();
                foreach ($array as $post => $views) {
                    $posts[] = $post;
                }
                $arg = array("post_type" => "post", "fields" => "ids", "offset" => $_POST["offset"], "posts_per_page" => $postNumber, "post__in" => $posts);
            }
        } else {
            if (isset($_POST["filter"]) && $_POST["filter"] == "today") {
                $array = is_array(get_option(date("Y-m-d"))) ? get_option(date("Y-m-d")) : array();
                $arg = array();
                uasort($array, "compare");
                if (!empty($array)) {
                    $posts = array();
                    foreach ($array as $post => $views) {
                        $posts[] = $post;
                    }
                    $arg = array("post_type" => "post", "fields" => "ids", "offset" => $_POST["offset"], "posts_per_page" => $postNumber, "post__in" => $posts);
                }
            } else {
                if (isset($_POST["filter"]) && $_POST["filter"] == "week") {
                    $array = is_array(get_option(date("W-Y"))) ? get_option(date("W-Y")) : array();
                    $arg = array();
                    uasort($array, "compare");
                    if (!empty($array)) {
                        $posts = array();
                        foreach ($array as $post => $views) {
                            $posts[] = $post;
                        }
                        $arg = array("post_type" => "post", "fields" => "ids", "offset" => $_POST["offset"], "posts_per_page" => $postNumber, "post__in" => $posts);
                    }
                } else {
                    if (isset($_POST["filter"]) && $_POST["filter"] == "month") {
                        $array = is_array(get_option(date("Y-m"))) ? get_option(date("Y-m")) : array();
                        $arg = array();
                        uasort($array, "compare");
                        if (!empty($array)) {
                            $posts = array();
                            foreach ($array as $post => $views) {
                                $posts[] = $post;
                            }
                            $arg = array("post_type" => "post", "fields" => "ids", "offset" => $_POST["offset"], "posts_per_page" => $postNumber, "post__in" => $posts);
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
                            $arg = array("post_type" => "post", "fields" => "ids", "offset" => $_POST["offset"], "posts_per_page" => $postNumber, "post__in" => $posts);
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
            echo "<h2 class=\"noMorePosts\">لا يوجد نتائج اخري</h2>\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\$(function(){\n\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t})\n\t\t\t</script>\n    ";
        }
        wp_die();
    }
    public function advancedSearch()
    {
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
        $args = array("posts_per_page" => $postNumber, "fields" => "ids", "post_type" => "post", "offset" => $_POST["offset"], "tax_query" => array("relation" => "AND"));
        if (isset($_POST["cat"]) && !empty($_POST["cat"])) {
            $args["tax_query"][] = array("taxonomy" => "category", "terms" => $_POST["cat"], "field" => "term_id");
        }
        if (isset($_POST["release"]) && !empty($_POST["release"])) {
            $args["tax_query"][] = array("taxonomy" => "release-year", "terms" => get_term_by("term_id", $_POST["release"], "release-year")->slug, "field" => "slug");
        }
        if (isset($_POST["quality"]) && !empty($_POST["quality"])) {
            $args["tax_query"][] = array("taxonomy" => "Quality", "terms" => get_term_by("term_id", $_POST["quality"], "Quality")->slug, "field" => "slug");
        }
        if (isset($_POST["lang"]) && !empty($_POST["lang"])) {
            $args["tax_query"][] = array("taxonomy" => "language", "terms" => get_term_by("term_id", $_POST["lang"], "language")->slug, "field" => "slug");
        }
        if (isset($_POST["nation"]) && !empty($_POST["nation"])) {
            $args["tax_query"][] = array("taxonomy" => "country", "terms" => get_term_by("term_id", $_POST["nation"], "country")->slug, "field" => "slug");
        }
        if (isset($_POST["resolution"]) && !empty($_POST["resolution"])) {
            $args["tax_query"][] = array("taxonomy" => "resolution", "terms" => get_term_by("term_id", $_POST["resolution"], "resolution")->slug, "field" => "slug");
        }
        if (isset($_POST["genre"]) && !empty($_POST["genre"])) {
            $args["tax_query"][] = array("taxonomy" => "genre", "terms" => get_term_by("term_id", $_POST["genre"], "genre")->slug, "field" => "slug");
        }
        $wp_query = new WP_Query();
        $wp_query->query($args);
        while ($wp_query->have_posts()) {
            $wp_query->the_post();
            (new ThemeContext())->Block($post);
        }
        wp_reset_query();
        wp_die();
    }
    public function compare($a, $b)
    {
        if ($a == $b) {
            return 0;
        }
        return $b < $a ? -1 : 1;
    }
    public function archiveMore()
    {
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
        $args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "offset" => $_POST["offset"], "tax_query" => array("relation" => "AND"));
        if ($_POST["taxonomy"] == "category") {
            $args["tax_query"][] = array("taxonomy" => "category", "terms" => $_POST["termid"], "field" => "id", "include_children" => true, "operator" => "IN");
        } else {
            if ($_POST["taxonomy"] == "post_tag") {
                $args["tax_query"][] = array("taxonomy" => "post_tag", "terms" => $_POST["termid"], "field" => "id", "include_children" => true, "operator" => "IN");
            } else {
                $args["tax_query"][] = array("taxonomy" => $_POST["taxonomy"], "terms" => $_POST["slug"], "field" => "slug", "include_children" => true, "operator" => "IN");
            }
        }
        if (count(get_posts($args))) {
            $wp_query = new WP_Query();
            $wp_query->query($args);
            while ($wp_query->have_posts()) {
                $wp_query->the_post();
                (new ThemeContext())->Block($post);
            }
            wp_reset_query();
        } else {
            echo "<div class=\"EmptyPosts\">لا توجد موضوعات اخري </div>\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\$(function(){\n\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t})\n\t\t\t</script>\n\t\t";
        }
        wp_die();
    }
    public function NewsMore()
    {
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
        $args = array("post_type" => "news", "fields" => "ids", "posts_per_page" => $postNumber, "offset" => $_POST["offset"], "tax_query" => array("relation" => "AND"));
        if (!empty($_POST["termid"]) && !empty($_POST["taxonomy"])) {
            $args["tax_query"][] = array("taxonomy" => $_POST["taxonomy"], "terms" => get_term_by("id", $_POST["termid"], $_POST["taxonomy"])->slug, "field" => "slug", "include_children" => true, "operator" => "IN");
        } else {
            $args["meta_query"][] = array(array("key" => "pinNews", "compare" => "NOT EXISTS"));
        }
        if (count(get_posts($args))) {
            $wp_query = new WP_Query();
            $wp_query->query($args);
            while ($wp_query->have_posts()) {
                $wp_query->the_post();
                (new ThemeContext())->NewsBlock($post);
            }
            wp_reset_query();
        } else {
            echo "<div class=\"EmptyPosts\">لا توجد موضوعات اخري </div>\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\$(function(){\n\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t})\n\t\t\t</script>\n\t\t";
        }
        wp_die();
    }
    public function SearchComplete()
    {
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
        $args = array("fields" => "ids", "post_type" => "post", "posts_per_page" => $postNumber, "s" => $_POST["search"], "ignore_sticky_posts" => 1);
        $wp_query = new WP_Query();
        $wp_query->query($args);
        while ($wp_query->have_posts()) {
            $wp_query->the_post();
            (new ThemeContext())->Block($post);
        }
        wp_die();
    }
    public function NewsBlock($id)
    {
        if (wp_get_attachment_url(get_post_thumbnail_id())) {
            $NewsThumb = get_the_post_thumbnail_url($id, "NewsBlock");
        } else {
            $NewsThumb = get_option("DefultBlock")["url"];
        }
        $post = get_post($id);
        echo "<div class=\"NewsCard\">";
        echo "<a href=\"" . get_the_permalink($id) . "\">";
        echo "<div class=\"NewsCardThumb\"><div class=\"ViewsLabel\"><span>مشاهدات</span>";
        echo "<em>" . (0 < get_post_meta($id, "views", true) ? get_post_meta($id, "views", true) : "0") . "</em>";
        echo "</div>";
        echo "<img data-src=\"" . $NewsThumb . "\">";
        echo "<time><i class=\"fa fa-calendar\"></i>" . date("d-m-Y", strtotime($post->post_date)) . "</time>";
        echo "</div><div class=\"NewsCardHover\">";
        echo "<h2>" . get_the_title($id) . "</h2>";
        echo "<div class=\"ContentCard\">" . wp_trim_words(get_the_content(), "15", "..") . "</div>";
        echo "</div></a></div>";
    }
    private function PreGetPostsAction()
    {
        if (is_admin()) {
            return $query;
        }
        if (isset($query->query_vars["post_type"]) && $query->query_vars["post_type"] == "post") {
            $query->set("orderby", "meta_value_num");
            $query->set("meta_key", "imdbRating");
            $query->set("order", "DESC");
        }
        return $query;
    }
    public function Home($id)
    {
        if (isset($_POST["type"]) && $_POST["type"] == "ratings") {
            add_action("pre_get_posts", array($this, "PreGetPostsAction"));
        }
        if (isset($_POST["genre"])) {
            $genre = get_term($_POST["genre"], "genre");
        }
        if (isset($_POST["year"])) {
            $year = get_term($_POST["year"], "release-year");
        }
        if (isset($_POST["category"])) {
            $category = get_term($_POST["category"], "category");
        }
        echo "<div class=\"MoviesBlocksList\" id=\"HomeSlide\">";
        if (array_key_exists("page", $_GET)) {
            $paged = $_GET["page"];
        } else {
            $paged = 1;
        }
        $loop = 0;
        $temp = $wp_query;
        $wp_query = NULL;
        $args = array("post_type" => "post", "posts_per_page" => get_option("Home_RecentNumber" . (wp_is_mobile() ? "_Mobile" : "")), "paged" => $paged, "fields" => "ids");
        if (isset($year->slug)) {
            $args["release-year"] = $year->slug;
        }
        if (isset($genre->slug)) {
            $args["genre"] = $genre->slug;
        }
        if (isset($category->term_id)) {
            $args["cat"] = $category->term_id;
        }
        if (isset($_POST["type"]) && $_POST["type"] == "ratings") {
            $pageSlug = "/ratings";
            $args["meta_key"] = "imdbRating";
            $args["orderby"] = "meta_value_num";
        } else {
            if (isset($_POST["type"]) && $_POST["type"] == "popular") {
                $pageSlug = "/popular";
                $args["meta_key"] = "views";
                $args["orderby"] = "meta_value_num";
            }
        }
        $wp_query = new WP_Query();
        $wp_query->query($args);
        while ($wp_query->have_posts()) {
            $wp_query->the_post();
            (new ThemeContext())->Block($post);
        }
        if (isset($pageSlug)) {
            echo "<a href=\"" . home_url() . $pageSlug . "\" class=\"MorePostsAngle\">مزيد من العروض <i class=\"fa fa-angle-left\"></i></a>";
        } else {
            $Params = array();
            if (isset($category->term_id)) {
                $Params["cat"] = $category;
            }
            if (isset($year->slug)) {
                $Params["year"] = $year;
            }
            if (isset($genre->slug)) {
                $Params["genre"] = $genre;
            }
            $k = 0;
            foreach ($Params as $key => $value) {
                $val = $key == "cat" ? $value->term_id : $value->slug;
                if ($k == 0) {
                    $link = get_term_link($value);
                } else {
                    if ($k == 1) {
                        $link .= "?" . $key . "=" . $val;
                    } else {
                        $link .= "&" . $key . "=" . $val;
                    }
                }
                $k++;
            }
            echo "<a href=\"" . $link . "\" class=\"MorePostsAngle\">مزيد من العروض <i class=\"fa fa-angle-left\"></i></a>";
        }
        echo "</div>";
        wp_die();
    }
    public function SlidBlock($id)
    {
        if (wp_get_attachment_url(get_post_thumbnail_id())) {
            $thumb = get_the_post_thumbnail_url($id, "TopFull");
        } else {
            $thumb = get_option("DefultBlock")["url"];
        }
        echo "<div class=\"BgTopSlider\" style=\"background-image:url(" . $thumb . ")\"></div>";
        echo "<div class=\"BgTopSlider\" style=\"background-image:url(" . $thumb . ")\"></div>";
        echo "<div class=\"TillerTop\" data-trailer=\"" . $id . "\"><div class=\"ClossTF\"><span>الرجوع للتفاصيل </span><i class=\"fas fa-backspace\"></i></div><div class=\"TopsTrilHere\" data-open=\"" . $id . "\"></div></div>";
        echo "<div class=\"SliderBlocks\" data-content=\"" . $id . "\">";
        echo "<a href=\"" . get_the_permalink($id) . "\">";
        if (!get_post_meta($id, "trailer", 1)) {
            echo "<div class=\"PlayOpenPost\">";
            if (get_post_meta($id, "runtime", 1)) {
                echo "<span class=\"runtime\">" . get_post_meta($id, "runtime", 1) . "</span>";
            }
            echo "<div class=\"PlayNow\"><i class=\"fal fa-play\"></i><span>المشاهدة</span></div></div>";
        }
        echo "<div class=\"DivContentNew\">";
        if (get_post_meta($id, "imdbRating", 1)) {
            echo "<div class=\"IMDBBB\"><div class=\"Ratese\"><h3>IMDB</h3>";
            echo "<span>" . get_post_meta($id, "imdbRating", 1) . "</span>";
            echo "<span>" . (get_post_meta($id, "imdbVotes", 1) ? get_post_meta($id, "imdbVotes", 1) : "") . "</span>";
            echo "</div></div>";
        }
        if (get_post_meta($id, "title2", 1)) {
            echo "<h2>" . get_post_meta($id, "title2", 1) . "</h2>";
        } else {
            echo "<h2>" . get_the_title($id) . "</h2>";
        }
        echo "<div class=\"TopTerms\">";
        if (get_the_terms($id, "category", 1)) {
            foreach (array_slice(is_array(get_the_terms($id, "category", 1)) ? get_the_terms($id, "category", 1) : array(), 0, 1) as $catego) {
                echo "<span class=\"Cat\">" . $catego->name . "</span>";
            }
        }
        if (get_the_terms($id, "genre", 1)) {
            foreach (array_slice(is_array(get_the_terms($id, "genre", 1)) ? get_the_terms($id, "genre", 1) : array(), 0, 2) as $genre) {
                echo "<span class=\"Genre\">" . $genre->name . "</span>";
            }
        }
        if (get_the_terms($id, "release-year", 1)) {
            foreach (array_slice(is_array(get_the_terms($id, "release-year", 1)) ? get_the_terms($id, "release-year", 1) : array(), 0, 1) as $year) {
                echo "<span class=\"year\">" . $year->name . "</span>";
            }
        }
        if (get_the_terms($id, "Quality", 1)) {
            foreach (array_slice(is_array(get_the_terms($id, "Quality", 1)) ? get_the_terms($id, "Quality", 1) : array(), 0, 1) as $Quality) {
                echo "<span class=\"Quality\">" . $Quality->name . "</span>";
            }
        }
        echo "</div><div class=\"RowerContent\">";
        echo wp_trim_words(get_the_content($id), 30, "...");
        echo "<div class=\"NewTem\">";
        if (get_the_terms($id, "actor", 1)) {
            echo "<div class=\"dis\"><em>بطولة:</em>";
            $i = 0;
            foreach (array_slice(is_array(get_the_terms($id, "actor", 1)) ? get_the_terms($id, "actor", 1) : array(), 0, 5) as $actor) {
                $i++;
                echo "<span class=\"actor\">" . (1 < $i ? " , " : "") . "" . $actor->name . "</span>";
            }
            echo "</div>";
        }
        if (get_the_terms($id, "director", 1)) {
            echo "<div class=\"dis\"><em>اخراج :</em>";
            foreach (array_slice(is_array(get_the_terms($id, "director", 1)) ? get_the_terms($id, "director", 1) : array(), 0, 1) as $director) {
                echo "<span class=\"director\">" . $director->name . "</span>";
            }
            echo "</div>";
        }
        echo "</div></div></div></a>";
        if (get_post_meta($id, "trailer", 1)) {
            echo "<div class=\"PlayOpenPost TrailerOpenPost\" data-trailer=\"" . $id . "\" data-link=\"" . get_the_permalink($id) . "\">";
            if (get_post_meta($id, "runtime", 1)) {
                echo "<span class=\"runtime\">" . get_post_meta($id, "runtime", 1) . "</span>";
            }
            echo "<div class=\"PlayNow\"><i class=\"fas fa-play\"></i><span>الأعلان</span></div></div>";
        }
        echo "</div>";
    }
    public function SlidAjax()
    {
        $id = $_POST["id"];
        if (wp_get_attachment_url(get_post_thumbnail_id($id))) {
            $thumb = get_the_post_thumbnail_url($id, "TopFull");
        } else {
            $thumb = get_option("DefultBlock")["url"];
        }
        echo "<div class=\"BgTopSlider\" style=\"background-image:url(" . $thumb . ")\"></div>";
        echo "<div class=\"BgTopSlider\" style=\"background-image:url(" . $thumb . ")\"></div>";
        echo "<div class=\"TillerTop\" data-trailer=\"" . $id . "\"><div class=\"ClossTF\"><span>الرجوع للتفاصيل </span><i class=\"fas fa-backspace\"></i></div><div class=\"TopsTrilHere\" data-open=\"" . $id . "\"></div></div>";
        echo "<div class=\"SliderBlocks\" data-content=\"" . $id . "\">";
        echo "<a href=\"" . get_the_permalink($id) . "\">";
        if (!get_post_meta($id, "trailer", 1)) {
            echo "<div class=\"PlayOpenPost\">";
            if (get_post_meta($id, "runtime", 1)) {
                echo "<span class=\"runtime\">" . get_post_meta($id, "runtime", 1) . "</span>";
            }
            echo "<div class=\"PlayNow\"><i class=\"fal fa-play\"></i><span>المشاهدة</span></div></div>";
        }
        echo "<div class=\"DivContentNew\">";
        if (get_post_meta($id, "imdbRating", 1)) {
            echo "<div class=\"IMDBBB\"><div class=\"Ratese\"><h3>IMDB</h3>";
            echo "<span>" . get_post_meta($id, "imdbRating", 1) . "</span>";
            echo "<span>" . (get_post_meta($id, "imdbVotes", 1) ? get_post_meta($id, "imdbVotes", 1) : "") . "</span>";
            echo "</div></div>";
        }
        if (get_post_meta($id, "title2", 1)) {
            echo "<h2>" . get_post_meta($id, "title2", 1) . "</h2>";
        } else {
            echo "<h2>" . get_the_title($id) . "</h2>";
        }
        echo "<div class=\"TopTerms\">";
        if (get_the_terms($id, "category", 1)) {
            foreach (array_slice(is_array(get_the_terms($id, "category", 1)) ? get_the_terms($id, "category", 1) : array(), 0, 1) as $catego) {
                echo "<span class=\"Cat\">" . $catego->name . "</span>";
            }
        }
        if (get_the_terms($id, "genre", 1)) {
            foreach (array_slice(is_array(get_the_terms($id, "genre", 1)) ? get_the_terms($id, "genre", 1) : array(), 0, 2) as $genre) {
                echo "<span class=\"Genre\">" . $genre->name . "</span>";
            }
        }
        if (get_the_terms($id, "release-year", 1)) {
            foreach (array_slice(is_array(get_the_terms($id, "release-year", 1)) ? get_the_terms($id, "release-year", 1) : array(), 0, 1) as $year) {
                echo "<span class=\"year\">" . $year->name . "</span>";
            }
        }
        if (get_the_terms($id, "Quality", 1)) {
            foreach (array_slice(is_array(get_the_terms($id, "Quality", 1)) ? get_the_terms($id, "Quality", 1) : array(), 0, 1) as $Quality) {
                echo "<span class=\"Quality\">" . $Quality->name . "</span>";
            }
        }
        echo "</div><div class=\"RowerContent\">";
        $pst = get_post($id);
        $postcontent = $pst->post_content;
        echo wp_trim_words($postcontent, 40, "...");
        echo "<div class=\"NewTem\">";
        if (get_the_terms($id, "actor", 1)) {
            echo "<div class=\"dis\"><em>بطولة:</em>";
            $i = 0;
            foreach (array_slice(is_array(get_the_terms($id, "actor", 1)) ? get_the_terms($id, "actor", 1) : array(), 0, 5) as $actor) {
                $i++;
                echo "<span class=\"actor\">" . (1 < $i ? " , " : "") . "" . $actor->name . "</span>";
            }
            echo "</div>";
        }
        if (get_the_terms($id, "director", 1)) {
            echo "<div class=\"dis\"><em>اخراج :</em>";
            foreach (array_slice(is_array(get_the_terms($id, "director", 1)) ? get_the_terms($id, "director", 1) : array(), 0, 1) as $director) {
                echo "<span class=\"director\">" . $director->name . "</span>";
            }
            echo "</div>";
        }
        echo "</div></div></div></a>";
        if (get_post_meta($id, "trailer", 1)) {
            echo "<div class=\"PlayOpenPost TrailerOpenPost\" data-trailer=\"" . $id . "\" data-link=\"" . get_the_permalink($id) . "\">";
            if (get_post_meta($id, "runtime", 1)) {
                echo "<span class=\"runtime\">" . get_post_meta($id, "runtime", 1) . "</span>";
            }
            echo "<div class=\"PlayNow\"><i class=\"fas fa-play\"></i><span>الأعلان</span></div></div>";
        }
        echo "</div>";
        wp_die();
    }
    public function TopMiniBlock($id)
    {
        if (wp_get_attachment_url(get_post_thumbnail_id())) {
            $thumb = get_the_post_thumbnail_url($id, "TopSlider");
        } else {
            $thumb = get_option("DefultBlock")["url"];
        }
        echo "<div class=\"TopAjaxB\" data-id=\"" . $id . "\">";
        echo "<img data-src=\"" . $thumb . "\">";
        echo "<h2>" . get_the_title($id) . "</h2>";
        echo "</div>";
    }
    public function Block($id)
    {
        if (wp_get_attachment_url(get_post_thumbnail_id())) {
            $thumb = get_the_post_thumbnail_url($id, "TopSlider");
        } else {
            $thumb = get_option("DefultBlock")["url"];
        }
        echo "<div class=\"MovieItem\">";
        if (get_post_meta($id, "ribbon", 1)) {
            echo "<div class=\"boxRipP ribbon\"><span>" . get_post_meta($id, "ribbon", 1) . "</span></div>";
        }
        echo "<a title=\"" . get_the_title($id) . "\" href=\"" . get_the_permalink($id) . "\" data-inc=\"" . $thumb . "\" data-style=\"background-image:url(" . $thumb . ")\">";
        if (get_post_meta($id, "title2", 1)) {
            echo " <div class=\"MinRows\">" . get_post_meta($id, "title2", 1) . "</div>";
        } else {
            echo "<div class=\"MinRows\">" . get_the_title($id) . "</div>";
        }
        echo "<div class=\"Poster\">";
        echo "<img data-src=\"" . $thumb . "\">";
        echo "</div><div class=\"TitleMovie\">";
        echo "<h2>" . get_the_title($id) . "</h2>";
        echo "<div class=\"MAngCo\">";
        echo wp_trim_words(get_the_content($id), 15, "...");
        echo "</div><ul class=\"ListMacks\">";
        if (get_the_terms($id, "category", 1)) {
            foreach (array_slice(is_array(get_the_terms($id, "category", 1)) ? get_the_terms($id, "category", 1) : array(), 0, 1) as $category) {
                echo "<li><i class=\"fas fa-th-list\"></i>";
                echo "<span>" . $category->name . "</span>";
                echo "</li>";
            }
        }
        if (get_the_terms($id, "genre", 1)) {
            foreach (array_slice(is_array(get_the_terms($id, "genre", 1)) ? get_the_terms($id, "genre", 1) : array(), 0, 1) as $genre) {
                echo "<li><i class=\"fas fa-film\"></i>";
                echo "<span>" . $genre->name . "</span>";
                echo "</li>";
            }
        }
        echo "</ul></div><div class=\"PostMetaTar\">";
        if (get_post_meta($id, "imdbRating", true)) {
            echo "<div class=\"IMDBlock\"><span>IMDB</span><em>" . get_post_meta($id, "imdbRating", true) . "</em></div>";
        }
        if (get_the_terms($id, "Quality", 1)) {
            foreach (array_slice(is_array(get_the_terms($id, "Quality", 1)) ? get_the_terms($id, "Quality", 1) : array(), 0, 1) as $quality) {
                echo "<div class=\"QualtBLock\">" . $quality->name . "</div>";
            }
        }
        if (get_post_meta($id, "number", 1)) {
            echo "<div class=\"Number\"><span>الحلقة </span><em>" . get_post_meta($id, "number", 1) . "</em></div>";
        }
        echo "</div></a></div>";
    }
    public function tvMore()
    {
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
        $found = false;
        if ($_POST["filter"] == "latest") {
            foreach (array_slice(get_categories(array("taxonomy" => "selary")), $_POST["offset"], $postNumber) as $ser) {
                $posts = get_posts(array("post_type" => "post", "fields" => "ids", "posts_per_page" => 1, "selary" => $ser->slug));
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
                $found = "true";
            }
            if ($found == false) {
                echo "\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t\t});\n\t\t\t\t</script>\n\t\t\t\t<div class=\"EmptyPosts\">لاتوجد مواضيع حاليا </div>";
            }
        } else {
            if ($_POST["filter"] == "best") {
                foreach (array_slice(get_categories(array("taxonomy" => "selary", "meta_key" => $_POST["filter"])), $_POST["offset"], $postNumber) as $ser) {
                    $posts = get_posts(array("post_type" => "post", "fields" => "ids", "posts_per_page" => 1, "selary" => $ser->slug));
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
                    $found = "true";
                }
                if ($found == false) {
                    echo "\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t\t});\n\t\t\t\t</script>\n\t\t\t\t<div class=\"EmptyPosts\">لاتوجد مواضيع حاليا </div>";
                }
            } else {
                if ($_POST["filter"] == "new") {
                    $args = array("post_type" => "post", "posts_per_page" => $postNumber, "offset" => $_POST["offset"], "fields" => "ids", "meta_key" => "number");
                    if (0 < count(get_posts($args))) {
                        $wp_query = new WP_Query();
                        $wp_query->query($args);
                        while ($wp_query->have_posts()) {
                            $wp_query->the_post();
                            (new ThemeContext())->Block($post);
                        }
                        wp_reset_query();
                    } else {
                        echo "<h2 class=\"noMorePosts\">لا يوجد نتائج اخري</h2>\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t\t});\n\t\t\t\t</script>\n\t\t \t";
                    }
                } else {
                    if ($_POST["filter"] == "famous") {
                        foreach (array_slice(get_categories(array("taxonomy" => "selary", "meta_key" => $_POST["filter"])), $_POST["offset"], $postNumber) as $ser) {
                            $posts = get_posts(array("post_type" => "post", "fields" => "ids", "posts_per_page" => 1, "selary" => $ser->slug));
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
                            $found = "true";
                        }
                        if ($found == false) {
                            echo "\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t\t});\n\t\t\t\t</script>\n\t\t\t\t<div class=\"EmptyPosts\">لاتوجد مواضيع حاليا </div>";
                        }
                    } else {
                        if ($_POST["filter"] == "newSeries") {
                            foreach (array_slice(get_categories(array("taxonomy" => "selary", "meta_key" => $_POST["filter"])), $_POST["offset"], $postNumber) as $ser) {
                                $posts = get_posts(array("post_type" => "post", "fields" => "ids", "posts_per_page" => 1, "selary" => $ser->slug));
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
                                $found = "true";
                            }
                            if ($found == false) {
                                echo "\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t\t});\n\t\t\t\t</script>\n\t\t\t\t<div class=\"EmptyPosts\">لاتوجد مواضيع حاليا </div>";
                            }
                        }
                    }
                }
            }
        }
        wp_die();
    }
    public function TvPro()
    {
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
        $found = false;
        if ($_POST["filter"] == "latest") {
            foreach (array_slice(get_categories(array("taxonomy" => "tvshow")), $_POST["offset"], $postNumber) as $ser) {
                $posts = get_posts(array("post_type" => "post", "fields" => "ids", "posts_per_page" => 1, "tvshow" => $ser->slug));
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
                $found = "true";
            }
            if ($found == false) {
                echo "\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t\t});\n\t\t\t\t</script>\n\t\t\t\t<div class=\"EmptyPosts\">لاتوجد مواضيع حاليا </div>";
            }
        } else {
            if ($_POST["filter"] == "best") {
                foreach (array_slice(get_categories(array("taxonomy" => "tvshow", "meta_key" => $_POST["filter"])), $_POST["offset"], $postNumber) as $ser) {
                    $posts = get_posts(array("post_type" => "post", "fields" => "ids", "posts_per_page" => 1, "tvshow" => $ser->slug));
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
                    $found = "true";
                }
                if ($found == false) {
                    echo "\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t\t});\n\t\t\t\t</script>\n\t\t\t\t<div class=\"EmptyPosts\">لاتوجد مواضيع حاليا </div>";
                }
            } else {
                if ($_POST["filter"] == "new") {
                    $args = array("post_type" => "post", "posts_per_page" => $postNumber, "offset" => $_POST["offset"], "fields" => "ids", "meta_key" => "TvPro");
                    if (0 < count(get_posts($args))) {
                        $wp_query = new WP_Query();
                        $wp_query->query($args);
                        while ($wp_query->have_posts()) {
                            $wp_query->the_post();
                            (new ThemeContext())->Block($post);
                        }
                        wp_reset_query();
                    } else {
                        echo "<h2 class=\"noMorePosts\">لا يوجد نتائج اخري</h2>\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t\t});\n\t\t\t\t</script>\n\t\t \t";
                    }
                } else {
                    if ($_POST["filter"] == "famous") {
                        foreach (array_slice(get_categories(array("taxonomy" => "tvshow", "meta_key" => $_POST["filter"])), $_POST["offset"], $postNumber) as $ser) {
                            $posts = get_posts(array("post_type" => "post", "fields" => "ids", "posts_per_page" => 1, "tvshow" => $ser->slug));
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
                            $found = "true";
                        }
                        if ($found == false) {
                            echo "\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t\t});\n\t\t\t\t</script>\n\t\t\t\t<div class=\"EmptyPosts\">لاتوجد مواضيع حاليا </div>";
                        }
                    } else {
                        if ($_POST["filter"] == "newSeries") {
                            foreach (array_slice(get_categories(array("taxonomy" => "tvshow", "meta_key" => $_POST["filter"])), $_POST["offset"], $postNumber) as $ser) {
                                $posts = get_posts(array("post_type" => "post", "fields" => "ids", "posts_per_page" => 1, "tvshow" => $ser->slug));
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
                                $found = "true";
                            }
                            if ($found == false) {
                                echo "\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MainRelated').attr('data-loading','true');\n\t\t\t\t\t});\n\t\t\t\t</script>\n\t\t\t\t<div class=\"EmptyPosts\">لاتوجد مواضيع حاليا </div>";
                            }
                        }
                    }
                }
            }
        }
        wp_die();
    }
    public function GetCanonicalURL()
    {
        $pageURL = "http";
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        return $pageURL;
    }
    public function SingleHead($post)
    {
        $sitename = get_option("SiteName") == "" ? get_bloginfo("name") : get_option("SiteName");
        $facebook = get_option("facebook");
        $title = $post->post_title;
        $image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        $ogimage = !isset(get_post_meta($post->ID, "ogimage", true)["url"]) && empty(get_post_meta($post->ID, "ogimage", true)["url"]) ? $image : get_post_meta($post->ID, "ogimage", true)["url"];
        $content = $post->post_content;
        $metadescription = get_post_meta($post->ID, "metadescription", true) == "" ? $content : get_post_meta($post->ID, "metadescription", true);
        $metadescription = wp_trim_words($metadescription, 30, "");
        $metatitle = get_post_meta($post->ID, "metatitle", true) == "" ? $title : get_post_meta($post->ID, "metatitle", true);
        if (get_query_var("download")) {
            $metatitle .= " - تحميل";
        }
        $canonical = $this->CanonicalURL;
        if ($post->post_type == "post") {
            $cats = is_array(get_the_terms($post->ID, "category", "")) ? get_the_terms($post->ID, "category", "") : array();
        } else {
            if ($post->post_type == "news") {
                $cats = is_array(get_the_terms($post->ID, "catnews", "")) ? get_the_terms($post->ID, "catnews", "") : array();
            } else {
                $cats = is_array(get_the_terms($post->ID, "progcategories", "")) ? get_the_terms($post->ID, "progcategories", "") : array();
            }
        }
        $category = "";
        foreach (array_slice($cats, 0, 1) as $term) {
            $category = $term->name;
        }
        $publishedtime = date("c", strtotime($post->post_date));
        $modifiedtime = date("c", strtotime($post->post_modified));
        echo "<title>" . $metatitle . " | " . $sitename . "</title>";
        echo "<meta name=\"description\" content=\"" . $metadescription . "\" />";
        echo "<meta name=\"robots\" content=\"follow,index\" />";
        echo "<link rel=\"canonical\" href=\"" . $canonical . "\" />";
        echo "<meta property=\"og:locale\" content=\"ar_AR\" /><meta property=\"og:type\" content=\"article\" />";
        echo "<meta property=\"og:title\" content=\"" . $metatitle . "\" />";
        echo "<meta property=\"og:description\" content=\"" . $metadescription . "\" />";
        echo "<meta property=\"og:url\" content=\"" . $canonical . "\" />";
        echo "<meta property=\"og:site_name\" content=\"" . $sitename . "\" />";
        echo "<meta property=\"article:publisher\" content=\"" . $facebook . "\" />";
        echo "<meta property=\"article:section\" content=\"" . $category . "\" />";
        echo "<meta property=\"article:published_time\" content=\"" . $publishedtime . "\" />";
        echo "<meta property=\"article:modified_time\" content=\"" . $modifiedtime . "\" />";
        echo "<meta property=\"og:updated_time\" content=\"" . $modifiedtime . "\" />";
        echo "<meta property=\"og:image\" content=\"" . $ogimage . "\" />";
        echo "<meta property=\"og:image:secure_url\" content=\"" . $ogimage . "\" />";
        echo "<meta property=\"og:image:width\" content=\"1200\" /><meta property=\"og:image:height\" content=\"800\" /><meta name=\"twitter:card\" content=\"summary_large_image\" />";
        echo "<meta name=\"twitter:description\" content=\"" . $metadescription . "\" />";
        echo "<meta name=\"twitter:title\" content=\"" . $metatitle . "\" />";
        echo "<meta name=\"twitter:image\" content=\"" . $ogimage . "\" />";
    }
    public function PageHead($post)
    {
        $sitename = get_option("SiteName") == "" ? get_bloginfo("name") : get_option("SiteName");
        $facebook = get_option("facebook");
        $title = $post->post_title;
        $image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        $ogimage = !isset(get_post_meta($post->ID, "ogimage", true)["url"]) && empty(get_post_meta($post->ID, "ogimage", true)["url"]) ? $image : get_post_meta($post->ID, "ogimage", true)["url"];
        $content = $post->post_content;
        $metadescription = get_post_meta($post->ID, "metadescription", true) == "" ? $content : get_post_meta($post->ID, "metadescription", true);
        $metadescription = wp_trim_words($metadescription, 30, "");
        if (is_page("movies")) {
            $metatitle = get_post_meta($post->ID, "metatitle", true) == "" ? $title . " | " . $sitename : get_post_meta($post->ID, "metatitle", true) . " | " . $sitename;
            if (isset($_GET["key"]) && $_GET["key"] == "new") {
                $metatitle = $title . " - افلام جديدة | " . $sitename;
            }
            if (isset($_GET["key"]) && $_GET["key"] == "latest") {
                $metatitle = $title . " - احدث الاضافات | " . $sitename;
            }
            if (isset($_GET["key"]) && $_GET["key"] == "best") {
                $metatitle = $title . " - افضل الافلام | " . $sitename;
            }
            if (isset($_GET["key"]) && $_GET["key"] == "famous") {
                $metatitle = $title . " - الاكثر شهرة | " . $sitename;
            }
            if (isset($_GET["key"]) && $_GET["key"] == "imdbRating") {
                $metatitle = $title . " - الاكثر تقيما | " . $sitename;
            }
        } else {
            if (is_page("series")) {
                $metatitle = get_post_meta($post->ID, "metatitle", true) == "" ? $title . " | " . $sitename : get_post_meta($post->ID, "metatitle", true) . " | " . $sitename;
                if (isset($_GET["key"]) && $_GET["key"] == "new") {
                    $metatitle = $title . " - احدث الحلقات  | " . $sitename;
                }
                if (isset($_GET["key"]) && $_GET["key"] == "latest") {
                    $metatitle = $title . " - احدث المسلسلات | " . $sitename;
                }
                if (isset($_GET["key"]) && $_GET["key"] == "newSeries") {
                    $metatitle = $title . " - مسلسلات جديدة  | " . $sitename;
                }
                if (isset($_GET["key"]) && $_GET["key"] == "best") {
                    $metatitle = $title . " - افضل المسلسلات | " . $sitename;
                }
                if (isset($_GET["key"]) && $_GET["key"] == "famous") {
                    $metatitle = $title . " - اشهر المسلسلات | " . $sitename;
                }
            } else {
                if (is_page("tvshow")) {
                    $metatitle = get_post_meta($post->ID, "metatitle", true) == "" ? $title . " | " . $sitename : get_post_meta($post->ID, "metatitle", true) . " | " . $sitename;
                    if (isset($_GET["key"]) && $_GET["key"] == "new") {
                        $metatitle = get_the_title() . " - احدث الحلقات  | " . $sitename;
                    }
                    if (isset($_GET["key"]) && $_GET["key"] == "latest") {
                        $metatitle = get_the_title() . " - احدث البرامج  | " . $sitename;
                    }
                    if (isset($_GET["key"]) && $_GET["key"] == "newSeries") {
                        $metatitle = get_the_title() . " - برامج جديدة | " . $sitename;
                    }
                    if (isset($_GET["key"]) && $_GET["key"] == "best") {
                        $metatitle = get_the_title() . " - افضل البرمج | " . $sitename;
                    }
                    if (isset($_GET["key"]) && $_GET["key"] == "famous") {
                        $metatitle = get_the_title() . " - البرامج التليفزيونية الاكثر شهرة  | " . $sitename;
                    }
                } else {
                    if (is_page("trending")) {
                        $metatitle = get_post_meta($post->ID, "metatitle", true) == "" ? $title . " | " . $sitename : get_post_meta($post->ID, "metatitle", true) . " | " . $sitename;
                        if (isset($_GET["key"]) && $_GET["key"] == "now") {
                            $metatitle = get_the_title() . " - الان | " . $sitename;
                        }
                        if (isset($_GET["key"]) && $_GET["key"] == "today") {
                            $metatitle = get_the_title() . " - اليوم | " . $sitename;
                        }
                        if (isset($_GET["key"]) && $_GET["key"] == "week") {
                            $metatitle = get_the_title() . " - هذه الاسبوع | " . $sitename;
                        }
                        if (isset($_GET["key"]) && $_GET["key"] == "month") {
                            $metatitle = get_the_title() . " - هذا الشهر | " . $sitename;
                        }
                    } else {
                        $metatitle = get_post_meta($post->ID, "metatitle", true) == "" ? $title . " | " . $sitename : get_post_meta($post->ID, "metatitle", true) . " | " . $sitename;
                    }
                }
            }
        }
        $canonical = $this->CanonicalURL;
        $cats = is_array(get_the_terms($post->ID, "progcategories", "")) ? get_the_terms($post->ID, "progcategories", "") : array();
        $category = "";
        foreach (array_slice($cats, 0, 1) as $term) {
            $category = $term->name;
        }
        $publishedtime = date("c", strtotime($post->post_date));
        $modifiedtime = date("c", strtotime($post->post_modified));
        echo "<title>" . $metatitle . "</title>";
        echo "<meta name=\"description\" content=\"" . $metadescription . "\" />";
        echo "<meta name=\"robots\" content=\"follow,index\" />";
        echo "<link rel=\"canonical\" href=\"" . $canonical . "\" />";
        echo "<meta property=\"og:locale\" content=\"ar_AR\" /><meta property=\"og:type\" content=\"article\" />";
        echo "<meta property=\"og:title\" content=\"" . $metatitle . "\" />";
        echo "<meta property=\"og:description\" content=\"" . $metadescription . "\" />";
        echo "<meta property=\"og:url\" content=\"" . $canonical . "\" />";
        echo "<meta property=\"og:site_name\" content=\"" . $sitename . "\" />";
        echo "<meta property=\"article:publisher\" content=\"" . $facebook . "\" />";
        echo "<meta property=\"article:section\" content=\"" . $category . "\" />";
        echo "<meta property=\"article:published_time\" content=\"" . $publishedtime . "\" />";
        echo "<meta property=\"article:modified_time\" content=\"" . $modifiedtime . "\" />";
        echo "<meta property=\"og:updated_time\" content=\"" . $modifiedtime . "\" />";
        echo "<meta property=\"og:image\" content=\"" . $ogimage . "\" />";
        echo "<meta property=\"og:image:secure_url\" content=\"" . $ogimage . "\" />";
        echo "<meta property=\"og:image:width\" content=\"1200\" /><meta property=\"og:image:height\" content=\"800\" /><meta name=\"twitter:card\" content=\"summary_large_image\" />";
        echo "<meta name=\"twitter:description\" content=\"" . $metadescription . "\" />";
        echo "<meta name=\"twitter:title\" content=\"" . $metatitle . "\" />";
        echo "<meta name=\"twitter:image\" content=\"" . $ogimage . "\" />";
    }
    public function ArchiveHead($obj)
    {
        $sitename = get_option("SiteName") == "" ? get_bloginfo("name") : get_option("SiteName");
        $secondname = get_bloginfo("name");
        $title = $obj->name . " - " . $sitename;
        if (get_query_var("paged")) {
            $paged = get_query_var("paged");
        } else {
            if (get_query_var("page")) {
                $paged = get_query_var("page");
            } else {
                $paged = 1;
            }
        }
        if (1 < $paged) {
            $title .= " - صفحة " . $paged;
        }
        $description = $obj->description;
        $canonical = get_term_link($obj);
        echo "<title>" . $title . "</title>";
        echo "<meta name=\"description\" content=\"" . $description . "\" />";
        echo "<meta name=\"robots\" content=\"follow,index\" />";
        echo "<link rel=\"canonical\" href=\"" . $canonical . "\" />";
        echo "<meta property=\"og:locale\" content=\"ar_AR\" /><meta property=\"og:type\" content=\"object\" />";
        echo "<meta property=\"og:title\" content=\"" . $title . "\" />";
        echo "<meta property=\"og:description\" content=\"" . $description . "\" />";
        echo "<meta property=\"og:url\" content=\"" . $canonical . "\" />";
        echo "<meta property=\"og:site_name\" content=\"" . $sitename . "\" />";
        echo "<meta name=\"twitter:card\" content=\"summary_large_image\" />";
        echo "<meta name=\"twitter:description\" content=\"" . $description . "\" />";
        echo "<meta name=\"twitter:title\" content=\"" . $title . "\" />";
    }
    public function HomeHead()
    {
        $title = get_bloginfo("name");
        if (get_query_var("paged")) {
            $paged = get_query_var("paged");
        } else {
            if (get_query_var("page")) {
                $paged = get_query_var("page");
            } else {
                $paged = 1;
            }
        }
        if (1 < $paged) {
            $title .= " - صفحة " . $paged;
        }
        $description = get_option("SiteName") == "" ? get_bloginfo("description") : get_option("descSite");
        $canonical = home_url();
        $sitename = get_option("SiteName") != "" ? get_option("SiteName") : get_bloginfo("name");
        echo "<title>" . $sitename . "</title>";
        echo "<meta name=\"description\" content=\"" . $description . "\" />";
        echo "<meta name=\"robots\" content=\"follow,index\" /><meta property=\"og:locale\" content=\"ar_AR\" /><meta property=\"og:type\" content=\"website\" />";
        echo "<meta property=\"og:title\" content=\"" . $title . "\" />";
        echo "<meta property=\"og:description\" content=\"" . $description . "\" />";
        echo "<meta property=\"og:url\" content=\"" . $canonical . "\" />";
        echo "<meta property=\"og:site_name\" content=\"" . $sitename . "\" />";
        echo "<meta name=\"twitter:card\" content=\"summary_large_image\" />";
        echo "<meta name=\"twitter:description\" content=\"" . $description . "\" />";
        echo "<meta name=\"twitter:title\" content=\"" . $title . "\" />";
    }
    public function SearchHead()
    {
        if (get_query_var("paged")) {
            $paged = get_query_var("paged");
        } else {
            if (get_query_var("page")) {
                $paged = get_query_var("page");
            } else {
                $paged = 1;
            }
        }
        if (1 < $paged) {
            $title .= " - صفحة " . $paged;
        }
        $description = get_option("descSite") == "" ? get_bloginfo("descSite") : get_option("description");
        $canonical = home_url();
        $sitename = get_option("SiteName") == "" ? get_bloginfo("name") : get_option("SiteName");
        $title = "نتائج البحث عن " . get_search_query() . " | " . $sitename;
        echo "<title>" . $title . "</title>";
        echo "<meta name=\"description\" content=\"" . $description . "\" />";
        echo "<meta name=\"robots\" content=\"follow,index\" />";
        echo "<link rel=\"canonical\" href=\"" . $canonical . "\" />";
        echo "<meta property=\"og:locale\" content=\"ar_AR\" /><meta property=\"og:type\" content=\"website\" />";
        echo "<meta property=\"og:title\" content=\"" . $title . "\" />";
        echo "<meta property=\"og:description\" content=\"" . $description . "\" />";
        echo "<meta property=\"og:url\" content=\"" . $canonical . "\" />";
        echo "<meta property=\"og:site_name\" content=\"" . $sitename . "\" />";
        echo "<meta name=\"twitter:card\" content=\"summary_large_image\" />";
        echo "<meta name=\"twitter:description\" content=\"" . $description . "\" />";
        echo "<meta name=\"twitter:title\" content=\"" . $title . "\" />";
    }
    public function Meta()
    {
        global $post;
        if (is_single()) {
            $this->SingleHead($post);
        } else {
            if (is_home() || is_front_page()) {
                $this->HomeHead();
            } else {
                if (is_search()) {
                    $this->SearchHead();
                } else {
                    if (is_page()) {
                        $this->PageHead($post);
                    } else {
                        if (is_archive() || is_tax() || is_category()) {
                            $obj = get_queried_object();
                            $this->ArchiveHead($obj);
                        }
                    }
                }
            }
        }
    }
    public function CommentItem($comment, $post)
    {
        $class = "";
        $status = "زائر";
        if (0 < $comment->user_id) {
            $user = get_userdata($comment->user_id);
            if (in_array("administrator", $user->roles) || in_array("editor", $user->roles) || in_array("author", $user->roles)) {
                $status = "الدعم";
                $class = "featured";
            } else {
                $status = "عضو";
            }
        }
        echo "<li id=\"comment-" . $comment->comment_ID . "\">\n\t\t\t<div class=\"UserAvatar " . $class . "\"></div>\n\t\t\t<div class=\"NameArea\">\n\t\t\t\t<span>" . $comment->comment_author . "</span>\n\t\t\t\t<em>" . $status . "</em>\n\t\t\t</div>\n\t\t\t<div class=\"CommentContent\">" . $comment->comment_content . "</div>\n\t\t\t<div class=\"CommentInfo\">\n\t\t\t\t<div class=\"CommentDate\">\n\t\t\t\t\t" . date("d/m/Y", strtotime($comment->comment_date)) . "\n\t\t\t\t</div>\n\t\t\t\t<a href=\"javascript:void(0);\" data-comment=\"" . $comment->comment_ID . "\" data-id=\"" . $post->ID . "\" onClick=\"ReplyComment(this);\">رد</a>\n\t\t\t</div>\n\t\t</li>";
        $arguments = array("status" => "approve", "number" => "10", "post_id" => $post->ID, "parent" => $comment->comment_ID);
        $comments = get_comments($arguments);
        if (!empty($comments)) {
            echo "<ul class=\"ChildComments\">";
            foreach ($comments as $comment) {
                $this->CommentItem($comment, $post);
            }
            echo "</ul>";
        }
    }
    public function Reportthis()
    {
        $reports = is_array(get_option("ReportsManagement")) ? get_option("ReportsManagement") : array();
        $reports[$this->Method["POSTs"]["id"]] = $this->Method["POSTs"]["id"];
        update_option("ReportsManagement", $reports);
        update_post_meta($this->Method["POSTs"]["id"], "reports", get_post_meta($this->Method["POSTs"]["id"], "reports", true) + 1);
        wp_die();
    }
    public function firstServer()
    {
        $post = $_POST["id"];
        if (get_post_meta($_POST["id"], "embed_pelicula", true)) {
            echo get_post_meta($_POST["id"], "embed_pelicula", true);
        }
        echo "\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\$('.OpenServers').attr('data-loaded','true');\n\t\t\t</script>\n\t\t";
        wp_die();
    }
    public function GetServer()
    {
        echo get_post_meta($post->ID, "servers", true)[$_POST["id"]]["embed"];
        wp_die();
    }
    public function Espoblock()
    {
        $postID = $_POST["taxid"];
        $offset = $_POST["offset"];
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
        $args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "offset" => $offset, "tax_query" => array("relation" => "or"));
        foreach (is_array(get_the_terms($postID, "category", "")) ? get_the_terms($postID, "category", "") : array() as $category) {
            if (!empty($category)) {
                $args["tax_query"][] = array("taxonomy" => "category", "terms" => $category->term_id, "field" => "id", "include_children" => true, "operator" => "IN");
            }
        }
        foreach (is_array(get_the_terms($postID, "genre", "")) ? get_the_terms($postID, "genre", "") : array() as $genre) {
            if (!empty($genre)) {
                $args["tax_query"][] = array("taxonomy" => "genre", "terms" => $genre->term_id, "field" => "id", "include_children" => true, "operator" => "IN");
            }
        }
        foreach (is_array(get_the_terms($postID, "release-year", "")) ? get_the_terms($postID, "release-year", "") : array() as $release_year) {
            if (!empty($release_year)) {
                $args["tax_query"][] = array("taxonomy" => "release-year", "terms" => $release_year->term_id, "field" => "id", "include_children" => true, "operator" => "IN");
            }
        }
        foreach (is_array(get_the_terms($postID, "Quality", "")) ? get_the_terms($postID, "Quality", "") : array() as $quality) {
            if (!empty($quality)) {
                $args["tax_query"][] = array("taxonomy" => "Quality", "terms" => $quality->term_id, "field" => "id", "include_children" => true, "operator" => "IN");
            }
        }
        if (get_post_meta($postID, "TvPro", 1)) {
            $args["meta_key"] = "TvPro";
        } else {
            if (get_post_meta($postID, "number", 1)) {
                $args["meta_key"] = "number";
                $args["meta_compare"] = "NOT IN";
                $args["meta_value"] = array("");
            } else {
                $args["meta_key"] = "number";
                $args["meta_compare"] = "IN";
                $args["meta_value"] = array("");
            }
        }
        if (count(get_posts($args))) {
            $wp_query = new WP_Query();
            $wp_query->query($args);
            while ($wp_query->have_posts()) {
                $wp_query->the_post();
                (new ThemeContext())->Block($post);
            }
        } else {
            echo "<h2 class=\"NoMore\">عفوا لاتوجد مواضيع </h2>\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MoreLoaded').hide();\n\t\t\t\t\t});\n\t\t\t\t</script>\n\t\t\t";
        }
        wp_die();
    }
    public function RelatedTab()
    {
        $offset = $_POST["offset"];
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
        $args = array("post_type" => "post", "fields" => "ids", "offset" => $offset, "posts_per_page" => $postNumber, "tax_query" => array("relation" => "AND"));
        if (isset($_POST["filter"]) && $_POST["filter"] == "category") {
            $args["tax_query"][] = array("taxonomy" => "category", "terms" => $_POST["taxid"], "field" => "id", "include_children" => true, "operator" => "IN");
        } else {
            if (isset($_POST["filter"]) && $_POST["filter"] == "genre") {
                $args["tax_query"][] = array("taxonomy" => "genre", "terms" => $_POST["taxid"], "field" => "id", "include_children" => true, "operator" => "IN");
            } else {
                if (isset($_POST["filter"]) && $_POST["filter"] == "release-year") {
                    $args["tax_query"][] = array("taxonomy" => "release-year", "terms" => $_POST["taxid"], "field" => "id", "include_children" => true, "operator" => "IN");
                } else {
                    if (isset($_POST["filter"]) && $_POST["filter"] == "Quality") {
                        $args["tax_query"][] = array("taxonomy" => "Quality", "terms" => $_POST["taxid"], "field" => "id", "include_children" => true, "operator" => "IN");
                    }
                }
            }
        }
        if (isset($_POST["dtype"]) && $_POST["dtype"] == "TvPro") {
            $args["meta_key"] = "TvPro";
        } else {
            if (isset($_POST["dtype"]) && $_POST["dtype"] == "series") {
                $args["meta_key"] = "number";
                $args["meta_compare"] = "NOT IN";
                $args["meta_value"] = array("");
            } else {
                $args["meta_key"] = "number";
                $args["meta_compare"] = "IN";
                $args["meta_value"] = array("");
            }
        }
        if (0 < count(get_posts($args))) {
            $wp_query = new WP_Query();
            $wp_query->query($args);
            while ($wp_query->have_posts()) {
                $wp_query->the_post();
                (new ThemeContext())->Block($post);
            }
        } else {
            echo "<h2 class=\"NoMore\">عفوا لاتوجد مواضيع </h2>\t\t\t\t<script type=\"text/javascript\">\n\t\t\t\t\t\$(function(){\n\t\t\t\t\t\t\$('.MoreLoaded').hide();\n\t\t\t\t\t});\n\t\t\t\t</script>\n\t\t";
        }
        wp_die();
    }
    public function AdvSearch()
    {
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
        $args = array("posts_per_page" => $postNumber, "offset" => $_POST["offset"], "fields" => "ids", "post_type" => "post", "tax_query" => array("relation" => "AND"));
        if (isset($_POST["cat"]) && !empty($_POST["cat"])) {
            $args["tax_query"][] = array("taxonomy" => "category", "terms" => get_term_by("slug", $_POST["cat"], "category")->term_id, "field" => "id", "include_children" => true, "operator" => "IN");
        }
        if (isset($_POST["release"]) && !empty($_POST["release"])) {
            $args["tax_query"][] = array("taxonomy" => "release-year", "terms" => $_POST["release"], "field" => "slug", "include_children" => true, "operator" => "IN");
        }
        if (isset($_POST["quality"]) && !empty($_POST["quality"])) {
            $args["tax_query"][] = array("taxonomy" => "Quality", "terms" => $_POST["quality"], "field" => "slug", "include_children" => true, "operator" => "IN");
        }
        if (isset($_POST["lang"]) && !empty($_POST["lang"])) {
            $args["tax_query"][] = array("taxonomy" => "language", "terms" => $_POST["lang"], "field" => "slug", "include_children" => true, "operator" => "IN");
        }
        if (isset($_POST["nation"]) && !empty($_POST["nation"])) {
            $args["tax_query"][] = array("taxonomy" => "nation", "terms" => $_POST["nation"], "field" => "slug", "include_children" => true, "operator" => "IN");
        }
        if (isset($_POST["resolution"]) && !empty($_POST["resolution"])) {
            $args["tax_query"][] = array("taxonomy" => "resolution", "terms" => $_POST["resolution"], "field" => "slug", "include_children" => true, "operator" => "IN");
        }
        if (isset($_POST["genre"]) && !empty($_POST["genre"])) {
            $args["tax_query"][] = array("taxonomy" => "genre", "terms" => $_POST["genre"], "field" => "slug", "include_children" => true, "operator" => "IN");
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
            echo "      <script type=\"text/javascript\">\n        \$(function(){\n          \$('.MainRelated').attr('data-loading', 'true');\n        });\n      </script>\n      <h2 class=\"noMorePosts\">لا يوجد نتائج اخري</h2>";
        }
        wp_die();
    }
    public function MoreSections()
    {
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
        $post = $_POST["id"];
        $args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "offset" => $_POST["offset"], "tax_query" => array("relation" => "AND"));
        if (get_post_meta($post, "filteringby", true) == "imdb") {
            $args["orderby"] = "meta_value_num";
            $args["meta_key"] = "imdbRating";
        } else {
            if (get_post_meta($post, "filteringby", true) == "views") {
                $args["orderby"] = "meta_value_num";
                $args["meta_key"] = "views";
            } else {
                if (get_post_meta($post, "filteringby", true) == "ratings") {
                    $args["orderby"] = "meta_value_num";
                    $args["meta_key"] = "ratings_average";
                } else {
                    if (get_post_meta($post, "filteringby", true) == "pin") {
                        $args["meta_key"] = "pin";
                    }
                }
            }
        }
        if (get_post_meta($post, "category", true) != "") {
            $args["tax_query"][] = array("taxonomy" => "category", "terms" => get_post_meta($post, "category", true), "field" => "id", "include_children" => true, "operator" => "IN");
        }
        if (get_post_meta($post, "ser", true) != "") {
            $args["tax_query"][] = array("taxonomy" => "selary", "terms" => get_post_meta($post, "ser", true), "field" => "id", "include_children" => true, "operator" => "IN");
        }
        if (get_post_meta($post, "movseries", true) != "") {
            $args["tax_query"][] = array("taxonomy" => "assemblies", "terms" => get_post_meta($post, "movseries", true), "field" => "id", "include_children" => true, "operator" => "IN");
        }
        if (get_post_meta($post, "genre", true) != "") {
            $args["tax_query"][] = array("taxonomy" => "genre", "terms" => get_post_meta($post, "genre", true), "field" => "id", "include_children" => true, "operator" => "IN");
        }
        if (get_post_meta($post, "quality", true) != "") {
            $args["tax_query"][] = array("taxonomy" => "Quality", "terms" => get_post_meta($post, "quality", true), "field" => "id", "include_children" => true, "operator" => "IN");
        }
        if (get_post_meta($post, "language", true) != "") {
            $args["tax_query"][] = array("taxonomy" => "language", "terms" => get_post_meta($post, "language", true), "field" => "id", "include_children" => true, "operator" => "IN");
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
            echo "      <script type=\"text/javascript\">\n        \$(function(){\n          \$('.MainRelated').attr('data-loading', 'true');\n        });\n      </script>\n      <h2 class=\"noMorePosts\">لا يوجد نتائج اخري</h2>";
        }
        wp_die();
    }
    public function customlink()
    {
        $post = $_POST["id"];
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
        global $post;
        $args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => $postNumber, "offset" => $_POST["offset"], "tax_query" => array("relation" => "AND"));
        if (get_post_meta($post, "tag_category", true) != "") {
            $args["tax_query"][] = array("taxonomy" => "category", "terms" => get_post_meta($post, "tag_category", true), "field" => "id", "include_children" => true, "operator" => "IN");
        }
        if (get_post_meta($post, "actor_category", true) != "") {
            $args["tax_query"][] = array("taxonomy" => "actor", "terms" => get_post_meta($post, "actor_category", true), "field" => "id", "include_children" => true, "operator" => "IN");
        }
        if (get_post_meta($post, "director_category", true) != "") {
            $args["tax_query"][] = array("taxonomy" => "director", "terms" => get_post_meta($post, "director_category", true), "field" => "id", "include_children" => true, "operator" => "IN");
        }
        if (get_post_meta($post, "genre_category", true) != "") {
            $args["tax_query"][] = array("taxonomy" => "genre", "terms" => get_post_meta($post, "genre_category", true), "field" => "id", "include_children" => true, "operator" => "IN");
        }
        if (get_post_meta($post, "quality_category", true) != "") {
            $args["tax_query"][] = array("taxonomy" => "Quality", "terms" => get_post_meta($post, "quality_category", true), "field" => "id", "include_children" => true, "operator" => "IN");
        }
        if (get_post_meta($post, "escritor_category", true) != "") {
            $args["tax_query"][] = array("taxonomy" => "escritor", "terms" => get_post_meta($post, "escritor_category", true), "field" => "id", "include_children" => true, "operator" => "IN");
        }
        if (get_post_meta($post, "year_category", true) != "") {
            $args["tax_query"][] = array("taxonomy" => "release-year", "terms" => get_post_meta($post, "year_category", true), "field" => "id", "include_children" => true, "operator" => "IN");
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
            echo "        <script type=\"text/javascript\">\n          \$(function(){\n            \$('.MainRelated').attr('data-loading', 'true');\n          });\n        </script>\n        <h2 class=\"noMorePosts\">لا يوجد نتائج اخري</h2>";
        }
        wp_die();
    }
    public function getSeason()
    {
        global $post;
        $saser = array("post_type" => "post", "fields" => "ids", "selary" => $_POST["slug"], "posts_per_page" => 30, "meta_key" => "number", "order" => "ASC", "orderby" => "meta_value_num");
        foreach (get_posts($saser) as $episode) {
            echo "<li " . ($_POST["posid"] == $episode ? " class=\"current\"" : "") . ">\n\t\t\t\t<a href=\"" . get_the_permalink($episode) . "\" title=\"" . get_the_title($episode) . "\" alt=\"" . get_the_title($episode) . "\">\n\t\t\t\t\t<span><em>الحلقة</em>" . get_post_meta($episode, "number", 1) . "</span>";
            echo "<div class=\"QualityEpe\">";
            foreach (array_slice(is_array(get_the_terms($episode, "Quality", "")) ? get_the_terms($episode, "Quality", "") : array(), 0, 1) as $quality) {
                echo $quality->name;
            }
            echo "</div>";
            $thIwed = get_post($episode);
            echo "<div class=\"DateEpe\">منذ  " . human_time_diff(date("U", strtotime($thIwed->post_date)), current_time("timestamp")) . "</div>\n\t\t\t\t</a>\n\t\t\t</li>";
        }
        wp_die();
    }
    public function tvshow()
    {
        global $post;
        $saser = array("post_type" => "post", "tvshow" => $_POST["slug"], "fields" => "ids", "posts_per_page" => 30, "meta_key" => "number", "order" => "ASC", "orderby" => "meta_value_num");
        foreach (get_posts($saser) as $episode) {
            echo "<li " . ($_POST["posid"] == $episode ? " class=\"current\"" : "") . ">\n\t\t\t\t<a href=\"" . get_the_permalink($episode) . "\" title=\"" . get_the_title($episode) . "\" alt=\"" . get_the_title($episode) . "\">\n\t\t\t\t\t<span><em>الحلقة</em>" . get_post_meta($episode, "number", 1) . "</span>";
            echo "<div class=\"QualityEpe\">";
            foreach (array_slice(is_array(get_the_terms($episode, "Quality", "")) ? get_the_terms($episode, "Quality", "") : array(), 0, 1) as $quality) {
                echo $quality->name;
            }
            echo "</div>";
            $thIwed = get_post($episode);
            echo "<div class=\"DateEpe\">منذ  " . human_time_diff(date("U", strtotime($thIwed->post_date)), current_time("timestamp")) . "</div>\n\t\t\t\t</a>\n\t\t\t</li>";
        }
        wp_die();
    }
    public function seshow()
    {
        global $post;
        $args = array("post_type" => "post", "posts_per_page" => -1, "tvshow" => $_POST["slug"], "fields" => "ids");
        echo "<ul class=\"InnerESP\">";
        $wp_query = new WP_Query();
        $wp_query->query($args);
        while ($wp_query->have_posts()) {
            $wp_query->the_post();
            echo " <li>\n\t\t\t\t\t<a href=\"" . get_the_permalink($post) . "\">\n\t\t\t\t\t\t<span>" . get_post_meta($post, "number", 1) . "</span>\n\t\t\t\t\t\t<p>حلقة</p>\n\t\t\t\t\t</a>\n\t\t\t\t</li>";
        }
        echo "</ul>";
        wp_die();
    }
    public function likeAjax()
    {
        if (isset($_POST["like"])) {
            $like = $_POST["like"];
            $id = $_POST["id"];
            (new ThemeContext())->set_like($id);
            echo (new ThemeContext())->likes($id);
            if (isset($_COOKIE["disliked" . $id . ""]) && $_COOKIE["disliked" . $id . ""] == "yes") {
                (new ThemeContext())->set_unlike($id);
                echo "<script type=\"text/javascript\">\n\t\t\t  \tvar num = \$(\"li.dislikes span\").text();\n\t\t\t  \t\$(\"li.dislikes span\").text(num - 1);\n\t\t\t  </script>";
                setcookie("disliked" . $id . "", "yes", time() - 86400 * 30, "/");
            }
        }
        wp_die();
    }
    public function dislikeAjax()
    {
        $id = $_POST["id"];
        (new ThemeContext())->set_unlike($id);
        echo (new ThemeContext())->unlikes($id);
        if (isset($_COOKIE["liked" . $id . ""]) == "yes") {
            (new ThemeContext())->set_like($id);
            echo "<script type=\"text/javascript\">\n\t\t  \tvar num = \$(\"li.likes span\").text();\n\t\t  \t\$(\"li.likes span\").text(num - 1);\n\t\t  </script>";
            setcookie("liked" . $id . "", "yes", time() - 86400 * 30, "/");
        }
        wp_die();
    }
    public function LoveThis()
    {
        update_post_meta($this->Method["POSTs"]["id"], "loves", get_post_meta($this->Method["POSTs"]["id"], "loves", true) + 1);
        echo get_post_meta($this->Method["POSTs"]["id"], "loves", true);
        wp_die();
    }
    public function Header($num = "")
    {
        if (is_404()) {
            header("Location: " . home_url());
            exit;
        }
        require get_template_directory() . "/Standard/header" . $num . ".php";
    }
    public function Footer($num = "")
    {
        require get_template_directory() . "/Standard/footer" . $num . ".php";
    }
    public function Page($headernum = "")
    {
        $this->Header($headernum);
        if (!is_home()) {
            $post = get_post($this->args->ID);
            setup_postdata($post);
            if (get_post_meta($post->ID, "recent", true) != "") {
                $this->Archive("category", get_post_meta($post->ID, "recent", true)[0], "post", $post->post_title);
            }
        } else {
            global $wp_query;
            global $wp_rewrite;
            require get_template_directory() . "/Standard/Home.php";
        }
        $this->Footer();
    }
    public function Triller()
    {
        global $post;
        $postID = $_POST["id"];
        echo get_post_meta($postID, "trailer", 1);
        wp_die();
    }
    public function GenerateData()
    {
        $id = $_POST["id"];
        $type = $_POST["type"];
        $data = file_get_contents("http://yourcolor.net/imdb/api/" . $type . ".php?id=" . $id);
        $data = json_decode($data, 1);
        $fields = explode("|", $_POST["fields"]);
        if ($type == "name") {
            if (in_array("image", $fields)) {
                $image_url = $data["image"];
                if (!empty($image_url)) {
                    $post_id = "";
                    $upload_dir = wp_upload_dir();
                    $image_data = wp_remote_fopen($image_url);
                    $filename = basename($image_url);
                    $filename = str_replace(".jpg", "-" . $post_id . ".jpg", $filename);
                    if (wp_mkdir_p($upload_dir["path"])) {
                        $file = $upload_dir["path"] . "/" . $filename;
                    } else {
                        $file = $upload_dir["basedir"] . "/" . $filename;
                    }
                    file_put_contents($file, $image_data);
                    $wp_filetype = wp_check_filetype($filename, NULL);
                    $attachment = array("post_mime_type" => $wp_filetype["type"], "post_title" => sanitize_file_name($filename), "post_content" => "", "post_status" => "inherit");
                    $attach_id = wp_insert_attachment($attachment, $file, $post_id);
                    require_once ABSPATH . "wp-admin/includes/image.php";
                    $attach_data = wp_generate_attachment_metadata($attach_id, $file);
                    wp_update_attachment_metadata($attach_id, $attach_data);
                }
            }
            echo "<script type=\"text/javascript\">";
            if (in_array("image", $fields)) {
                echo "\$(\".apb-field-image input\").val(\"" . wp_get_attachment_url($attach_id) . "\");";
                echo "\$(\".apb-field-image .APBPreviewFile\").attr(\"src\", \"" . wp_get_attachment_url($attach_id) . "\");";
            }
            if (in_array("about", $fields)) {
                echo "\$(\"#description\").val(\"" . str_replace("\"", "'", $data["about"]) . "\");";
            }
            echo "</script><div class=\"DataSuccess\">\n\t\t\t\t<span class=\"dashicons dashicons-smiley\"></span>\n\t\t\t\t<div class=\"alert alert-success\">تم سحب البيانات المطلوبة .. مقال سعيد :)</div>\n\t\t\t</div>";
        } else {
            if (in_array("poster", $fields)) {
                $image_url = $data["poster"];
                if (!empty($image_url)) {
                    $post_id = "";
                    $upload_dir = wp_upload_dir();
                    $image_data = wp_remote_fopen($image_url);
                    $filename = basename($image_url);
                    $filename = str_replace(".jpg", "-" . $post_id . ".jpg", $filename);
                    if (wp_mkdir_p($upload_dir["path"])) {
                        $file = $upload_dir["path"] . "/" . $filename;
                    } else {
                        $file = $upload_dir["basedir"] . "/" . $filename;
                    }
                    file_put_contents($file, $image_data);
                    $wp_filetype = wp_check_filetype($filename, NULL);
                    $attachment = array("post_mime_type" => $wp_filetype["type"], "post_title" => sanitize_file_name($filename), "post_content" => "", "post_status" => "inherit");
                    $attach_id = wp_insert_attachment($attachment, $file, $post_id);
                    require_once ABSPATH . "wp-admin/includes/image.php";
                    $attach_data = wp_generate_attachment_metadata($attach_id, $file);
                    wp_update_attachment_metadata($attach_id, $attach_data);
                }
            }
            echo "\t\t\t<script type=\"text/javascript\">\n\t\t\t\t";
            if (in_array("poster", $fields)) {
                echo "\t\t\t\t    \$('#_thumbnail_id').val(\"";
                echo $attach_id;
                echo "\");\n\t\t\t\t    \$('#postimagediv .inside > center').remove();\n\t\t\t\t    \$('#postimagediv .inside').prepend('<center><h1>تم تعيين صورة بارزة</h1></center>');\n\t\t\t\t";
            }
            echo "\t\t\t\t";
            if (isset($data["released"]) && in_array("released", $fields)) {
                echo "\t\t\t    \t\$('#released').val(\"";
                echo str_replace("\"", "'", $data["released"]);
                echo "\");\n\t\t\t    ";
            }
            echo "\t    \t\t";
            if (isset($data["trailer"]) && in_array("trailer", $fields)) {
                echo "\t\t\t    \t\$('#trailer').val(\"";
                echo str_replace("\"", "'", $data["trailer"]);
                echo "\");\n\t\t\t    ";
            }
            echo "\t\t\t    ";
            if (isset($data["mpaa"]) && in_array("mpaa", $fields)) {
                echo "\t\t\t    \t\$('#new-tag-mpaa').val(\"";
                echo str_replace("\"", "'", $data["mpaa"]);
                echo "\");\n\t\t\t    ";
            }
            echo "\t\t\t    ";
            if (isset($data["awards"]) && in_array("awards", $fields)) {
                echo "\t\t\t    \t\$('#new-tag-awards').val(\"";
                echo str_replace("\"", "'", $data["awards"]);
                echo "\");\n\t\t\t    ";
            }
            echo "\t\t\t    ";
            if (isset($data["runtime"]) && in_array("runtime", $fields)) {
                echo "\t\t\t    \t\$('#runtime').val(\"";
                echo str_replace("\"", "'", $data["runtime"]);
                echo "\");\n\t\t\t    ";
            }
            echo "\t\t\t    ";
            if (isset($data["rating"]) && in_array("rating", $fields)) {
                echo "\t\t\t    \t\$('#imdbRating').val(\"";
                echo str_replace("\"", "'", $data["rating"]);
                echo "\");\n\t\t\t    ";
            }
            echo "\t\t\t    ";
            if (isset($data["votes"]) && in_array("votes", $fields)) {
                echo "\t\t\t    \t\$('#imdbVotes').val(\"";
                echo str_replace("\"", "'", $data["votes"]);
                echo "\");\n\t\t\t    ";
            }
            echo "\t\t\t    ";
            if (isset($data["cast"]) && in_array("cast", $fields)) {
                echo "\t\t\t    \t\$('#new-tag-actor').val(\"";
                echo str_replace("\"", "'", $data["cast"]);
                echo "\");\n\t\t\t    ";
            }
            echo "\t\t\t\t";
            if (in_array("genre", $fields)) {
                echo "\t\t\t\t\t";
                $genres = str_replace("\"", "'", $data["genre"]);
                $en = array("Action", "Adventure", "Music", "Musical", "Comedy", "Drama", "Documentary", "Animation", "Biography", "Crime", "Family", "Fantasy", "History", "Horror", "Mystery", "Romance", "Sci-Fi", "Short", "Sport", "Superhero", "Thriller", "War", "Western");
                $ar = array("اكشن", "مغامرة", "موسيقي", "موسيقي", "كوميدي", "دراما", "وثائقي", "كرتون", "سيرة ذاتية", "جريمة", "عائلي", "فانتازيا", "تاريخي", "رعب", "غموض", "رومانسي", "خيال علمي", "قصير", "رياضي", "خارقة", "اثارة", "حربي", "ويسترن");
                foreach ($en as $k => $genre) {
                    $genres = str_replace($genre, $ar[$k], $genres);
                }
                echo "\t\t\t    \t\$('#new-tag-genre').val(\"";
                echo $genres;
                echo "\");\n\t\t\t\t";
            }
            echo "\t\t\t    ";
            if (isset($data["directors"]) && in_array("directors", $fields)) {
                echo "\t\t\t    \t\$('#new-tag-director').val(\"";
                echo str_replace("\"", "'", $data["directors"]);
                echo "\");\n\t\t\t    ";
            }
            echo "\t\t\t    ";
            if (isset($data["writers"]) && in_array("writers", $fields)) {
                echo "\t\t\t    \t\$('#new-tag-escritor').val(\"";
                echo str_replace("\"", "'", $data["writers"]);
                echo "\");\n\t\t\t    ";
            }
            echo "\t\t\t    ";
            if (isset($data["story"]) && in_array("story", $fields)) {
                echo "\t\t\t    \t\$('#story').val(\"";
                echo str_replace("\"", "'", $data["story"]);
                echo "\");\n\t\t\t    ";
            }
            echo "\t\t\t    ";
            if (isset($data["country"]) && in_array("country", $fields)) {
                echo "\t\t\t    \t\$('#new-tag-nation').val(\"";
                echo str_replace("\"", "'", $data["country"]);
                echo "\");\n\t\t\t    ";
            }
            echo "\t\t\t    ";
            if (isset($data["year"]) && in_array("year", $fields)) {
                echo "\t\t\t    \t\$('#new-tag-release-year').val(\"";
                echo str_replace("\"", "'", $data["year"]);
                echo "\");\n\t\t\t    ";
            }
            echo "\t\t\t    ";
            if (isset($data["language"]) && in_array("language", $fields)) {
                echo "\t\t\t    \t\$('#new-tag-language').val(\"";
                echo str_replace("\"", "'", $data["language"]);
                echo "\");\n\t\t\t    ";
            }
            echo "\t\t\t</script>\n\t\t\t<div class=\"DataSuccess\">\n\t\t\t\t<span class=\"dashicons dashicons-smiley\"></span>\n\t\t\t\t<div class=\"alert alert-success\">تم سحب البيانات المطلوبة .. مقال سعيد :)</div>\n\t\t\t</div>\n\t\t\t";
        }
        wp_die();
    }
    public function Archive($taxonomy, $id, $ptype, $title = NULL, $order = "recent", $hasheader = false)
    {
        global $wp_query;
        global $wp_rewrite;
        global $post;
        if ($hasheader == true) {
            $this->Header();
        }
        $obj = get_term($id, $taxonomy);
        require get_template_directory() . "/Standard/Archive.php";
        if ($hasheader == true) {
            $this->Footer();
        }
    }
    public function Search($searchtxt = "", $perpage = 15)
    {
        global $wp_query;
        global $wp_rewrite;
        global $post;
        global $wpdb;
        $this->Header();
        require get_template_directory() . "/Standard/Search.php";
        $this->Footer();
    }
    public function SearchFilter($query)
    {
        if (!is_admin() && $query->is_main_query() && $query->is_search) {
            $query->set("post_type", array("post"));
        }
    }
    public function ArchivePagination($wp_query, $wp_rewrite)
    {
        echo "<div class=\"pagination\">";
        1 < $wp_query->query_vars["paged"] ? $current = $wp_query->query_vars["paged"] : ($current = 1);
        $pagination = array("base" => @add_query_arg("page", "%#%"), "format" => "", "total" => $wp_query->max_num_pages, "current" => $current, "show_all" => false, "type" => "list", "next_text" => "&laquo;", "prev_text" => "&raquo;");
        if ($wp_rewrite->using_permalinks()) {
            $pagination["base"] = user_trailingslashit(trailingslashit(remove_query_arg("page", get_pagenum_link(1))) . "?page=%#%/", "paged");
        }
        if (!empty($wp_query->query_vars["s"])) {
            $pagination["add_args"] = array("s" => get_query_var("s"));
        }
        echo paginate_links($pagination);
        echo "</div>";
    }
    public function Breadcrumb()
    {
        global $post;
        $schema_link = "http://data-vocabulary.org/Breadcrumb";
        $home = "الرئيسية";
        $delimiter = "<span class=\"seprator\">&raquo;</span>";
        $homeLink = get_bloginfo("url");
        if (!(is_home() || is_front_page())) {
            echo "<div id=\"mpbreadcrumbs\">";
            if (!is_single()) {
                echo "انت هنا : ";
            }
            echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . $homeLink . "\">" . "<span itemprop=\"title\">" . $home . "</span>" . "</a></span>" . $delimiter . " ";
            if (get_page_by_path("blog") && !is_page("blog")) {
                echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . get_permalink(get_page_by_path("blog")) . "\">" . "<span itemprop=\"title\">Blog</span></a></span>" . $delimiter . " ";
            }
            if (is_category()) {
                $thisCat = get_category(get_query_var("cat"), false);
                if ($thisCat->parent != 0) {
                    $category_link = get_category_link($thisCat->parent);
                    echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . $category_link . "\">" . "<span itemprop=\"title\">" . get_cat_name($thisCat->parent) . "</span>" . "</a></span>" . $delimiter . " ";
                }
                $category_id = get_cat_ID(single_cat_title("", false));
                $category_link = get_category_link($category_id);
                echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . $category_link . "\">" . "<span itemprop=\"title\">" . single_cat_title("", false) . "</span>" . "</a></span>";
            } else {
                if (is_single() && !is_attachment()) {
                    $category = get_the_category();
                    if (empty($category)) {
                        $category = get_the_terms($post->ID, "progcategories", "");
                    }
                    if ($category) {
                        foreach ($category as $cat) {
                            echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . get_category_link($cat->term_id) . "\">" . "<span itemprop=\"title\">" . $cat->name . "</span>" . "</a></span>" . $delimiter . " ";
                        }
                    }
                    echo get_the_title();
                } else {
                    if (is_tax()) {
                        $category = get_queried_object();
                        if (0 < $category->parent) {
                            $category = get_term($category->parent, $category->taxonomy);
                            echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . get_term_link($category) . "\">" . "<span itemprop=\"title\">" . $category->name . "</span>" . "</a></span>" . $delimiter . "";
                            $category = get_queried_object();
                        }
                        echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . get_term_link($category) . "\">" . "<span itemprop=\"title\">" . $category->name . "</span>" . "</a></span>";
                    } else {
                        if (!is_single() && !is_page() && get_post_type() != "post" && !is_404()) {
                            $post_type = get_post_type_object(get_post_type());
                            echo $post_type->labels->singular_name;
                        } else {
                            if (is_attachment()) {
                                $parent = get_post($post->post_parent);
                                $cat = get_the_category($parent->ID);
                                $cat = $cat[0];
                                echo get_category_parents($cat, true, " " . $delimiter . " ");
                                echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . get_permalink($parent) . "\">" . "<span itemprop=\"title\">" . $parent->post_title . "</span>" . "</a></span>";
                                echo " " . $delimiter . " " . get_the_title();
                            } else {
                                if (is_page() && !$post->post_parent) {
                                    $get_post_slug = $post->post_title;
                                    $post_slug = str_replace("-", " ", $get_post_slug);
                                    echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . get_permalink() . "\">" . "<span itemprop=\"title\">" . ucfirst($post_slug) . "</span>" . "</a></span>";
                                } else {
                                    if (is_page() && $post->post_parent) {
                                        $parent_id = $post->post_parent;
                                        $breadcrumbs = array();
                                        while ($parent_id) {
                                            $page = get_page($parent_id);
                                            $breadcrumbs[] = "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . get_permalink($page->ID) . "\">" . "<span itemprop=\"title\">" . get_the_title($page->ID) . "</span>" . "</a></span>";
                                            $parent_id = $page->post_parent;
                                        }
                                        $breadcrumbs = array_reverse($breadcrumbs);
                                        for ($i = 0; $i < count($breadcrumbs); $i++) {
                                            echo $breadcrumbs[$i];
                                            if ($i != count($breadcrumbs) - 1) {
                                                echo " " . $delimiter . " ";
                                            }
                                        }
                                        echo $delimiter . "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . get_permalink() . "\">" . "<span itemprop=\"title\">" . the_title_attribute("echo=0") . "</span>" . "</a></span>";
                                    } else {
                                        if (is_tag()) {
                                            $tag_id = get_term_by("name", single_cat_title("", false), "post_tag");
                                            if ($tag_id) {
                                                $tag_link = get_tag_link($tag_id->term_id);
                                            }
                                            echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . $tag_link . "\">" . "<span itemprop=\"title\">" . single_cat_title("", false) . "</span>" . "</a></span>";
                                        } else {
                                            if (is_author()) {
                                                global $author;
                                                $userdata = get_userdata($author);
                                                echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . get_author_posts_url($userdata->ID) . "\">" . "<span itemprop=\"title\">" . $userdata->display_name . "</span>" . "</a></span>";
                                            } else {
                                                if (is_404()) {
                                                    echo "Error 404";
                                                } else {
                                                    if (is_search()) {
                                                        echo "نتائج البحث عن \"" . get_search_query() . "\"";
                                                    } else {
                                                        if (is_day()) {
                                                            echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . get_year_link(get_the_time("Y")) . "\">" . "<span itemprop=\"title\">" . get_the_time("Y") . "</span>" . "</a></span>" . $delimiter . " ";
                                                            echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . get_month_link(get_the_time("Y"), get_the_time("m")) . "\">" . "<span itemprop=\"title\">" . get_the_time("F") . "</span>" . "</a></span>" . $delimiter . " ";
                                                            echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . get_day_link(get_the_time("Y"), get_the_time("m"), get_the_time("d")) . "\">" . "<span itemprop=\"title\">" . get_the_time("d") . "</span>" . "</a></span>";
                                                        } else {
                                                            if (is_month()) {
                                                                echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . get_year_link(get_the_time("Y")) . "\">" . "<span itemprop=\"title\">" . get_the_time("Y") . "</span>" . "</a></span>" . $delimiter . " ";
                                                                echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . get_month_link(get_the_time("Y"), get_the_time("m")) . "\">" . "<span itemprop=\"title\">" . get_the_time("F") . "</span>" . "</a></span>";
                                                            } else {
                                                                if (is_year()) {
                                                                    echo "<span itemscope itemtype=\"" . $schema_link . "\"><a itemprop=\"url\" href=\"" . get_year_link(get_the_time("Y")) . "\">" . "<span itemprop=\"title\">" . get_the_time("Y") . "</span>" . "</a></span>";
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if (get_query_var("paged")) {
                if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
                    echo " (";
                }
                echo __("صفحة") . " " . get_query_var("paged");
                if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
                    echo ")";
                }
            }
            echo "</div>";
        }
    }
    public function CommentsArea($id)
    {
        $post = get_post($id);
        setup_postdata($post);
        require get_template_directory() . "/Setup/Comments/Interface.php";
    }
    public function Single()
    {
        global $post;
        $category = is_array(get_the_terms($post->ID, "category", true)) ? get_the_terms($post->ID, "category", true) : array();
        $post_tag = is_array(get_the_terms($post->ID, "post_tag", true)) ? get_the_terms($post->ID, "post_tag", true) : array();
        $years = is_array(get_the_terms($post->ID, "release-year", true)) ? get_the_terms($post->ID, "release-year", true) : array();
        $quality = is_array(get_the_terms($post->ID, "quality", true)) ? get_the_terms($post->ID, "quality", true) : array();
        $genre = is_array(get_the_terms($post->ID, "genre", true)) ? get_the_terms($post->ID, "genre", true) : array();
        $actor = is_array(get_the_terms($post->ID, "actor", true)) ? get_the_terms($post->ID, "actor", true) : array();
        $this->Header();
        require get_template_directory() . "/Standard/Singles/" . $post->post_type . ".php";
        $this->Footer();
    }
    public function IMDbOptions()
    {
    }
    public function Views($id)
    {
        update_post_meta($id, "views", get_post_meta($id, "views", true) + 1);
        update_post_meta($id, "views_" . date("w-m-Y") . "", get_post_meta($id, "views_" . date("w-m-Y") . "", true) + 1);
        update_post_meta($id, "views_" . date("d-m-Y") . "", get_post_meta($id, "views_" . date("d-m-Y") . "", true) + 1);
    }
    public function likes($id)
    {
        $likes = get_post_meta($id, "likes", true) == "" ? "0" : get_post_meta($id, "likes", true);
        return $likes;
    }
    public function unlikes($id)
    {
        $unlike = get_post_meta($id, "unlike", true) == "" ? "0" : get_post_meta($id, "unlike", true);
        return $unlike;
    }
    public function set_like($id)
    {
        setcookie("liked" . $id . "", "yes", time() + 86400 * 30, "/");
        if ($_COOKIE["liked_" . $id . ""] != "yes") {
            update_post_meta($id, "likes", get_post_meta($id, "likes", true) + 1);
            setcookie("liked_" . $id . "", "yes", time() + 86400 * 30, "/");
            if ($_COOKIE["nolikes_" . $id . ""] == "yes") {
                update_post_meta($id, "unlike", get_post_meta($id, "unlike", true) - 1);
                setcookie("nolikes_" . $id . "", "", time() + 86400 * 30, "/");
                return NULL;
            }
        } else {
            if (get_post_meta($id, "likes", true) == "0") {
                update_post_meta($id, "likes", "0");
                setcookie("liked_" . $id . "", "", time() + 86400 * 30, "/");
                return NULL;
            }
            if ($_COOKIE["liked_" . $id . ""] == "yes") {
                update_post_meta($id, "likes", get_post_meta($id, "likes", true) - 1);
                setcookie("liked_" . $id . "", "", time() + 86400 * 30, "/");
            }
        }
    }
    public function set_unlike($id)
    {
        setcookie("disliked" . $id . "", "yes", time() + 86400 * 30, "/");
        if ($_COOKIE["nolikes_" . $id . ""] != "yes") {
            update_post_meta($id, "unlike", get_post_meta($id, "unlike", true) + 1);
            setcookie("nolikes_" . $id . "", "yes", time() + 86400 * 30, "/");
            if ($_COOKIE["liked_" . $id . ""] == "yes") {
                update_post_meta($id, "likes", get_post_meta($id, "likes", true) - 1);
                setcookie("liked_" . $id . "", "", time() + 86400 * 30, "/");
                return NULL;
            }
        } else {
            if (get_post_meta($id, "unlike", true) == "0") {
                update_post_meta($id, "unlike", "0");
                setcookie("nolikes_" . $id . "", "", time() + 86400 * 30, "/");
                return NULL;
            }
            if ($_COOKIE["nolikes_" . $id . ""] == "yes") {
                update_post_meta($id, "unlike", get_post_meta($id, "unlike", true) - 1);
                setcookie("nolikes_" . $id . "", "", time() + 86400 * 30, "/");
            }
        }
    }
    public function check_liked($id)
    {
        if ($_COOKIE["liked_" . $id . ""] == "yes") {
            return "active";
        }
    }
    public function check_unliked($id)
    {
        if ($_COOKIE["nolikes_" . $id . ""] == "yes") {
            return "active";
        }
    }
}
class ThemeQueries
{
    private $args = NULL;
    public function __construct($args = array())
    {
        $this->args = $args;
    }
    public function Query()
    {
        global $post;
        $query = get_posts($this->args);
        return $query;
    }
    public function Categories($tax = "category", $hempty = 1, $orderby = "id", $order = "ASC", $fields = "all", $search = "", $number = "", $offset = "", $parent = 0)
    {
        global $post;
        $args = array("taxonomy" => $tax, "orderby" => $orderby, "order" => $order, "hide_empty" => $hempty, "fields" => $fields, "parent" => $parent);
        if (!empty($search)) {
            $args["name__like"] = $search;
        }
        if (!empty($offset) && is_numeric($offset)) {
            if (!empty($number) && is_numeric($number)) {
                $terms = array_slice(get_terms($args), $offset, $number);
            } else {
                $terms = array_slice(get_terms($args), $offset);
            }
        } else {
            if (!empty($number) && is_numeric($number)) {
                $terms = array_slice(get_terms($args), 0, $number);
            } else {
                $terms = get_terms($args);
            }
        }
        return $terms;
    }
    public function PostTax($id)
    {
        $category = is_array(get_the_terms($id, "category", "")) ? get_the_terms($id, "category", "") : array();
        $years = is_array(get_the_terms($id, "release-year", "")) ? get_the_terms($id, "release-year", "") : array();
        $quality = is_array(get_the_terms($id, "quality", "")) ? get_the_terms($id, "quality", "") : array();
        $awards = is_array(get_the_terms($id, "awards", "")) ? get_the_terms($id, "awards", "") : array();
        $country = is_array(get_the_terms($id, "country", "")) ? get_the_terms($id, "country", "") : array();
        $language = is_array(get_the_terms($id, "language", "")) ? get_the_terms($id, "language", "") : array();
        $genre = is_array(get_the_terms($id, "genre", "")) ? get_the_terms($id, "genre", "") : array();
        $actor = is_array(get_the_terms($id, "actor", "")) ? get_the_terms($id, "actor", "") : array();
        $director = is_array(get_the_terms($id, "director", "")) ? get_the_terms($id, "director", "") : array();
        $writers = is_array(get_the_terms($id, "writers", "")) ? get_the_terms($id, "writers", "") : array();
        $movseries = is_array(get_the_terms($id, "movseries", "")) ? get_the_terms($id, "movseries", "") : array();
        $series = is_array(get_the_terms($id, "series", "")) ? get_the_terms($id, "series", "") : array();
        $fields["category"] = $category;
        $fields["release-year"] = $years;
        $fields["quality"] = $quality;
        $fields["awards"] = $awards;
        $fields["country"] = $country;
        $fields["language"] = $language;
        $fields["genre"] = $genre;
        $fields["actor"] = $actor;
        $fields["director"] = $director;
        $fields["writers"] = $writers;
        $fields["movseries"] = $movseries;
        $fields["series"] = $series;
        return $fields;
    }
}
function cmp($a, $b)
{
    if ($a["order"] == $b["order"]) {
        return 0;
    }
    return $a["order"] < $b["order"] ? -1 : 1;
}
function cmm_down($a, $b)
{
    if ($a["order"] == $b["order"]) {
        return 0;
    }
    return $a["order"] < $b["order"] ? -1 : 1;
}

?>