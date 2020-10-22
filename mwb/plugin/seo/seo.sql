##
## Table structure for table `{$g5['mwb_seo_config_table']}`
##

DROP TABLE IF EXISTS `{$g5['mwb_seo_config_table']}`;
CREATE TABLE IF NOT EXISTS `{$g5['mwb_seo_config_table']}` (
  `seo_description` text NOT NULL DEFAULT '',
  `seo_image` text NOT NULL DEFAULT '',
  `seo_facebook_id` text NOT NULL DEFAULT '',
  `seo_instagram_id` text NOT NULL DEFAULT '',
  `seo_naverblog_id` text NOT NULL DEFAULT '',
  `seo_navercafe_id` text NOT NULL DEFAULT '',
  `seo_twitter_id` text NOT NULL DEFAULT '',
  `seo_fb_app_id` text NOT NULL DEFAULT '',
  `seo_fb_page` text NOT NULL DEFAULT '',
  `seo_naver_verify` text NOT NULL DEFAULT '',
  `seo_google_verify` text NOT NULL DEFAULT '',
  `seo_naver_analytics` text NOT NULL DEFAULT '',
  `seo_google_analytics` text NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{$g5['mwb_seo_config_table']}`(`seo_description`) VALUES ('사이트에 대한 설명');