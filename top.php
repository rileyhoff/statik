<!DOCTYPE html>
<html lang="en"> <!-- assignment 5.0 -->
<head>
    <title>Statik - <?php echo $title ?></title>
    <meta charset="utf-8">
    <meta name="author" content="Riley Hoff">
    <meta name="description" content="Statik is an actions sports and lifestyle 
          web site that highlights events in the Burlington Vt area. The website 
          also showcases althetes, bands and artists from around the world.">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style.css" rel="stylesheet" type="text/css" media="screen"/>
    
<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
<![endif]-->


<?php
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// PATH SETUP
//
// $domain = "https://www.uvm.edu" or http://www.uvm.edu;
 $domain = "https://";
if (isset($_SERVER['HTTPS'])) {
    if($_SERVER['HTTPS']) {
       $domain = "https://";
    }
}

 $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");

$domain .= $server;

$phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

$path_parts = pathinfo($phpSelf);

if ($debug){
    print "<p>Domain" . $domain;
    print "<p>php Self". $phpSelf;
    print "<p>Path Parts<pre>";
    print_r($path_parts);
    print "</pre>";
}

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// inlcude all libraries
//

require_once('lib/security.php');





?>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script src="js/jquery.flexslider.js"></script>

        <script type="text/javascript">
            var flexsliderStylesLocation = "css/flexslider.css";
            $('<link rel="stylesheet" type="text/css" href="'+flexsliderStylesLocation+'" >').appendTo("head");
            $(window).load(function() {

                $('.flexslider').flexslider({
                    animation: "fade",
                    slideshowSpeed: 3000,
                    animationSpeed: 1000
                });

            });
        </script>
</head>
<!-- ################ body section ######################### -->
<?php

print '<body id="' . $path_parts['filename'] . '">';

include "header.php";
include "nav.php";

?>
