<?php
$sub_menu = "950050";
include_once("./_common.php");

auth_check($auth[$sub_menu], 'r');

$g5['title'] = "MWB SEO 설치";

$setup = $_POST['setup'];

include_once(G5_ADMIN_PATH.'/admin.head.php');
?>
<form name="hidden_form" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']?>">
<input type="hidden" name="setup">
</form>
<?php
//MWB 설정 정보 테이블이 있는지 검사한다.
if( isset($g5['mwb_seo_config_table']) && sql_query(" DESCRIBE {$g5['mwb_seo_config_table']} ", false)) {
    if(!$setup){
        echo '<script>
            var answer = confirm("이미 MWB-SEO 환경이 설치되어 있습니다.새로 설치 할 경우 DB 자료가 망실됩니다. 새로 설치하시겠습니까?");
            if (answer){
                document.hidden_form.setup.value = "1";
                document.hidden_form.submit();
            } else {
                history.back();
            }
            </script>
        ';
        exit;
    }
}
?>

<div id="mwb_install">
    <ol>
        <li>MWB-SEO 환경 설치가 시작되었습니다.</li>
        <li id="mwb_job_01">전체 테이블 생성중</li>
        <li id="mwb_job_02">DB설정 중</li>
        <li id="mwb_job_03"></li>
    </ol>

    <p><button type="button" id="mwb_btn_next" disabled class="btn_frmline" onclick="location.href='seo.php';">MWB SEO 설정</button></p>

</div>
<?php
flush(); usleep(50000);

// 테이블 생성 ------------------------------------
$file = implode("", file(MWB_SEO_PATH."/seo.sql"));
eval("\$file = \"$file\";");

$f = explode(";", $file);
for ($i=0; $i<count($f); $i++) {
    if (trim($f[$i]) == "") continue;
    sql_query($f[$i]) or die(mysqli_error());
}
// 테이블 생성 ------------------------------------

echo "<script>document.getElementById('mwb_job_01').innerHTML='전체 테이블 생성 완료';</script>";
flush(); usleep(50000);

$read_point = 0;
$write_point = 0;
$comment_point = 0;
$download_point = 0;

//-------------------------------------------------------------------------------------------------
// config 테이블 설정

echo "<script>document.getElementById('mwb_job_02').innerHTML='DB설정 완료';</script>";
flush(); usleep(50000);
//-------------------------------------------------------------------------------------------------

echo "<script>document.getElementById('mwb_job_03').innerHTML='MWB SEO 설정 변경 후 사용하세요.';</script>";
flush(); usleep(50000);
?>

<script>document.getElementById('mwb_btn_next').disabled = false;</script>
<script>document.getElementById('mwb_btn_next').focus();</script>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>