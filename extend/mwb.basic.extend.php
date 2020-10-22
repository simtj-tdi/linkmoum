<?php
/**
 * MWB-SEO
 * copyright NoamdHaan@gmail.com
 * Licensed under MIT
 */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 에러 로그 표시 - 개발 끝난 뒤 주석처리
if($is_admin) {
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);
}

// MWB 버전 관리
define('MWB_VER',         '20180308-1');
define('MWB_JS_VER',      '20180308-1');
define('MWB_CSS_VER',     '20180308-1');

// MWB 상수 선언
define('MWB_DIR',         'mwb');
define('MWB_ASSETS',      'assets');
define('MWB_SNS_DIR',     'sns');
define('MWB_SEO_DIR',     'seo');
define('MWB_ETC_DIR',     'etc');
define('MWB_LANG_DIR',    'lang');

define('MWB_URL',           G5_URL.'/'.MWB_DIR);
define('MWB_ADMIN_URL',     G5_ADMIN_URL.'/'.MWB_DIR);
define('MWB_CSS_URL',       MWB_URL.'/'.G5_CSS_DIR);
define('MWB_JS_URL',        MWB_URL.'/'.G5_JS_DIR);
define('MWB_IMG_URL',       MWB_URL.'/'.G5_IMG_DIR);
define('MWB_ASSETS_URL',    MWB_URL.'/'.MWB_ASSETS);
define('MWB_LIB_URL',       MWB_URL.'/'.G5_LIB_DIR);
define('MWB_PLUGIN_URL',    MWB_URL.'/'.G5_PLUGIN_DIR);
define('MWB_SNS_URL',       MWB_PLUGIN_URL.'/'.MWB_SNS_DIR);
define('MWB_SEO_URL',       MWB_PLUGIN_URL.'/'.MWB_SEO_DIR);
define('MWB_LANG_URL',      MWB_PLUGIN_URL.'/'.MWB_LANG_DIR);
define('MWB_ETC_URL',       MWB_PLUGIN_URL.'/'.MWB_ETC_DIR);
define('MWB_SEO_DATA_URL',  G5_DATA_URL.'/'.MWB_SNS_DIR);

define('MWB_PATH',          G5_PATH.'/'.MWB_DIR);
define('MWB_ADMIN_PATH',    G5_ADMIN_PATH.'/'.MWB_DIR);
define('MWB_CSS_PATH',      MWB_PATH.'/'.G5_CSS_DIR);
define('MWB_JS_PATH',       MWB_PATH.'/'.G5_JS_DIR);
define('MWB_IMG_PATH',      MWB_PATH.'/'.G5_IMG_DIR);
define('MWB_ASSETS_PATH',   MWB_PATH.'/'.MWB_ASSETS);
define('MWB_LIB_PATH',      MWB_PATH.'/'.G5_LIB_DIR);
define('MWB_PLUGIN_PATH',   MWB_PATH.'/'.G5_PLUGIN_DIR);
define('MWB_SNS_PATH',      MWB_PLUGIN_PATH.'/'.MWB_SNS_DIR);
define('MWB_SEO_PATH',      MWB_PLUGIN_PATH.'/'.MWB_SEO_DIR);
define('MWB_LANG_PATH',     MWB_PLUGIN_PATH.'/'.MWB_LANG_DIR);
define('MWB_ETC_PATH',      MWB_PLUGIN_PATH.'/'.MWB_ETC_DIR);
define('MWB_SEO_DATA_PATH', G5_DATA_PATH.'/'.MWB_SNS_DIR);

// mwb_config_table 에서 기본설정 불러오기
$g5['mwb_config_prefix'] = 'mwb_';
$g5['mwb_config_table'] = $g5['mwb_config_prefix'] . 'config';
//mwb 설정테이블 값 항상 불러오기
if(sql_query(" DESCRIBE {$g5['mwb_config_table']} ")) {
	$mwbcfg = sql_fetch(" select * from {$g5['mwb_config_table']} ",false);
}

?>