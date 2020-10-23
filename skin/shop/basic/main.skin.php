<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


?>

<?php
$i=0;
    foreach((array) $list as $row){

        if( empty($row) || $i >= $ca['ca_1'] ) continue;
        $i++;

        ?>
        <div class="col-12 col-md-4 px-1 mb-1">
            <div class="list" onclick="window.open('<?php echo $row['it_origin'];?>')">
                <div class="list-title"><span><?php echo $i;?>위. <?php echo stripslashes($row['it_name']);?></span></div>
                <div class="list-img my-1">
                    <?php echo get_it_image($row['it_id'], "200", "100", '', '', stripslashes($row['it_name']), $row['it_origin']); ?>
                </div>
                <?php echo item_icon($row); ?>
                <div class="list-point mt-1"><?php echo stripslashes($row['it_basic']);?></div>
                <div class="list-text" style="height: 120px; overflow: hidden; ">
                    <?php echo $row['it_explan']; ?>
                </div>
                <div class="list-btn" style="margin-top: 20px;" ><?php echo stripslashes($row['it_name']);?> 바로가기</div>
            </div>
        </div>

<?php } ?>

