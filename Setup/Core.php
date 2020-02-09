<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

class ThemeCore extends ThemeTree
{
    public function AddTaxonomy($id, $ptypes = array(), $name, $rewrite = false, $hierarchical = true)
    {
        $labels = array("name" => __($name, "ProgramsLocalize", "post type general name"), "all_items" => __("كل العناصر", "ProgramsLocalize", "all items"), "add_new_item" => __("اضافة عنصر جديد", "ProgramsLocalize", "adding a new item"), "new_item_name" => __("اسم عنصر جديد", "ProgramsLocalize", "adding a new item"));
        register_taxonomy($id, $ptypes, array("hierarchical" => $hierarchical, "rewrite" => $rewrite, "labels" => $labels));
    }
    public function PostColumns($defaults)
    {
        $defaults["views"] = "عدد المشاهدات";
        return $defaults;
    }
    public function PostColumnsContent($column_name, $post_ID)
    {
        if ($column_name == "views") {
            echo (int) get_post_meta($post_ID, "views", true);
        }
    }
    public function AddPType($name, $singlename, $plus = "", $id, $public = true, $rewrite = false, $supports = array(), $position = "")
    {
        $labels = array("name" => _x($name, "post type general name", "ProgramsLocalize"), "singular_name" => _x($name, "post type singular name", "ProgramsLocalize"), "menu_name" => _x($name, "admin menu", "ProgramsLocalize"), "name_admin_bar" => _x($name, "add new on admin bar", "ProgramsLocalize"), "add_new" => _x("اضف جديد", "search", "ProgramsLocalize"), "add_new_item" => __("إضافة " . $singlename . " جديد" . $plus, "ProgramsLocalize"), "new_item" => __($singlename . " جديد" . $plus, "ProgramsLocalize"), "edit_item" => __("تعديل " . $singlename, "ProgramsLocalize"), "all_items" => __("كل " . $name, "ProgramsLocalize"), "search_items" => __("بحث  في " . $name, "ProgramsLocalize"), "parent_item_colon" => __($singlename . " الرئيس", "ProgramsLocalize"), "not_found" => __("لا يوجد عناصر.", "ProgramsLocalize"), "not_found_in_trash" => __("لا يوجد عناصر فى سلة المهملات.", "ProgramsLocalize"));
        $args = array("labels" => $labels, "public" => $public, "rewrite" => $rewrite, "supports" => $supports);
        if (is_numeric($position)) {
            $args["menu_position"] = $position;
        }
        register_post_type($id, $args);
    }
    public function EndPoints()
    {
        add_rewrite_endpoint("download", EP_PERMALINK);
    }
    public function SetQueryVars($vars)
    {
        $vars[] = "download";
        return $vars;
    }
    public function ManageRequests($vars)
    {
        if (isset($vars["download"])) {
            $vars["download"] = true;
        }
        return $vars;
    }
    public function AdsContentFilter($content)
    {
        $FirstParagraph = "<center>" . get_option("FirstParagraph") . "</center>";
        $ThirdParagraph = "<center>" . get_option("ThirdParagraph") . "</center>";
        $SpecificParagraph = "<center>" . get_option("SpecificParagraph") . "</center>";
        if (is_single() && !is_admin()) {
            return $this->InsertAdsParagraph($FirstParagraph, 1, $content);
        }
        return $content;
    }
    public function InsertAdsParagraph($insertion, $paragraph_id, $content)
    {
        $closing_p = "</p>";
        $paragraphs = explode($closing_p, $content);
        foreach ($paragraphs as $index => $paragraph) {
            if (trim($paragraph)) {
                $paragraphs[$index] .= $closing_p;
            }
            if ($paragraph_id == $index + 1) {
                $paragraphs[$index] .= $insertion;
            }
        }
        return implode("", $paragraphs);
    }
    public function ThemeSetup()
    {
        if (!is_admin()) {
            $currentURL = (new ThemeContext())->GetCanonicalURL();
            if (isset($_GET["page"])) {
                $currentURL = str_replace(array("/?page=", "?page="), "/page/", $currentURL);
                wp_redirect($currentURL);
            }
            if (isset($_GET["s"])) {
                $currentURL = str_replace(array("/?s=", "?s="), "/search/", $currentURL);
                wp_redirect($currentURL);
            }
        }
        add_theme_support("automatic-feed-links");
        add_theme_support("post-thumbnails");
        add_image_size("NewsBlock", 360, 270, false);
        add_image_size("SecSingleBlock", 600, 600, false);
        add_image_size("TopFull", 1000, 800, false);
        add_image_size("TopSlider", 300, 380, false);
        add_image_size("defaultgenre", 58, 55, false);
        add_image_size("defaultgenre1", 100, 120, false);
        add_image_size("defaultgenre2", 58, 60, false);
        add_image_size("defaultslider", 190, 230, false);
        register_nav_menus(array("main-menu" => __("القائمة الرئيسية", "YourColor"), "footer-menu" => __("قائمة الفوتر", "YourColor")));
        add_action("init", array($this, "EndPoints"));
        add_filter("query_vars", array($this, "SetQueryVars"));
        add_filter("request", array($this, "ManageRequests"));
        add_filter("the_content", array($this, "AdsContentFilter"));
    }
}
require get_template_directory() . "/Setup/YTS/setup.php";

?>