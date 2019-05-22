<form class="form-horizontal newoil-form" method="post" action="<?php echo $formAction ?>" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="widget-box widget-color-blue2">
                <div class="widget-header">
                    <h4 class="widget-title lighter smaller"><?php echo $subtitle?></h4>
                    
                </div>
                <div class="widget-body">
                    <div class="widget-main padding-8">
                        <div class="form-group">
                            <label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right">銀行名稱</label>
                            <div class="col-xs-12 col-sm-5">
                              <select class="form-control select2" name="bank_num" id="bank_num" data-placeholder="請選擇" required>
								<?php if(isset($bankList)):?>
                                    <?php foreach($bankList as $rowBank):?>
                                    <option value="<?php echo $rowBank["num"]?>" <?php if($rowBank["num"]==@$row["bank_num"]) echo ' selected'?>><?php echo $rowBank["bank_code"].$rowBank["bank_name"]?></option>
                                    <?php endforeach;?>
                                <?php endif;?>
                              </select>
                              
                            </div>
                         </div>
                        
                        <div class="form-group">
                            <label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right">銀行帳號</label>
                            <div class="col-xs-12 col-sm-5">
                            	<input type="text" class="form-control" id="bank_account" name="bank_account" value="<?php if(isset($row)) echo $row["bank_account"]?>" placeholder="銀行帳號" required />
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right">銀行戶名</label>
                            <div class="col-xs-12 col-sm-5">
                            	<input type="text" class="form-control" id="account_name" name="account_name" value="<?php if(isset($row)) echo $row["account_name"]?>" placeholder="銀行戶名" required />
                            </div>
                        </div> 
                       
                         
                        <div class="form-group">
                            <label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right">狀態</label>
                            <div class="col-xs-12 col-sm-5">
                              <select class="form-control select2" name="active" id="active" data-placeholder="請選擇" required>
                                <option value="Y" <?php if(@$row["active"]=='Y') echo ' selected'?>>開放</option>
                                <option value="N" <?php if(@$row["active"]=='N') echo ' selected'?>>關閉</option>
                              </select>
                            
                            </div>
                        </div> 
                       
                        
                        <div class="form-group">
                            <label for="inputWarning" class="col-sm-3 control-label no-padding-right"></label>
                            <div class="col-xs-12 col-sm-5">
                                <button type="submit" class="btn btn-primary">送出</button>
                                <a class='btn btn-danger' href='<?php echo $cancelBtn;?>' >取消</a>
                            </div>    
                        </div> 
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

