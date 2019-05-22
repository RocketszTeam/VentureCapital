<script type="text/JavaScript">
	$(function(){
		$('.activeSwitch').click(function(){
			$.ajax({
				type: "POST",
				url: "<?php echo site_url(SYSTEM_URL."/Manger/AjaxActive")?>",
				cache: false,
				data: { num: $(this).val(), active: ($(this).prop('checked') ? 'Y' : 'N') }
			});
		});
	});
</script>
<!-- PAGE CONTENT BEGINS -->
<?php if($openFind=='Y'):	//啟用搜尋才顯示?>
<div class="page-header">
    <form class="form-horizontal" method="post" action="<?php echo $s_action ?>">
        <div class="row">
            <div class="col-xs-12 col-sm-12">
            	<div id="accordion" class="accordion-style1 panel-group">
                	<div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title ">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                   <i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
                                    &nbsp;篩選條件
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseOne">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right">群組</label>
                                    <div class="col-xs-12 col-sm-5">
                                      <select class="form-control selectpicker" name="find1" id="find1">
                                        <option value="">請選擇</option>
                                        <?php if(isset($row_group)):?>
                                        <?php foreach($row_group as $row):?>
                                        <option value="<?php echo $row["u_power"]?>" <?php if($row["u_power"]==@$_REQUEST["find1"]) echo ' selected'?>><?php echo $row["power_name"]?></option>
                                        <?php endforeach;?>
                                        <?php endif;?>		
                                      </select>
                                      <?php if (@$_REQUEST["find1"]!=""){$find_msg.=($find_msg!="" ? "、" : "")."群組=【".tb_sql2("power_name","admin_group","u_power",@$_REQUEST["find1"])."】";} ?>
                                    </div>
                                 </div>
                                <div class="form-group">
                                    <label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right">帳號</label>
                                    <div class="col-xs-12 col-sm-5">
                                      <input type="text" class="form-control" id="find2" name="find2" value="<?php echo @$_REQUEST["find2"]?>" placeholder="帳號" />
                                      <?php if (@$_REQUEST["find2"]!=""){$find_msg.=($find_msg!="" ? "、" : "")."帳號=【".@$_REQUEST["find2"]."】";} ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right">姓名</label>
                                    <div class="col-xs-12 col-sm-5">
                                      <input type="text" class="form-control" id="find3" name="find3" value="<?php echo @$_REQUEST["find3"]?>" placeholder="姓名" />
                                      <?php if (@$_REQUEST["find3"]!=""){$find_msg.=($find_msg!="" ? "、" : "")."姓名=【".@$_REQUEST["find3"]."】";} ?>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right">狀態</label>
                                    <div class="col-xs-12 col-sm-5">
                                      <select class="form-control selectpicker" name="find4" id="find4">
                                        <option value="">請選擇</option>
                                        <option value="Y" <?php if (@$_REQUEST["find4"]=="Y"){?> selected="selected" <?php } ?>>啟用</option>
                                        <option value="N" <?php if (@$_REQUEST["find4"]=="N"){?> selected="selected" <?php } ?>>停權</option>
                                      </select>
                                      <?php if (@$_REQUEST["find4"]=="Y"){$find_msg.=($find_msg!="" ? "、" : "")."狀態=【啟用】";} ?>
                                      <?php if (@$_REQUEST["find4"]=="N"){$find_msg.=($find_msg!="" ? "、" : "")."狀態=【停權】";} ?>
                                    </div>
                                 </div>     
                                <div class="text-center">
                                    <a href="<?php echo site_url(uri_string()) ?>" class="btn btn-yellow btn-sm">
                                        <span class="ace-icon fa fa-times icon-on-right bigger-110"></span>
                                        清除篩選
                                    </a>
                                    <button type="submit" class="btn btn-purple btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        條件篩選
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php
    if(@$find_msg!=""){	//列出搜尋條件
		$find_arr=explode('、',$find_msg);
	?>
    <div class="widget-box widget-color-green">
        <div class="widget-body">
            <div class="widget-main padding-8">
                <ul class="list-unstyled spaced">
                    <?php foreach($find_arr as $find_str):?>
                    <li><i class="ace-icon fa fa-search bigger-110 red"></i><?php echo $find_str?></li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>    
    </div>
    
    <?php
	}
	?>
</div>

<?php endif;?>

<table id="simple-table" class="table table-bordered table-hover table-responsive">
    <thead>
        <tr>
            <!--<th class="center">
                <label class="pos-rel">
                    <input type="checkbox" class="ace" />
                    <span class="lbl"></span>
                </label>
            </th>-->
            
            <th>群組</th>
            <th>帳號</th>
            <th class="hidden-480">姓名</th>
            <th class="hidden-480">登入時間</th>
            <th class="hidden-480">登入IP</th>
            <th>狀態</th>
            <th>管理</th>
        </tr>
    </thead>
    <tbody>
		<?php 
        if(isset($result)):
            foreach($result as $row):
        ?>
        <tr>
            <td><?php echo tb_sql2("power_name","admin_group","u_power",$row["u_power"])?></td>
            <td>
				<a href="<?php echo site_url(SYSTEM_URL."/Manger/login_list/".$row["num"]) ?>" data-rel="tooltip" title="登入歷程"><?php echo $row["u_id"]?></a>
                <div class="hidden-md hidden-lg text-danger">
                	<?php echo $row["u_name"]?>
                </div>
            </td>
            <td class="hidden-480"><?php echo $row["u_name"]?></td>
            <td class="hidden-480"><?php echo $row["u_logintime"]?></td>
            <td class="hidden-480"><?php echo $row["u_loginip"]?></td>
            <td>
            	<label>
                	<input name="switch-field-1" class="ace ace-switch  activeSwitch" type="checkbox" value="<?php echo $row["num"]?>" <?php if ($row["active"]=="Y") echo ' checked' ?> />
                    <span class="lbl"></span>
                </label>
                
            </td>
            <td>
            	<?php if($row["u_power"]!=1):?>
                <div class="hidden-sm hidden-xs btn-group">
                    <a href="<?php echo site_url($editBTN.$row["num"])?>" class="btn btn-xs btn-info" title="修改">
                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                    </a>
                    <button class="btn btn-xs btn-danger" data-toggle="modal" title="刪除" data-target="#dialog-confirm" data-action="<?php echo site_url($delBTN.$row["num"])?>">
                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                    </button>
                </div>
                <div class="hidden-md hidden-lg">
                    <div class="inline pos-rel">
                        <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
                            <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                            <li>
                                <a href="<?php echo site_url($editBTN.$row["num"]) ?>" class="tooltip-success" data-rel="tooltip" title="修改">
                                    <span class="green">
                                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                                    </span>
                                </a>
                            </li>

                            <li>
                            	<a href="#" class="tooltip-error" data-rel="tooltip" data-toggle="modal" title="刪除" data-target="#dialog-confirm" data-action="<?php echo site_url($delBTN.$row["num"])?>">
                                    <span class="red">
                                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php endif;?>                                                
           </td>                                      
        </tr>
        <?php endforeach;
		endif;
		?>
    </tbody>
</table> 

<div class="text-center">
	<?php echo @$pagination ?>
    <!--<ul class="pagination">
        <li><a href="#"><i class="ace-icon fa fa-angle-double-left"></i></a></li>
        <li><a href="#">1</a></li>
        <li class="active"><a href="#">2</a></li>
        <li><a href="#"><i class="ace-icon fa fa-angle-double-right"></i></a></li>
    </ul>-->
</div>
