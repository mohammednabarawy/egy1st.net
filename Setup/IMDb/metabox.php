<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

if (isset($_GET["tag_ID"])) {
    $type = "name";
    $img = "name";
    $test = "nm0776040";
} else {
    $type = "movie";
    $img = "imdb";
    $test = "tt1520211";
}
$fields["movie"] = array("poster" => "البوستر", "released" => "تاريخ الإصدار", "mpaa" => "الفئة العمرية", "awards" => "الجوائز", "story" => "القصة", "runtime" => "مدة التشغيل", "rating" => "التقييمات", "votes" => "التصويتات", "cast" => "فريق العمل", "genre" => "الانواع", "directors" => "المخرجين", "writers" => "الكاتبين", "country" => "البلد", "year" => "سنة الإصدار", "language" => "اللغة", "trailer" => "الاعلان");
$fields["name"] = array("image" => "الصورة", "about" => "السيرة الذاتية");
echo "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"";
echo get_template_directory_uri();
echo "/Setup/IMDb/style.css?";
echo rand();
echo "\" />\n\n<div class=\"IMDbBox\">\n\n\t<input type=\"text\" name=\"imdbID\" id=\"IMDBID\" />\n\n\t<button id=\"ExtractIMDB\" onClick=\"ImdbExtract(\$('#IMDBID').val(), this);return false;\">إستخراج البيانات</button>\n\n\t<button id=\"PreviewIMDB\" onClick=\"\$(this).toggleClass('active');\$('.FilterFields').toggleClass('active');return false;\">معاينة</button>\n\n\t<a href=\"javascript:void(0);\" class=\"HowToIMDB\" onclick=\"\$(this).remove();\$('.HowToIMDBList').show();\">لا تعلم كيفية إستخدام أداة IMDB ?</a>\n\n\t<ul class=\"HowToIMDBList\" style=\"display: none;\">\n\n\t\t<li><em></em> أدخل على رابط الفيلم فى موقع <strong>IMDb</strong>.</li>\n\n\t\t<li><em></em> ستجد أن رابط الفيلم به معرف مشابه إلي <strong>";
echo $test;
echo "</strong> و لكن بأرقام مختلفة.</li>\n\n\t\t<li><em></em> حدد هذا المعرف بدون اي علامات أخري.</li>\n\n\t\t<img src=\"https://yourcolor.net/imdb/";
echo $img;
echo ".png\" alt=\"how to imdb\" />\n\n\t</ul>\n\n\t<ul class=\"FilterFields\">\n\n\t\t";
foreach ($fields[$type] as $field => $name) {
    echo "\n\t\t\t<li class=\"active\" data-field=\"";
    echo $field;
    echo "\">\n\n\t\t\t\t<div class=\"Switch\">\n\n\t\t\t\t\t<span>معطّل</span>\n\n\t\t\t\t\t<strong>مفعّل</strong>\n\n\t\t\t\t\t<em></em>\n\n\t\t\t\t</div>\n\n\t\t\t\t";
    echo $name;
    echo "\n\t\t\t</li>\n\n\t\t";
}
echo "\n\t</ul>\n\n</div>\n\n<div class=\"IMDBJsonData\" id=\"JSONData\">\n\n</div>\n\n<script type=\"text/javascript\">\n\tvar \$ = jQuery;\n\t\$('.FilterFields > li').click(function(){\n\t\t\$(this).toggleClass('active');\n\t});\n\tfunction ImdbExtract(id, el) {\n\t\tvar args = '';\n\t\t\$('.FilterFields > li.active').each(function(els, el){\n\t\t\targs=\$(el).data('field')+'|'+args;\n\t\t});\n\t\t\$(el).css({\"pointer-events\":'none', \"opacity\":'.4'});\n\t\t\$('#JSONData').html('<div class=\"JsonLoader\"><svg version=\"1.1\" id=\"loader-1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" width=\"40px\" height=\"40px\" viewBox=\"0 0 40 40\" enable-background=\"new 0 0 40 40\" xml:space=\"preserve\"> <path opacity=\"0.2\" fill=\"#000\" d=\"M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z\"></path> <path fill=\"#000\" d=\"M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z\"> <animateTransform attributeType=\"xml\" attributeName=\"transform\" type=\"rotate\" from=\"0 20 20\" to=\"360 20 20\" dur=\"0.5s\" repeatCount=\"indefinite\"></animateTransform> </path></svg><span>جارِ السحب ..</span></div>');\n\t\t\$.ajax({\n\t\t\turl: \"";
echo home_url();
echo "/wp-admin/admin-ajax.php\",\n\t\t\ttype:'POST',\n\t\t\tdata: {'action':'GenerateData','fields':args,'id':id,'type':'";
echo $type;
echo "'},\n\t\t\tsuccess: function(msg) {\n\t\t\t\t\$('#JSONData').html(msg);\n\t\t\t\t\$(el).css({\"pointer-events\":'inherit', \"opacity\":'1'});\n\t\t\t}\n\t\t});\n\t}\n\n\tfunction ImdbPreview(id, el) {\n\t\t\$(el).css({\"pointer-events\":'none', \"opacity\":'.4'});\n\t}\n\n</script>";

?>