<!DOCTYPE HTML>
<html>
   <head>
      <?php $this -> load -> view("www/includes/head.php")?>
      <link href="<?php echo ASSETS_URL ?>/www/css/page.css" rel="stylesheet" type="text/css">
   </head>
   <body>
      <?php $this -> load -> view("www/includes/header.php")?>
      <section class="page_container">
         <div class="page_content">
            <img src="<?php echo ASSETS_URL ?>/www/images/left_img1.png" alt="" class="left_img">
            <div class="page_mtitle">News<b>最新消息</b></div>
            <?php if(isset($row)):?>

            <div class="inner_content">
               <div class="news_header">
                  <div class="news_detail_title"><?php echo $row["subject"]?></div>
                  <div>
                     <span class="active_tag org_tag">最新消息</span>
                     <span class="news_detail_date"><?php echo date('Y.m.d',strtotime($row["buildtime"]))?></span>
                  </div>
               </div>
               <div class="news_detail_txt">
                 <?php echo $row["word"]?>
               </div>
            </div>
            <?php endif;?>

            <!--inner_content end-->
            <img src="<?php echo ASSETS_URL ?>/www/images/right_img1.png" alt="" class="right_img">
            <div class="page_line"></div>
            <a href="<?php echo site_url('News')?>" class="back_btn"><i class="fa fa-angle-left" aria-hidden="true"></i>回列表</a>
         </div>
      </section>
      <?php $this -> load -> view("www/includes/footer.php")?>
   </body>
</html>
