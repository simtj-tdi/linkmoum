<?php
/**
 * MWB-SEO
 * copyright NoamdHaan@gmail.com
 * Licensed under MIT
 */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<!-- MWB-SEO 채널 설정 ld+json 방식 대신 적용-->
<span itemscope="" itemtype="http://schema.org/Organization">
    <link itemprop="url" href="https://www.goobeegoobee.com">
    <?php if($mwbseo['seo_facebook_id']) { ?>
    <a itemprop="sameAs" href="https://www.facebook.com/<?php echo $mwbseo['seo_facebook_id'] ?>"></a>
    <?php } ?>
    <?php if($mwbseo['seo_instagram_id']) { ?>
    <a itemprop="sameAs" href="https://www.instagram.com/<?php echo $mwbseo['seo_instagram_id'] ?>"></a>
    <?php } ?>
    <?php if($mwbseo['seo_naverblog_id']) { ?>
    <a itemprop="sameAs" href="https://blog.naver.com/<?php echo $mwbseo['seo_naverblog_id'] ?>"></a>
    <?php } ?>
    <?php if($mwbseo['seo_navercafe_id']) { ?>
    <a itemprop="sameAs" href="https://www.twitter.com/<?php echo $mwbseo['seo_navercafe_id'] ?>"></a>
    <?php } ?>
    <?php if($mwbseo['seo_twitter_id']) { ?>
    <a itemprop="sameAs" href="https://www.twitter.com/<?php echo $mwbseo['seo_twitter_id'] ?>"></a>
    <?php } ?>
</span>