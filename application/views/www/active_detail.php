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
         <div class="page_mtitle">Activity<b>活動訊息</b></div>
         <?php if(isset($row)):?>
         <div class="inner_content">
            <div class="active_header">
               <!-- <div><a href="" class="apply_btn">我要申請 <i></i></a></div> -->
               <div style="width: 100%">
                  <div>
                     <span class="active_tag org_tag">優惠活動</span>
                     <span class="active_detail_date"><i class="icon-clock"></i><?php echo date('Y.m.d',strtotime($row["buildtime"]))?></span>
                     <?php if($row["selltime1"] ||$row["selltime2"] ):?>
                     <span class="active_dateEnd"> / 活動期間：
                        <?php echo $row["selltime1"] ? date('Y.m.d',strtotime($row["selltime1"])) : "" ?>
                        <?php echo $row["selltime2"] ? "~" . date('Y.m.d',strtotime($row["selltime2"])) : "" ?></span>
                     <?php endif;?>
                  </div>
                  <div class="active_detail_title"><?php echo $row["subject"]?></div>
                  <?php if($row["pic1"]!=''):?>
                     <div class="active_detail_image"><img src="<?php echo UPLOADS_URL.'/active/'.$row["pic1"]?>" alt=""></div>
                  <?php endif;?>
               </div>
            </div>
            <div class="active_detail_txt">
               <?php echo $row["word"]?>
            </div>
         </div>
         <?php endif;?>
         <!--inner_content end-->
         <img src="<?php echo ASSETS_URL ?>/www/images/right_img1.png" alt="" class="right_img">
         <div class="page_line"></div>
         <div class="act_btn">
            <a href="<?php echo site_url('Active')?>" class="back_btn"><i class="fa fa-angle-left" aria-hidden="true"></i>回列表</a>
         </div>
      </div>
   </section>
      <?php $this -> load -> view("www/includes/footer.php")?>
   </body>
</html>
