<!DOCTYPE HTML>
<html>
   <head>
      <?php $this -> load -> view("www/includes/head.php")?>
      <link href="<?php echo ASSETS_URL ?>/www/css/page.css" rel="stylesheet" type="text/css">
      <script type="text/javascript" src="<?php echo ASSETS_URL?>/www/js/forget.js"></script>

   </head>
   <body>
      <?php $this -> load -> view("www/includes/header.php")?>
      <section class="page_container">
         <div class="page_content term_content">
            <img src="images/left_img1.png" alt="" class="left_img">
            <div class="page_mtitle">Forget Password<b>會員密碼查詢</b></div>
            <div class="inner_content reg_content">
               <form class="form-horizontal member_form form" id="signForm" method="post">
                  <input type="hidden" name="forget_sms_token" id="forget_sms_token" value="<?php echo @$forget_sms_token?>">
                  <div class="form-group">
                     <label for="userId" class="col-sm-3 control-label required">會員帳號</label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control" name="u_id" id="u_id" maxlength="15"  placeholder="請輸入會員帳號">
                     </div>
                     <!-- <div class="col-sm-offset-2 col-sm-10 warning_txt"><i class="icon-close"></i>帳號已被註冊</div> -->
                  </div>
                  
                  <div class="form-group">
                     <label for="phone" class="col-sm-3 control-label required">手機號碼</label>
                     <div class="col-sm-6">
                        <input type="tel" class="form-control" name="phone" name="phone" id="f_phone" maxlength="10" placeholder="請輸入手機號碼">
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="phone" class="col-sm-3 control-label required">輸入驗證碼</label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control" name="forget_checknum" id="forget_checknum" maxlength="4"placeholder="請輸入驗證碼">
                     </div>
                     <div class="col-sm-3 note_txt">
                        <img id="regImg" class="regImg" src="<?php echo site_url("Vcode2")?>?token=<?php echo $token?>&s_name=forget_checknum" onclick="changeChkImg('forget_checknum','regImg')" style="cursor:pointer" title="刷新驗證碼">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="page_form_btn">
                        <button type="button" class="btn btn-default submit_btn" id="submitBtn">送出查詢</button>
                     </div>
                  </div>
               </form>
            </div>
            <!--inner_content end-->
            <img src="images/right_img1.png" alt="" class="right_img">
         </div>
      </section>
      <!-- Footer -->
      <?php $this -> load -> view("www/includes/footer.php")?>
   </body>
</html>