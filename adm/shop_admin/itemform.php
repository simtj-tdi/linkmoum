<?php
$sub_menu = '400300';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);
include_once(G5_LIB_PATH.'/iteminfo.lib.php');

auth_check($auth[$sub_menu], "w");

$html_title = "상품 ";

if ($w == "")
{
    $html_title .= "입력";

    // 옵션은 쿠키에 저장된 값을 보여줌. 다음 입력을 위한것임
    //$it[ca_id] = _COOKIE[ck_ca_id];
    $it['ca_id'] = get_cookie("ck_ca_id");
    $it['ca_id2'] = get_cookie("ck_ca_id2");
    $it['ca_id3'] = get_cookie("ck_ca_id3");
    if (!$it['ca_id'])
    {
        $sql = " select ca_id from {$g5['g5_shop_category_table']} order by ca_order, ca_id limit 1 ";
        $row = sql_fetch($sql);
        if (!$row['ca_id'])
            alert("등록된 분류가 없습니다. 우선 분류를 등록하여 주십시오.", './categorylist.php');
        $it['ca_id'] = $row['ca_id'];
    }
    //$it[it_maker]  = stripslashes($_COOKIE[ck_maker]);
    //$it[it_origin] = stripslashes($_COOKIE[ck_origin]);

}
else if ($w == "u")
{
    $html_title .= "수정";

    if ($is_admin != 'super')
    {
        $sql = " select it_id from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_category_table']} b
                  where a.it_id = '$it_id'
                    and a.ca_id = b.ca_id
                    and b.ca_mb_id = '{$member['mb_id']}' ";
        $row = sql_fetch($sql);
        if (!$row['it_id'])
            alert("\'{$member['mb_id']}\' 님께서 수정 할 권한이 없는 상품입니다.");
    }

    $it = get_shop_item($it_id);

    if(!$it)
        alert('상품정보가 존재하지 않습니다.');

    if (!$ca_id)
        $ca_id = $it['ca_id'];

    $sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' ";
    $ca = sql_fetch($sql);
}
else
{
    alert();
}

$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page;

$g5['title'] = $html_title;
include_once (G5_ADMIN_PATH.'/admin.head.php');

// 분류리스트
$category_select = '';
$script = '';
$sql = " select * from {$g5['g5_shop_category_table']} ";
if ($is_admin != 'super')
    $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $len = strlen($row['ca_id']) / 2 - 1;

    $nbsp = "";
    for ($i=0; $i<$len; $i++)
        $nbsp .= "&nbsp;&nbsp;&nbsp;";

    $category_select .= "<option value=\"{$row['ca_id']}\">$nbsp{$row['ca_name']}</option>\n";

    $script .= "ca_use['{$row['ca_id']}'] = {$row['ca_use']};\n";
    $script .= "ca_stock_qty['{$row['ca_id']}'] = {$row['ca_stock_qty']};\n";
    //$script .= "ca_explan_html['$row[ca_id]'] = $row[ca_explan_html];\n";
    $script .= "ca_sell_email['{$row['ca_id']}'] = '{$row['ca_sell_email']}';\n";
}

