<!DOCTYPE HTML>
<html>
   <head>
      <?php $this -> load -> view("www/includes/head.php")?>
      <link href="<?php echo ASSETS_URL ?>/www/css/page.css" rel="stylesheet" type="text/css">
   </head>
   <body>
      <?php $this -> load -> view("www/includes/header.php")?>
      <section class="page_container esport_container">
         <div class="page_content">
            <div class="page_mtitle">捕魚<b>遊戲</b></div>
            <div class="inner_content">

            <div class="game_seo">
               <p>捕魚游戲提供多款遊戲砲台和子彈，將形形色色不同幣值的魚兒收入囊中！您選擇的砲台將決定您的火力和賭注倍數，隨機出現的幸運美人魚特色轉盤還將增加你的獎金！
               讓您輕鬆暢快地在汪洋深海中捕獲各類魚群，與各地的玩家聚集在一起一比高下，成為最高贏家還能獲得額外豐厚獎勵噢！一同來參戰吧……</p>
            </div>

               <div class="game_list">
                
				
				  
				  <!--PS-->
				  <!--<div class="game_unit">
                     <div class="game_img imgLiquidFill imgLiquid">
                        <img src="<?php echo ASSETS_URL?>/www/images/game/game_ps.png" alt="">
                     </div>
                     <div class="game_title">PS</div>
                     <a href="javascript:void(0);" onclick="javascript:alert('即將上線，敬請期待');" class="game_btn">進入遊戲<i class="fa fa-caret-right"></i></a>
                  </div> -->
				  
				  
				   <div class="game_unit">

                     <div class="game_img imgLiquidFill imgLiquid">
                        <img src="<?php echo ASSETS_URL?>/www/images/game/fish-penhfun.jpg" alt="">
                     </div>
                     <div class="game_title">RTG 捕魚</div>
                     <a href="<?php echo site_url("Opengame?gm=51&GameCode=2162689")?>"  class="game_btn" target="_blank">進入遊戲<i class="fa fa-caret-right"></i></a>
               </div>

				  <div class="game_unit">
                     <div class="game_img imgLiquidFill imgLiquid">
                        <img src="<?php echo ASSETS_URL?>/www/images/game/fish2.jpg" alt="">
                     </div>
                     <div class="game_title">EG爆金捕魚</div>
                     <a href="<?php echo site_url("Opengame?gm=64")?>"  class="game_btn" target="_blank">進入遊戲<i class="fa fa-caret-right"></i></a>
                     </div>
               </div>
                       
            </div>
            <!--inner_content end-->
         </div>
      </section>
      <?php $this -> load -> view("www/includes/footer.php")?>
   </body>
</html>