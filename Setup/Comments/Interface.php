<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.3
 * @ Release: 10.12.2019
 *
 * @ ZendGuard Decoder PHP 5.6
 */

echo "<form action=\"";
echo home_url();
echo "\" data-parent=\"0\" data-id=\"";
echo $post->ID;
echo "\" class=\"CommentsFormInner\" method=\"POST\" onsubmit=\"SubmitComment(this);return false;\">\n\t<div class=\"LeftInfo\">\n\t\t";
if (is_user_logged_in()) {
    global $current_user;
    echo "\t\t<input type=\"text\" disabled name=\"yourname\" value=\"";
    echo $current_user->display_name;
    echo "\" placeholder=\"إسمك الكريم *\" />\n\t\t<input type=\"email\" disabled name=\"email\" value=\"";
    echo $current_user->user_email;
    echo "\" placeholder=\"بريدك الإلكتروني *\" />\n\t\t";
} else {
    echo "\t\t<input type=\"text\" name=\"yourname\" placeholder=\"إسمك الكريم *\" />\n\t\t<input type=\"email\" name=\"email\" placeholder=\"بريدك الإلكتروني *\" />\n\t\t";
}
echo "\t\t<textarea name=\"comment\" placeholder=\"أكتب التعليق هنا ..\"></textarea>\n\t\t<div class=\"SubmitComment\">\n\t\t\t<button type=\"submit\">إرســال التعليق</button>\n\t\t</div>\n\t</div>\n\t<div class=\"RightComment\">\n\t\t";
$arguments = array("status" => "approve", "number" => "15", "post_id" => $post->ID, "parent" => 0);
$comments = get_comments($arguments);
$totalcomments = wp_count_comments($post->ID)->approved;
echo "\t\t";
if (0 < count($comments)) {
    echo "\t\t\t<div class=\"CommentsList\" data-id=\"";
    echo $post->ID;
    echo "\">\n\t\t\t\t<div class=\"SectionTitle\">\n\t\t\t\t\t<span>التعليقات <em>";
    echo $totalcomments;
    echo "</em></span>\n\t\t\t\t</div>\n\t\t\t\t<ul class=\"CommentsListInner\">\n\t\t\t\t\t";
    foreach ($comments as $comment) {
        echo "\t\t\t\t\t\t";
        echo (new ThemeContext())->CommentItem($comment, $post);
        echo "\t\t\t\t\t";
    }
    echo "\t\t\t\t</ul>\n\t\t\t\t";
    if (15 < $totalcomments) {
        echo "\t\t\t\t\t<a href=\"javascript:void(0);\" onClick=\"LoadMoreComments(this);\" data-id=\"";
        echo $post->ID;
        echo "\" data-offset=\"15\" class=\"LoadMoreComment\">المزيد من التعليقات</a>\n\t\t\t\t";
    }
    echo "\t\t\t</div>\n\t\t";
} else {
    echo "\t\t\t<div class=\"CommentsList\" data-id=\"";
    echo $post->ID;
    echo "\">\n\t\t\t\t<div class=\"NoCommentsFound\">لا يوجد تعليقات لهذا المقال ..</div>\n\t\t\t</div>\n\t\t";
}
echo "\t</div>\n</form>";

?>