// 재입고알림 설정 필드 추가
if(!sql_query(" select it_stock_sms from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}`
                    ADD `it_stock_sms` tinyint(4) NOT NULL DEFAULT '0' AFTER `it_stock_qty` ", true);
}

// 추가옵션 포인트 설정 필드 추가
if(!sql_query(" select it_supply_point from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}`
                    ADD `it_supply_point` int(11) NOT NULL DEFAULT '0' AFTER `it_point_type` ", true);
}

// 상품메모 필드 추가
if(!sql_query(" select it_shop_memo from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}`
                    ADD `it_shop_memo` text NOT NULL AFTER `it_use_avg` ", true);
}

// 지식쇼핑 PID 필드추가
// 상품메모 필드 추가
if(!sql_query(" select ec_mall_pid from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}`
                    ADD `ec_mall_pid` varchar(255) NOT NULL AFTER `it_shop_memo` ", true);
}

$pg_anchor ='<ul class="anchor">
<li><a href="#anc_sitfrm_cate">상품분류</a></li>
<li><a href="#anc_sitfrm_skin">스킨설정</a></li>
<li><a href="#anc_sitfrm_ini">기본정보</a></li>
<li><a href="#anc_sitfrm_compact">요약정보</a></li>
<li><a href="#anc_sitfrm_cost">가격 및 재고</a></li>
<li><a href="#anc_sitfrm_sendcost">배송비</a></li>
<li><a href="#anc_sitfrm_img">상품이미지</a></li>
<li><a href="#anc_sitfrm_relation">관련상품</a></li>
<li><a href="#anc_sitfrm_event">관련이벤트</a></li>
<li><a href="#anc_sitfrm_optional">상세설명설정</a></li>
<li><a href="#anc_sitfrm_extra">여분필드</a></li>
</ul>
';


// 쿠폰적용안함 설정 필드 추가
if(!sql_query(" select it_nocoupon from {$g5['g5_shop_item_table']} limit 1", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}`
                    ADD `it_nocoupon` tinyint(4) NOT NULL DEFAULT '0' AFTER `it_use` ", true);
}

// 스킨필드 추가
if(!sql_query(" select it_skin from {$g5['g5_shop_item_table']} limit 1", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}`
                    ADD `it_skin` varchar(255) NOT NULL DEFAULT '' AFTER `ca_id3`,
                    ADD `it_mobile_skin` varchar(255) NOT NULL DEFAULT '' AFTER `it_skin` ", true);
}
?>

<form name="fitemform" action="./itemformupdate.php" method="post" enctype="MULTIPART/FORM-DATA" autocomplete="off" onsubmit="return fitemformcheck(this)">

<input type="hidden" name="codedup" value="<?php echo $default['de_code_dup_use']; ?>">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod"  value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx"  value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<input type="hidden" name="ii_article[]" value="">
<input type="hidden" name="it_use" value="1">

<?php if ($w == '') { // 추가 ?>
    <!-- 최근에 입력한 코드(자동 생성시)가 목록의 상단에 출력되게 하려면 아래의 코드로 대체하십시오. -->
    <!-- <input type=text class=required name=it_id value="<?php echo 10000000000-time()?>" size=12 maxlength=10 required> <a href='javascript:;' onclick="codedupcheck(document.all.it_id.value)"><img src='./img/btn_code.gif' border=0 align=absmiddle></a> -->
    <input type="hidden" name="it_id" value="<?php echo time(); ?>" id="it_id" required class="frm_input required" size="20" maxlength="20">
<?php } else { ?>
    <input type="hidden" name="it_id" value="<?php echo $it['it_id']; ?>">
<?php } ?>

<section id="anc_sitfrm_cate">
    <h2 class="h2_frm">분류</h2>


    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>상품분류 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="ca_id">기본분류</label></th>
            <td>
                <select name="ca_id" id="ca_id" onchange="categorychange(this.form)">
                    <option value="">선택하세요</option>
                    <?php echo conv_selected_option($category_select, $it['ca_id']); ?>
                </select>
                <script>
                    var ca_use = new Array();
                    var ca_stock_qty = new Array();
                    //var ca_explan_html = new Array();
                    var ca_sell_email = new Array();
                    var ca_opt1_subject = new Array();
                    var ca_opt2_subject = new Array();
                    var ca_opt3_subject = new Array();
                    var ca_opt4_subject = new Array();
                    var ca_opt5_subject = new Array();
                    var ca_opt6_subject = new Array();
                    <?php echo "\n$script"; ?>
                </script>
            </td>
        </tr>
        <?php for ($i=2; $i<=1; $i++) { ?>
        <tr>
            <th scope="row"><label for="ca_id<?php echo $i; ?>"><?php echo $i; ?>차 분류</label></th>
            <td>
                <?php echo help($i.'차 분류는 기본 분류의 하위 분류 개념이 아니므로 기본 분류 선택시 해당 상품이 포함될 최하위 분류만 선택하시면 됩니다.'); ?>
                <select name="ca_id<?php echo $i; ?>" id="ca_id<?php echo $i; ?>">
                    <option value="">선택하세요</option>
                    <?php echo conv_selected_option($category_select, $it['ca_id'.$i]); ?>
                </select>
            </td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</section>

<section id="anc_sitfrm_ini">
    <h2 class="h2_frm">기본정보</h2>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>기본정보 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_3">
        </colgroup>
        <tbody>

        <tr>
            <th scope="row"><label for="it_name">타이틀</label></th>
            <td colspan="2">
                <input type="text" name="it_name" value="<?php echo get_text(cut_str($it['it_name'], 250, "")); ?>" id="it_name" required class="frm_input required" size="95">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="it_origin">URL</label></th>
            <td>
                <input type="text" name="it_origin" value="<?php echo get_text($it['it_origin']); ?>" id="it_origin" class="frm_input" size="40">
            </td>
            <td class="td_grpset">
                <input type="checkbox" name="chk_ca_it_origin" value="1" id="chk_ca_it_origin">
                <label for="chk_ca_it_origin">분류적용</label>
                <input type="checkbox" name="chk_all_it_origin" value="1" id="chk_all_it_origin">
                <label for="chk_all_it_origin">전체적용</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="it_origin">모바일 URL</label></th>
            <td>
                <input type="text" name="it_brand" value="<?php echo get_text($it['it_brand']); ?>" id="it_brand" class="frm_input" size="40">
            </td>
            <td class="td_grpset">
                <input type="checkbox" name="chk_ca_it_origin" value="1" id="chk_ca_it_origin">
                <label for="chk_ca_it_origin">분류적용</label>
                <input type="checkbox" name="chk_all_it_origin" value="1" id="chk_all_it_origin">
                <label for="chk_all_it_origin">전체적용</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="it_basic">기본설명</label></th>
            <td>
                <input type="text" name="it_basic" value="<?php echo get_text(html_purifier($it['it_basic'])); ?>" id="it_basic" class="frm_input" size="95">
            </td>
            <td class="td_grpset">
                <input type="checkbox" name="chk_ca_it_basic" value="1" id="chk_ca_it_basic">
                <label for="chk_ca_it_basic">분류적용</label>
                <input type="checkbox" name="chk_all_it_basic" value="1" id="chk_all_it_basic">
                <label for="chk_all_it_basic">전체적용</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="it_maker">부가설명</label></th>
            <td>
                <input type="text" name="it_maker" value="<?php echo get_text($it['it_maker']); ?>" id="it_maker" class="frm_input" size="40">
            </td>
            <td class="td_grpset">
                <input type="checkbox" name="chk_ca_it_maker" value="1" id="chk_ca_it_maker">
                <label for="chk_ca_it_maker">분류적용</label>
                <input type="checkbox" name="chk_all_it_maker" value="1" id="chk_all_it_maker">
                <label for="chk_all_it_maker">전체적용</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="it_order">출력순서</label></th>
            <td>
                <?php echo help("숫자가 작을 수록 상위에 출력됩니다. 음수 입력도 가능하며 입력 가능 범위는 -2147483648 부터 2147483647 까지입니다.\n<b>입력하지 않으면 자동으로 출력됩니다.</b>"); ?>
                <input type="text" name="it_order" value="<?php echo $it['it_order']; ?>" id="it_order" class="frm_input" size="12">
            </td>
            <td class="td_grpset">
                <input type="checkbox" name="chk_ca_it_order" value="1" id="chk_ca_it_order">
                <label for="chk_ca_it_order">분류적용</label>
                <input type="checkbox" name="chk_all_it_order" value="1" id="chk_all_it_order">
                <label for="chk_all_it_order">전체적용</label>
            </td>
        </tr>
        <tr>
            <th scope="row">상품유형</th>
            <td>
                <?php echo help("메인화면에 유형별로 출력할때 사용합니다.\n이곳에 체크하게되면 상품리스트에서 유형별로 정렬할때 체크된 상품이 가장 먼저 출력됩니다."); ?>
                <input type="checkbox" name="it_type1" value="1" <?php echo ($it['it_type1'] ? "checked" : ""); ?> id="it_type1">
                <label for="it_type1">히트 <img src="<?php echo G5_SHOP_URL; ?>/img/icon_hit.gif" alt=""></label>
                <input type="checkbox" name="it_type2" value="1" <?php echo ($it['it_type2'] ? "checked" : ""); ?> id="it_type2">
                <label for="it_type2">추천 <img src="<?php echo G5_SHOP_URL; ?>/img/icon_rec.gif" alt=""></label>
                <input type="checkbox" name="it_type3" value="1" <?php echo ($it['it_type3'] ? "checked" : ""); ?> id="it_type3">
                <label for="it_type3">신상품 <img src="<?php echo G5_SHOP_URL; ?>/img/icon_new.gif" alt=""></label>
                <input type="checkbox" name="it_type4" value="1" <?php echo ($it['it_type4'] ? "checked" : ""); ?> id="it_type4">
                <label for="it_type4">인기 <img src="<?php echo G5_SHOP_URL; ?>/img/icon_best.gif" alt=""></label>
                <input type="checkbox" name="it_type5" value="1" <?php echo ($it['it_type5'] ? "checked" : ""); ?> id="it_type5">
                <label for="it_type5">할인 <img src="<?php echo G5_SHOP_URL; ?>/img/icon_discount.gif" alt=""></label>
            </td>
            <td class="td_grpset">
                <input type="checkbox" name="chk_ca_it_type" value="1" id="chk_ca_it_type">
                <label for="chk_ca_it_type">분류적용</label>
                <input type="checkbox" name="chk_all_it_type" value="1" id="chk_all_it_type">
                <label for="chk_all_it_type">전체적용</label>
            </td>
        </tr>




        </tbody>
        </table>
    </div>
</section>



<section id="anc_sitfrm_img">
    <h2 class="h2_frm">이미지</h2>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>이미지 업로드</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <?php for($i=1; $i<=2; $i++) { ?>
        <tr>
            <th scope="row"><label for="it_img<?php echo $i; ?>">이미지 <?php echo $i; ?></label></th>
            <td>
                <input type="file" name="it_img<?php echo $i; ?>" id="it_img<?php echo $i; ?>">
                <?php
                $it_img = G5_DATA_PATH.'/item/'.$it['it_img'.$i];
                $it_img_exists = run_replace('shop_item_image_exists', (is_file($it_img) && file_exists($it_img)), $it, $i);

                if($it_img_exists) {
                    $thumb = get_it_thumbnail($it['it_img'.$i], 25, 25);
                    $img_tag = run_replace('shop_item_image_tag', '<img src="'.G5_DATA_URL.'/item/'.$it['it_img'.$i].'" class="shop_item_preview_image" >', $it, $i);
                ?>
                <label for="it_img<?php echo $i; ?>_del"><span class="sound_only">이미지 <?php echo $i; ?> </span>파일삭제</label>
                <input type="checkbox" name="it_img<?php echo $i; ?>_del" id="it_img<?php echo $i; ?>_del" value="1">
                <span class="sit_wimg_limg<?php echo $i; ?>"><?php echo $thumb; ?></span>
                <div id="limg<?php echo $i; ?>" class="banner_or_img">
                    <?php echo $img_tag; ?>
                    <button type="button" class="sit_wimg_close">닫기</button>
                </div>
                <script>
                $('<button type="button" id="it_limg<?php echo $i; ?>_view" class="btn_frmline sit_wimg_view">이미지<?php echo $i; ?> 확인</button>').appendTo('.sit_wimg_limg<?php echo $i; ?>');
                </script>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</section>



<div class="btn_fixed_top">
    <a href="./itemlist.php?<?php echo $qstr; ?>" class="btn btn_02">목록</a>
    <a href="<?php echo shop_item_url($it_id); ?>" class="btn_02  btn">상품보기</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>
</form>


<script>
var f = document.fitemform;

<?php if ($w == 'u') { ?>
$(".banner_or_img").addClass("sit_wimg");
$(function() {
    $(".sit_wimg_view").bind("click", function() {
        var sit_wimg_id = $(this).attr("id").split("_");
        var $img_display = $("#"+sit_wimg_id[1]);

        $img_display.toggle();

        if($img_display.is(":visible")) {
            $(this).text($(this).text().replace("확인", "닫기"));
        } else {
            $(this).text($(this).text().replace("닫기", "확인"));
        }

        var $img = $("#"+sit_wimg_id[1]).children("img");
        var width = $img.width();
        var height = $img.height();
        if(width > 700) {
            var img_width = 700;
            var img_height = Math.round((img_width * height) / width);

            $img.width(img_width).height(img_height);
        }
    });
    $(".sit_wimg_close").bind("click", function() {
        var $img_display = $(this).parents(".banner_or_img");
        var id = $img_display.attr("id");
        $img_display.toggle();
        var $button = $("#it_"+id+"_view");
        $button.text($button.text().replace("닫기", "확인"));
    });
});
<?php } ?>

function codedupcheck(id)
{
    if (!id) {
        alert('상품코드를 입력하십시오.');
        f.it_id.focus();
        return;
    }

    var it_id = id.replace(/[A-Za-z0-9\-_]/g, "");
    if(it_id.length > 0) {
        alert("상품코드는 영문자, 숫자, -, _ 만 사용할 수 있습니다.");
        return false;
    }

    $.post(
        "./codedupcheck.php",
        { it_id: id },
        function(data) {
            if(data.name) {
                alert("코드 '"+data.code+"' 는 '".data.name+"' (으)로 이미 등록되어 있으므로\n\n사용하실 수 없습니다.");
                return false;
            } else {
                alert("'"+data.code+"' 은(는) 등록된 코드가 없으므로 사용하실 수 있습니다.");
                document.fitemform.codedup.value = '';
            }
        }, "json"
    );
}

function fitemformcheck(f)
{
    if (!f.ca_id.value) {
        alert("기본분류를 선택하십시오.");
        f.ca_id.focus();
        return false;
    }

    if (f.w.value == "") {
        var error = "";
        $.ajax({
            url: "./ajax.it_id.php",
            type: "POST",
            data: {
                "it_id": f.it_id.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                error = data.error;
            }
        });

        if (error) {
            alert(error);
            return false;
        }
    }

    if(f.it_point_type.value == "1" || f.it_point_type.value == "2") {
        var point = parseInt(f.it_point.value);
        if(point > 99) {
            alert("포인트 비율을 0과 99 사이의 값으로 입력해 주십시오.");
            return false;
        }
    }

    if(parseInt(f.it_sc_type.value) > 1) {
        if(!f.it_sc_price.value || f.it_sc_price.value == "0") {
            alert("기본배송비를 입력해 주십시오.");
            return false;
        }

        if(f.it_sc_type.value == "2" && (!f.it_sc_minimum.value || f.it_sc_minimum.value == "0")) {
            alert("배송비 상세조건의 주문금액을 입력해 주십시오.");
            return false;
        }

        if(f.it_sc_type.value == "4" && (!f.it_sc_qty.value || f.it_sc_qty.value == "0")) {
            alert("배송비 상세조건의 주문수량을 입력해 주십시오.");
            return false;
        }
    }

    // 관련상품처리
    var item = new Array();
    var re_item = it_id = "";

    $("#reg_relation input[name='re_it_id[]']").each(function() {
        it_id = $(this).val();
        if(it_id == "")
            return true;

        item.push(it_id);
    });

    if(item.length > 0)
        re_item = item.join();

    $("input[name=it_list]").val(re_item);

    // 이벤트처리
    var evnt = new Array();
    var ev = ev_id = "";

    $("#reg_event_list input[name='ev_id[]']").each(function() {
        ev_id = $(this).val();
        if(ev_id == "")
            return true;

        evnt.push(ev_id);
    });

    if(evnt.length > 0)
        ev = evnt.join();

    $("input[name=ev_list]").val(ev);

    <?php echo get_editor_js('it_explan'); ?>
    <?php echo get_editor_js('it_mobile_explan'); ?>
    <?php echo get_editor_js('it_head_html'); ?>
    <?php echo get_editor_js('it_tail_html'); ?>
    <?php echo get_editor_js('it_mobile_head_html'); ?>
    <?php echo get_editor_js('it_mobile_tail_html'); ?>

    return true;
}

function categorychange(f)
{
    var idx = f.ca_id.value;

    if (f.w.value == "" && idx)
    {
        //f.it_use.checked = ca_use[idx] ? true : false;
        f.it_stock_qty.value = ca_stock_qty[idx];
        f.it_sell_email.value = ca_sell_email[idx];
    }
}

categorychange(document.fitemform);
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
