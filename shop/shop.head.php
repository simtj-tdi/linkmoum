<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가


include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

add_javascript('<script src="'.G5_JS_URL.'/owlcarousel/owl.carousel.min.js"></script>', 10);
add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/owlcarousel/owl.carousel.css">', 0);

add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/bootstrap.min.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/style.css">', 0);

?>
