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
?>

<!-- 상단 시작 { -->
<div id="hd" style="height:100px ;">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>
    

    <div id="hd_wrapper" style="height: 80px">
        <div id="logo">
        	11<a href="<?php echo G5_URL; ?>/"><img src="<?php echo G5_URL; ?>/img/logo.png" alt="<?php echo $config['cf_title']; ?>"></a>
        </div>
    </div>

</div>
<!-- } 상단 끝 -->

<?php
    $wrapper_class = array();
    if( defined('G5_IS_COMMUNITY_PAGE') && G5_IS_COMMUNITY_PAGE ){
        $wrapper_class[] = 'is_community';
    }
?>

<!-- 전체 콘텐츠 시작 { -->
<div id="wrapper" class="<?php echo implode(' ', $wrapper_class); ?>">

    <!-- #container 시작 { -->
    <div id="container" >

        <!-- .shop-content 시작 { -->
        <div class="is_item">
