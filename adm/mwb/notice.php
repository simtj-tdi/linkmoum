<?php
$sub_menu = "950000";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g5['title'] = "MWB 안내";

include_once(G5_ADMIN_PATH.'/admin.head.php');

?>

<section>
    <h2 class="h2_frm">관리 메뉴 설명</h2>
    <div class="local_desc02 local_desc">
        <p>상단 MWB 관리에 대한 각각의 설명입니다. 꼭 참고하시기 바랍니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>관리 메뉴 설명</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>

        <?php if (!sql_query(" DESCRIBE {$g5['mwb_seo_config_table']} ")) { ?>
        <tr class="mwb_admin_install">
            <th scope="row"></th>
            <td colspan="3">
                <p>MOOWABO SEO의 기능을 이용하기 위하여 설치 및 설정 페이지로 이동합니다.<br></p>
                <a href="<?php echo MWB_ADMIN_URL ?>/install_seo.php">MOOWABO SEO 설치</a>
            </td>
        </tr>
        <?php } ?>

		<?php if (sql_query(" DESCRIBE {$g5['mwb_seo_config_table']} ")) { ?>
        <tr>
            <th scope="row" class="lnb_svc">SEO 관리</th>
            <td>
                <p>업체의 SEO 내용을 변경할 수 있습니다.</p><a href="<?php echo MWB_ADMIN_URL ?>/seo.php" class="btn_frmline">바로가기</a>
            </td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</section>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>