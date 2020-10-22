<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_MOBILE_PATH.'/head.php');

?>

    <script src="<?php echo G5_JS_URL; ?>/swipe.js"></script>
    <script src="<?php echo G5_JS_URL; ?>/shop.mobile.main.js"></script>

<!--    <div>-->
<!--        <ul class="hbox-menu">-->
<!--            <li><a href="http://google.com" target="_blank">google</a></li>-->
<!--            <li><a href="http://naver.com" target="_blank">naver</a></li>-->
<!--            <li><a href="http://daum.net" target="_blank">daum</a></li>-->
<!--            <li><a href="http://nate.com" target="_blank">nate</a></li>-->
<!--            <li><a href="http://zum.co.kr" target="_blank">zum</a></li>-->
<!--            <li><a href="http://www.youtube.com" target="_blank">youtube</a></li>-->
<!--            <li><a href="http://www.instagram.com" target="_blank">instagram</a></li>-->
<!--            <li><a href="http://www.facebook.com" target="_blank">facebook</a></li>-->
<!--            <li><a href="http://twitter.com" target="_blank">twitter</a></li>-->
<!--        </ul>-->
<!--    </div>-->
    <div id="category"  >
        <div class="ct_wr" >
            <?php
            $mshop_ca_res1 = sql_query(get_mshop_category('', 2));

            for($i=0; $mshop_ca_row1=sql_fetch_array($mshop_ca_res1); $i++) {
                if($i == 0)
                    echo '<ul class="cate" style="">'.PHP_EOL;
                ?>
                <li class="cate_li_1" style="text-align: center; width: 100%; " >
                <a href="<?php echo shop_category_url($mshop_ca_row1['ca_id']); ?>" class="cate_li_1_a"><?php echo get_text($mshop_ca_row1['ca_name']); ?></a>
                <?php
                if (!empty($mshop_ca_row1['ca_1'])) {
                    $limits = " limit 0, " . $mshop_ca_row1['ca_1'];
                } else {
                    $limits = "";
                }

                $mshop_ca_res2_sql = " select * from `{$g5['g5_shop_item_table']}` where it_use = '1' and ca_id like '{$mshop_ca_row1['ca_id']}%'  order by it_order, it_id desc". $limits;
                $mshop_ca_res2_result = sql_query($mshop_ca_res2_sql);
                $ii = 0;
                for($j=0; $mshop_ca_row2=sql_fetch_array($mshop_ca_res2_result); $j++) {

                    if($j == 0)
                        echo '<ul class=" sub_cate1">'.PHP_EOL;

                        $item_link = $mshop_ca_row2['it_brand'] ? $mshop_ca_row2['it_brand'] : $mshop_ca_row2['it_origin'];
                    ?>
                    <li class="cate_li_2" style="float:left; width: 33.3%">
                        <a href="<?php echo $item_link; ?>" target="_blank"><?php echo $mshop_ca_row2['it_name']; ?></a>
                    </li>
                    <?php


                    $ii++;
                }
                if ($ii%3 > 0) {
                    for ($y=0; $y<3-($ii%3); $y++) {
                        ?>
                        <li class="cate_li_2" style="float:left;width: 33.3%; " >
                            <a href="" target="_blank">&nbsp;</a>
                        </li>
                        <?php
                    }
                }

                if($j > 0)
                    echo '</ul>'.PHP_EOL;
                ?>
                </li>
                <?php
            }
            echo '</ul>'.PHP_EOL;
            ?>
        </div>
    </div>

    <script>
        $("#container").addClass("idx-container");
    </script>


<?php
include_once(G5_MOBILE_PATH.'/tail.php');
?>