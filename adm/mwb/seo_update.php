<?php
$sub_menu = "950050";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

check_admin_token();

$sql = " update {$g5['mwb_seo_config_table']}
            set seo_description = '{$_POST['seo_description']}',
                seo_image = '{$_POST['seo_image']}',
                seo_facebook_id = '{$_POST['seo_facebook_id']}',
                seo_instagram_id = '{$_POST['seo_instagram_id']}',
                seo_naverblog_id = '{$_POST['seo_naverblog_id']}',
                seo_navercafe_id = '{$_POST['seo_navercafe_id']}',
                seo_twitter_id = '{$_POST['seo_twitter_id']}',
                seo_fb_app_id = '{$_POST['seo_fb_app_id']}',
                seo_fb_page = '{$_POST['seo_fb_page']}',
                seo_naver_verify = '{$_POST['seo_naver_verify']}',
                seo_google_verify = '{$_POST['seo_google_verify']}',
                seo_naver_analytics = '{$_POST['seo_naver_analytics']}',
                seo_google_analytics = '{$_POST['seo_google_analytics']}'
                ";
sql_query($sql,true);

$sql2 = " update {$g5['config_table']}
            set cf_title = '{$_POST['cf_title']}' ";
sql_query($sql2);

// 이미지 업로드 
if(is_uploaded_file($_FILES['mwb_seo_img']['tmp_name'])) {
    if(($imgtype = exif_imagetype($_FILES['mwb_seo_img']['tmp_name']))) {
        if($imgtype == 2 || $imgtype == 3) { // jpeg,png 일 때만
            @mkdir(MWB_SEO_DATA_PATH, G5_DIR_PERMISSION);
            @chmod(MWB_SEO_DATA_PATH, G5_DIR_PERMISSION);
            $seofilepath = MWB_SEO_DATA_PATH."/".'mwb-seo.jpg';
            move_uploaded_file($_FILES['mwb_seo_img']['tmp_name'], $seofilepath);
            chmod($seofilepath, G5_FILE_PERMISSION);
        } else {
            @unlink($_FILES['img_files']['tmp_name']['mwbseo']);
        }
    } else {
        @unlink($_FILES['img_files']['tmp_name']['mwbseo']);
    }
}

goto_url('./seo.php', false);
?>