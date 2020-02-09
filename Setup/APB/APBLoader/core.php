<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

class APBFields extends APB
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
            $this->post = $Params["post"];
        } else {
            if (isset($Params["taxonomy"]) && is_numeric($Params["tag_ID"])) {
                $this->type = "edit";
                $this->post = $Params["tag_ID"];
            } else {
                $this->type = "add";
                $this->post = 0;
            }
        }
    }
    public function ARorEN($orig, $arr)
    {
        if (isset($arr["nameEN"]) && !is_rtl()) {
            $orig = $arr["nameEN"];
        }
        return $orig;
    }
    public function PinnedJQuery()
    {
        echo "<script type=\"text/javascript\">\n\t\tvar HomeURL = \"" . home_url() . "\";\n\t\tvar errorAjax = \"" . (is_rtl() ? "حدث خطأ اثناء المتابعة .. تحقق من الإنترنت الخاص بك." : "There's something happened while we're trying to continue .. Check your internet.") . "\";\n\t\tvar UploadButtonText = \"" . (is_rtl() ? "إستخدام" : "Use this") . "\";\n\t\tfunction PinnedJQuery() {\n\t\t\t\$(\".ColorViewer\").colorpicker();\n\t\t\t\$(\".CodePreview\").each(function(els, el){\n\t\t\t\tif( !\$(el).next().hasClass(\"CodeMirror\") ) {\n\t\t\t\t\tvar editor = CodeMirror.fromTextArea(el, {\n\t\t\t\t\t\tmode: \"text/html\",\n\t\t\t\t\t\tstyleActiveLine: true,\n\t\t\t\t\t\tlineNumbers: true,\n\t\t\t\t\t\tlineWrapping: true\n\t\t\t\t\t});\n\t\t\t\t}\n\t\t\t});\n\t\t\t\$(\".EditorPreview\").each(function(els, el){\n\t\t\t\t\$(el).removeClass(\"EditorPreview\")\n\t\t\t\t\$(el).richText();\n\t\t\t});\n\t\t\t\$(\".DatePreview\").each(function(els, el){\n\t\t\t\t\$(el).datepicker({\n\t\t\t\t\ttimepicker: \$(el).data(\"time\"),\n\t\t\t\t\tposition: \"top right\",\n\t\t\t\t\tformat: \$(el).data(\"format\"),\n\t\t\t\t\tlanguage: \"en\"\n\t\t\t\t});\n\t\t\t});\n\t\t}\n\t\tPinnedJQuery();\n\t\t</script>";
    }
    public function AjaxFields($layout = "", $fields = "", $numb = "0")
    {
        $args = $this->boxes[$fields]["fields"][$layout];
        foreach ($args["fields"] as $k => $field) {
            echo "<div class=\"apb-field apb-field-" . $field["id"] . " apb-type-" . $field["type"] . "\">";
            $this->FieldType($field, $args["id"], isset($args["addmore"]) ? $args["addmore"] : false, $numb, $fields);
            echo "</div>";
        }
        $this->PinnedJQuery();
    }
    public function APBAddLayoutBuilder($metabox = "", $numb)
    {
        $args = $this->boxes[$metabox];
        (new APBFields())->SetupFields($args, $metabox, $numb);
    }
    public function APBAddGroupFields($metabox = "", $group = "", $numb)
    {
        $args = $this->boxes[$metabox];
        foreach ($args["fields"] as $k => $field) {
            if ($field["id"] == $group) {
                $name = $group;
                $id = $group;
                echo "<div class=\"apb-field apb-field-" . $field["id"] . " apb-type-" . $field["type"] . "\">";
                (new APBFieldsTypes())->Group($value, $field, $name, $id, $metabox, $numb);
                echo "<div class=\"LayoutsBuilderFooter\">";
                echo "<a href=\"javascript:void();\" class=\"AddMoreGroup\" data-numb=\"" . ($numb + 1) . "\" data-group=\"" . $group . "\" data-metabox=\"" . $metabox . "\">+ " . (is_rtl() ? "إضافة المزيد" : "Add More") . "</a>";
                echo "</div></div>";
            }
        }
        $this->PinnedJQuery();
    }
    public function SetupFields($args = array(), $MetaboxID = "", $numb = "0", $taxonomy = false)
    {
        if ($args["type"] == "layouts") {
            if ($taxonomy == true) {
                if ($this->type == "edit") {
                    $value = is_array(get_term_meta($this->post, $MetaboxID, true)) ? get_term_meta($this->post, $MetaboxID, true) : array();
                } else {
                    $value = array();
                }
            } else {
                if ($this->type == "edit") {
                    $value = is_array(get_post_meta($this->post, $MetaboxID, true)) ? get_post_meta($this->post, $MetaboxID, true) : array();
                } else {
                    $value = array();
                }
            }
            if (!empty($value)) {
                $numb = 0;
                foreach ($value as $k2 => $v) {
                    if (isset($value[$k2])) {
                        echo "<div class=\"APBMainLayout\" data-numb=\"" . $numb . "\">";
                        echo "<a onClick=\"\$(this).parent().remove();\" href=\"javascript:void(0);\" class=\"RemoveIT\"><i class=\"fa fa-times\"></i></a><div class=\"MoveElement\"><a href=\"javascript:void(0);\" onClick=\"NextItem(this);\" class=\"UpBTN\"><i class=\"fa fa-angle-up\"></i></a><a href=\"javascript:void(0);\" onClick=\"PrevItem(this);\" class=\"DownBTN\"><i class=\"fa fa-angle-down\"></i></a></div>";
                        if (isset($value["type"])) {
                            echo "<input type=\"hidden\" name=\"" . $MetaboxID . "[type]\" id=\"" . $MetaboxID . "\" />";
                        }
                        echo "<ul class=\"APBLayouts\">";
                        foreach ($args["fields"] as $k => $f) {
                            $i = 0;
                            $layout = $this->layouts[$f["layout"]];
                            if (isset($layout)) {
                                $i++;
                                $current = 0;
                                if (isset($value[$k2][$f["id"]])) {
                                    $current = 1;
                                    $currentlayout = $k;
                                }
                                echo "<li data-layout=\"" . $k . "\" data-layoutval=\"" . $f["id"] . "\" data-fields=\"" . $MetaboxID . "\" class=\"layoutitem layout-" . $f["id"] . " " . ($current == 1 ? "layout-current" : "") . " layout-" . $layout["type"] . "\">";
                                if ($layout["type"] == "layout") {
                                    echo $layout["layout"];
                                } else {
                                    if ($layout["type"] == "name") {
                                        echo "<span class=\"LayoutName\">" . $this->ARorEN($layout["name"], $layout) . "</span>";
                                    }
                                }
                                echo "</li>";
                            }
                        }
                        echo "</ul><div class=\"APBLayoutsBuilder\">";
                        if (!empty($value)) {
                            $args2 = $this->boxes[$MetaboxID]["fields"][$currentlayout];
                            foreach ($args2["fields"] as $k => $field) {
                                echo "<div class=\"apb-field apb-field-" . $field["id"] . " apb-type-" . $field["type"] . "\">";
                                $this->FieldType($field, $args2["id"], isset($args2["addmore"]) ? $args2["addmore"] : false, $k2, $MetaboxID, $args2["id"]);
                                echo "</div>";
                            }
                        } else {
                            echo "<div class=\"SadFace\"><em></em><em></em><span></span></div>";
                            echo "<p class=\"DidntSelectYet\">" . (is_rtl() ? "لم يتم إختيار تقسيم .." : "You didn't select layout yet ..") . "</p>";
                        }
                        echo "</div>";
                        $count = count($value) - 1;
                        if (!isset($value["type"]) && $numb == $count) {
                            echo "<div class=\"LayoutsBuilderFooter\">";
                            echo "<a href=\"javascript:void();\" class=\"AddMoreLayout\" data-numb=\"" . ((int) $numb + 1) . "\" data-metabox=\"" . $MetaboxID . "\">+ " . (is_rtl() ? "إضافة المزيد" : "Add More") . "</a>";
                            echo "</div>";
                        }
                        echo "</div>";
                        $numb++;
                    }
                }
            } else {
                echo "<div class=\"APBMainLayout\" data-numb=\"" . $numb . "\">";
                echo "<a href=\"javascript:void(0);\" onClick=\"\$(this).parent().remove();\" class=\"RemoveIT\"><i class=\"fa fa-times\"></i></a><div class=\"MoveElement\"><a href=\"javascript:void(0);\" onClick=\"NextItem(this);\" class=\"UpBTN\"><i class=\"fa fa-angle-up\"></i></a><a href=\"javascript:void(0);\" onClick=\"PrevItem(this);\" class=\"DownBTN\"><i class=\"fa fa-angle-down\"></i></a></div>";
                if (!(isset($args["addmore"]) && $args["addmore"] == true)) {
                    echo "<input type=\"hidden\" name=\"" . $MetaboxID . "[type]\" id=\"" . $MetaboxID . "\" />";
                }
                echo "<ul class=\"APBLayouts\">";
                $i = 0;
                foreach ($args["fields"] as $k => $field) {
                    if (isset($this->layouts[$field["layout"]])) {
                        $i++;
                        $layout = $this->layouts[$field["layout"]];
                        $current = 0;
                        if (isset($value["type"]) && $value["type"] == $field["id"]) {
                            $current = 1;
                        }
                        echo "<li data-layout=\"" . $k . "\" data-layoutval=\"" . $field["id"] . "\" data-fields=\"" . $MetaboxID . "\" class=\"layoutitem layout-" . $field["id"] . " " . ($current == 1 ? "layout-current" : "") . " layout-" . $layout["type"] . "\">";
                        if ($layout["type"] == "layout") {
                            echo $layout["layout"];
                        } else {
                            if ($layout["type"] == "name") {
                                echo "<span class=\"LayoutName\">" . $this->ARorEN($layout["name"], $layout) . "</span>";
                            }
                        }
                        echo "</li>";
                    }
                }
                echo "</ul><div class=\"APBLayoutsBuilder\">";
                if (!empty($value)) {
                    $args = $this->boxes[$MetaboxID]["fields"][$currentlayout];
                    foreach ($args["fields"] as $k => $field) {
                        echo "<div class=\"apb-field apb-field-" . $field["id"] . " apb-type-" . $field["type"] . "\">";
                        $this->FieldType($field, $args["id"], isset($args["addmore"]) ? $args["addmore"] : false, $numb, $MetaboxID, $args["id"]);
                        echo "</div>";
                    }
                } else {
                    echo "<div class=\"SadFace\"><em></em><em></em><span></span></div>";
                    echo "<p class=\"DidntSelectYet\">" . (is_rtl() ? "لم يتم إختيار تقسيم .." : "You didn't select layout yet ..") . "</p>";
                }
                echo "</div>";
                if (isset($args["addmore"]) && $args["addmore"] == true) {
                    echo "<div class=\"LayoutsBuilderFooter\">";
                    echo "<a href=\"javascript:void();\" class=\"AddMoreLayout\" data-numb=\"" . ((int) $numb + 1) . "\" data-metabox=\"" . $MetaboxID . "\">+ " . (is_rtl() ? "إضافة المزيد" : "Add More") . "</a>";
                    echo "</div>";
                }
                echo "</div>";
            }
        } else {
            foreach ($args["fields"] as $k => $field) {
                echo "<div class=\"apb-field apb-field-" . $field["id"] . " apb-type-" . $field["type"] . "\">";
                $this->FieldType($field, 0, false, 0, $MetaboxID, "", $taxonomy);
                echo "</div>";
            }
        }
    }
    public function TaxonomyList($args)
    {
        if (!isset($args["field"])) {
            $args["field"] = "id";
        }
        $arr = array();
        $Terms = get_categories(array("taxonomy" => $args["Tax"], "hide_empty" => 0));
        if (isset($args["number"])) {
            $Terms = array_slice($Terms, 0, $args["number"]);
        }
        foreach ($Terms as $term) {
            if ($args["field"] == "id") {
                $field = $term->term_id;
            } else {
                if ($args["field"] == "slug") {
                    $field = $term->category_nicename;
                } else {
                    if ($args["field"] == "name") {
                        $field = $term->cat_name;
                    } else {
                        if ($args["field"] == "parent") {
                            $field = $term->parent;
                        }
                    }
                }
            }
            $arr[$field] = $term->cat_name;
        }
        return $arr;
    }
    public function FieldType($field, $hasparent = "", $addmore = false, $numb = "0", $metaboxid = "", $layout = "", $taxonomy = false)
    {
        if ($field["type"] == "title") {
            $name = $field["id"];
            $id = $field["id"];
            (new APBFieldsTypes())->Field($field, $name, $id, $hasparent, "", "", "", "", $metaboxid);
        } else {
            if ($hasparent == "") {
                $name = $field["id"];
                $id = $field["id"];
                if ($field["type"] != "group") {
                    echo "<label for=\"" . $field["id"] . "\">" . $this->ARorEN($field["name"], $field) . "</label>";
                }
                (new APBFieldsTypes())->Field($field, $name, $id, $hasparent, "", "", "", "", $metaboxid, $taxonomy);
            } else {
                $name = $metaboxid . "[" . $numb . "]" . "[" . $hasparent . "]" . "[" . $field["id"] . "]";
                $id = $metaboxid . "_" . $numb . "_" . $hasparent . "_" . $numb . "_" . $field["id"];
                if ($field["type"] != "group") {
                    echo "<label for=\"" . $id . "\">" . $this->ARorEN($field["name"], $field) . "</label>";
                }
                (new APBFieldsTypes())->Field($field, $name, $id, $metaboxid, "", $layout, $numb, "", $metaboxid, $taxonomy);
            }
        }
    }
}
require APB_Path . "/APBLoader/FieldTypes.php";
require APB_Path . "/APBLoader/ajax.php";
function APBGetLayout($id, $layout)
{
    $arr = array();
    foreach (is_array(get_post_meta($id, $layout, true)) ? get_post_meta($id, $layout, true) : array() as $v) {
        foreach ($v as $key => $value) {
            $arr[] = array("layout" => $key, "args" => $value);
        }
    }
    return $arr;
}

?>