<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

define("YTS_Path", trailingslashit(dirname(__FILE__)));
list(, $YTSURL) = explode(get_template_directory(), trailingslashit(dirname(__FILE__)));
$YTSURL = get_template_directory_uri() . $YTSURL;
define("YTS_URL", $YTSURL);
require YTS_Path . "/YTSLoader/core.php";
$YTS = new YTS();
$YTS->SetupYTS();
class YTS
{
    private $args = NULL;
    private $boxes = NULL;
    public function __construct($arguments = array())
    {
        $this->args = $arguments;
        $layouts = array();
        $metaboxes = array();
        $Config = array();
        require YTS_Path . "/layouts.php";
        require YTS_Path . "/fields.php";
        require YTS_Path . "/config.php";
        $this->layouts = $layouts;
        $this->boxes = $metaboxes;
        $this->ConfigTheme = $Config;
    }
    private function Methods()
    {
        return $_POST;
    }
    public function CanSave()
    {
        $return = false;
        if (current_user_can("edit_posts") && current_user_can("edit_published_posts")) {
            $return = true;
        }
        return $return;
    }
    public function AdminEnqueue()
    {
        echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"" . YTS_URL . "UI/style.css?" . rand() . "\" />";
        if (!is_rtl()) {
            echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"" . YTS_URL . "UI/ltr.css?" . rand() . "\" />";
        }
    }
    public function AdminFooter()
    {
        echo "<script>var \$ = jQuery;</script>";
        echo "<script type=\"text/javascript\" src=\"" . YTS_URL . "UI/js/bootstrap.bundle.min.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . YTS_URL . "UI/js/bootstrap-colorpicker.min.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . YTS_URL . "UI/js/codemirror.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . YTS_URL . "UI/js/DatePickerEN.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . YTS_URL . "UI/js/jquery.richtext.min.js\"></script>";
        (new YTSFields())->PinnedJQuery();
        echo "<script src=\"" . YTS_URL . "UI/main.js?" . rand() . "\" type=\"text/javascript\"></script>";
        wp_register_script("mediaelement", plugins_url("wp-mediaelement.min.js", __FILE__), array("jquery"), "4.8.2", true);
        wp_enqueue_script("mediaelement");
        wp_enqueue_script("ytsuploadscript", YTS_URL . "UI/js/UploadAction.js", array("jquery"), NULL, false);
    }
    public function SetupYTS()
    {
        add_action("admin_menu", array($this, "SetupControlPanel"));
        add_action("admin_enqueue_scripts", array($this, "AdminEnqueue"));
        add_action("admin_footer", array($this, "AdminFooter"));
    }
    public function UpdateOption($key, $val)
    {
        if ($this->CanSave()) {
            update_option($key, $val);
        }
    }
    public function SaveOptions($FieldsID)
    {
        if ($this->CanSave()) {
            $v = $this->boxes[$FieldsID];
            if ($v["type"] == "layouts") {
                if (isset($this->Methods()[$k])) {
                    $this->UpdateOption($k, $this->Methods()[$k]);
                }
            } else {
                if ($v["type"] == "fields") {
                    foreach ($v["fields"] as $kf => $vf) {
                        if (isset($this->Methods()[$vf["id"]])) {
                            if ($vf["type"] == "textarea_code") {
                                $this->UpdateOption($vf["id"], stripslashes($this->Methods()[$vf["id"]]));
                            } else {
                                $this->UpdateOption($vf["id"], $this->Methods()[$vf["id"]]);
                            }
                            if (isset($vf["switch"]) && $vf["switch"] == true) {
                                $this->UpdateOption($vf["id"] . "_switch", isset($this->Methods()[$vf["id"] . "_switch"]) ? $this->Methods()[$vf["id"] . "_switch"] : 0);
                            }
                        }
                    }
                }
            }
        }
    }
    public function ImportExportPanel()
    {
        echo "<link rel=\"stylesheet\" href=\"https://kit-pro.fontawesome.com/releases/v5.9.0/css/pro.min.css\"><div style=\"height:20px;\"></div><form action=\"\" method=\"POST\" enctype=\"multipart/form-data\"><div class=\"YTSData\">";
        $name = is_rtl() ? "تصدير الإعدادات" : "Export settings";
        echo "<div class=\"Heading\">";
        echo "<h2>" . $name . "</h2>";
        echo "</div><div id=\"YTSTabInner\"><div class=\"yts-field yts-field-Exportdata yts-type-textarea_code\"><div class=\"yts-field-inner\" style=\"float:none;width:auto;\">";
        $JSON = array();
        foreach ($this->boxes as $k => $v) {
            if ($v["type"] == "layouts") {
                $JSON[$k] = YT_Option($k);
            } else {
                if ($v["type"] == "fields") {
                    foreach ($v["fields"] as $kf => $vf) {
                        $JSON[$vf["id"]] = YT_Option($vf["id"]);
                        if (isset($vf["switch"]) && $vf["switch"] == true) {
                            $JSON[$vf["id"] . "_switch"] = YT_Option($vf["id"] . "_switch");
                        }
                    }
                }
            }
        }
        $JSON = json_encode($JSON);
        echo "<textarea autocomplete=\"off\" autocorrect=\"off\" autocapitalize=\"off\" spellcheck=\"false\" onFocus=\"this.focus();this.select();\" onClick=\"this.focus();this.select();\" style=\"height:300px;direction:ltr;\">" . $JSON . "</textarea>";
        echo "</div></div></div></div><div style=\"height:20px;\"></div><div class=\"YTSData\">";
        $name = is_rtl() ? "إستيراد إعدادات" : "Import settings";
        echo "<div class=\"Heading\">";
        echo "<h2>" . $name . "</h2>";
        echo "</div><div id=\"YTSTabInner\">";
        if (isset($this->Methods()["YTSSubmit"])) {
            $json = stripslashes($this->Methods()["ImportData"]);
            $json = json_decode($json, 1);
            foreach ($json as $k => $v) {
                $this->UpdateOption($k, $v);
            }
            echo "<div class=\"alert alert-success\">" . (is_rtl() ? "تم إستيراد الإعدادات !!" : "Settings imported !!") . "</div>";
        }
        echo "<div class=\"yts-field yts-field-Exportdata\"><label for=\"Exportdata\">كود الإستيراد</label><div class=\"yts-field-inner\"><textarea name=\"ImportData\" style=\"height:300px;direction:ltr;\"></textarea></div></div></div></div><input type=\"hidden\" name=\"YTSSubmit\" value=\"1\" /><div class=\"YTSBottomBar\">";
        $text = is_rtl() ? "إستيراد الإعدادات" : "Import settings";
        echo "<button type=\"submit\"><i class=\"fa fa-check\"></i> " . $text . "</button>";
        echo "</div></form>";
    }
    public function ControlPanelFields($current = "")
    {
        echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"" . YTS_URL . "UI/css/codemirror.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"" . YTS_URL . "UI/css/richtext.min.css\" />";
        echo "<link rel=\"stylesheet\" href=\"https://kit-pro.fontawesome.com/releases/v5.9.0/css/pro.min.css\">";
        echo "<link href=\"" . YTS_URL . "UI/css/datepicker.css\" rel=\"stylesheet\">";
        echo "<link href=\"" . YTS_URL . "UI/css/colorpicker.css\" rel=\"stylesheet\">";
        echo "<link href=\"http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css\" rel=\"stylesheet\"><script type=\"text/javascript\">\$ = jQuery;</script>";
        echo "<script type=\"text/javascript\" src=\"" . YTS_URL . "UI/js/owl.carousel.min.js\"></script>";
        echo "<div class=\"YTSMain\"><div class=\"YTSTabMenu\"><div class=\"YTSTabMenuTitle\"><h1><span class=\"dashicons dashicons-smiley\"></span></h1>";
        $text = is_rtl() ? "لوحة تحكم القالب" : "Control Panel";
        echo "<h2>" . $text . "</h2>";
        echo "</div><div class=\"YTSTabListManage\"><ul class=\"YTSTabList\">";
        $i = 0;
        $currentclass = "";
        foreach ($this->boxes as $k => $v) {
            $i++;
            $currentclass = "";
            if ($current == "" && $i == 1) {
                $currentclass = " class=\"current\"";
                $fieldsID = $k;
            } else {
                if ($k == $current) {
                    $currentclass = " class=\"current\"";
                    $fieldsID = $k;
                }
            }
            $name = is_rtl() ? $v["name"] : $v["nameEN"];
            echo "<li data-tab=\"" . $k . "\"" . $currentclass . ">";
            echo "<a href=\"admin.php?page=yts-" . strtolower($k) . "\">";
            echo $v["icon"];
            echo "<strong>" . $name . "</strong>";
            echo "</a></li>";
        }
        echo "</ul></div></div><script type=\"text/javascript\">var NavBarSlider = [\"<a class='SliderOwl-prev'><i class='fa fa-angle-right'></i></a>\", \"<a class='SliderOwl-next'><i class='fa fa-angle-left'></i></a>\"];";
        echo "\$(\".YTSTabList\").owlCarousel({\n\t\t\t        responsiveClass:true,\n\t\t\t        stopOnHover: true,\n\t\t\t        loop: false,\n\t\t\t        autoPlay: false,\n\t\t\t        autoWidth: true,\n\t\t\t        addClassActive: true,\n\t\t\t        rtl: " . (is_rtl() ? "true" : "false") . ",\n\t\t\t        navText : NavBarSlider,\n\t\t\t    }).on(\"loaded.owl.carousel\", function(event) {\n\t\t\t\t    \$(\".YTSTabList\").css({\"opacity\":\"1\"});\n\t\t\t\t});\n\t\t\t</script>";
        echo "<form action=\"\" method=\"POST\" enctype=\"multipart/form-data\">";
        $arg = $this->boxes[$fieldsID];
        echo "<div class=\"YTSData\">";
        $name = is_rtl() ? $arg["name"] : $arg["nameEN"];
        echo "<div class=\"Heading\">";
        echo "<h2>" . $name . "</h2>";
        echo "</div><div id=\"YTSTabInner\">";
        if (isset($this->Methods()["YTSSubmit"])) {
            $this->SaveOptions($fieldsID);
            echo "<div class=\"alert alert-success\">" . (is_rtl() ? "تم حفظ الإعدادات بنجاح !!" : "Settings saved !!") . "</div>";
        }
        (new YTSFields())->SetupFields($arg, $fieldsID, "0");
        echo "</div></div><input type=\"hidden\" name=\"YTSSubmit\" value=\"1\" /><div class=\"YTSBottomBar\">";
        $text = is_rtl() ? "حفظ الإعدادات" : "Save settings";
        echo "<button type=\"submit\"><i class=\"fa fa-check\"></i> " . $text . "</button>";
        echo "</div></form></div>";
        if (!did_action("wp_enqueue_media")) {
            wp_enqueue_media();
        }
    }
    public function SetupControlPanel()
    {
        $name = is_rtl() ? $this->ConfigTheme["name"] : $this->ConfigTheme["nameEN"];
        add_menu_page($name, $name, $this->ConfigTheme["roles"], "YTS", array($this, "ControlPanelFields"), "dashicons-smiley");
        foreach ($this->boxes as $slug => $arr) {
            $name = is_rtl() ? $arr["name"] : $arr["nameEN"];
            $id = "yts-" . strtolower($slug);
            add_submenu_page("YTS", $name, $name, $this->ConfigTheme["roles"], $id, function ($a) use($slug) {
                $this->ControlPanelFields($slug);
            });
        }
        add_submenu_page("YTS", "إستيراد / تصدير", "إستيراد / تصدير", $this->ConfigTheme["roles"], "yts-dataexport", array($this, "ImportExportPanel"));
    }
}

?>