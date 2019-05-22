<footer class="footer_box">
    <div class="partner hidden-xs">
        <div class="container">
            <ul>
                <li><img src="<?php echo ASSETS_URL?>/www/images/partner_pic1.png" alt=""></li>
                <li><img src="<?php echo ASSETS_URL?>/www/images/partner_pic2.png" alt=""></li>
                <li><img src="<?php echo ASSETS_URL?>/www/images/partner_pic3.png" alt=""></li>
                <li><img src="<?php echo ASSETS_URL?>/www/images/partner_pic4.png" alt=""></li>
            </ul>
        </div>
    </div>
    <!-- partner end -->
    <div class="footer_menu d-mm-none">
        <ul>
            <li><a href="index.html">首頁</a>｜</li>
            <li><a href="<?php echo site_url("Guide?kind=1")?>">關於我們</a>｜</li>
            <li><a href="<?php echo site_url("Guide?kind=2")?>">儲值教學</a>｜</li>
            <li><a href="<?php echo site_url("Guide?kind=3")?>">責任博彩</a>｜</li>
            <li><a href="<?php echo site_url("Guide?kind=4")?>">遊戲幫助</a>｜</li>
            <li><a href="<?php echo site_url("Guide?kind=5")?>">隱私保護</a>｜</li>
            <li><a href="<?php echo site_url("Guide?kind=6")?>">規則條款</a>｜</li>
            <li><a href="<?php echo site_url("Guide?kind=7")?>">合營代理</a>｜</li>
        </ul>
    </div>
    <!-- footer_menu end -->
    <div class="copyright">Copyright &copy; 2017 All rights reserved</div>
    <!-- copyright end -->
</footer>
<!--footer end-->

<!-- Body JS  -->
<!--<div class="side_service"><a class="btn" href="javascript:openwindow('http://kefu.ziyun.com.cn/vclient/chat/?websiteid=139073')"></a></div>-->


<!-- <a href="javascript:openwindow('https://line.me/ti/p/@geo6903t')">
	<div class="livechat-girl animated"> <img class="girl" src="<?php echo ASSETS_URL ?>/www/images/en_3.png">
	  <div class="livechat-hint rd-notice-tooltip rd-notice-type-success rd-notice-position-left single-line show_hint">
		<div class="rd-notice-content">客服LINE ID: @geo6903t</div>
	  </div>
	  <div class="animated-circles">
		<div class="circle c-1"></div>
		<div class="circle c-2"></div>
		<div class="circle c-3"></div>
	  </div>
	</div>
</a> -->

<div class="OnlineService_Bg">
	<div class="OnlineService_Box">
		<!-- <ul class="OnlineService_QQBox"><li><a target="_blank" rel="nofollow" href="http://sc.chinaz.com/">站长素材</a></li></ul> -->
		<!-- <div class="OnlineService_Phone"><a href="http://kefu.ziyun.com.cn/vclient/chat/?websiteid=147244&wc=43adf3" target="_blank">在線客服</a></div>
		<div class="OnlineService_Sign"><a href="https://line.me/ti/p/@geo6903t" target="_blank">LINE客服</a></div> -->
		<div class="OnlineService_Top"><a href="#">返回頂部</a></div>
	</div>
</div>

<div class="suspend">
	<dl>
		<dt class="IE6PNG">在線客服<i class="fas fa-sms"></i></dt>
		<dd class="suspendQQ"><a href="<?php echo site_url("Guide?kind=7")?>" target="_blank"><i class="fas fa-user-alt"></i><span>合營代理</span></a></dd>
		<dd class="suspendTel"><a href="#" target="_blank"><i class="fas fa-headphones"></i><span>SERVICE</span></a></dd>
		<dd class="suspendTe2"><a href="#" target="_blank"><i class="fab fa-line"></i><span>######</span></a></dd>
	</dl>
</div>

<div class="suspend2 ">
	<dl>
		<dt class="IE6PNG" id="timeop">維修時間<i class="fas fa-business-time"></i></dt>
		<dd class="suspendQQ">
		<h6>星期一</h6>
		<ul class="list-none">
					<li><span>沙龍真人</span><br>11:00-13:30</li>
					<li><span>WM真人</span><br>12:00-14:30</li>
					<li><span>SUPER體育</span><br>12:00-16:30</li>
					<li><span>六合彩球</span><br>12:00-16:00</li>
		</ul>
		</dd>
		
		<dd class="suspendTel">
		<h6>星期三</h6>
		<ul class="list-none">
					<li><span>DG真人</span><br>07:30-09:30</li>
					<li><span>歐博真人</span><br>08:00-12:00</li>
					<li><span>EG捕魚</span><br>09:00-11:00</li>
				</ul>
		</dd>
	</dl>
</div>


<script type="text/javascript">           
	$(document).ready(function(){

		//$(".suspend").mouseover(function() {
			//		$(this).stop();
			//		$(this).animate({width: 160}, 400);
		//	})
		
		//	$(".suspend").mouseout(function() {
		//			$(this).stop();
		//			$(this).animate({width: 40}, 400);
		//	});
		


		$(".suspend").click(function(){
				$(".suspend").toggleClass("show2");
			});
		$("#timeop").click(function(){
				$(".suspend2").toggleClass("show3");
			});
	


	});
</script>

<style>

</style>


<div class="m_ft d-md-none" >
	<div class="row">
	
		<div class="col">
			<a href="https://line.me/ti/p/@geo6903t">
				<i class="fas fa-headset issq" ></i>
				<div>客服</div>
			</a>
		</div>

		<!----登入前---->
		<?php if (!$isLogin): ?>
		<div class="col">
			<a href="<?php echo site_url("Active")?>">
				<i class="fas fa-gift issq" ></i>
				<div>優惠</div>
			</a>
		</div>
		<div class="col" style="margin: auto;">
			<a href="<?php echo site_url() ?>">
				<div style="font-size: 30px;color: #fff;"><i class="fa fa-home" aria-hidden="true"></i></div>
			</a>
		</div>
		<div class="col">
			<a class="login" href="#login_dialog" >
				<i class="fas fa-sign-in-alt issq" ></i>
				<div>登入</div>
			</a>
		</div>
		<div class="col">
			<a href="<?php echo site_url('Manger/register') ?>">
				<i class="fa fa-user issq"></i>
				<div>註冊</div>
			</a>
		</div>
		
		<!----登入後---->
		<?php  else: ?>
		<div class="col">
			<a href="<?php echo site_url("Manger/deposit") ?>">
				<i class="fas fa-dollar-sign issq" ></i>
				<div>儲值</div>
			</a>
		</div>
		<div class="col" style="margin: auto;">
			<a href="<?php echo site_url() ?>">
				<div style="font-size: 30px;color: #fff;"><i class="fa fa-home" aria-hidden="true"></i></div>
			</a>
		</div>
		<div class="col">
			<a href="<?php echo site_url('Manger/account') ?>">
				<i class="far fa-id-badge issq" ></i>
				<div>會員</div>
			</a>
		</div>
		<div class="col">
			<a href="<?php echo site_url('Index/logout') ?>">
				<i class="fas fa-sign-out-alt issq"></i>
				<div>登出</div>
			</a>
		</div>

		<?php endif; ?>
	</div>
</div>


<?php $this -> load -> view("www/includes/body_js.php")?>

		

