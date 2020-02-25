<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

class APBFieldsTypes extends APBFields
{
    private $field = NULL;
    private $id = NULL;
    private $value = NULL;
    public function Field($field, $name, $id, $hasparent, $isgroup = "no", $layout = "", $numb = 0, $moregroup = "", $MetaboxID = "", $taxonomy = false)
    {
        $value = "";
        if ($taxonomy == true) {
            if ((new APBFields())->type == "edit") {
                if ($hasparent == "") {
                    if (0 < $isgroup) {
                        $isgroup = $isgroup - 1;
                        $parent = get_term_meta($this->post, $moregroup, true);
                        if (isset($parent[$isgroup][$field["id"]])) {
                            $value = $parent[$isgroup][$field["id"]];
                        }
                    } else {
                        $value = get_term_meta($this->post, $name, true);
                    }
                } else {
                    $parent = get_term_meta($this->post, $hasparent, true);
                    if (isset($parent[$numb][$layout][$field["id"]])) {
                        $value = $parent[$numb][$layout][$field["id"]];
                    } else {
                        $value = "";
                    }
                }
            } else {
                $value = "";
            }
        } else {
            if ((new APBFields())->type == "edit") {
                if ($hasparent == "") {
                    if (0 < $isgroup) {
                        $isgroup = $isgroup - 1;
                        $parent = get_post_meta($this->post, $moregroup, true);
                        if (isset($parent[$isgroup][$field["id"]])) {
                            $value = $parent[$isgroup][$field["id"]];
                        }
                    } else {
                        $value = get_post_meta($this->post, $name, true);
                    }
                } else {
                    $parent = get_post_meta($this->post, $hasparent, true);
                    if (isset($parent[$numb][$layout][$field["id"]])) {
                        $value = $parent[$numb][$layout][$field["id"]];
                    } else {
                        $value = "";
                    }
                }
            } else {
                $value = "";
            }
        }
        if ($field["type"] == "text") {
            echo "<div class=\"apb-field-inner\">";
            $this->Text($value, $field, $name, $id);
            echo "</div>";
        } else {
            if ($field["type"] == "textarea") {
                echo "<div class=\"apb-field-inner\">";
                $this->Textarea($value, $field, $name, $id);
                echo "</div>";
            } else {
                if ($field["type"] == "textarea_code") {
                    echo "<div class=\"apb-field-inner\">";
                    $this->TextareaCode($value, $field, $name, $id);
                    echo "</div>";
                } else {
                    if ($field["type"] == "select") {
                        echo "<div class=\"apb-field-inner\">";
                        $this->Select($value, $field, $name, $id);
                        echo "</div>";
                    } else {
                        if ($field["type"] == "date") {
                            echo "<div class=\"apb-field-inner\">";
                            $this->Date($value, $field, $name, $id);
                            echo "</div>";
                        } else {
                            if ($field["type"] == "colorpicker") {
                                echo "<div class=\"apb-field-inner\">";
                                $this->ColorPicker($value, $field, $name, $id);
                                echo "</div>";
                            } else {
                                if ($field["type"] == "radio") {
                                    echo "<div class=\"apb-field-inner\">";
                                    $this->Radio($value, $field, $name, $id);
                                    echo "</div>";
                                } else {
                                    if ($field["type"] == "taxonomy_select") {
                                        echo "<div class=\"apb-field-inner\">";
                                        $this->TaxonomySelect($value, $field, $name, $id);
                                        echo "</div>";
                                    } else {
                                        if ($field["type"] == "taxonomy_radio") {
                                            echo "<div class=\"apb-field-inner\">";
                                            $this->TaxonomyRadio($value, $field, $name, $id);
                                            echo "</div>";
                                        } else {
                                            if ($field["type"] == "taxonomy_checkbox") {
                                                echo "<div class=\"apb-field-inner\">";
                                                $this->TaxonomyCheckbox($value, $field, $name, $id);
                                                echo "</div>";
                                            } else {
                                                if ($field["type"] == "checkbox") {
                                                    echo "<div class=\"apb-field-inner\">";
                                                    $this->Checkbox($value, $field, $name, $id);
                                                    echo "</div>";
                                                } else {
                                                    if ($field["type"] == "file") {
                                                        echo "<div class=\"apb-field-inner\">";
                                                        $this->File($value, $field, $name, $id);
                                                        echo "</div>";
                                                    } else {
                                                        if ($field["type"] == "file_list") {
                                                            echo "<div class=\"apb-field-inner\">";
                                                            $this->FileList($value, $field, $name, $id);
                                                            echo "</div>";
                                                        } else {
                                                            if ($field["type"] == "editor") {
                                                                echo "<div class=\"apb-field-inner\">";
                                                                $this->Editor($value, $field, $name, $id);
                                                                echo "</div>";
                                                            } else {
                                                                if ($field["type"] == "group") {
                                                                    $this->Group($value, $field, $name, $id, $MetaboxID);
                                                                } else {
                                                                    if ($field["type"] == "title") {
                                                                        echo "<div class=\"FieldTitle\">" . $field["name"] . "</div>";
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
            }
        }
    }
    public function Text($value, $field, $name, $id)
    {
        echo "<input type=\"text\" value=\"" . $value . "\" name=\"" . $name . "\" id=\"" . $id . "\" />";
    }
    public function Textarea($value, $field, $name, $id)
    {
        $height = "";
        if (isset($field["height"])) {
            $height = "style=\"height:" . $field["height"] . "px\"";
        }
        echo "<textarea " . $height . " name=\"" . $name . "\" id=\"" . $id . "\">" . $value . "</textarea>";
    }
    public function TextareaCode($value, $field, $name, $id)
    {
        echo "<textarea class=\"CodePreview\" name=\"" . $name . "\" id=\"" . $id . "\">" . $value . "</textarea>";
    }
    public function Select($value, $field, $name, $id)
    {
        echo "<select name=\"" . $name . "\" id=\"" . $id . "\">";
        foreach ($field["options"] as $v => $option) {
            echo "<option" . ($value == $v ? " selected" : "") . " value=\"" . $v . "\">" . $option . "</option>";
        }
        echo "</select>";
        if (isset($field["onchange"])) {
            echo "<script>jQuery(window).load(function(){";
            echo "jQuery(\"#" . $id . "\").change(function(){";
            foreach ($field["onchange"] as $k8 => $v8) {
                echo "if( \$(this).val() == \"" . $k8 . "\" ) {";
                echo "jQuery(this).parent().parent().parent().find(\".apb-field-" . $v8 . "\").show();";
                echo "}else {";
                echo "jQuery(this).parent().parent().parent().find(\".apb-field-" . $v8 . "\").hide();";
                echo "}";
            }
            echo "});";
            foreach ($field["onchange"] as $k8 => $v8) {
                if ($value != $k8) {
                    echo "jQuery(\"#" . $id . "\").parent().parent().parent().find(\".apb-field-" . $v8 . "\").hide();";
                }
            }
            echo "});</script>";
        }
    }
    public function Date($value, $field, $name, $id)
    {
        echo "<input type=\"text\" value=\"" . $value . "\" data-language=\"en\" class=\"DatePreview\" data-time=\"" . ($field["time"] == true ? "true" : "false") . "\" data-format=\"" . (isset($field["format"]) ? $field["format"] : "d-m-Y H:i:s") . "\" name=\"" . $name . "\" id=\"" . $id . "\" />";
    }
    public function ColorPicker($value, $field, $name, $id)
    {
        echo "<input type=\"text\" value=\"" . $value . "\" class=\"ColorViewer\" name=\"" . $name . "\" id=\"" . $id . "\" />";
    }
    public function Radio($value, $field, $name, $id)
    {
        $k = 0;
        foreach ($field["options"] as $v => $opt) {
            $k++;
            $idCheckbox = $id . $k;
            echo "<label class=\"APBCheckLabel\" for=\"" . $idCheckbox . "\">";
            echo "<input" . ($v == $value ? " checked" : "") . " type=\"radio\" value=\"" . $v . "\" name=\"" . $name . "\" id=\"" . $idCheckbox . "\" />";
            echo "<span></span>";
            echo "<em>" . $opt . "</em>";
            echo "</label>";
        }
    }
    public function TaxonomySelect($value, $field, $name, $id)
    {
        $taxonomy = "category";
        if (isset($field["taxonomy"])) {
            $taxonomy = $field["taxonomy"];
        }
        $args = array("Tax" => $taxonomy);
        if (isset($field["field"])) {
            $args["field"] = $field["field"];
        }
        if (isset($field["number"])) {
            $args["number"] = $field["number"];
        }
        if (!isset($field["placeholder"])) {
            $field["placeholder"] = "إختر";
        }
        echo "<select name=\"" . $name . "\" id=\"" . $id . "\">";
        echo "<option" . ($value == "" ? " selected" : "") . " value=\"\">" . $field["placeholder"] . "</option>";
        foreach ($this->TaxonomyList($args) as $v => $option) {
            echo "<option" . ($value == $v ? " selected" : "") . " value=\"" . $v . "\">" . $option . "</option>";
        }
        echo "</select>";
    }
    public function TaxonomyRadio($value, $field, $name, $id)
    {
        $taxonomy = "category";
        if (isset($field["taxonomy"])) {
            $taxonomy = $field["taxonomy"];
        }
        $args = array("Tax" => $taxonomy);
        if (isset($field["field"])) {
            $args["field"] = $field["field"];
        }
        if (isset($field["number"])) {
            $args["number"] = $field["number"];
        }
        $k = 0;
        foreach ($this->TaxonomyList($args) as $v => $opt) {
            $k++;
            $idCheckbox = $id . $k;
            echo "<label class=\"APBCheckLabel\" for=\"" . $idCheckbox . "\">";
            echo "<input" . ($v == $value ? " checked" : "") . " type=\"radio\" value=\"" . $v . "\" name=\"" . $name . "\" id=\"" . $idCheckbox . "\" />";
            echo "<span></span>";
            echo "<em>" . $opt . "</em>";
            echo "</label>";
        }
    }
    public function TaxonomyCheckbox($value = array(), $field, $name, $id)
    {
        $taxonomy = "category";
        if (isset($field["taxonomy"])) {
            $taxonomy = $field["taxonomy"];
        }
        $args = array("Tax" => $taxonomy);
        if (isset($field["field"])) {
            $args["field"] = $field["field"];
        }
        if (isset($field["number"])) {
            $args["number"] = $field["number"];
        }
        $k = 0;
        foreach ($this->TaxonomyList($args) as $v => $opt) {
            $k++;
            $idCheckbox = $id . $k;
            echo "<label class=\"APBCheckLabel\" for=\"" . $idCheckbox . "\">";
            echo "<input" . (in_array($v, is_array($value) ? $value : array()) ? " checked" : "") . " type=\"checkbox\" value=\"" . $v . "\" name=\"" . $name . "[]\" id=\"" . $idCheckbox . "\" />";
            echo "<span></span>";
            echo "<em>" . $opt . "</em>";
            echo "</label>";
        }
    }
    public function Checkbox($value = array(), $field, $name, $id)
    {
        if (isset($field["options"])) {
            $k = 0;
            foreach ($field["options"] as $v => $opt) {
                $k++;
                $idCheckbox = $id . $k;
                echo "<label class=\"APBCheckLabel\" for=\"" . $idCheckbox . "\">";
                echo "<input" . (in_array($v, is_array($value) ? $value : array()) ? " checked" : "") . " type=\"checkbox\" value=\"" . $v . "\" name=\"" . $name . "[]\" id=\"" . $idCheckbox . "\" />";
                echo "<span></span>";
                echo "<em>" . $opt . "</em>";
                echo "</label>";
            }
        } else {
            $value = is_array($value) ? "" : $value;
            echo "<label class=\"APBCheckLabel\" for=\"" . $id . "\">";
            echo "<input " . ($value == "on" ? "checked" : "") . " type=\"checkbox\" value=\"on\" name=\"" . $name . "\" id=\"" . $id . "\" />";
            echo "<span></span>";
            echo "<em>" . $field["name"] . "</em>";
            echo "</label>";
        }
    }
    public function File($value, $field, $name, $id)
    {
        $id = str_replace(array("[", "]"), "_", $id);
        $id = str_replace("__", "_", $id);
        $button = is_rtl() ? "رفع ملف" : "Upload file";
        echo "<input type=\"hidden\" id=\"" . $id . "_id\" />";
        echo "<input type=\"text\" value=\"" . $value . "\" name=\"" . $name . "\" id=\"" . $id . "\" />";
        echo "<a href=\"javascript:void(0);\" data-multiple=\"false\" data-type=\"" . (isset($field["mime"]) ? $field["mime"] : "image") . "\" data-field=\"#" . $id . "\" data-name=\"" . $name . "\" data-rlname=\"" . $field["name"] . "\" class=\"APBUploadButton\">" . (isset($field["button"]) ? $field["button"] : $button) . "</a>";
        $style = "";
        if (empty($value)) {
            $style = "display:none;";
        }
        echo "<img class=\"APBPreviewFile\" id=\"" . $id . "_preview\" style=\"" . $style . "\" src=\"" . $value . "\" />";
        echo "<a style=\"" . $style . "\" href=\"javascript:void(0);\" class=\"APBRemoveButton\" data-multiple=\"false\" id=\"" . $id . "_remove\">حذف</a>";
    }
    public function FileList($value, $field, $name, $id)
    {
        $id = str_replace(array("[", "]"), "_", $id);
        $id = str_replace("__", "_", $id);
        $button = is_rtl() ? "رفع ملف" : "Upload file";
        echo "<a href=\"javascript:void(0);\" data-multiple=\"true\" data-type=\"" . (isset($field["mime"]) ? $field["mime"] : "image") . "\" data-field=\"#" . $id . "\" data-name=\"" . $name . "\" data-rlname=\"" . $field["name"] . "\" class=\"APBUploadButton\">" . (isset($field["button"]) ? $field["button"] : $button) . "</a>";
        echo "<div class=\"previewList\" id=\"" . $id . "_preview\">";
        foreach (is_array($value) ? $value : array() as $k => $url) {
            echo "<span><input type=\"hidden\" name=\"" . $name . "[" . $k . "]\" value=\"" . $url . "\" /><em onClick=\"this.parent().remove();\"><span></span><span></span></em><img src=\"" . $url . "\" /></span>";
        }
        echo "</div>";
        $style = "";
        if (empty($value)) {
            $style = "display:none;";
        }
        echo "<a style=\"" . $style . "\" href=\"javascript:void(0);\" class=\"APBRemoveButton\" data-multiple=\"true\" id=\"" . $id . "_remove\">حذف الكل</a>";
    }
    public function Editor($value, $field, $name, $id)
    {
        wp_editor($value, $id, array("textarea_name" => $name));
        echo "<script>\r\n\t\t\$(document).ready(function(){\r\n\t\t\t// remove existing editor instance\r\n\t\t\ttinymce.execCommand('mceRemoveEditor', true, '" . $id . "');\r\n\r\n\t\t\t// init editor for newly appended div\r\n\t\t\tvar init = tinymce.extend( {}, tinyMCEPreInit.mceInit[ '" . $id . "' ] );\r\n\t\t\ttry { tinymce.init( init ); } catch(e){}\r\n\t\t});\r\n\t\t</script>";
    }
    public function Group($value, $field, $parentname, $id, $MetaboxID = "", $original = 0)
    {
        $i = $original == 0 ? 0 : $original;
        if (!empty($value) && $original == 0) {
            foreach ($value as $k => $v) {
                echo "<div>";
                echo "<h2>" . $field["name"] . " [<em>" . ($i + 1) . "</em>]<a href=\"javascript:void(0);\" onClick=\"RemoveGroupField(this);\" class=\"RemoveIT\"></a></h2>";
                foreach (array_filter($field["fields"]) as $f) {
                    if (!empty($f)) {
                        echo "<div class=\"apb-field apb-hook apb-field-" . $f["id"] . " apb-type-" . $f["type"] . "\">";
                        if ($f["type"] == "title") {
                            $name = $parentname . "[" . $k . "][" . $f["id"] . "]";
                            $id = $parentname . "_" . $k . "_" . $f["id"];
                            $this->Field($f, $name, $id, 0, (int) $k + 1, "", "", $parentname, $MetaboxID);
                        } else {
                            $name = $parentname . "[" . $k . "][" . $f["id"] . "]";
                            $id = $parentname . "_" . $k . "_" . $f["id"];
                            echo "<label for=\"" . $parentname . "_" . $f["id"] . "\">" . $this->ARorEN($f["name"], $f) . "</label>";
                            $this->Field($f, $name, $id, 0, (int) $k + 1, "", "", $parentname, $MetaboxID);
                        }
                        echo "</div>";
                    }
                }
                $i = $k + 1;
                echo "</div>";
            }
            echo "<div class=\"LayoutsBuilderFooter\">";
            echo "<a href=\"javascript:void();\" class=\"AddMoreGroup\" data-numb=\"" . $i . "\" data-group=\"" . $parentname . "\" data-metabox=\"" . $MetaboxID . "\">+ " . (is_rtl() ? "إضافة المزيد" : "Add More") . "</a>";
            echo "</div>";
        } else {
            echo "<div>";
            echo "<h2>" . $field["name"] . " [<em>" . ($i + 1) . "</em>]<a href=\"javascript:void(0);\" onClick=\"RemoveGroupField(this);\" class=\"RemoveIT\"></a></h2>";
            foreach ($field["fields"] as $field) {
                echo "<div class=\"apb-field apb-field-" . $field["id"] . " apb-type-" . $field["type"] . "\">";
                if ($field["type"] == "title") {
                    $name = $parentname . "[" . $i . "][" . $field["id"] . "]";
                    $id = $parentname . "_" . $i . "_" . $field["id"];
                    (new APBFieldsTypes())->Field($field, $name, $id, 0, (int) $i + 1, "", "", "", $MetaboxID);
                } else {
                    $name = $parentname . "[" . $i . "][" . $field["id"] . "]";
                    $id = $parentname . "_" . $i . "_" . $field["id"];
                    echo "<label for=\"" . $parentname . "_" . $field["id"] . "\">" . $this->ARorEN($field["name"], $field) . "</label>";
                    (new APBFieldsTypes())->Field($field, $name, $id, 0, (int) $i + 1, "", "", "", $MetaboxID);
                }
                echo "</div>";
            }
            echo "</div><div class=\"LayoutsBuilderFooter\">";
            echo "<a href=\"javascript:void();\" class=\"AddMoreGroup\" data-numb=\"" . ($i + 1) . "\" data-group=\"" . $parentname . "\" data-metabox=\"" . $MetaboxID . "\">+ " . (is_rtl() ? "إضافة المزيد" : "Add More") . "</a>";
            echo "</div>";
        }
    }
}

?>