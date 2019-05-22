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
          <div class="inner_content">
            <div class="news_list">
              <?php foreach($newsList as $row):?>
              <div class="news_unit">
                <a href="<?php echo site_url("News/detail") . "?num=" . $row["num"] ?>">
                  <div class="news_top">
                    <span class="active_tag org_tag">最新消息</span>
                    <span class="news_date"><i class="icon-clock"></i><?php echo date('Y.m.d',strtotime($row["buildtime"]))?></span>
                  </div>
                  <div class="news_title"><?php echo $row["subject"]?></div>
                </a>
              </div>
              <?php endforeach;?>
            </div>
          </div>

          <img src="<?php echo ASSETS_URL ?>/www/images/right_img1.png" alt="" class="right_img">
          <div class="page_line"></div>
          <!-- 
          <div class="page_btn">
            <a href="#"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
            <ul>
              <li><a href="#" class="select">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li><a href="#">6</a></li>
              <li><a href="#">7</a></li>
              <li><a href="#">8</a></li>
            </ul>
            <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
          </div> -->
        </div>
      </section>

      <?php $this -> load -> view("www/includes/footer.php")?>
   </body>
</html>
