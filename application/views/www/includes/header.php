<header class="header_box">
   <div class="top">
   <a class="navbar-brand logo" href="<?php echo site_url()?>"><img src="<?php echo ASSETS_URL ?>/www/images/logo.png" alt=""></a>
      <?php if (isset( $isLogin ) && !$isLogin):  //登入前?>
      <div class="container">
         <a class="login logina" href="#login_dialog" ><span><i class="fas fa-sign-in-alt" ></i>會員登入</span></a>
         <div class="hidden">
            <div class="modall" id="login_dialog">
               <div class="login_dialog_title">
                  <span><img src="<?php echo ASSETS_URL ?>/www/images/index2/vip.png" alt="" style="width: 200px;"></span>
                  <span>會員登入</span>
               </div>
               <form  id="LoginForm" class="form-horizontal login_dialog_form" method="post">
                  <div class="form-group">
                     <div class="col-xs-12">
												<input type="hidden" name="rtn" id="rtn">
                        <input type="text"  id="login_u_id" name="login_u_id" class="form-control clearVal" placeholder="帳號">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-xs-12">
                        <input type="password" class="form-control login_u_password" id="login_u_password" placeholder="密碼">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-xs-8 col-sm-8 col-md-8">
                        <input type="number" class="form-control" id="chknum" placeholder="驗證碼">
                     </div>
                     <div class="col-xs-4 col-sm-4 col-md-4 code_pic">
                        <img id="chkImg" style="cursor: pointer" src="<?php echo site_url("Vcode2") ?>?token=<?php echo $token ?>" class="img-fluid" alt="刷新驗證碼" onclick="changeChkImg()">
                     </div>
                  </div>
                  <div class="login_link">
                     <a href="<?php echo site_url("Forget") ?>">忘記密碼</a>|<a href="<?php echo site_url("Manger/register") ?>">加入會員</a>
                  </div>
                  <div class="form-group">
                     <div class="page_form_btn">
                        <button type="submit" class="btn btn-primary" onclick="doLogin('LoginForm')">登入</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <!--login_dialog end-->
         <a href="<?php echo site_url("Manger/register") ?>" class="jonina"><span><i class="fa fa-user" style="color: black;"></i>免費註冊</span></a>
         <!--<select class="selectpicker" data-width="fit" data-style="btn-select">
            <option data-content='<span class="flag-icon flag-icon-tw"></span> 繁體中文'>繁體中文</option>
            <option data-content='<span class="flag-icon flag-icon-cn"></span> 簡体中文'>簡体中文</option>
            <option data-content='<span class="flag-icon flag-icon-us"></span> English'>English</option>
         </select> -->
      </div>
      <?php else: ?>
      <div class="loginfont container ">
          <span class="user_name"><?php echo $user_info[ "u_name" ] ?>，歡迎光臨～</span>
			<br>
          <ul class="top_user_info">
              <li><i class="icon-shopping-bag"></i>剩餘點數：<a href="<?php echo site_url("Manger/deposit") ?>"><?php echo number_format($user_info[ 'WalletTotal' ], 0) ?>點</a></li>
              <li><a href="<?php echo site_url("Manger/account") ?>"><i class="fa fa-user"></i>會員中心</a></li>
              <li><a href="<?php echo site_url("Index/logout") ?>"><i class="fas fa-sign-out-alt"></i>登出</a></li>
          </ul>
      </div>
      <?php endif; ?>

   </div>
   <nav class="navbar navbar-default menuBar">
      <div class="container">
         <!-- Brand and toggle get grouped for better mobile display -->
         <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menuBox" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <!--<a class="navbar-brand logo" href="<?php echo site_url()?>"><img src="<?php echo ASSETS_URL ?>/www/images/logo.png" alt=""></a>-->
         </div>
         <!-- Collect the nav links, forms, and other content for toggling -->
         <div class="collapse navbar-collapse" id="menuBox">
            <!--<ul class="nav navbar-nav menu-list navbar-right">
               <li><a href="<?php echo site_url()?>">首頁</a></li>
               <li><a href="<?php echo site_url("Live")?>">真人視訊</a></li>
               <li><a href="<?php echo site_url("Sport")?>">體育賽事</a></li>
               <li><a href="<?php echo site_url("Slot")?>">電子遊戲</a></li>
               <li><a  href="<?php echo site_url("EEgame")?>">捕魚遊戲</a></li>
               <li><a href="<?php echo site_url("Keno")?>">彩票遊戲</a></li>
               <li><a href="<?php echo site_url("Active")?>">優惠活動</a></li>
               <li><a href="<?php echo site_url("News")?>">最新公告</a></li>
            </ul>-->
			<ul class="nav navbar-nav menu-list navbar-right">
               <li><a href="<?php echo site_url()?>">首頁</a></li>
               
               <li><a href="/#s1">體育賽事</a></li>
			   <li><a href="/#s2">真人視訊</a></li>
               <li><a href="/#s3">電子遊戲</a></li>
              <!-- <li><a  href="<?php echo site_url("Esport")?>">電子競技</a></li>-->
               <!--<li><a  href="<?php echo site_url("Opengame?gm=51&GameCode=2162689")?>">捕魚遊戲</a></li>-->
               <li><a href="/#s4">彩票遊戲</a></li>
			   <!--<li><a  href="<?php echo site_url("EEgame")?>">捕魚遊戲</a></li>-->
               <!-- <li><a href="appdownload.html">APP下載</a></li> -->
               <li><a href="<?php echo site_url("Active")?>">優惠活動</a></li>
               <li><a href="<?php echo site_url("News")?>">最新公告</a></li>
            </ul>
            <span class="hamb-top"></span>
            <span class="hamb-middle"></span>
            <span class="hamb-bottom"></span>
            </button>
            <!-- <div class="dropdown user_dropdown lang_dropdown">
               <div class="dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <span class=""><i class="fa fa-globe"></i></span>
                 <span class="caret"></span>
               </div>
               <ul class="dropdown-menu top_lang_info" aria-labelledby="dropdownMenu2">
                 <li>繁中</li>
                 <li>简中</li>
                 <li>简中</li>
               </ul>
               </div> -->
         </div>
         <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
   </nav>
   <!--nav end-->
</header>
<?php $this -> load -> view("www/includes/banner.php")?>



