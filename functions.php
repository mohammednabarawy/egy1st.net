<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

require get_template_directory() . "/Setup/Core.php";
require get_template_directory() . "/Setup/Context.php";
(new ThemeTree())->Setup();
require get_template_directory() . "/Setup/APB/setup.php";
class ThemeTree
{
    private $args = NULL;
    private $_GET = NULL;
    private $_POST = NULL;
    public function __construct($args = array())
    {
        $this->args = $args;
        $this->Method = array("GETs" => $_GET, "POSTs" => $_POST);
    }
    public function PTypesSetup()
    {
        (new ThemeCore())->AddPType("شرائح  الرئيسية", "شريحة", "", "sections", true, false, array("title"));
        (new ThemeCore())->AddPType("روابط مخصصة", "الرابط", "", "customlink", true, false, array("title"));
        (new ThemeCore())->AddPType("الاخبار", "الخبر", "", "news", true, false, array("title", "editor", "thumbnail"));
        (new ThemeCore())->AddPType("الاخبار", "الخبر", "", "news", true, false, array("title", "editor", "thumbnail"));
    }
    public function TaxonomySetup()
    {
        (new ThemeCore())->AddTaxonomy("awards", "post", "الجوائز", array("slug" => "awards"), false);
        (new ThemeCore())->AddTaxonomy("release-year", "post", "سنة الاصدار", array("slug" => "release-year"), false);
        (new ThemeCore())->AddTaxonomy("Quality", "post", "الجودة", array("slug" => "Quality"), false);
        (new ThemeCore())->AddTaxonomy("resolution", "post", "الدقة", array("slug" => "resolution"), false);
        (new ThemeCore())->AddTaxonomy("country", "post", "الدولة", array("slug" => "country"), false);
        (new ThemeCore())->AddTaxonomy("language", "post", "اللغة", array("slug" => "language"), false);
        (new ThemeCore())->AddTaxonomy("genre", "post", "الانواع", array("slug" => "genre"), false);
        (new ThemeCore())->AddTaxonomy("age", "post", "الفئة العمرية ", array("slug" => "age"), false);
        (new ThemeCore())->AddTaxonomy("actor", "post", "الممثلين", array("slug" => "actor"), false);
        (new ThemeCore())->AddTaxonomy("director", "post", "المخرجين", array("slug" => "director"), false);
        (new ThemeCore())->AddTaxonomy("escritor", "post", "الكاتبين", array("slug" => "escritor"), false);
        (new ThemeCore())->AddTaxonomy("assemblies", "post", "سلاسل الافلام", array("slug" => "assemblies"), false);
        (new ThemeCore())->AddTaxonomy("selary", "post", "المسلسلات", array("slug" => "selary"), ture);
        (new ThemeCore())->AddTaxonomy("catnews", "news", "تصنيف الاخبار", array("slug" => "catnews"), false);
        (new ThemeCore())->AddTaxonomy("newstag", "news", "وسوم الاخبار", array("slug" => "newstag"), false);
        (new ThemeCore())->AddTaxonomy("production", "news", "وسوم الاخبار", array("slug" => "production"), false);
        (new ThemeCore())->AddTaxonomy("tvshow", "post", "برامج  تليفزيونية", array("slug" => "tvshow"), ture);
    }
    public function widgetsetup()
    {
    }
    public function ColorSwitch()
    {
        if (isset($_POST["currentColor"])) {
            $mainStyle = $_POST["currentColor"];
            setcookie("siteColor", $mainStyle, time() + 31556926, "/");
        }
    }
    public function Setup()
    {
        add_action("init", array($this, "PTypesSetup"));
        add_action("widgets_init", array($this, "widgetsetup"));
        add_action("init", array(new ThemeCore(), "ThemeSetup"));
        add_action("init", array($this, "TaxonomySetup"));
        add_action("init", array($this, "ColorSwitch"));
        add_action("pre_get_posts", array(new ThemeContext(), "SearchFilter"));
        add_filter("manage_posts_columns", array(new ThemeCore(), "PostColumns"));
        add_action("manage_posts_custom_column", array(new ThemeCore(), "PostColumnsContent"), 10, 2);
        add_action("wp_ajax_nopriv_SearchComplete", array(new ThemeContext(), "SearchComplete"));
        add_action("wp_ajax_SearchComplete", array(new ThemeContext(), "SearchComplete"));
        add_action("wp_ajax_nopriv_MoreTab", array(new ThemeContext(), "MoreTab"));
        add_action("wp_ajax_MoreTab", array(new ThemeContext(), "MoreTab"));
        add_action("wp_ajax_nopriv_filterTab", array(new ThemeContext(), "filterTab"));
        add_action("wp_ajax_filterTab", array(new ThemeContext(), "filterTab"));
        add_action("wp_ajax_nopriv_sectionLoadMore", array(new ThemeContext(), "sectionLoadMore"));
        add_action("wp_ajax_sectionLoadMore", array(new ThemeContext(), "sectionLoadMore"));
        add_action("wp_ajax_nopriv_firstServer", array(new ThemeContext(), "firstServer"));
        add_action("wp_ajax_firstServer", array(new ThemeContext(), "firstServer"));
        add_action("wp_ajax_nopriv_GetServer", array(new ThemeContext(), "GetServer"));
        add_action("wp_ajax_GetServer", array(new ThemeContext(), "firstServer"));
        add_action("wp_ajax_nopriv_Espoblock", array(new ThemeContext(), "Espoblock"));
        add_action("wp_ajax_Espoblock", array(new ThemeContext(), "Espoblock"));
        add_action("wp_ajax_nopriv_getSeason", array(new ThemeContext(), "getSeason"));
        add_action("wp_ajax_getSeason", array(new ThemeContext(), "getSeason"));
        add_action("wp_ajax_nopriv_tvshow", array(new ThemeContext(), "tvshow"));
        add_action("wp_ajax_tvshow", array(new ThemeContext(), "tvshow"));
        add_action("wp_ajax_nopriv_seshow", array(new ThemeContext(), "seshow"));
        add_action("wp_ajax_seshow", array(new ThemeContext(), "seshow"));
        add_action("wp_ajax_nopriv_likeAjax", array(new ThemeContext(), "likeAjax"));
        add_action("wp_ajax_likeAjax", array(new ThemeContext(), "likeAjax"));
        add_action("wp_ajax_nopriv_advancedSearch", array(new ThemeContext(), "advancedSearch"));
        add_action("wp_ajax_advancedSearch", array(new ThemeContext(), "advancedSearch"));
        add_action("wp_ajax_nopriv_archiveMore", array(new ThemeContext(), "archiveMore"));
        add_action("wp_ajax_archiveMore", array(new ThemeContext(), "archiveMore"));
        add_action("wp_ajax_nopriv_NewsMore", array(new ThemeContext(), "NewsMore"));
        add_action("wp_ajax_NewsMore", array(new ThemeContext(), "NewsMore"));
        add_action("wp_ajax_nopriv_dislikeAjax", array(new ThemeContext(), "dislikeAjax"));
        add_action("wp_ajax_dislikeAjax", array(new ThemeContext(), "dislikeAjax"));
        add_action("wp_ajax_nopriv_moviesMore", array(new ThemeContext(), "moviesMore"));
        add_action("wp_ajax_moviesMore", array(new ThemeContext(), "moviesMore"));
        add_action("wp_ajax_nopriv_tvMore", array(new ThemeContext(), "tvMore"));
        add_action("wp_ajax_tvMore", array(new ThemeContext(), "tvMore"));
        add_action("wp_ajax_nopriv_AdvSearch", array(new ThemeContext(), "AdvSearch"));
        add_action("wp_ajax_AdvSearch", array(new ThemeContext(), "AdvSearch"));
        add_action("wp_ajax_nopriv_MoreSections", array(new ThemeContext(), "MoreSections"));
        add_action("wp_ajax_MoreSections", array(new ThemeContext(), "MoreSections"));
        add_action("wp_ajax_nopriv_customlink", array(new ThemeContext(), "customlink"));
        add_action("wp_ajax_customlink", array(new ThemeContext(), "customlink"));
        add_action("wp_ajax_nopriv_TreangingMore", array(new ThemeContext(), "TreangingMore"));
        add_action("wp_ajax_TreangingMore", array(new ThemeContext(), "TreangingMore"));
        add_action("wp_ajax_nopriv_TvPro", array(new ThemeContext(), "TvPro"));
        add_action("wp_ajax_TvPro", array(new ThemeContext(), "TvPro"));
        add_action("wp_ajax_nopriv_RateNow", array(new ThemeContext(), "RateNow"));
        add_action("wp_ajax_RateNow", array(new ThemeContext(), "RateNow"));
        add_action("wp_ajax_nopriv_Triller", array(new ThemeContext(), "Triller"));
        add_action("wp_ajax_Triller", array(new ThemeContext(), "Triller"));
        add_action("wp_ajax_nopriv_RelatedTab", array(new ThemeContext(), "RelatedTab"));
        add_action("wp_ajax_RelatedTab", array(new ThemeContext(), "RelatedTab"));
        add_action("wp_ajax_nopriv_SetionOpen", array(new ThemeContext(), "SetionOpen"));
        add_action("wp_ajax_SetionOpen", array(new ThemeContext(), "SetionOpen"));
        add_action("wp_ajax_nopriv_SlidAjax", array(new ThemeContext(), "SlidAjax"));
        add_action("wp_ajax_SlidAjax", array(new ThemeContext(), "SlidAjax"));
        add_action("wp_ajax_nopriv_MoviesSlider", array(new ThemeContext(), "MoviesSlider"));
        add_action("wp_ajax_MoviesSlider", array(new ThemeContext(), "MoviesSlider"));
        add_action("wp_ajax_GenerateData", array(new ThemeContext(), "GenerateData"));
        add_filter("hide_admin_bar", "__return_false");
    }
}
class Tak_history
{
    public function update_later($data_array)
    {
        $user_id = $data_array["user_id"];
        $post_id = $data_array["post_id"];
        $get_later = get_user_meta($user_id, "history", true);
        if (empty($get_later)) {
            $id_array = array($post_id);
            update_user_meta($user_id, "history", $id_array);
        } else {
            array_unshift($get_later, $post_id);
            $result = array_unique($get_later);
            update_user_meta($user_id, "history", $result);
        }
    }
}
function compare($a, $b)
{
    if ($a == $b) {
        return 0;
    }
    return $b < $a ? -1 : 1;
}

?>