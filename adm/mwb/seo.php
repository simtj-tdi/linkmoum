<?php
$sub_menu = "950050";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if (!strstr($_SERVER['SCRIPT_NAME'], 'install_seo.php')) {
    if (!sql_num_rows(sql_query(" show tables like '{$g5['mwb_seo_config_table']}' "))) { 
        goto_url('install_seo.php');
    }
}

$g5['title'] = "MWB SEO 설정";

include_once(G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor">
    <li><a href="#mwb_server_info">서버 정보</a></li>
    <li><a href="#mwb_seo_info">SEO & 기타설정</a></li>
</ul>';
?>

<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">

<?php if ($is_admin = 'super') { ?>
<section>
    <h2 class="h2_frm" id="mwb_server_info">서버 정보</h2>
    <?php echo $pg_anchor ?>
    <div class="local_desc02 local_desc">
        <p>서버의 정보를 확인할 수 있습니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>서버 정보</caption>
        <colgroup>
            <col class="grid_4">
            <col class="grid_8">
            <col class="grid_4">
            <col class="grid_8">
        </colgroup>
        <tbody>
        <tr>
            <th scope="row">MYSQL USER</th>
            <td><?php echo G5_MYSQL_USER; ?></td>
            <th scope="row">MYSQL DB</th>
            <td><?php echo G5_MYSQL_DB; ?></td>
        </tr>
        <tr>
            <th scope="row">서버 IP</th>
            <td><?php echo ($_SERVER['SERVER_ADDR']?$_SERVER['SERVER_ADDR']:$_SERVER['LOCAL_ADDR']); ?></td>
            <th scope="row"></th>
            <td></td>
        </tr>
        </tbody>
        </table>
    </div>
</section>
<?php } ?>

<section>
    <h2 class="h2_frm" id="mwb_seo_info">SEO & 기타설정 관리</h2>
    <?php echo $pg_anchor ?>
    <div class="local_desc02 local_desc">
        <p>SEO 및 기타설정 정보를 변경할 수 있습니다.</p>
        <p>SEO, 네이버 사이트 등록, SNS 공유 페이지 설정 등에 이용됩니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>SEO 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col class="grid_8">
            <col class="grid_4">
            <col class="grid_8">
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_title">홈페이지 제목</label></th>
            <td>
                <?php echo help("'cf_title'과 동일한 홈페이지 제목"); ?>
                <input type="text" name="cf_title" value="<?php echo $config['cf_title'] ?>" id="cf_title" required class="required frm_input" size="60">
            </td>
            <th scope="row"><label for="seo_description">사이트 설명</label></th>
            <td>
                <?php echo help("메타태그에 들어가는 사이트 설명을 입력합니다<br>네이버, 카카오, 페이스북, 트위터, 인스타그램 등에 사용됩니다."); ?>
                <textarea name="seo_description" id="seo_description" row="2" style="height:auto;"><?php echo $mwbseo['seo_description'] ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="seo_image">기본 이미지 파일명</label></th>
            <td colspan="3">
                <?php echo help("메타태그에 들어갈 SEO 이미지를 등록합니다. og 권장사이즈는 가로 1200px,세로 630px입니다. jpg,png 파일만 가능합니다.<br>게시글에 이미지가 있다면 게시글 이미지가 우선으로 노출됩니다."); ?>
                <input type="file" name="mwb_seo_img">
                <?php
                if(file_exists(MWB_SEO_DATA_PATH.'/mwb-seo.jpg')) {
                    $filenameurl = MWB_SEO_DATA_URL.'/mwb-seo.jpg';
                    if(($imgtype = exif_imagetype(MWB_SEO_DATA_PATH.'/mwb-seo.jpg'))) {
                        if($imgtype == 2 || $imgtype == 3) { // jpeg,png 일때 
                            print "<img src='".$filenameurl."' width='200px' height='112px'>";
                        }
                    }
                } ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="seo_facebook_id">페이스북</label></th>
            <td>
                <?php echo help("운영하는 페이스북 계정이 있으면 ID를 입력합니다."); ?>
                <input type="text" name="seo_facebook_id" value="<?php echo $mwbseo['seo_facebook_id'] ?>" id="seo_facebook_id" class="frm_input" size="30">
                <a href="https://www.facebook.com" target="_blank" class="btn_frmline">페이스북</a>
            </td>
            <th scope="row"><label for="seo_instagram_id">인스타그램</label></th>
            <td>
                <?php echo help("운영하는 인스타그램 계정이 있으면 ID를 입력합니다."); ?>
                <input type="text" name="seo_instagram_id" value="<?php echo $mwbseo['seo_instagram_id'] ?>" id="seo_instagram_id" class="frm_input" size="30">
                <a href="https://www.instagram.com" target="_blank" class="btn_frmline">인스타그램</a>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="seo_naverblog_id">네이버 블로그</label></th>
            <td>
                <?php echo help("운영하는 네이버 블로그 계정이 있으면 ID를 입력합니다."); ?>
                <input type="text" name="seo_naverblog_id" value="<?php echo $mwbseo['seo_naverblog_id'] ?>" id="seo_naverblog_id" class="frm_input" size="30">
                <a href="https://section.blog.naver.com" target="_blank" class="btn_frmline">네이버 블로그</a>
            </td>
            <th scope="row"><label for="seo_navercafe_id">네이버 카페</label></th>
            <td>
                <?php echo help("운영하는 네이버 카페 계정이 있으면 ID를 입력합니다."); ?>
                <input type="text" name="seo_navercafe_id" value="<?php echo $mwbseo['seo_navercafe_id'] ?>" id="seo_navercafe_id" class="frm_input" size="30">
                <a href="https://section.cafe.naver.com" target="_blank" class="btn_frmline">네이버 카페</a>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="seo_twitter_id">트위터</label></th>
            <td>
                <?php echo help("운영하는 트위터 계정이 있으면 ID를 입력합니다."); ?>
                <input type="text" name="seo_twitter_id" value="<?php echo $mwbseo['seo_twitter_id'] ?>" id="seo_twitter_id" class="frm_input" size="30">
                <a href="https://twitter.com" target="_blank" class="btn_frmline">트위터</a>
            </td>
            <th scope="row"></th>
            <td>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="seo_naver_analytics">네이버 애널리틱스</label></th>
            <td>
                <?php echo help("네이버 애널리틱스 코드를 입력합니다.(생략 가능)"); ?>
                <input type="text" name="seo_naver_analytics" value="<?php echo $mwbseo['seo_naver_analytics'] ?>" id="seo_naver_analytics" class="frm_input" size="50">
                <a href="http://analytics.naver.com/" target="_blank" class="btn_frmline">네이버 애널리틱스</a>
            </td>
            <th scope="row"><label for="seo_google_analytics">구글 애널리틱스</label></th>
            <td>
                <?php echo help("구글 애널리틱스 코드를 입력합니다.(생략 가능)"); ?>
                <input type="text" name="seo_google_analytics" value="<?php echo $mwbseo['seo_google_analytics'] ?>" id="seo_google_analytics" class="frm_input" size="50">
                <a href="http://www.google.com/intl/ko_ALL/analytics/" target="_blank" class="btn_frmline">구글 애널리틱스</a>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="seo_naver_verify">네이버 사이트확인</label></th>
            <td>
                <?php echo help("네이버 사이트 확인 코드를 입력합니다.(생략 가능)<br>네이버에서는 html 파일 업로드를 권장하고 있습니다."); ?>
                <input type="text" name="seo_naver_verify" value="<?php echo $mwbseo['seo_naver_verify'] ?>" id="seo_naver_verify" class="frm_input" size="50">
                <a href="http://webmastertool.naver.com/" target="_blank" class="btn_frmline">네이버 웹마스터도구</a>
            </td>
            <th scope="row"><label for="seo_google_verify">구글 사이트확인</label></th>
            <td>
                <?php echo help("구글 사이트확인 코드를 입렵합니다.(생략 가능)<br>구글에서는 html 파일 업로드를 권장하고 있습니다."); ?>
                <input type="text" name="seo_google_verify" value="<?php echo $mwbseo['seo_google_verify'] ?>" id="seo_google_verify" class="frm_input" size="50">
                <a href="https://www.google.com/webmasters/tools/home?hl=ko" target="_blank" class="btn_frmline">구글 Search Console</a>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="seo_fb_app_id">페이스북 앱 아이디</label></th>
            <td>
                <?php echo help("페이스북 앱 아이디를 입력합니다. (생략 가능)<br>https://developers.facebook.com/apps 에서 찾을 수 있습니다."); ?>
                <input type="text" name="seo_fb_app_id" value="<?php echo $mwbseo['seo_fb_app_id'] ?>" id="seo_fb_app_id" class="frm_input" size="50">
                <a href="https://developers.facebook.com/" target="_blank" class="btn_frmline">페이스북 개발자도구</a>
            </td>
            <th scope="row"><label for="seo_fb_page">페이스북 페이지</label></th>
            <td>
                <?php echo help("페이스북 페이지. (생략 가능)<br>페이지 설정 탭에서 찾을 수 있습니다."); ?>
                <input type="text" name="seo_fb_page" value="<?php echo $mwbseo['seo_fb_page'] ?>" id="seo_fb_page" class="frm_input" size="50">
                <a href="https://www.facebook.com" target="_blank" class="btn_frmline">페이스북</a>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<div class="btn_fixed_top btn_confirm">
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>

<script>
function fconfigform_submit(f)
{
    f.action = "./seo_update.php";
    return true;
}
</script>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>