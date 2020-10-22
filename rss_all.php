<?php
// RSS 전체게시판 사용 (전체최신글 사용) - GIT(www.g-it.kr) 
//include_once('./_common.php');
include_once('../../../common.php');
$lines = "10";  // 게시글수


// 특수문자 변환
function specialchars_replace($str, $len=0) {
    if ($len) {
        $str = substr($str, 0, $len);
    }

    $str = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $str);

    /*
    $str = preg_replace("/&/", "&amp;", $str);
    $str = preg_replace("/</", "&lt;", $str);
    $str = preg_replace("/>/", "&gt;", $str);
    */

    return $str;
}

header('Content-type: text/xml');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
echo "<channel>\n";
echo "<title>".specialchars_replace("{$config['cf_title']} > 에서 최근에 올라온 콘텐츠 입니다")."</title>\n";
echo "<link>".specialchars_replace(G5_URL)."</link>\n";
echo "<description>테스트 버전 0.2 (2004-04-26)</description>\n";
echo "<language>ko</language>\n";
?>

<?php
/*
게시판에서 rss체크 되것만 불러올때
$sql = " select a.*, b.* from {$g5['board_new_table']} a, {$g5['board_table']} b 
                where a.bo_table = b.bo_table 
					 and a.wr_id = a.wr_parent
					 and b.bo_use_search = '1'
                     and b.bo_list_level <= '{$member['mb_level']}'
                     and b.bo_use_rss_view = '1'
                order by a.bn_id desc limit 0, $lines ";
*/
$sql = " select a.*, b.* from {$g5['board_new_table']} a, {$g5['board_table']} b 
                where a.bo_table = b.bo_table 
					 and a.wr_id = a.wr_parent
					 and b.bo_use_search = '1'
                     and b.bo_list_level <= '{$member['mb_level']}'
                order by a.bn_id desc limit 0, $lines ";
$result = sql_query($sql);

for ($i=0; $rows = sql_fetch_array($result); $i++) {
    $row = sql_fetch(" select wr_id, wr_subject, wr_content, wr_name, wr_datetime, wr_option
                        from " .$g5['write_prefix'].$rows['bo_table']. "
						where wr_id = '{$rows['wr_id']}' 
                              and wr_is_comment = 0
                              and wr_option not like '%secret%'	");
	
	$file = "";

	if (strstr($row['wr_option'], 'html'))
        $html = 1;
    else
        $html = 0;
?>

	<item>
	<title><?php echo specialchars_replace($row['wr_subject']) ?></title>
	<link><?php echo specialchars_replace(G5_BBS_URL.'/board.php?bo_table='.$rows['bo_table'].'&wr_id='.$row['wr_id']) ?></link>
	<description><![CDATA[<?php echo $file ?><?php echo conv_content($row['wr_content'], $html) ?>]]></description>
	<dc:creator><?php echo specialchars_replace($row['wr_name']) ?></dc:creator>
	<?php
	$date = $row['wr_datetime'];
	// rss 리더 스킨으로 호출하면 날짜가 제대로 표시되지 않음
	//$date = substr($date,0,10) . "T" . substr($date,11,8) . "+09:00";
	$date = date('r', strtotime($date));
	?>
	<dc:date><?php echo $date ?></dc:date>
	</item>

<?php
} // for end

echo '</channel>'."\n";
echo '</rss>'."\n";
?>