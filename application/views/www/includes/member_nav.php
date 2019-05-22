 <div class="member_tab">
    <ul class="member_list_pc">
        <li><a href="<?php echo site_url("Manger/account") ?>">個人資料</a></li>
        <li><a href="<?php echo site_url("Manger/deposit") ?>">點數儲值</a></li>
        <!--<li><a href="<?php echo site_url("Account/bank") ?>">匯款記錄</a></li>-->
        <li><a href="<?php echo site_url("History/index") ?>">儲值紀錄</a></li>
        <li><a href="<?php echo site_url("Manger/transfer") ?>">點數轉移</a></li>
        <li><a href="<?php echo site_url("History/transfer") ?>">轉移紀錄</a></li>
		<li><a href="<?php echo site_url("Manger/withdrawal") ?>">點數拍賣</a></li>
        <li><a href="<?php echo site_url("History/sell") ?>">拍賣紀錄</a></li>
    </ul>
    <select name="here" onchange="location.href=this.options[this.selectedIndex].value;" class="member_list_mb">
        <option value="">請選擇</option>
        <option value="<?php echo site_url("Manger/account") ?>">個人資料</option>
        <option value="<?php echo site_url("Manger/deposit") ?>" >點數儲值</option>
        <!--<option value="<?php echo site_url("Account/bank") ?>" >匯款記錄</option>-->
        <option value="<?php echo site_url("History/index") ?>">儲值紀錄</option>
        <option value="<?php echo site_url("Manger/transfer") ?>">點數轉移</option>
        <option value="<?php echo site_url("History/transfer") ?>">轉移紀錄</option>
       <option value="<?php echo site_url("Manger/withdrawal") ?>">點數拍賣</option>
        <option value="<?php echo site_url("History/sell") ?>">拍賣紀錄</option>
    </select>
</div>
<script>
  $(function(){
		$(".member_list_pc a").each(function(ele, i){
			if($(this).attr("href") == location.href) {
				$(this).addClass("select");
			}
			console.log($(this).attr("href"), location.href);
		});

	});
</script>