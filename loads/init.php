<?php
include 'util.php';
__bindtextdomain("blog", "blog");


if (function_exists('bind_textdomain_codeset'))
{
    bind_textdomain_codeset("blog", 'UTF-8');
}


$MyMetatag->setCss("/modulos/blog/web/css/blog.css");
$MyMetatag->setJs("/modulos/blog/web/js/blog.js");
?>
