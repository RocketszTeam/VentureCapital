<!DOCTYPE HTML>
<html>
   <head>
      <?php $this -> load -> view("www/includes/head.php")?>
      <link href="<?php echo ASSETS_URL ?>/www/css/page.css" rel="stylesheet" type="text/css">
      <script type="text/javascript" src="<?php echo ASSETS_URL?>/www/js/register.js"></script>

   </head>
   <body>
      <?php $this -> load -> view("www/includes/header.php")?>
      <section class="page_container">
         <div class="page_content term_content">
            <img src="images/left_img1.png" alt="" class="left_img">
            <div class="page_mtitle">Join Member<b>申請會員</b></div>
            <div class="inner_content reg_content">
               <form class="form-horizontal member_form form" id="signForm" method="post">
                  <input type="hidden" name="sms_token" id="sms_token" value="<?php echo @$sms_token?>">
                  <div class="form-group">
                     <label for="name" class="col-sm-2 control-label required">會員姓名</label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control" id="u_name" name="u_name" maxlength="5" placeholder="請輸入真實姓名，以免影響您的權益">
                     </div>
                     <div class="col-sm-4 note_txt">(請輸入真實姓名)</div>
                  </div>
                  <div class="form-group">
                     <label for="userId" class="col-sm-2 control-label required">會員帳號</label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control" name="u_id" id="u_id" maxlength="15"  placeholder="6~13碼英文數字組合">
                     </div>
                     <div class="col-sm-4 note_txt">(6~13碼英文數字組合)</div>
                     <!-- <div class="col-sm-offset-2 col-sm-10 warning_txt"><i class="icon-close"></i>帳號已被註冊</div> -->
                  </div>
                  <div class="form-group">
                     <label for="password" class="col-sm-2 control-label required">設定密碼</label>
                     <div class="col-sm-6">
                        <input type="password" class="form-control" name="u_password" id="u_password" maxlength="15" placeholder="6~13碼英文數字組合">
                     </div>
                     <div class="col-sm-4 note_txt">(6~13碼英文數字組合)</div>
                     <!-- <div class="col-sm-offset-2 col-sm-10 warning_txt"><i class="icon-close"></i>密碼輸入錯誤</div> -->
                  </div>
                  <div class="form-group">
                     <label for="u_password2" class="col-sm-2 control-label required">確認密碼</label>
                     <div class="col-sm-6">
                        <input type="password" class="form-control" name="u_password2" id="u_password2" maxlength="15"  placeholder="再次輸入密碼">
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="phone" class="col-sm-2 control-label required">手機號碼</label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control" name="phone" id="phone" maxlength="10"placeholder="請輸入您的手機" >
                     </div>
                     <div class="col-sm-4 note_txt">
                        <button class="code_btn btn btn-block" id="smsBTN">獲取驗證碼</button>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="code" class="col-sm-2 control-label required">輸入簡訊驗證碼</label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control" name="sms_code" id="sms_code" maxlength="4" placeholder="請輸入簡訊驗證碼">
                     </div>
                     <!-- <div class="col-sm-offset-2 col-sm-10 warning_txt"><i class="icon-close"></i>驗證碼輸入錯誤</div> -->
                  </div>
                  <div class="form-group">
                     <label for="name" class="col-sm-2 control-label required">LINE ID</label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control" id="line" name="line" maxlength="20" placeholder="請輸入LINE ID">
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="phone" class="col-sm-2 control-label required">驗證碼</label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control" name="checknum" id="checknum" maxlength="4" placeholder="請輸入圖形驗證碼">
                     </div>
                     <div class="col-sm-4 note_txt">
                        <img id="regImg" src="<?php echo site_url("Vcode2")?>?token=<?php echo $token?>&s_name=reg_checknum" onclick="changeChkImg('reg_checknum','regImg')" style="cursor:pointer;width:100%;padding:10px;" title="刷新驗證碼">

                     </div>
                  </div>
                  <div class="form-check">
                     <label class="form-check-labe col-md-offset-2 col-sm-6">
                     <input type="checkbox" class="form-check-input agree" id="squaredThree">
                     <span class="link-color1">我已經閱讀並同意使用者合約</span>
                     </label>
                  </div>
                  <div class="form-group">
                     <div class="page_form_btn">
                        <button type="reset" class="btn btn-default reset_btn">清除</button>
                        <button type="submit" class="btn btn-default submit_btn" id="submitBtn">送出</button>
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