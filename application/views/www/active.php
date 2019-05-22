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
		 <div class="activebox">
	<div class="row no-gutters">
		<div class="col-12 contentHeaderText">
			<div>優惠活動</div>
			<span>PREFERENTIAL</span>
		</div>
	</div>
	<div class="container">
		<div class="row dis-f-c">
			<div class="col-lg-10 col-md-12">
				<div class="activity">
					<?php if(isset($activeList)):?>
					<?php foreach($activeList as $keys=>$row):?>
					<div class="toggle activity_banner mb-3">
						<div class="b_img a_pic"><img src="<?php echo UPLOADS_URL?>/active/<?php echo $row["pic1"]?>" style=" max-width: 100%;"></div>
						<div class="info">
							<div>
								<h3><?php echo $row["subject"]?></h3>
								<h4>活動說明</h4>
								<?php echo $row["word"]?>
							</div>
						</div>
					</div>
					<?php endforeach;?>
					<?php endif;?>

					<div class="selection">
					</div>
							</div>
						</div>
					</div>
				</div>
			</div> 
		 </div>
		
      <!--   <div class="page_content">
            <img src="<?php echo ASSETS_URL ?>/www/images/left_img1.png" alt="" class="left_img">
            <div class="page_mtitle">Activity<b>優惠活動</b></div>
            <div class="inner_content">
               <?php if(isset($activeList)):?>
               <div class="active_list">
                  <?php foreach($activeList as $keys=>$row):?>
                  <div class="active_unit">
                     <a href="<?php echo site_url("Active/detail") . "?num=" . $row["num"] ?>">
                        <div class="active_date">
                           <span><i><?php echo date('d',strtotime($row["buildtime"]))?></i><em><?php echo date('M',strtotime($row["buildtime"]))?></em></span>
                           <b><?php echo date('Y',strtotime($row["buildtime"]))?></b>
                        </div>
                        <div class="active_right">
                           <span class="active_tag org_tag">優惠活動</span>
                           <div class="active_title"><?php echo $row["subject"]?></div>
                           <?php if($row["pic1"]!=''):?>
                           <div class="active_image"><img src="<?php echo UPLOADS_URL.'/active/'.$row["pic1"]?>" alt=""></div>
                           <?php endif;?>                   
                        </div>
                     </a>
                  </div>
                  <?php endforeach;?>
               </div>
               <?php endif;?>                   
            </div>

 <img src="<?php echo ASSETS_URL ?>/www/images/right_img1.png" alt="" class="right_img">
            <div class="page_line"></div>

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
            </div> 
      
 </div>-->
 
 
 <script>
	$(document).ready(function() {
		$('.toggle').click(function() {
			$(this).find('.info').slideToggle("slow");
		});
	});
</script>

      </section>
      <?php $this -> load -> view("www/includes/footer.php")?>
   </body>
</html>
