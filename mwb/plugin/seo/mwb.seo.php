<?php
/**
 * MWB-SEO
 * copyright NoamdHaan@gmail.com
 * Licensed under MIT
 */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 메타 기본정보
$mwbseo_image_thumb_width = 1200;
$mwbseo_image_thumb_height = 630;
$mwbseo_canonical = set_http($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ;
$mwbseo['seo_image'] = MWB_SEO_DATA_URL."/".'mwb-seo.jpg';

// 게시글일 경우 데이터베이스 불러오기
if($bo_table && $wr_id) {
	$mwbseo_row = sql_fetch("select wr_subject, wr_content, mb_id, wr_name, wr_datetime from g5_write_{$bo_table} where wr_id = '$wr_id' limit 1");
}

// 게시글인 경우와 아닌 경우 구분
if($mwbseo_row) {
	$mwbseo_type = 'article'; // 게시글이 article 형태가 아닐 경우 주석처리
	$mwbseo_writer = $mwbseo_row['wr_name'];
	$mwbseo_sitename = $mwbseo_row['wr_subject'];
	$mwbseo_title = $mwbseo_row['wr_subject'].'-'.$board['bo_subject'];
	$mwbseo_description = cut_str(strip_tags($mwbseo_row['wr_content']), 150,'…');
	include_once(G5_LIB_PATH.'/thumbnail.lib.php');
	$thumb = get_list_thumbnail($bo_table, $wr_id, $mwbseo_image_thumb_width, $mwbseo_image_thumb_height);
	if($thumb['src']) {
        $thumb_url = $thumb['src'];
    } else {
        $thumb_url = $mwbseo['seo_image'];
    }
    $mwbseo_image = $thumb_url;
} else {
	$mwbseo_type = 'website';
	$mwbseo_writer = $config['cf_title'];
	$mwbseo_description = $mwbseo['seo_description'];
	if($board['bo_subject']) {
		$mwbseo_sitename = $board['bo_subject'];
        $mwbseo_title = $board['bo_subject'].'-'.$config['cf_title'];
    } else {
    	$mwbseo_sitename = $config['cf_title'];
    	$mwbseo_title = $config['cf_title'];
    }
    $mwbseo_image = $mwbseo['seo_image'];
}

// 게시판이 관련되지 않은 경우 타이틀 가져오기
$mwbseo_title = ($wr_id || $bo_table) ? $mwbseo_title : $g5_head_title; 
?>

<!-- MWB-SEO meta -->
<link rel="canonical" href="<?php echo $mwbseo_canonical ?>" />
<meta name="robots" content="index,follow" />
<meta name="subject" content="<?php echo $mwbseo_sitename ?>" />
<meta name="title" content="<?php echo $mwbseo_title ?>" />
<meta name="author" content="<?php echo $mwbseo_writer ?>">
<meta name="description" content="<?php echo $mwbseo_description ?>"/>

<!-- MWB-SEO og meta -->
<meta property="og:type" content="<?php echo $mwbseo_type ?>" />
<meta property="og:rich_attachment" content="true" />
<meta property="og:site_name" content="<?php echo $mwbseo_sitename ?>" />
<meta property="og:title" content="<?php echo $mwbseo_title ?>" />
<meta property="og:description" content="<?php echo $mwbseo_description ?>" />
<?php if($mwbseo_row) { ?>
    <meta property="article:author" content="<?php echo $mwbseo_writer ?>" />
    <meta property="article:publisher" content="<?php echo $mwbseo_sitename ?>" />
    <meta property="og:image:width" content="<?php echo $mwbseo_image_thumb_width ?>" >
    <meta property="og:image:height" content="<?php echo $mwbseo_image_thumb_height ?>" >
    <meta property="og:image" content="<?php echo $mwbseo_image ?>" />
<?php } else { ?>
    <meta property="og:image" content="<?php echo $mwbseo_image ?>" />
<?php } ?>
<meta property="og:url" content="<?php echo $mwbseo_canonical ?>" />
<?php if($mwbseo['seo_fb_app_id']) { ?>
	<meta property="fb:app_id" content="<?php echo $mwbseo['seo_fb_app_id'] ?>"/>
<?php } ?>
<?php if($mwbseo['seo_fb_page']) { ?>
	<meta property="fb:pages" content="<?php echo $mwbseo['seo_fb_page'] ?>">
<?php } ?>

<!-- MWB-GB twitter meta -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="<?php echo $mwbseo_sitename ?>" />
<meta name="twitter:title" content="<?php echo $mwbseo_title ?>" />
<meta name="twitter:description" content="<?php echo $mwbseo_description ?>" />
<meta name="twitter:image" content="<?php echo $mwbseo_image ?>" />
<meta name="twitter:creator" content="<?php echo $mwbseo_writer ?>">

<!-- MWB-GB google+ meta -->
<meta itemprop="name" content="<?php echo $mwbseo_title ?>" />
<meta itemprop="description" content="<?php echo $mwbseo_description ?>" />
<meta itemprop="image" content="<?php echo $mwbseo_image ?>" />

<!-- APPLE MWB-GB -->
<meta name="apple-mobile-web-app-title" content="<?php echo $config['cf_title'] ?>">

<?php if($mwbseo['seo_naver_verify']) { ?>
<!-- 네이버 웹마스터도구 -->
<meta name="naver-site-verification" content="<?php echo $mwbseo['seo_naver_verify'] ?>"/>
<?php } ?>

<?php if($mwbseo['seo_google_verify']) { ?>
<!-- 구글 Search Console -->
<meta name="google-site-verification" content="<?php echo $mwbseo['seo_google_verify'] ?>" />
<?php } ?>

<?php if($mwbseo['seo_naver_analytics']) { // tail.sub.php 파일의 </body> 앞에 두는 것을 권장 ?>
<!-- 네이버 애널리틱스 -->
<?php include_once(MWB_SEO_PATH.'/mwb.seo.naver.analytics.php'); ?>
<?php } ?>

<?php if($mwbseo['seo_google_analytics']) { // tail.sub.php 파일의 </body> 앞에 두는 것을 권장 ?>
<!-- 구글 애널리틱스 -->
<?php include_once(MWB_SEO_PATH.'/mwb.seo.google.analytics.php'); ?>
<?php } ?>

<title><?php echo $mwbseo_title; // </title>는 head.sub.php 에서 닫음 ?>