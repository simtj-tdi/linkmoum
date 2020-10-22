<?php
/**
 * MWB-SEO
 * copyright NoamdHaan@gmail.com
 * Licensed under MIT
 */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// mwb_seo_config_table 에서 기본설정 불러오기
$g5['mwb_seo_prefix'] = 'mwb_seo_';
$g5['mwb_seo_config_table'] = $g5['mwb_seo_prefix'] . 'config';
//mwb 설정테이블 값 항상 불러오기
if(sql_query(" DESCRIBE {$g5['mwb_seo_config_table']} ")) {
	$mwbseo = sql_fetch(" select * from {$g5['mwb_seo_config_table']} ",false);
}

?>