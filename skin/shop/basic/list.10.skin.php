<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);

// 장바구니 또는 위시리스트 ajax 스크립트
add_javascript('<script src="'.G5_JS_URL.'/shop.list.action.js"></script>', 10);
?>
<style>
    html {overflow-y:scroll;}
    body {background:#F4F5FB;margin:0px;padding:0px;font-size:10pt;font-family:나눔고딕,Nanum Gothic,돋움,Dotum;}
    h1 {padding:0px;padding-bottom:5px;margin:0px;font-size:12pt;line-height:12pt;color:#19629C;color:#D63900;}
    h3 {padding:0px;margin:0px;font-size:10pt;line-height:10pt;font-weight:normal;display:inline;letter-spacing:0px;word-spacing:0px;color:#333;}
    .top {background:#19629C;box-shadow: 0px 3px 3px 0px #999;}
    .topbox {max-width:1080px;margin:0px auto;height:51px;font-size:15pt;font-weight:bold;color:#fff;}
    .topbox .logo {float:left;width:200px;margin-top:0px;font-weight:bold;}
    .topbox a {text-decoration:none;color:#fff;}
    .topbox .menu {float:right;width:120px;text-align:right;font-size:12pt;font-weight:normal;margin-right:10px;margin-top:15px;font-size:11pt;}
    .contents {max-width:1080px;margin:0px auto;clear:both;}
    .bottom {font-size:10pt;text-align:center;color:#555;padding:5px;color:#555;}
    .notice {margin-top:10px;padding-left:5px;padding-right:5px;color:#333;padding:3px;}
    .la_subject {padding:20px 10px 10px 10px;font-size:1.4em;font-weight:bold;border-bottom:2px solid #19629C;color:#333;}
    .la_info {padding:5px;color:#555;font-size:1.1em;border-bottom:1px solid #a1a1a1;}
    .la_info strong {margin-right:12px;}
    .user_icon {vertical-align:middle;border-radius:14px;width:28px;margin-right:8px;}
    .la_con {padding:10px 5px;border-bottom:1px solid #a1a1a1;font-size:1.1em;line-height:1.5em;}
    .la_comm {background:#f5f5f5;padding:5px;border-bottom:1px solid #a1a1a1;}
    .la_commlist {border-bottom:1px dotted #a1a1a1;color:#555;padding:10px;padding-left:20px;font-size:1.1em;line-height:1.5em;}
    .la_commlist strong {margin-left:8px;margin-right:12px;}
    .la_commlist p {margin:5px 5px 0px 20px;}
    .la_list {margin-top:10px;height:34px;clear:both;border-bottom:1px dashed #a1a1a1;}
    .la_listday {float:right;padding:5px;font-size:1.2em;color:#333;}
    .la_listsub {float:left;padding:5px;font-size:1.2em;color:#555;}
    .la_listsub a{color:#555;text-decoration:none;}
    .la_listsub a:hover{text-decoration:underline;}
    .la_new {padding:20px 10px 10px 10px;font-size:1.3em;font-weight:bold;border-bottom:2px solid #19629C;color:#333;}
    .item {margin:7px 0px;border:1px solid #a1a1a1;background:#fff;cursor:pointer;height:118px;padding:5px;}
    .item:hover {border-color:#19629C;}
    .item .image {float:left;margin-right:5px;}
    .item .name {font-size:12pt;font-weight:bold;line-height:34px;}
    .linked {margin:0px;padding:2px 0px 0px 0px;font-weight:bold;text-decoration:underline;color:#2E65C9;}
    .item .view {font-size:11pt;line-height:20px;}
    .item .button {font-size:11pt;float:right;height:100px;width:120px;line-height: 100px;text-align:center;font-weight:bold;background:#fff;border-left:1px solid #a1a1a1;color:#333}
    .item .button:hover {background:#19629C;color:#fff;}
    .latest {}
    .latest .open {float:right;font-size:10pt;color:#555;padding-right:10px;margin-bottom:5px;display:none;}
    .latest .close {float:right;font-size:10pt;color:#555;padding-right:10px;margin-bottom:5px;}
    .latest .gal {clear:both;border-top:1px solid #a1a1a1;}
    .latest .gallist {border:1px solid #a1a1a1;border-top:0px;padding:5px;background:#fff;}
    .latest .listBox .reply {color:#19629C;}
    .latest .latestList {padding:8px;padding-left:10px;border-bottom:1px dashed #a1a1a1;font-size:11pt;}
    .latest .latestList a {text-decoration:none;color:#333;}
    .latest .latestList a:hover {text-decoration:underline;}
    .latest .latestDay {padding:8px;padding-right:10px;border-bottom:1px dashed #a1a1a1;font-size:10pt;text-align:right;color:#333;}
    @media screen and (max-width: 900px){
        .item .button {display:none;}
    }
    @media screen and (max-width: 700px){
        .h1 {font-size:12pt;}
        .h3 {font-size:11pt;}
        .item .image img {width:120px;height:60px;margin:20px 0px;}
        .item .name {font-size:11pt;line-height:30px;}
        .item .view {font-size:10pt;line-height:16px;}
    }
</style>
<div class="contents">
<?php

echo $ca['ca_2'];"</br>";
echo $ca['ca_3'];

$i=0;
foreach((array) $list as $row){

    if( empty($row) ) continue;
    $i++;

//    echo "<xmp>";
//    print_r($list);
//    echo "</xmp>";
?>
    <div class="item" onclick="window.open('<?php echo $row['it_origin'];?>')" >
        <div class="image">
            <?php echo get_it_image($row['it_id'], "200", "100", '', '', stripslashes($row['it_name']), $row['it_origin']); ?>
        </div>
        <div class="button">
            바로가기
        </div>
        <div class="name">
            <?php echo $i;?>. <?php echo stripslashes($row['it_name']);?>
            <?php echo item_icon($row); ?></div>
        <div class="view">
             <?php echo stripslashes($row['it_basic']);?><br /><?php echo stripslashes($row['it_maker']);?><p class="linked">[무료포인트 받기 / 사이트바로가기]</p>
        </div>
    </div>
<?php } ?>


</div>