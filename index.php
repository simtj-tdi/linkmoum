<?php
include_once('./_common.php');

define("_INDEX_", TRUE);

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/index.php');
    return;
}

include_once(G5_SHOP_PATH.'/shop.head.php');


?>
    <div class="header">
        <div class="container">
            <a href="/">2020 신규 웹하드 순위 TOP 12</a>
        </div>
    </div>
    <div class="container">
        <div class="row pl-0 pr-0">
            <?php
                $ca_id = "mi";
                $sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' and ca_use = '1'  ";
                $ca = sql_fetch($sql);

                // 스킨경로
                $skin_dir = G5_SHOP_SKIN_PATH;

                if($ca['ca_skin_dir']) {
                    if(preg_match('#^theme/(.+)$#', $ca['ca_skin_dir'], $match))
                        $skin_dir = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
                    else
                        $skin_dir = G5_PATH.'/'.G5_SKIN_DIR.'/shop/'.$ca['ca_skin_dir'];

                    if(is_dir($skin_dir)) {
                        $skin_file = $skin_dir.'/'.$ca['ca_skin'];

                        if(!is_file($skin_file))
                            $skin_dir = G5_SHOP_SKIN_PATH;
                    } else {
                        $skin_dir = G5_SHOP_SKIN_PATH;
                    }
                }

                // 리스트 스킨
                $skin_file = $skin_dir.'/main.skin.php';

                $order_by = 'it_order, it_id desc';

                $list = new item_list($skin_file, $ca['ca_list_mod'], $ca['ca_list_row'], $ca['ca_img_width'], $ca['ca_img_height']);
                $list->set_category($ca['ca_id'], 1);
                $list->set_category($ca['ca_id'], 2);
                $list->set_category($ca['ca_id'], 3);
                $list->set_is_page(true);
                $list->set_order_by($order_by);
                $list->set_from_record($from_record);
                $list->set_view('it_img', true);
                $list->set_view('it_id', false);
                $list->set_view('it_name', true);
                $list->set_view('it_basic', true);
                $list->set_view('it_cust_price', true);
                $list->set_view('it_price', true);
                $list->set_view('it_icon', true);
                $list->set_view('sns', true);
            ?>

            <div class="col-md-12 m-0 p-0 mt-1 d-flex flex-wrap">
                <?php
                    echo $list->run();
                ?>
            </div>

        </div>
    </div>


<?php
include_once(G5_SHOP_PATH.'/shop.tail.php');
?>