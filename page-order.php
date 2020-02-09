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
echo get_option("archive") != "" ? "<center>" . get_option("archive") . "</center>" : "";
$user = get_userdata($post->post_author);
echo "<div style=\"display:none;\" itemscope itemtype=\"http://schema.org/NewsArticle\"><meta itemscope itemprop=\"mainEntityOfPage\"  itemType=\"https://schema.org/WebPage\" itemid=\"https://google.com/article\"/>";
echo "<h2 itemprop=\"headline\">" . get_the_title($post->ID) . "</h2>";
echo "<h3 itemprop=\"author\" itemscope itemtype=\"https://schema.org/Person\">By <span itemprop=\"name\"><?=\$user->display_name?></span></h3>";
echo "<span itemprop=\"description\">" . wp_trim_words(get_the_content($post->ID), 20, "...") . "</span>";
echo "<div itemprop=\"review\" itemscope itemtype=\"http://schema.org/Review\">Review:<span itemprop=\"reviewRating\" itemscope itemtype=\"http://schema.org/Rating\"><span itemprop=\"ratingValue\">5</span> -</span>";
echo "<b>\"<span itemprop=\"name\">" . get_the_title($post->ID) . "</span>\" </b> by ";
echo "<span itemprop=\"author\" itemscope itemtype=\"http://schema.org/Person\">";
echo "<span itemprop=\"name\">" . $user->display_name . "</span></span>, written on";
echo "<meta itemprop=\"datePublished\" content=\"" . date("d-m-Y", strtotime($post->post_date)) . "\">" . date("d-m-Y", strtotime($post->post_date));
echo "<div itemprop=\"reviewBody\">" . wp_trim_words(get_the_content($post->ID), 20, "...") . "</div>";
echo "<span itemprop=\"publisher\" itemscope itemtype=\"http://schema.org/Organization\">";
echo "<meta itemprop=\"name\" content=\"" . get_the_title($post->ID) . "\">";
echo "</span></div><div itemprop=\"image\" itemscope itemtype=\"https://schema.org/ImageObject\">";
echo "<img src=\"" . wp_get_attachment_url(get_post_thumbnail_id($post->ID)) . "\"/>";
echo "<meta itemprop=\"url\" content=\"" . wp_get_attachment_url(get_post_thumbnail_id($post->ID)) . "\">";
echo "<meta itemprop=\"width\" content=\"816\"><meta itemprop=\"height\" content=\"500\"></div><div itemprop=\"publisher\" itemscope itemtype=\"https://schema.org/Organization\"><meta itemprop=\"name\" content=\"Google\"></div>";
echo "<meta itemprop=\"datePublished\" content=\"" . date("d-m-Y", strtotime($post->post_date)) . "\"/>";
echo "<meta itemprop=\"dateModified\" content=\"" . date("d-m-Y", strtotime($post->post_date)) . "\"/>";
echo "</div><script type=\"application/ld+json\">\n  {\n    \"@context\": \"http://schema.org\",\n    \"@type\": \"BreadcrumbList\",\n    ,{\n      \"@type\": \"ListItem\",\n      \"position\": 2,\n      \"item\": {\n        \"@id\": \"";
the_permalink();
echo "\",\n        \"name\": \"";
the_title();
echo "\"\n      }\n    }]\n  }\n</script>\n<div class=\"ContainerNews\"><div class=\"container\">";
wp_reset_query();
echo "<div class=\"main-content main-content-news\"><div class=\"newsContent\"><div class=\"NewTitles\">";
echo "<a href=\"" . get_the_permalink($post->ID) . "\" alt=\"" . get_the_title($post->ID) . "\" title=\"" . get_the_title($post->ID) . "\">";
echo "<h1>" . get_the_title($post->ID) . "</h1>";
echo "</a></div></div><div class=\"story Comment IsNewsSingle\">";
if (get_option("CommentCode")) {
    $disqus_shortname = get_option("CommentCode");
    wp_enqueue_script("disqus_embed", "http://" . $disqus_shortname . ".disqus.com/embed.js");
    echo "<div id=\"disqus_thread\"></div>\n          <script type=\"text/javascript\">\n            var disqus_shortname = \"" . $disqus_shortname . "\";\n            var disqus_title = \"" . $post->post_title . "\";\n            var disqus_url = \"" . get_permalink($post->ID) . "\";\n            var disqus_identifier = \"" . $disqus_shortname . "-" . $post->ID . "\";\n          </script>";
}
echo "</div>";
wp_reset_query();
echo "<div class=\"BreadcrumbMasteriv IsNewsSingle\" style=\"opacity:1\"><div class=\"breadcrumbs\"><div class=\"breadcrumb clearfix\"><div id=\"mpbreadcrumbs\">";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "\">";
echo "<span itemprop=\"title\">" . $home . "</span>";
echo "</a></span>";
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . $homeLink . "/latestnews\">";
echo "<span itemprop=\"title\"> # الاخبار </span></a></span>";
if (get_the_terms($post->ID, "catnews", 1)) {
    foreach (is_array(get_the_terms($post->ID, "catnews", 1)) ? get_the_terms($post->ID, "catnews", 1) : array() as $catnewsss) {
        echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
        echo "<a itemprop=\"url\" href=\"" . get_term_link($catnewsss) . "\">";
        echo "<span itemprop=\"title\"># " . $catnewsss->name . "</span>";
        echo "</a></span>";
    }
}
if (get_the_terms($post->ID, "newstag", 1)) {
    foreach (is_array(get_the_terms($post->ID, "newstag", 1)) ? get_the_terms($post->ID, "newstag", 1) : array() as $newstag) {
        echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
        echo "<a itemprop=\"url\" href=\"" . get_term_link($newstag) . "\">";
        echo "<span itemprop=\"title\"># " . $newstag->name . "</span>";
        echo "</a></span>";
    }
}
echo "<span itemscope=\"\" itemtype=\"" . $schema_link . "\">";
echo "<a itemprop=\"url\" href=\"" . get_the_permalink($post->ID) . "\">";
echo "<span itemprop=\"title\"># " . get_the_title($post->ID) . "</span>";
echo "</a></span></div></div></div></div></div></div></div>";
(new ThemeContext())->Footer();

?>