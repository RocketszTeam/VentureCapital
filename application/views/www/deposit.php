<!DOCTYPE HTML>
<html>
   <head>
      <?php $this -> load -> view("www/includes/head.php")?>
      <link href="<?php echo ASSETS_URL ?>/www/css/page.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="<?php echo ASSETS_URL?>/www/css/member.css" />
      <script type="text/javascript" src="<?php echo ASSETS_URL?>/www/js/deposit.js"></script>
      <script type="text/javascript">
         $(function(){
             $('.payment').click(function(){
                 $('#down-alert').hide();
                 if($(this).attr('data-payment')=='Credit'){
                     $("#down-alert").fadeToggle();
                     $('#depositForm').prop('target','_blank');
                 }else{
         if($('#pay_mode').val()==1){  //綠解原視窗
                       $('#depositForm').prop('target','_self');
         }else{  //中華另開
          $('#depositForm').prop('target','_blank');  
         }
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
               <div class="member_content">
                  <form class="form-horizontal member_form" id="depositForm" name="depositForm"  role="form" method="post" novalidate>
                     <input type="hidden" name="payment" id="payment" />
                     <input type="hidden" name="pay_mode" id="pay_mode" value="99" />
                     <div class="form-group way_box">
                        <label class="col-md-2 control-label">選擇儲值方式</label>
                        <div class="col-md-9">
                           <div class="pay">
                               <?php foreach($pay_config as $key => $val):?>
                                   <?php switch($val['paymentType']):
                                       case 'credit':?>
                                           <a class="payment payicon" data-payment="Credit"><img src="<?php echo ASSETS_URL?>/www/images/member/pay-icon6.png"></a>
                                           <?php break;?>
                                       <?php case 'atmncvs':?>
                                           <a class="payment payicon" data-payment="ATM"><img src="<?php echo ASSETS_URL ?>/www/images/member/pay-icon1.png"></a>
                                           <a class="payment payicon" data-payment="CVS"><img src="<?php echo ASSETS_URL?>/www/images/member/pay-icon7.png"></a>
                                           <?php break;?>
                                       <?php case 'atm':?>
                                          <a class="payment payicon" data-payment="ATM"><img src="<?php echo ASSETS_URL ?>/www/images/member/pay-icon1.png"></a>
                                          <?php break;?>
                                       <?php case 'cvs':?>
                                          <a class="payment payicon" data-payment="CVS"><img src="<?php echo ASSETS_URL?>/www/images/member/pay-icon7.png"></a>
                                          <?php break;?>
                                       <?php endswitch;?>
                               <?php endforeach;?>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="price" class="col-md-2 control-label">儲值金額</label>
                        <div class="col-md-6">
                           <input type="number" id="amount" name="amount" maxlength="10" class="form-control" placeholder="請輸入儲值點數">
                        </div>
                        <div class="col-md-4 note_txt">(建議儲值:1000以上)</div>
                     </div>
                     <div class="form-group">
                        <div class="page_form_btn">
                           <button type="submit" class="btn btn-default submit_btn">取得代碼</button>
                        </div>
                     </div>
                  </form>
                  <div class="member_note">
                     <div class="note_title"><i class="icon-notice"></i>儲值注意事項：</div>
                     超商代碼繳費，請勿使用「OK超商」繳費
                     <br/>ATM儲值請勿使用無卡存款，若使用無卡存款一律視為詐騙帳號停權處分。
                      <br/>會員如有需要其他點數儲值方式，請連絡客服人員
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
