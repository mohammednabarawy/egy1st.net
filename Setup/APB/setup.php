<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

define("APB_Path", trailingslashit(dirname(__FILE__)));
list(, $APBURL) = explode(get_template_directory(), trailingslashit(dirname(__FILE__)));
$APBURL = get_template_directory_uri() . $APBURL;
define("APB_URL", $APBURL);
require APB_Path . "/APBLoader/core.php";
$APB = new APB();
$APB->SetupAPB();
class APB
{
    private $args = NULL;
    private $boxes = NULL;
    public function __construct($arguments = array())
    {
        $this->args = $arguments;
        $layouts = array();
        $metaboxes = array();
        $Params = $_GET;
        require APB_Path . "/layouts.php";
        require APB_Path . "/fields.php";
        $this->layouts = $layouts;
        $this->boxes = $metaboxes;
        if (isset($Params["action"]) && $Params["action"] == "edit" && isset($_GET["post"])) {
            $this->type = "edit";
            $this->post = $_GET["post"];
        } else {
            $this->type = "add";
            $this->post = 0;
        }
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
    public function AdminFooter()
    {
        echo "<script>var \$ = jQuery;</script>";
        echo "<script type=\"text/javascript\" src=\"" . APB_URL . "UI/js/bootstrap.bundle.min.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . APB_URL . "UI/js/bootstrap-colorpicker.min.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . APB_URL . "UI/js/codemirror.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . APB_URL . "UI/js/DatePickerEN.js\"></script>";
        echo "<script type=\"text/javascript\" src=\"" . APB_URL . "UI/js/jquery.richtext.min.js\"></script>";
        (new APBFields())->PinnedJQuery();
        echo "<script src=\"https://code.jquery.com/ui/1.12.1/jquery-ui.js\"></script>";
        echo "<script src=\"" . APB_URL . "UI/addswitch.js?" . rand() . "\" type=\"text/javascript\"></script>";
        echo "<script src=\"" . APB_URL . "UI/main.js?" . rand() . "\" type=\"text/javascript\"></script>";
        if (!did_action("wp_enqueue_media")) {
            wp_enqueue_media();
        }
        wp_register_script("mediaelement", plugins_url("wp-mediaelement.min.js", __FILE__), array("jquery"), "4.8.2", true);
        wp_enqueue_script("mediaelement");
        wp_enqueue_script("myuploadscript", APB_URL . "UI/js/UploadAction.js", array("jquery"), NULL, false);
    }
    public function SetupEnqueue()
    {
        echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"" . APB_URL . "UI/style.css?" . rand() . "\" />";
        if (!is_rtl()) {
            echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"" . APB_URL . "UI/ltr.css?" . rand() . "\" />";
        }
        echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"" . APB_URL . "UI/css/codemirror.css\" />";
        echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"" . APB_URL . "UI/css/richtext.min.css\" />";
        echo "<link rel=\"stylesheet\" href=\"https://kit-pro.fontawesome.com/releases/v5.12.0/css/pro.min.css\">";
        echo "<link href=\"" . APB_URL . "UI/css/datepicker.css\" rel=\"stylesheet\">";
        echo "<link href=\"" . APB_URL . "UI/css/colorpicker.css\" rel=\"stylesheet\">";
        echo "<link href=\"http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css\" rel=\"stylesheet\">";
    }
    public function SetupAPB()
    {
        add_action("add_meta_boxes", array($this, "SetupMetaBox"));
        add_action("admin_enqueue_scripts", array($this, "SetupEnqueue"));
        add_action("admin_footer", array($this, "AdminFooter"));
        add_action("admin_footer", array($this, "AdminFooter"));
        add_action("save_post", array($this, "SavePost"), 10, 2);
        add_action("edit_post", array($this, "SavePost"), 10, 2);
        add_action("after_setup_theme", array($this, "AfterThemeSetup"));
    }
    public function GetMetaBox($post, $extra)
    {
        $args = $extra["args"];
        if (isset($args["callback"])) {
            require $args["callback"];
        } else {
            list(, $MetaboxID) = explode("APBMetaBox-", $extra["id"]);
            (new APBFields())->SetupFields($args, $MetaboxID, "0");
        }
    }
    public function SaveMetaBox()
    {
        $args = $extra["args"];
        if (isset($args["callback"])) {
            require $args["callback"];
        } else {
            list(, $MetaboxID) = explode("APBMetaBox-", $extra["id"]);
            (new APBFields())->SetupFields($args, $MetaboxID, "0");
        }
    }
    public function GetMetaTaxonomy($id)
    {
        $args = $this->boxes[$id];
        if (!did_action("wp_enqueue_media")) {
            wp_enqueue_media();
        }
        $title = is_rtl() ? $args["name"] : $args["nameEN"];
        echo "</table>";
        echo "<div id=\"APBMetaBox-" . $id . "\" class=\"postbox\">";
        echo "<h2 style=\"margin: 0; padding: 8px 12px; border-bottom: 1px solid #eee; font-size: 14px; line-height: 1.4;\"><span>" . $title . "</span></h2>";
        echo "<div class=\"inside\" style=\"padding:15px;\">";
        if (isset($args["callback"])) {
            require $args["callback"];
        } else {
            (new APBFields())->SetupFields($args, $id, "0", true);
        }
        echo "</div></div>";
    }
    public function SaveMetaTaxonomy($tagID)
    {
        if ($this->CanSave()) {
            foreach ($this->boxes as $k => $v) {
                if (isset($v["taxonomy"])) {
                    if ($v["type"] == "layouts") {
                        if (isset($this->Methods()[$k])) {
                            $this->UpdateTerm($tagID, $k, $this->Methods()[$k]);
                        }
                    } else {
                        if ($v["type"] == "fields") {
                            foreach ($v["fields"] as $kf => $vf) {
                                if (isset($this->Methods()[$vf["id"]])) {
                                    $this->UpdateTerm($tagID, $vf["id"], $this->Methods()[$vf["id"]]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function UpdatePost($id, $key, $val)
    {
        if ($this->CanSave()) {
            update_post_meta($id, $key, $val);
        }
    }
    public function RemovePost($id, $key)
    {
        if ($this->CanSave()) {
            delete_post_meta($id, $key);
        }
    }
    public function UpdateTerm($id, $key, $val)
    {
        if ($this->CanSave()) {
            update_term_meta($id, $key, $val);
        }
    }
    public function SavePost($postID)
    {
        global $post;
        if ($this->CanSave() && isset($this->Methods()["apbupdate"])) {
            foreach ($this->boxes as $k => $v) {
                if (isset($v["ptype"]) && !isset($v["callback"]) && in_array(get_post_type($postID), $v["ptype"])) {
                    if ($v["type"] == "layouts") {
                        if (isset($this->Methods()[$k])) {
                            $this->UpdatePost($postID, $k, $this->Methods()[$k]);
                        } else {
                            $this->RemovePost($postID, $k);
                        }
                    } else {
                        if ($v["type"] == "fields") {
                            foreach ($v["fields"] as $kf => $vf) {
                                if (isset($this->Methods()[$vf["id"]])) {
                                    $this->UpdatePost($postID, $vf["id"], $this->Methods()[$vf["id"]]);
                                } else {
                                    $this->RemovePost($postID, $vf["id"]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function SetupMetaBox()
    {
        foreach ($this->boxes as $k => $box) {
            if (isset($box["ptype"])) {
                add_meta_box("APBMetaBox-" . $k, __($box["name"], "APB"), array($this, "GetMetaBox"), $box["ptype"], $box["context"], $box["priority"], $box);
            }
        }
    }
    public function AfterThemeSetup()
    {
        foreach ($this->boxes as $k => $box) {
            if (isset($box["taxonomy"])) {
                if (is_array($box["taxonomy"])) {
                    foreach ($box["taxonomy"] as $tax) {
                        add_action("edited_" . $tax . "", array($this, "SaveMetaTaxonomy"));
                        add_action($tax . "_edit_form_fields", function ($a) use($k) {
                            (new APB())->GetMetaTaxonomy($k);
                        });
                    }
                } else {
                    add_action("edited_" . $box["taxonomy"] . "", array($this, "SaveMetaTaxonomy"));
                    add_action($box["taxonomy"] . "_edit_form_fields", function ($a, $b) use($box, $k) {
                        (new APB())->GetMetaTaxonomy($box);
                    });
                }
            }
        }
    }
}

?>