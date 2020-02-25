<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

$postID = $post->ID;
(new ThemeContext())->Views($post->ID);
if (is_user_logged_in()) {
    $current_user_id = get_current_user_id();
    $arg = array("user_id" => $current_user_id, "post_id" => $post->ID);
    $history = new Tak_history($arg);
    $set_data_later = $history->update_later($arg);
    $current_user = wp_get_current_user();
}
$option = get_option(date("Y-m-d H"));
if (isset($option[$post->ID])) {
    $option[$post->ID] = $option[$post->ID] + 1;
} else {
    $option[$post->ID] = 1;
}
$option = array_unique($option);
update_option(date("Y-m-d H"), $option);
$option1 = get_option(date("Y-m-d"));
if (isset($option1[$post->ID])) {
    $option1[$post->ID] = $option1[$post->ID] + 1;
} else {
    $option1[$post->ID] = 1;
}
$option1 = array_unique($option1);
update_option(date("Y-m-d"), $option1);
$option2 = get_option(date("Y-m"));
if (isset($option2[$post->ID])) {
    $option2[$post->ID] = $option2[$post->ID] + 1;
} else {
    $option2[$post->ID] = 1;
}
$option2 = array_unique($option2);
update_option(date("Y-m"), $option2);
$option3 = get_option(date("W-Y"));
if (isset($option3[$post->ID])) {
    $option3[$post->ID] = $option3[$post->ID] + 1;
} else {
    $option3[$post->ID] = 1;
}
$option3 = array_unique($option3);
update_option(date("W-Y"), $option3);
if (wp_get_attachment_url(get_post_thumbnail_id())) {
    $thumb = get_the_post_thumbnail_url($post->ID, "TopSlider ");
} else {
    $thumb = get_option("DefultBlock")["url"];
}
$Schema = "movie";
foreach (is_array(get_the_terms($post->ID, "selary", "")) ? get_the_terms($post->ID, "selary", "") : array() as $series) {
    $Schema = "serie";
    if (0 < $series->parent) {
        $HasSeasons = true;
        $SerieID = $series->parent;
        $CurrentSeason = $series->term_id;
    } else {
        $CurrentSeries = $series->term_id;
    }
}
foreach (is_array(get_the_terms($post->ID, "tvshow", "")) ? get_the_terms($post->ID, "tvshow", "") : array() as $tvshow) {
    $Schema = "tvshow";
    if (0 < $tvshow->parent) {
        $HasSeasons = true;
        $tvshowID = $tvshow->parent;
        $CurrentSeTv = $tvshow->term_id;
    } else {
        if (isset($serie->parent) && $serie->parent == 0) {
            $CurrentTvShow = $tvshow->term_id;
        } else {
            $CurrentTvShow = $tvshow->term_id;
        }
    }
}
$schema_link = "http://data-vocabulary.org/Breadcrumb";
$home = "الرئيسية";
$homeLink = home_url();
$delimiter = "<i class=\"fas fa-chevron-left\"></i>";
echo "<form action=\"" . get_the_permalink($post->ID) . "\" method=\"POST\" class=\"FormOpt\">";
echo "<input type=\"hidden\" name=\"watch\" id=\"watch\" value=\"" . $post->ID . "\">";
echo "<button type=\"submit\" class=\"OpenViewer\"><i class=\"fas fa-filter\"></i></button></form>";
if ($Schema == "movie") {
    echo "<div itemscope style=\"display: none;\" itemtype=\"http://schema.org/Movie\">";
    echo "<h1 itemprop=\"name\">" . get_the_title($post->ID) . "</h1>";
    echo "<img src=\"" . wp_get_attachment_url(get_post_thumbnail_id($post->ID)) . "\" itemprop=\"image\" />";
    echo "<span itemprop=\"description\">" . wp_trim_words(get_the_content(), 20, "...") . "</span>";
    echo "Director:";
    foreach (is_array(get_the_terms($post->ID, "director", "")) ? get_the_terms($post->ID, "director", "") : array() as $director) {
        echo "<div itemprop=\"director\" itemscope itemtype=\"http://schema.org/Person\">";
        echo "<span itemprop=\"name\">" . $director->name . "</span>";
        echo "</div>";
    }
    echo "Writers:";
    foreach (is_array(get_the_terms($post->ID, "country", "")) ? get_the_terms($post->ID, "country", "") : array() as $writers) {
        echo "<div itemprop=\"author\" itemscope itemtype=\"http://schema.org/Person\">";
        echo "<span itemprop=\"name\">" . $writers->name . "</span>";
        echo "</div>";
    }
    echo "Stars:";
    foreach (is_array(get_the_terms($post->ID, "actor", "")) ? get_the_terms($post->ID, "actor", "") : array() as $actor) {
        echo "<div itemprop=\"actor\" itemscope itemtype=\"http://schema.org/Person\">";
        echo "<span itemprop=\"name\">" . $actor->name . "</span>,";
        echo "</div>";
    }
    echo "<div itemprop=\"aggregateRating\" itemscope itemtype=\"http://schema.org/AggregateRating\"><span itemprop=\"ratingValue\">8</span>/<span itemprop=\"bestRating\">10</span> stars from<span itemprop=\"ratingCount\">200</span> users.Reviews: <span itemprop=\"reviewCount\">50</span>.</div>";
    echo "<span itemprop=\"datePublished\" content=\"" . date("d-m-Y", strtotime($post->post_date)) . "\" class=\"runtime\">";
    echo date("d-m-Y", strtotime($post->post_date));
    echo "</span></div>";
} else {
    if ($Schema == "tvshow") {
        if (get_the_terms($post->ID, "tvshow", "")) {
            foreach (get_the_terms($post->ID, "tvshow", "") as $serie) {
                if ($serie->parent == 0) {
                    echo "<div itemscope itemtype=\"http://schema.org/TVSeries\" style=\"display: none;\">";
                    echo "<a itemprop=\"url\" href=\"" . get_term_link($serie) . "\">";
                    echo "<span itemprop=\"name\">" . $serie->name . "</span></a>,";
                    foreach (get_the_terms($post->ID, "tvshow", "") as $season) {
                        if (0 < $season->parent) {
                            echo "<div itemprop=\"containsSeason\" itemscope itemtype=\"http://schema.org/TVSeason\">";
                            echo "<a itemprop=\"url\" href=\"" . get_term_link($season) . "\">";
                            echo "<span itemprop=\"name\">" . $season->name . "</span></a>,";
                            echo "<div itemprop=\"episode\" itemscope itemtype=\"http://schema.org/TVEpisode\">";
                            echo "<a itemprop=\"url\" href=\"" . get_the_permalink($post->ID) . "\">";
                            echo "<span itemprop=\"name\">" . get_the_title($post->ID) . "</span></a>,";
                            echo "episode <span itemprop=\"position\">" . get_post_meta($post->ID, "number", true) . "</span>,";
                            echo "</div></div>";
                        }
                    }
                    echo "</div>";
                }
            }
        }
    } else {
        if ($Schema == "serie" && get_the_terms($post->ID, "selary", "")) {
            foreach (get_the_terms($post->ID, "selary", "") as $serie) {
                if ($serie->parent == 0) {
                    echo "<div itemscope itemtype=\"http://schema.org/TVSeries\" style=\"display: none;\">";
                    echo "<a itemprop=\"url\" href=\"" . get_term_link($serie) . "\">";
                    echo "<span itemprop=\"name\">" . $serie->name . "</span></a>,";
                    foreach (get_the_terms($post->ID, "selary", "") as $season) {
                        if (0 < $season->parent) {
                            echo "<div itemprop=\"containsSeason\" itemscope itemtype=\"http://schema.org/TVSeason\">";
                            echo "<a itemprop=\"url\" href=\"" . get_term_link($season) . "\">";
                            echo "<span itemprop=\"name\">" . $season->name . "</span></a>,";
                            echo "<div itemprop=\"episode\" itemscope itemtype=\"http://schema.org/TVEpisode\">";
                            echo "<a itemprop=\"url\" href=\"" . get_the_permalink($post->ID) . "\">";
                            echo "<span itemprop=\"name\">" . get_the_title($post->ID) . "</span>";
                            echo "</a>,";
                            echo "episode <span itemprop=\"position\">" . get_post_meta($post->ID, "number", true) . "</span>,";
                            echo "</div></div>";
                        }
                    }
                    echo "</div>";
                }
            }
        }
    }
}
echo "<span itemprop=\"video\" itemscope itemtype=\"http://schema.org/VideoObject\" style=\"display:none\">";
echo "<meta itemprop=\"name\" content=\"" . get_the_title($post->ID) . "\">";
echo "<link itemprop=\"thumbnailUrl\" href=\"" . wp_get_attachment_url(get_post_thumbnail_id($post->ID)) . "\">";
echo "<meta itemprop=\"description\" content=\"" . get_the_title($post->ID) . "\">";
echo "<meta itemprop=\"uploadDate\" content=\"" . date("Y-m-d", strtotime($post->post_date)) . "T04:56:26\">";
echo "<link itemprop=\"embedURL\" href=\"" . get_the_permalink($post->ID) . "?watch=1\">";
echo "<meta itemprop=\"duration\" content=\"PT6M33S\"></span>";
if (get_post_meta($post->ID, "trailer", 1)) {
    echo "<div class=\"TrilerOverlay\"><div class=\"overlayClosse\"></div><span class=\"closseTriller\"><i class=\"fa fa-times\"></i></span><div class=\"MasterTriller\"></div></div>";
}
echo "<div class=\"CoverBSingle " . (isset($_POST["watch"]) ? "WatchPage" : "") . "\">";
echo "<div class=\"LiveTop\"><div class=\"container\"><div class=\"RightPoster LazyMod active\"><div class=\"DivImgPos\">";
echo "<div class=\"report\" data-title=\"" . get_the_title($post->ID) . "\">تبليغ </div>";
echo "<div class=\"Mashers\"><div class=\"social-share-icon\">";
echo "<a href=\"http://www.facebook.com/sharer.php?u=" . get_the_permalink($post->ID) . "&amp;t=" . get_the_title($post->ID) . "\" target=\"_blank\" class=\"option a1 color-facebook waves-effect waves-light\">";
echo "<i class=\"fab fa-facebook-f\"></i></a>";
echo "<a href=\"http://twitter.com/share?url=" . get_the_permalink($post->ID) . "\" target=\"_blank\" class=\"option a2 color-twitter waves-effect waves-light\">";
echo "<i class=\"fab fa-twitter\"></i></a>";
echo "<a href=\"https://api.whatsapp.com/send?phone=" . get_post_meta($post->ID, "phone", 1) . "&text=I" . get_the_title($post->ID) . "\" target=\"_blank\" class=\"option a5 color-whatsapp waves-effect waves-light\">";
echo "<i class=\"fab fa-whatsapp\"></i></a><a href=\"javascript:;\" class=\"option a color-facebook waves-effect waves-light\"><i class=\"fa fa-share-alt\"></i></a></div><svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\"><defs><filter id=\"goo\"><feGaussianBlur in=\"SourceGraphic\" stdDeviation=\"6\" result=\"blur\"></feGaussianBlur><feColorMatrix in=\"blur\" mode=\"matrix\" values=\"1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 15 -5\" result=\"goo\"></feColorMatrix><feBlend in=\"SourceGraphic\" in2=\"goo\"></feBlend></filter></defs></svg></div> ";
echo "<img data-src=\"" . $thumb . "\">";
echo "<div class=\"MasterLiks\"><ul class=\"list-unstyled clearfix likes\"><li class=\"likes\" data-like=\"like\"><i class=\"fal fa-smile\"></i><em>اعجبني</em>";
echo "<span>" . (new ThemeContext())->likes($post->ID) . "</span>";
echo "</li><li class=\"dislikes\" data-like=\"dislike\"><i class=\"fal fa-sad-tear\"></i><em>لم يعجبني</em>";
echo "<span>" . (new ThemeContext())->unlikes($post->ID) . "</span>";
echo "</li>";
if (get_post_meta($post->ID, "imdbRating", 1)) {
    $Rating = get_post_meta($post->ID, "imdbRating", 1);
    echo "<div class=\"IMDBBB\"><div class=\"Ratese\"><h3>IMDB</h3>";
    echo "<span>" . $Rating . "</span>";
    if (get_post_meta($post->ID, "imdbVotes", 1)) {
        echo "<span>" . (0 < get_post_meta($post->ID, "imdbVotes", 1) ? get_post_meta($post->ID, "imdbVotes", 1) : "") . "</span>";
    }
    echo "</div></div>";
}
echo "</ul><p class=\"rateP\"><span>";
$likes = (new ThemeContext())->likes($post->ID) == 0 || (new ThemeContext())->likes($post->ID) < 0 ? 0 : (new ThemeContext())->likes($post->ID);
$dislikes = (new ThemeContext())->unlikes($post->ID) == 0 || (new ThemeContext())->unlikes($post->ID) < 0 ? 0 : (new ThemeContext())->unlikes($post->ID);
if ($likes == 0 && $dislikes == 0) {
    echo 0 . "<b>%</b>";
} else {
    echo round($likes / ($likes + $dislikes) * 100, 1) . "<b>%</b>";
}
echo "</span><style type=\"text/css\">.rateP>span:after {clip-path: polygon(0 0, 100% 0, 100% <?=( \$likes / ( \$likes +  \$dislikes  )  * 100)?>%, 0 <?=( \$likes / ( \$likes +  \$dislikes  ) ) * 100?>%);}";
if ((new ThemeContext())->likes($post->ID) < (new ThemeContext())->unlikes($post->ID)) {
    echo ".story p>span:after {border:5px solid #f00;}";
}
echo "</style></p></div>";
if (get_post_meta($post->ID, "title2", 1)) {
    echo "<h1 class=\"Rowe\" title=\"" . get_post_meta($post->ID, "title2", 1) . "\">" . get_post_meta($post->ID, "title2", 1) . "</h1>";
}
echo "</div><div class=\"MasterBtnUl\">";
if (get_post_meta($post->ID, "watch", 1)) {
    echo "<div class=\"OpenServers BTNMaster\" data-loaded=\"false\"><i class=\"fal fa-tv-retro\"></i><span>سيرفرات المشاهدة </span></div>";
}
if (get_post_meta($post->ID, "downloads", 1)) {
    echo "<div class=\"DownloadServers BTNMaster\" data-loaded=\"false\"><i class=\"fal fa-download\"></i><span>روابط التحميل </span></div>";
}
if ($CurrentSeason) {
    echo "<div class=\"OpenSeasons BTNMaster\" data-loaded=\"false\"><i class=\"fal fa-tv-retro\"></i>";
    echo "<span>مواسم  " . get_term_by("id", $SerieID, "selary")->name . "</span>";
    echo "</div>";
} else {
    if ($CurrentSeries) {
        echo "<div class=\"OpenSeasons BTNMaster\" data-loaded=\"false\"><i class=\"fal fa-tv-retro\"></i>";
        echo "<span>حلقات " . get_term_by("id", $CurrentSeries, "selary")->name . "</span>";
        echo "</div>";
    }
}
if ($CurrentSeTv) {
    echo "<div class=\"OpenSeasons BTNMaster\" data-loaded=\"false\"><i class=\"fal fa-tv-retro\"></i>";
    echo "<span>مواسم " . get_term_by("id", $tvshowID, "tvshow")->name . "</span>";
    echo "</div>";
} else {
    if ($CurrentTvShow) {
        echo "<div class=\"OpenSeasons BTNMaster\" data-loaded=\"false\"><i class=\"fal fa-tv-retro\"></i>";
        echo "<span>لقات " . get_term_by("id", $CurrentTvShow, "tvshow")->name . "</span>";
        echo "</div>";
    }
}
if (get_the_terms($post->ID, "assemblies", 1)) {
    foreach (array_slice(is_array(get_the_terms($post->ID, "assemblies", 1)) ? get_the_terms($post->ID, "assemblies", 1) : array(), 0, 1) as $assema) {
        echo "<div class=\"OpenAssemb BTNMaster\" data-loaded=\"false\"><i class=\"fal fa-tv-retro\"></i>";
        echo "<span>" . $assema->name . "</span>";
        echo "</div>";
    }
}
echo "</div></div><div class=\"SLeft\"><div class=\"TheTitle\"><div class=\"TitleBar\">";
echo "<a href=\"" . get_the_permalink($post->ID) . "\">";
echo "<h1 title=\"" . get_the_title($post->ID) . "\">" . get_the_title($post->ID) . "</h1>";
echo "</a></div><div class=\"CategoriesList\">";
if (get_the_terms($post->ID, "category", 1)) {
    echo "<span class=\"Cat\">";
    foreach (array_slice(is_array(get_the_terms($post->ID, "category", 1)) ? get_the_terms($post->ID, "category", 1) : array(), 0, 1) as $catego) {
        echo "<a href=\"" . get_term_link($catego) . "\" title=\"" . $catego->name . "\">";
        echo "<em>" . $catego->name . "</em>";
        echo "</a>";
    }
    echo "</span>";
}
if (get_the_terms($post->ID, "genre", 1)) {
    foreach (array_slice(is_array(get_the_terms($post->ID, "genre", 1)) ? get_the_terms($post->ID, "genre", 1) : array(), 0, 4) as $genre) {
        echo "<span class=\"Genre\">";
        echo "<a href=\"" . get_term_link($genre) . "\" title=\"" . $genre->name . "\">";
        echo "<em>" . $genre->name . "</em>";
        echo "</a></span>";
    }
}
if (get_post_meta($post->ID, "released", 1)) {
    echo "<span class=\"released\">";
    echo "<em>" . get_post_meta($post->ID, "released", 1) . "</em>";
    echo "</span>";
}
if (get_the_terms($post->ID, "age", 1)) {
    foreach (array_slice(is_array(get_the_terms($post->ID, "age", 1)) ? get_the_terms($post->ID, "age", 1) : array(), 0, 4) as $age) {
        echo "<span class=\"age\">";
        echo "<a href=\"" . get_term_link($age) . "\" title=\"" . $age->name . "\">";
        echo "<em>" . $age->name . "</em>";
        echo "</a></span>";
    }
}
echo "</div></div><div class=\"ContentTex\"><span class=\"TitleBarD\"><i class=\"far fa-paragraph\"></i><em>القصة </em><ul>";
$resolution = get_the_terms($post->ID, "resolution", "");
if (!empty($resolution)) {
    echo "<li><div class=\"ImgIcon\"><i class=\"far fa-cog\"></i></div><span>الدقة :  </span>";
    foreach (array_slice(is_array($resolution) ? $resolution : array(), 0, 1) as $resolution) {
        echo "<a href=\"" . get_term_link($resolution) . "\">";
        echo $resolution->name;
        echo "</a>";
    }
    echo "</li>";
}
$awards = get_the_terms($post->ID, "awards", "");
if (!empty($awards)) {
    echo "<li><div class=\"ImgIcon\"><i class=\"fal fa-trophy-alt\"></i></div><span>الجوائز: </span>";
    foreach (array_slice(is_array($awards) ? $awards : array(), 0, 1) as $na) {
        echo "<a href=\"" . get_term_link($na) . "\">";
        echo $na->name;
        echo "</a> ";
    }
    echo "</li>";
}
if (get_post_meta($post->ID, "Awards", 1) != "") {
    echo "<li><div class=\"ImgIcon\"><i class=\"fal fa-trophy-alt\"></i></div><span>الجوائز : </span>";
    echo "<em>" . get_post_meta($post->ID, "Awards", 1) . "</em>";
    echo "</li>";
}
$runtime = get_post_meta($post->ID, "runtime", 1);
if (!empty($runtime)) {
    echo "<li><div class=\"ImgIcon\"><i class=\"far fa-clock\"></i></div><span>مدة العرض : </span>";
    echo "<em>" . $runtime . "</em>";
    echo "</li>";
}
$runtime = get_post_meta($post->ID, "Runtime", 1);
if (!empty($runtime)) {
    echo "<li><div class=\"ImgIcon\"><i class=\"far fa-clock\"></i></div><span>مدة العرض : </span>";
    echo "<em>" . $runtime . "</em>";
    echo "</li>";
}
echo "</ul></span>";
echo get_the_content();
echo "</div><div class=\"UiTagses\">";
if (get_the_terms($post->ID, "Quality", 1)) {
    echo "<div class=\"ItemNormal\">";
    foreach (array_slice(is_array(get_the_terms($post->ID, "Quality", 1)) ? get_the_terms($post->ID, "Quality", 1) : array(), 0, 1) as $Quality) {
        echo "<a href=\"" . get_term_link($Quality) . "\">";
        echo "<i class=\"fal fa-popcorn\"></i>";
        echo "<h4>" . $Quality->name . "</h4>";
        echo "<span>الجودة</span></a>";
    }
    echo "</div>";
}
if (get_the_terms($post->ID, "release-year", 1)) {
    echo "<div class=\"ItemNormal\">";
    foreach (array_slice(is_array(get_the_terms($post->ID, "release-year", 1)) ? get_the_terms($post->ID, "release-year", 1) : array(), 0, 1) as $year) {
        echo "<a href=\"" . get_term_link($year) . "\">";
        echo "<i class=\"far fa-calendar\"></i>";
        echo "<h4>" . $year->name . "</h4>";
        echo "<span>السنة</span></a>";
    }
    echo "</div>";
}
if (get_the_terms($post->ID, "nation", 1)) {
    echo "<div class=\"ItemNormal\">";
    foreach (array_slice(is_array(get_the_terms($post->ID, "nation", 1)) ? get_the_terms($post->ID, "nation", 1) : array(), 0, 1) as $nation) {
        echo "<a href=\"" . get_term_link($nation) . "\">";
        echo "<i class=\"fal fa-globe-africa\"></i>";
        echo "<h4>" . $nation->name . "</h4>";
        echo "<span>الدولة</span></a>";
    }
    echo "</div>";
}
if (get_the_terms($post->ID, "language", 1)) {
    echo "<div class=\"ItemNormal\">";
    foreach (array_slice(is_array(get_the_terms($post->ID, "language", 1)) ? get_the_terms($post->ID, "language", 1) : array(), 0, 1) as $language) {
        echo "<a href=\"" . get_term_link($language) . "\">";
        echo "<i class=\"fal fa-globe-africa\"></i>";
        echo "<h4>" . $language->name . "</h4>";
        echo "<span>اللغة</span></a>";
    }
    echo "</div>";
}
echo "<div class=\"ItemNormal\"><i class=\"fal fa-binoculars\"></i>";
echo "<h4>" . get_post_meta($post->ID, "views", 1) . "</h4>";
echo "<span>المشاهدات</span></div>";
if (get_post_meta($post->ID, "trailer", 1)) {
    echo "<div class=\"OpenTNoew\"><em>مشاهدة الاعلان </em></div>";
}
echo "</div><div class=\"CatsFilm\">";
$actor = is_array(get_the_terms($post->ID, "actor", "")) ? get_the_terms($post->ID, "actor", "") : array();
$country = is_array(get_the_terms($post->ID, "country", "")) ? get_the_terms($post->ID, "country", "") : array();
$director = is_array(get_the_terms($post->ID, "director", "")) ? get_the_terms($post->ID, "director", "") : array();
$arr = array_merge($actor, $country, $director);
if (!empty($arr)) {
    echo "<span class=\"TitleBarD\"><i class=\"fal fa-users-crown\"></i><em>فريق العمل</em></span>";
    if (get_the_terms($post->ID, "actor", "")) {
        echo "<li><strong>ممثل </strong>";
        $i = 0;
        foreach (get_the_terms($post->ID, "actor", "") as $actor) {
            $i++;
            $arr[] = $i;
            echo "<a href=\"" . get_term_link($actor) . "\" class=\"TeamWor\">";
            echo "<span>" . $actor->name . "</span>";
            echo "</a>";
        }
        echo "</li>";
    }
    if (get_the_terms($post->ID, "country", "")) {
        echo "<li><strong>الكاتب </strong>";
        $i = 0;
        foreach (get_the_terms($post->ID, "country", "") as $country) {
            $i++;
            echo "<a href=\"" . get_term_link($country) . "\" class=\"TeamWor\">";
            echo "<span>" . $country->name . "</span>";
            echo "</a>";
        }
    }
    echo "</li>";
    if (get_the_terms($post->ID, "director", "")) {
        echo "<li><strong>المخرج </strong>";
        $i = 0;
        foreach (get_the_terms($post->ID, "director", "") as $director) {
            $i++;
            echo "<a href=\"" . get_term_link($director) . "\" class=\"TeamWor\">";
            echo "<span>" . $director->name . "</span>";
            echo "</a>";
        }
    }
    echo "</li>";
}
echo "</div>";
echo "<div id=\"AdsDiv\" style=\"\">" . (get_option("Ad5") != "" ? get_option("Ad5") : "") . "</div>";
echo "<div class=\"BreadcrumbMasteriv BCrumbInSingle\" style=\"opacity:1\"><div class=\"breadcrumbs\"><div class=\"breadcrumb clearfix\"><div id=\"mpbreadcrumbs\">";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "\">";
echo "<span itemprop=\"title\">" . $home . "</span>";
echo "</a></span>";
if (get_the_terms($post->ID, "category", 1)) {
    foreach (is_array(get_the_terms($post->ID, "category", "")) ? get_the_terms($post->ID, "category", "") : array() as $category) {
        echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
        echo "<a itemprop=\"url\" href=\"" . get_term_link($category) . "\">";
        echo "# <span itemprop=\"title\">" . $category->name . "</span>";
        echo "</a></span>";
    }
}
if (get_the_terms($post->ID, "genre", 1)) {
    foreach (is_array(get_the_terms($post->ID, "genre", "")) ? get_the_terms($post->ID, "genre", "") : array() as $genre) {
        echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
        echo "<a itemprop=\"url\" href=\"" . get_term_link($genre) . "\">";
        echo "# <span itemprop=\"title\">" . $genre->name . "</span>";
        echo "</a></span>";
    }
}
if (get_the_terms($post->ID, "release-year", 1)) {
    foreach (is_array(get_the_terms($post->ID, "release-year", "")) ? get_the_terms($post->ID, "release-year", "") : array() as $year) {
        echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
        echo "<a itemprop=\"url\" href=\"" . get_term_link($year) . "\">";
        echo "# <span itemprop=\"title\">" . $year->name . "</span>";
        echo "</a></span>";
    }
}
if (get_the_terms($post->ID, "selary", 1)) {
    foreach (is_array(get_the_terms($post->ID, "selary", "")) ? get_the_terms($post->ID, "selary", "") : array() as $selary) {
        echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
        echo "<a itemprop=\"url\" href=\"" . get_term_link($selary) . "\">";
        echo "# <span itemprop=\"title\">" . $selary->name . "</span>";
        echo "</a></span>";
    }
}
if (get_the_terms($post->ID, "tvshow", 1)) {
    foreach (is_array(get_the_terms($post->ID, "tvshow", "")) ? get_the_terms($post->ID, "tvshow", "") : array() as $tvshow) {
        echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
        echo "<a itemprop=\"url\" href=\"" . get_term_link($tvshow) . "\">";
        echo "# <span itemprop=\"title\">" . $tvshow->name . "</span>";
        echo "</a></span>";
    }
}
if (get_the_terms($post->ID, "assemblies", 1)) {
    foreach (is_array(get_the_terms($post->ID, "assemblies", "")) ? get_the_terms($post->ID, "assemblies", "") : array() as $mblies) {
        echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
        echo "<a itemprop=\"url\" href=\"" . get_term_link($mblies) . "\">";
        echo "# <span itemprop=\"title\">" . $mblies->name . "</span>";
        echo "</a></span>";
    }
}
if (get_the_terms($post->ID, "post_tag", 1)) {
    $i = 0;
    foreach (is_array(get_the_terms($post->ID, "post_tag", "")) ? get_the_terms($post->ID, "post_tag", "") : array() as $post_tag) {
        $i++;
        echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
        echo "<a itemprop=\"url\" href=\"" . get_term_link($post_tag) . "\">";
        echo "# <span itemprop=\"title\">" . $post_tag->name . "</span>";
        echo "</a></span>";
    }
}
echo "</div></div></div></div>";
echo "<div id=\"AdsDiv\" style=\"\">" . (get_option("Ad6") != "" ? get_option("Ad6") : "") . "</div>";
if (get_post_meta($post->ID, "note1", 1) != "") {
    echo "<div class=\"note_box\">";
    echo get_post_meta($post->ID, "note1", 1);
    echo "</div>";
}
echo "<div class=\"containers\">";
echo "<div id=\"AdsDiv\" style=\"\">" . (get_option("Ad7") != "" ? get_option("Ad7") : "") . "</div>";
echo "<div class=\"DownloadSection\">";
wp_reset_query();
$array = array();
if (get_post_meta($post->ID, "embed_pelicula", 1)) {
    $array[] = get_post_meta($post->ID, "embed_pelicula", 1);
}
if (get_post_meta($post->ID, "embed_pelicula2", 1)) {
    $array[] = get_post_meta($post->ID, "embed_pelicula2", 1);
}
if (get_post_meta($post->ID, "embed_pelicula3", 1)) {
    $array[] = get_post_meta($post->ID, "embed_pelicula3", 1);
}
if (get_post_meta($post->ID, "embed_pelicula4", 1)) {
    $array[] = get_post_meta($post->ID, "embed_pelicula4", 1);
}
if (get_post_meta($post->ID, "embed_pelicula5", 1)) {
    $array[] = get_post_meta($post->ID, "embed_pelicula5", 1);
}
if (get_post_meta($post->ID, "embed_pelicula6", 1)) {
    $array[] = get_post_meta($post->ID, "embed_pelicula6", 1);
}
if (get_post_meta($post->ID, "embed_pelicula7", 1)) {
    $array[] = get_post_meta($post->ID, "embed_pelicula7", 1);
}
if (get_post_meta($post->ID, "embed_pelicula8", 1)) {
    $array[] = get_post_meta($post->ID, "embed_pelicula8", 1);
}
if (get_post_meta($post->ID, "embed_pelicula9", 1)) {
    $array[] = get_post_meta($post->ID, "embed_pelicula9", 1);
}
if (get_post_meta($post->ID, "embed_pelicula10", 1)) {
    $array[] = get_post_meta($post->ID, "embed_pelicula10", 1);
}
if (get_post_meta($post->ID, "embed_pelicula11", 1)) {
    $array[] = get_post_meta($post->ID, "embed_pelicula11", 1);
}
if (!empty($array)) {
    echo "<span class=\"TitleBarD\"><i class=\"far fa-play-circle\"></i><em>سيرفرات المشاهدة </em></span>";
    $watch = $array;
    echo "<div class=\"WatchServersMain\">\n\t\t\t\t\t\t\t\t<ul class=\"WatchServers\">";
    $i = 0;
    foreach ($array as $k => $SEmbed) {
        $selected = "";
        if ($i == 0) {
            $selected = "active";
        }
        echo "<li class=\"" . $selected . "\"  data-type=\"new\" data-server=\"" . $i . "\"><i class=\"fal fa-play-circle\"></i> سيرفر" . ($k + 1) . " <noscript>" . $SEmbed . "</noscript></li>";
        $i++;
    }
    echo "</ul>\n\t\t\t\t\t\t\t\t<div id=\"EmbedCode\">";
    echo "<div class=\"BGHosts\" data-style=\"background-image: url(" . $thumb . ")\"></div>";
    echo "<div class=\"WhatchOpenServ\"><i class=\"fas fa-play\"></i><span>شاهدة الان </span></div></div></div>";
}
echo "<div id=\"DownloadTable\">";
if (get_post_meta($post->ID, "downloads", true)) {
    echo "<span class=\"TitleBarD\"><i class=\"fal fa-download\"></i><em>روابط التحميل </em></span><div class=\"DownloadSer\">";
    foreach (is_array(get_post_meta($post->ID, "downloads", true)) ? get_post_meta($post->ID, "downloads", true) : array() as $download) {
        if (!empty($download["name"])) {
            echo "<div class=\"ListDownloads\">";
            echo "<a href=\"" . $download["url"] . "\" target=\"_blank\">";
            echo "<i class=\"fa fa-download\"></i>";
            if (!empty($download["name"])) {
                echo "<span class=\"Dtit\">" . $download["name"] . "</span>";
            }
            echo "<div class=\"Dqual\"><i class=\"fas fa-tv\"></i>";
            echo "<span>" . ($download["quality"] ? $download["quality"] : "") . "" . ($download["resolution"] ? $download["resolution"] : "") . "</span>";
            echo "</div>";
            if (!empty($download["size"])) {
                echo "<em class=\"Size\"><i class=\"fal fa-file-archive\"></i>" . $download["size"] . "</em>";
            }
            echo "</a></div>";
        }
    }
    echo "</div>";
}
echo "</div></div>";
echo "<div id=\"AdsDiv\" style=\"\">" . (get_option("Ad8") != "" ? get_option("A8") : "") . "</div>";
echo "<div id=\"AdsDiv\" style=\"\">" . (get_option("Ad9") != "" ? get_option("Ad9") : "") . "</div>";
echo "</div>";
wp_reset_query();
echo "<section class=\"content ISInSingle\"><div class=\"container\">";
if ($CurrentSeason) {
    echo "<span class=\"TitleBarD\"><i class=\"fas fa-film-canister\"></i><em>حلقات  </em><a href=\"" . get_term_link(get_term($CurrentSeason, "selary")) . "\">" . get_term($CurrentSeason, "selary")->name . "</a></span>";
} else {
    if ($CurrentSeries) {
        echo "<span class=\"TitleBarD\"><i class=\"fas fa-film-canister\"></i><em>حلقات  </em><a href=\"" . get_term_link(get_term($CurrentSeries, "selary")) . "\">" . get_term($CurrentSeries, "selary")->name . "</a></span>";
    }
}
if ($CurrentSeTv) {
    echo "<span class=\"TitleBarD\"><i class=\"fas fa-film-canister\"></i><em>حلقات  </em><a href=\"" . get_term_link(get_term($CurrentSeTv, "tvshow")) . "\">" . get_term_by("id", $CurrentSeTv, "tvshow")->name . "</a></span>";
} else {
    if ($CurrentTvShow) {
        echo "<span class=\"TitleBarD\"><i class=\"fas fa-film-canister\"></i><em>حلقات  </em><a href=\"" . get_term_link(get_term($CurrentTvShow, "tvshow")) . "\">" . get_term_by("id", $CurrentTvShow, "tvshow")->name . "</a></span>";
    }
}
if (isset($CurrentSeason)) {
    $num = 0;
    foreach (get_categories(array("taxonomy" => "selary", "orderby" => "date", "hide_empty" => 0, "parent" => $SerieID)) as $season) {
        if (get_term_meta($season->term_id, "shortname", 1)) {
            $titleSeason = get_term_meta($season->term_id, "shortname", 1);
        } else {
            $titleSeason = $season->cat_name;
        }
        if (get_term_meta($season->term_id, "order", 1)) {
            $SeasonKey = get_term_meta($season->term_id, "order", 1);
        } else {
            $SeasonKey = $num;
        }
        $FinalSeasons[$SeasonKey] = $season;
        $num++;
    }
    echo "<section class=\"ToggleMange\"><div class=\"container\"><ul class=\"MasterToggleItem\">";
    for ($i = 0; $i < 30; $i++) {
        if (isset($FinalSeasons[$i])) {
            $season = get_term($FinalSeasons[$i]);
            echo "<li data-type=\"getSeason\" class=\"SeriesItems " . ($CurrentSeason == $season->term_id ? "active" : "") . "\" data-slug=\"" . $season->slug . "\" data-title=\"" . $season->cat_name . "\" data-href=\"" . get_term_link($season) . "\" data-posid=\"" . $post->ID . "\">";
            echo "<em>" . (get_term_meta($season->term_id, "order", 1) != "" ? get_term_meta($season->term_id, "order", 1) : "") . "</em>";
            echo "<span>" . $season->cat_name . "</span>";
            echo "</li>";
        }
    }
    echo "</ul><div class=\"MasterToggleOpen\"><ul class=\"InnerESP\" data-loading=\"false\">";
    $saser = array("post_type" => "post", "fields" => "ids", "selary" => get_term($CurrentSeason, "selary")->slug, "posts_per_page" => 30, "meta_key" => "number", "order" => "ASC", "orderby" => "meta_value_num");
    foreach (get_posts($saser) as $episode) {
        echo "<li " . ($post->ID == $episode ? " class=\"current\"" : "") . ">";
        echo "<a href=\"" . get_the_permalink($episode) . "\" title=\"" . get_the_title($episode) . "\" alt=\"" . get_the_title($episode) . "\">";
        echo "<span>";
        echo "<em>الحلقة</em>" . get_post_meta($episode, "number", 1) . "</span>";
        echo "<div class=\"QualityEpe\">";
        foreach (array_slice(is_array(get_the_terms($episode, "Quality", "")) ? get_the_terms($episode, "Quality", "") : array(), 0, 1) as $quality) {
            echo $quality->name;
        }
        echo "</div>";
        $thIwed = get_post($episode);
        echo "<div class=\"DateEpe\">منذ  " . human_time_diff(date("U", strtotime($thIwed->post_date)), current_time("timestamp")) . "</div>";
        echo "</a></li>";
    }
    echo "</ul></div>";
    if (0 <= count(get_posts($saser))) {
        echo "<div class=\"MoreEpesode\">";
        echo "<a href=\"" . get_term_link(get_term($CurrentSeason, "selary")) . "\" target=\"_blank\">";
        echo "<i class=\"fab fa-pushed\"></i><span>المزيد </span></a></div>";
    }
    echo "</div></section>";
} else {
    if (isset($CurrentSeries)) {
        echo "<section class=\"ToggleMange\"><div class=\"container\"><div class=\"MasterToggleOpen\"><ul class=\"InnerESP\" data-loading=\"false\">";
        $saser = array("post_type" => "post", "fields" => "ids", "selary" => get_term($CurrentSeries, "selary")->slug, "posts_per_page" => 30, "meta_key" => "number", "order" => "ASC", "orderby" => "meta_value_num");
        foreach (get_posts($saser) as $episode) {
            echo "<li " . ($post->ID == $episode ? " class=\"current\"" : "") . ">";
            echo "<a href=\"" . get_the_permalink($episode) . "\" title=\"" . get_the_title($episode) . "\" alt=\"" . get_the_title($episode) . "\">";
            echo "<span>";
            echo "<em>الحلقة</em>" . get_post_meta($episode, "number", 1);
            echo "</span><div class=\"QualityEpe\">";
            foreach (array_slice(is_array(get_the_terms($episode, "Quality", "")) ? get_the_terms($episode, "Quality", "") : array(), 0, 1) as $quality) {
                echo $quality->name;
            }
            echo "</div>";
            $thIwed = get_post($episode);
            echo "<div class=\"DateEpe\">";
            echo "منذ  " . human_time_diff(date("U", strtotime($thIwed->post_date)), current_time("timestamp"));
            echo "</div></a></li>";
        }
        echo "</ul></div>";
        if (30 <= count(get_posts($saser))) {
            echo "<div class=\"MoreEpesode\">";
            echo "<a href=\"" . get_term_link(get_term($CurrentSeries, "selary")) . "\" target=\"_blank\">";
            echo "<i class=\"fab fa-pushed\"></i><span>المزيد </span></a></div>";
        }
        echo "</div></section>";
    }
}
wp_reset_query();
if (isset($CurrentSeTv)) {
    $num = 1;
    foreach (get_categories(array("taxonomy" => "tvshow", "orderby" => "date", "hide_empty" => 0, "parent" => $tvshowID)) as $season) {
        if (get_term_meta($season->term_id, "shortname", 1)) {
            $titleSeason = get_term_meta($season->term_id, "shortname", 1);
        } else {
            $titleSeason = $season->cat_name;
        }
        if (get_term_meta($season->term_id, "order", 1)) {
            $SeasonKey = get_term_meta($season->term_id, "order", 1);
        } else {
            $SeasonKey = $num;
        }
        $FinalSeasons[$SeasonKey] = $season;
        $num++;
    }
    echo "<section class=\"ToggleMange\"><div class=\"container\"><ul class=\"MasterToggleItem\">";
    for ($i = 0; $i < 30; $i++) {
        if (isset($FinalSeasons[$i])) {
            $season = get_term($FinalSeasons[$i]);
            echo "<li data-type=\"tvshow\" class=\"SeriesItems " . ($CurrentSeTv == $season->term_id ? "active" : "") . "\" data-slug=\"" . $season->slug . "\" data-title=\"" . $season->cat_name . "\" data-href=\"" . get_term_link($season) . "\" data-posid=\"" . $post->ID . "\">";
            echo "<em>" . (get_term_meta($season->term_id, "order", 1) != "" ? get_term_meta($season->term_id, "order", 1) : "") . "</em>";
            echo "<span>" . $season->cat_name . "</span>";
            echo "</li>";
        }
    }
    echo "</ul><div class=\"MasterToggleOpen\"><ul class=\"InnerESP\" data-loading=\"false\">";
    $saser = array("post_type" => "post", "fields" => "ids", "tvshow" => get_term($CurrentSeTv, "tvshow")->slug, "posts_per_page" => 30, "meta_key" => "number", "order" => "ASC", "orderby" => "meta_value_num");
    foreach (get_posts($saser) as $episode) {
        echo "<li " . ($post->ID == $episode ? " class=\"current\"" : "") . ">";
        echo "<a href=\"" . get_the_permalink($episode) . "\" title=\"" . get_the_title($episode) . "\" alt=\"" . get_the_title($episode) . "\">";
        echo "<span>";
        echo "<em>الحلقة</em>" . get_post_meta($episode, "number", 1);
        echo "</span><div class=\"QualityEpe\">";
        foreach (array_slice(is_array(get_the_terms($episode, "Quality", "")) ? get_the_terms($episode, "Quality", "") : array(), 0, 1) as $quality) {
            echo $quality->name;
        }
        echo "</div>";
        $thIwed = get_post($episode);
        echo "<div class=\"DateEpe\">";
        echo "منذ  " . human_time_diff(date("U", strtotime($thIwed->post_date)), current_time("timestamp"));
        echo "</div></a></li>";
    }
    echo "</ul></div>";
    if (30 <= count(get_posts($saser))) {
        echo "<div class=\"MoreEpesode\">";
        echo "<a href=\"" . get_term_link(get_term($CurrentSeTv, "tvshow")) . "\" target=\"_blank\">";
        echo "<i class=\"fab fa-pushed\"></i><span>المزيد </span></a></div>";
    }
    echo "</div></section>";
} else {
    if (isset($CurrentTvShow)) {
        echo "<section class=\"ToggleMange\"><div class=\"container\"><div class=\"MasterToggleOpen\"><ul class=\"InnerESP\" data-loading=\"false\">";
        $saser = array("post_type" => "post", "fields" => "ids", "tvshow" => get_term($CurrentTvShow, "tvshow")->slug, "posts_per_page" => 30, "meta_key" => "number", "order" => "ASC", "orderby" => "meta_value_num");
        foreach (get_posts($saser) as $episode) {
            echo "<li " . ($post->ID == $episode ? " class=\"current\"" : "") . ">";
            echo "<a href=\"" . get_the_permalink($episode) . "\" title=\"" . get_the_title($episode) . "\" alt=\"" . get_the_title($episode) . "\">";
            echo "<span><em>الحلقة</em>";
            echo get_post_meta($episode, "number", 1);
            echo "</span><div class=\"QualityEpe\">";
            foreach (array_slice(is_array(get_the_terms($episode, "Quality", "")) ? get_the_terms($episode, "Quality", "") : array(), 0, 1) as $quality) {
                echo $quality->name;
            }
            echo "</div>";
            $thIwed = get_post($episode);
            echo "<div class=\"DateEpe\">";
            echo "منذ  " . human_time_diff(date("U", strtotime($thIwed->post_date)), current_time("timestamp")) . "</div>";
            echo "</a></li>";
        }
        echo "</ul></div>";
        if (30 <= count(get_posts($saser))) {
            echo "<div class=\"MoreEpesode\">";
            echo "<a href=\"" . get_term_link(get_term($CurrentTvShow, "tvshow")) . "\" target=\"_blank\">";
            echo "<i class=\"fab fa-pushed\"></i><span>المزيد </span></a></div>";
        }
        echo "</div></section>";
    }
}
if (get_the_terms($post->ID, "assemblies", 1)) {
    echo "<section class=\"assemblies\">";
    foreach (array_slice(is_array(get_the_terms($post->ID, "assemblies", 1)) ? get_the_terms($post->ID, "assemblies", 1) : array(), 0, 1) as $assemblies) {
        echo "<span class=\"TitleBarD\"><i class=\"fas fa-film-canister\"></i><em>حلقات  </em><a href=\"" . get_term_link($assemblies) . "\">" . $assemblies->name . "</a></span>";
        $assem = array("post_type" => "post", "fields" => "ids", "assemblies" => $assemblies->slug, "posts_per_page" => 10);
        if (3 <= count(get_posts($assem))) {
            echo "<div class=\"SectionContent\"><div class=\"container\"><div class=\"left\"><i class=\"far fa-chevron-left\"></i></div><div class=\"right\"><i class=\"far fa-chevron-right\"></i></div><div class=\"OneSection owl-carousel\">";
            foreach (get_posts($assem) as $filmsN) {
                (new ThemeContext())->Block($filmsN);
            }
            echo "</div></div></div>";
        } else {
            echo "<div class=\"MainRelated\" data-loading=\"false\">";
            foreach (get_posts($assem) as $filmsN) {
                (new ThemeContext())->Block($filmsN);
            }
            echo "</div>";
        }
    }
    echo "</section>";
}
echo "<div id=\"AdsDiv\" style=\"\">" . (get_option("Ad4") != "" ? get_option("Ad4") : "") . "</div>";
echo "</div></section></div></div></div></div>";
if (get_post_meta($post->ID, "TvPro", 1)) {
    $TabType = "TvPro";
} else {
    if (get_post_meta($post->ID, "number", 1)) {
        $TabType = "series";
    } else {
        $TabType = "films";
    }
}
echo "<section class=\"RelatedPosts\"><div class=\"SectionTitle\"><div class=\"container\"><h2><div class=\"TitleMasterImg\"> <i class=\"far fa-link\"></i></div><span class=\"TitleSection\">عروض ذات صلة </span><span class=\"MiniSection\">يمكنك متابعة اختيارات ذات صلة </span></h2><div class=\"MasterTabRelated\">";
echo "<div class=\"ItemTabs active\" data-type=\"" . $TabType . "\" data-action=\"Espoblock\" data-id=\"" . $post->ID . "\" data-taxonomy=\"random\" data-title=\"عشوائي\" data-icon=\"fal fa-random\"><i class=\"fal fa-random\"></i><span>عشوائي</span></div>";
if (get_the_terms($post->ID, "category", "")) {
    foreach (array_slice(is_array(get_the_terms($post->ID, "category", "")) ? get_the_terms($post->ID, "category", "") : array(), 0, 1) as $category) {
        echo "<div class=\"ItemTabs\" data-type=\"" . $TabType . "\" data-action=\"RelatedTab\" data-id=\"" . $category->term_id . "\" data-taxonomy=\"category\" data-title=\"" . $category->name . "\" data-icon=\"fad fa-grip-horizontal\"><i class=\"fad fa-grip-horizontal\"></i><span>" . $category->name . "</span></div>";
    }
}
if (get_the_terms($post->ID, "genre", "")) {
    foreach (array_slice(is_array(get_the_terms($post->ID, "genre", "")) ? get_the_terms($post->ID, "genre", "") : array(), 0, 1) as $genre) {
        echo "<div class=\"ItemTabs\" data-type=\"" . $TabType . "\" data-action=\"RelatedTab\" data-id=\"" . $genre->term_id . "\" data-taxonomy=\"genre\" data-title=\"" . $genre->name . "\" data-icon=\"fas fa-film\"><i class=\"fas fa-film\"></i><span>" . $genre->name . "</span></div>";
    }
}
if (get_the_terms($post->ID, "release-year", "")) {
    foreach (array_slice(is_array(get_the_terms($post->ID, "release-year", "")) ? get_the_terms($post->ID, "release-year", "") : array(), 0, 1) as $release_year) {
        echo "<div class=\"ItemTabs\" data-type=\"" . $TabType . "\" data-action=\"RelatedTab\" data-id=\"" . $release_year->term_id . "\" data-taxonomy=\"release-year\" data-title=\"" . $release_year->name . "\" data-icon=\"fas fa-calendar-week\"><i class=\"fas fa-calendar-week\"></i><span>" . $release_year->name . "</span></div>";
    }
}
if (get_the_terms($post->ID, "Quality", "")) {
    foreach (array_slice(is_array(get_the_terms($post->ID, "Quality", "")) ? get_the_terms($post->ID, "Quality", "") : array(), 0, 1) as $Quality) {
        echo "<div class=\"ItemTabs\" data-type=\"" . $TabType . "\" data-action=\"RelatedTab\" data-id=\"" . $Quality->term_id . "\" data-taxonomy=\"Quality\" data-title=\"" . $Quality->name . "\" data-icon=\"fas fa-tv-alt\"><i class=\"fas fa-tv-alt\"></i><span>" . $Quality->name . "</span></div>";
    }
}
echo "</div><hr class=\"slash-1\"></div></div><div class=\"container\">";
global $post;
$args = array("post_type" => "post", "fields" => "ids", "posts_per_page" => 18, "tax_query" => array("relation" => "or"));
if (get_post_meta($post->ID, "TvPro", 1)) {
    $args["meta_key"] = "TvPro";
} else {
    if (get_post_meta($post->ID, "number", 1)) {
        $args["meta_key"] = "number";
        $args["meta_compare"] = "NOT IN";
        $args["meta_value"] = array("");
    } else {
        $args["meta_key"] = "number";
        $args["meta_compare"] = "IN";
        $args["meta_value"] = array("");
    }
}
foreach (is_array(get_the_terms($post->ID, "category", "")) ? get_the_terms($post->ID, "category", "") : array() as $category) {
    if (!empty($category)) {
        $args["tax_query"][] = array("taxonomy" => "category", "terms" => $category->term_id, "field" => "id", "include_children" => true, "operator" => "IN");
    }
}
foreach (is_array(get_the_terms($post->ID, "genre", "")) ? get_the_terms($post->ID, "genre", "") : array() as $genre) {
    if (!empty($genre)) {
        $args["tax_query"][] = array("taxonomy" => "genre", "terms" => $genre->term_id, "field" => "id", "include_children" => true, "operator" => "IN");
    }
}
foreach (is_array(get_the_terms($post->ID, "release-year", "")) ? get_the_terms($post->ID, "release-year", "") : array() as $release_year) {
    if (!empty($release_year)) {
        $args["tax_query"][] = array("taxonomy" => "release-year", "terms" => $release_year->term_id, "field" => "id", "include_children" => true, "operator" => "IN");
    }
}
foreach (is_array(get_the_terms($post->ID, "Quality", "")) ? get_the_terms($post->ID, "Quality", "") : array() as $Quality) {
    if (!empty($Quality)) {
        $args["tax_query"][] = array("taxonomy" => "Quality", "terms" => $Quality->term_id, "field" => "id", "include_children" => true, "operator" => "IN");
    }
}
echo "<div class=\"MainRelated\" data-loading=\"false\">";
$wp_query = new WP_Query();
$wp_query->query($args);
while ($wp_query->have_posts()) {
    $wp_query->the_post();
    (new ThemeContext())->Block($post);
}
wp_reset_query();
echo "</div>\n\t\t<div class=\"MoreLoaded\" data-id=\"" . $post->ID . "\" data-taxonomy=\"random\" data-action=\"Espoblock\" data-type=\"" . $TabType . "\">عرض المزيد </div>\n\t</div>\n</section>";
echo "<div id=\"AdsDiv\" style=\"\">" . (get_option("Ad10") != "" ? get_option("Ad10") : "") . "</div>";
echo "<div class=\"reportpopup\"><div class=\"reportbox\">";
echo do_shortcode(get_option("reportcode"));
echo "</div></div>\n";

?>