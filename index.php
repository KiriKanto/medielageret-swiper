<!--Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
require_once 'includes/db__Connect.php';
require 'class/c_cart.php';
require 'class/c_database.php';
//width for later use
if(isset($_POST['width'])){
    $_SESSION['screen_size'] = array();
    $_SESSION['screen_size']['width'] = intval($_POST['width']);
    $_SESSION['screen_size']['height'] = intval($_POST['height']);
}

define("ROOT", "http://localhost/hf-php/medielearning__Msb/");


if(isset($_GET['page']))
{
    $page__Url=$_GET['page'];
}
else
{
    $page__Url="landing";
}

// Gemmer sti
    $page_path = 'pages/'.$page__Url.'.php';

function generateSalt($max = 16) {
    $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
    $i = 0;
    $salt = "";
    while ($i < $max) {
        $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
        $i++;
    }
    return $salt;
}
$salt = generateSalt();


//CLASS CART BEGINS !!!!

if(isset($_SESSION['user__Id']))
{
    $my_db = new c_database();

    if(isset($_POST['add__To__Cart']))
    {
        $my_db->add_to_cart($_POST['prod__Variant__Id'], $_POST['product_quantity']);
    }
}
else
{
    $my_cart = new c_cart();


    if (isset($_POST['add__To__Cart']))
    {
        $my_cart->add_to_cart($_POST['prod__Variant__Id'], $_POST['product_quantity']);

    }
}

// CLASS CART ENDS!!!!!!
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Media learning</title>
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>

<!-- for-mobile-apps -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="keywords" content="Model Profile Widget Responsive, Login form web template, Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<!-- //for-mobile-apps -->

<!--Google Fonts-->
<link href='//fonts.googleapis.com/css?family=Gudea:400,700' rel='stylesheet' type='text/css'>
</head>
<script type="text/javascript">
    $(document).ready(function () {
        var windowsize    = $(window).width();
        console.log(windowsize);
        if(windowsize > 375)
        {
            var mySwiper    = new Swiper('.swiper-container', {
                slidesPerView: 'auto',
                spaceBetween: 0,
                loop: true,
                loopedSlides: 17,
                lazyLoadingInPrevNext: true,
                freeMode: true,
                initialSlide: 0
            });

        }
        else
            {
                var mySwiper = new Swiper('.swiper-container', {
                    slidesPerView: 'auto',
                    spaceBetween: 0,
                    loop: true,
                    loopedSlides: 17,
                    lazyLoadingInPrevNext: true,
                    freeMode: true,
                    initialSlide: 0


                });
            }
            //products slider
        if(windowsize > 375)
        {
            var secondswiper    = new Swiper('.s2', {
                slidesPerView: 'auto',
                spaceBetween: 0,
                loop: true,
                loopedSlides: 10,
                lazyLoadingInPrevNext: true,
                freeMode: true,
                initialSlide: 0
            });

        }
        else
        {
            var secondswiper    = new Swiper('.s2', {
                slidesPerView: 'auto',
                spaceBetween: 0,
                loop: true,
                loopedSlides: 10,
                lazyLoadingInPrevNext: true,
                freeMode: true,
                initialSlide: 0


            });
        }
    });
</script>
<body>

<div id="wrapper">

<!--wrapper start-->

    <?php
    include ("includes/nav.php");
    ?>
    <?php
    if ( file_exists($page_path) )
    {
        include($page_path);
        // Ellers udskrives fejlbesked
    }
    else
    {
        echo "Error 404: Page could not be found.";
    }
    if($page__Url == "landing")
    {

    }
    else
    {

        include ("includes/footer.php");
    }
    ?>

<!--wrapper end-->
</div>
<script src="scripts/scroll__Top.js"> </script>
<script src="scripts/nav__Click.js"></script>
</body>
</html>
<?php
include ("includes/db__Close.php");
?>