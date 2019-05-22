<!DOCTYPE HTML>
<html>
   <head>
      <?php $this -> load -> view("www/includes/head.php")?>
      <link href="<?php echo ASSETS_URL ?>/www/css/page.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="<?php echo ASSETS_URL?>/www/css/member.css" />
        <script type="text/javascript" src="<?php echo ASSETS_URL?>/www/js/transfer.js"></script>
      <script type="text/javascript">
        $(function(){
        $('.payment').click(function(){
            $('#down-alert').hide();
            if($(this).attr('data-payment')=='Credit'){
              $("#down-alert").fadeToggle();
              $('#depositForm').prop('target','_blank');
            }else{
              $('#depositForm').prop('target','_self');
            }
          });
          
        });
      </script>
   </head>
   <body>
      <?php $this -> load -> view("www/includes/header.php")?>
      <section class="page_container">
         <div class="page_content">
            <img src="images/left_img1.png" alt="" class="left_img">
            <div class="page_mtitle">Member<b>會員中心</b></div>
            <div class="inner_content">
               <?php $this -> load -> view("www/includes/member_nav.php")?>
               
               
<div class="inner" id="memberUser">
	<div class="register_bg">
		<div class="registerBg"></div>

		<div class="memberInfo">
			<table class="table table-striped history member_table member_record">
				<thead>
				<tr>
					<th>時 間</th>
					<th>類 型</th>
					<th>金 額 </th>
				</tr>
				</thead>
				<tbody>
				<?php if(isset($result)):?>
				<?php foreach($result as $row):?>
				<tr>
					<td><?php echo $row["buildtime"]?></td>
					<td>
						<?php echo tb_sql("kind","wallet_kind",$row["kind"])?>
						<?php if($row['kind'] == 3 || $row['kind']==4):	//轉出轉入遊戲?>
							<p class="w1"><?php echo ($row['kind']==3 ?'轉入' :'轉出').tb_sql("makers_name","game_makers",$row['makers_num'])?></p>
							<p class="red">剩餘點數：<?php echo number_format($row["makers_balance"],2,'.',',')?></p>
						<?php endif;?>
					</td>
					<td>
						<p class="<?php echo ($row["points"] < 0 ?  'red' : 'text-success')?>"> <?php echo number_format($row["points"],0)?> </p>
					</td>
				</tr>
				<?php endforeach;?>
				<?php endif;?>
				</tbody>
			</table>
		</div>
		<div class="text-center">
			<?php echo @$pagination ?>
		</div>
	</div>
</div>


            <!--inner_content end-->
            <img src="images/right_img1.png" alt="" class="right_img">
         </div>
      </section>
      <!-- Footer -->
      <?php $this -> load -> view("www/includes/footer.php")?>
   </body>
</html>