<?php
/**
 * MWB-SEO
 * copyright NoamdHaan@gmail.com
 * Licensed under MIT
 */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $mwbseo['seo_google_analytics'] ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo $mwbseo['seo_google_analytics'] ?>');
</script>
