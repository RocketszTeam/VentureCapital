<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sabaapi {
	var $CI;
	var $timeout=10;	//curl允許等待秒數
	var $Checkkey='key';	//自行設定.
	var $api_url='http://tsa.igptech.net/api/';	//API URL
	var	$err=['執行成功','執行過程中失敗','會員名稱（Username）重複','','賠率類型格式錯誤','幣別格式錯誤','廠商會員識別碼重複',
	'最小限制轉帳金額大於最大限制轉帳金額','無效的前綴字元','廠商識別碼失效','系統維護中'];

	var $vendor_id='a6prkqb3wl';
	var $operatorId='rockettest'; //rockettest
	var $vendor_member_id='NAch1014'; //NAabc123
    var $oddstype = '1';
    var $currency = '20' ;  //4泰銖  20虛擬貨幣
    var $maxtransfer = '100' ;
    var $mintransfer = '20' ;

	public function __construct(){	
		$this->CI =&get_instance();
	}

    //create_account(account_prefix . $u_id, $u_password, $mem_num, $gamemaker_num)
    //echo $this->saba->CreateMember('test','10',112,'a6prkqb3wl','NAch1014','rockettest','a','c','jack','1',20,100,20);

	public function create_account($u_id, $u_password, $mem_num, $gamemaker_num=112){	//創建遊戲帳號
		$err=['執行成功','執行失敗','會員名稱（Username）重複','','賠率類型格式錯誤','幣別格式錯誤','廠商會員識別碼重複',
		'最小限制轉帳金額大於最大限制轉帳金額','無效的前綴字元','廠商識別碼失效','系統維護中'];
		$parameter=array();
		$sqlStr="select * from `games_account` where `u_id`=?  and `mem_num`=? and `gamemaker_num`=?";
		$parameter[':u_id']=trim($u_id);
		$parameter[':mem_num']=$mem_num;
		$parameter[':gamemaker_num']=$gamemaker_num;
		$row=$this->CI->webdb->sqlRow($sqlStr,$parameter);
		if($row==NULL){	//無帳號才呼叫api
            $vendor_member_id = $this -> operatorId . "_" . $u_id; //此遊戲自己前綴
			$data=array('vendor_id'=>$this -> vendor_id,'Vendor_Member_ID'=>$vendor_member_id,
            'OperatorId'=>$this -> operatorId,'FirstName'=>$u_id,'LastName'=>$u_id,'UserName'=>$u_id,
            'OddsType'=>$this -> oddstype, 'Currency'=>$this -> currency,'MaxTransfer'=>$this -> maxtransfer,'MinTransfer'=>$this -> mintransfer,
			'Custominfo1'=>'a','Custominfo2'=>'a','Custominfo3'=>'a',
			'Custominfo4'=>'a','Custominfo5'=>'a');
			$QS=http_build_query($data);
            $ch = curl_init($this->api_url."CreateMember");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $QS);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT,$this->timeout); 
			$output = curl_exec($ch);
			//回傳json
			$curl_errno = curl_errno($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);	
		
			$output=json_decode($output);
			print_r($output);
			if(!$curl_errno){
				if($http_code===200 && $output->error_code=='0'){	//帳號創建成功 && ($out->error_code=='0'
					$colSql="u_id,mem_num,gamemaker_num";
					$upSql="INSERT INTO `games_account` (".sqlInsertString($colSql,0).") VALUES (".sqlInsertString($colSql,1).")";
					$parameter=array();
					$parameter[':u_id']=trim($u_id);	
					$parameter[':mem_num']=$mem_num;
					$parameter[':gamemaker_num']=$gamemaker_num;
					$this->CI->webdb->sqlExc($upSql,$parameter);
					return NULL;
				}else{
					return 	$err[$output->error_code];
                }
                
			}else{
				return '系統繁忙中，請稍後再試'	;
			}
		}else{
			return '會員已有此類型帳號';
		}
	}

	public function get_balance($u_id){
		$err[2]='傳入的廠商會員識別碼為空值';
		$err[7]='取得非Sportsbook用戶餘額錯誤';
        $vendor_member_id = $this -> operatorId . "_" . $u_id; //此遊戲自己前綴
		$data=array('vendor_id'=>$this -> vendor_id,'vendor_member_ids'=>$vendor_member_id,'wallet_id'=>'1');
		$QS=http_build_query($data);
		$ch = curl_init($this->api_url."CheckUserBalance");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $QS);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT,$this->timeout); 
		$output = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curl_errno = curl_errno($ch);
		curl_close($ch);	
		//print_r($http_code);
		$output=json_decode($output);
		//$out=get_object_vars($output);
		//print_r($out);
		$usermsg=array('0'=>'執行成功','2'=>'會員不存在','3'=>'會員被封存','6'=>'會員尚未轉帳過',
		'7'=>'取得非Sportsbook用戶餘額錯誤');
		$usererror=$output->Data[0]->error_code;
		//$output=json_decode($output);
        //print_r($output);
			if(!$curl_errno){
				if($http_code==200 && $output->error_code=='0'){	//帳號創建成功
					return $output->Data[0]->balance;
				}else{
					return $err[$output->error_code].'<br>'.'用戶錯誤訊息'.$usermsg[$usererror];
				}
			}else{
				return '系統繁忙中，請稍後再試';
			}        
	}

	public function get_OperatorID(){
		$data=array('vendor_id'=>$this -> vendor_id);
		$QS=http_build_query($data);
		$ch = curl_init($this->api_url."get_OperatorID");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $QS);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT,$this->timeout); 
		$output = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curl_errno = curl_errno($ch);
		curl_close($ch);	
		$out=json_decode($output);
		//print_r($output);
		//echo $http_code;
		return $out;
	}


	//stdClass Object ( [error_code] => 0 [message] => Success [Data] => stdClass Object ( [trans_id] => 295 [before_amount] => 0 [after_amount] => 100 [bonus_before_amount] => 0 [bonus_after_amount] => 0 [system_id] => AEUGUUS08002 [status] => 0 ) )
    //OUT20190430165447rocketsz
    public function deposit($u_id,$amount,$mem_num,$gamemaker_num=112,$logID=NULL){	//轉入點數到遊戲帳號內
        $OrderId='OUT'.date('YmdHis').trim($u_id);
        //將轉點編號寫入DB
        $upSql="UPDATE `member_wallet_log` SET `TradeNo`='".$OrderId."' where num=".$logID;
        $OperatorID = $this->get_OperatorID();
        $vendor_member_id = $this -> operatorId . "_" . $u_id; //此遊戲自己前綴
        $vendor_trans_id=$OperatorID . "_" . $OrderId;
        $data=array('vendor_id'=>$this -> vendor_id,'vendor_member_id'=>$vendor_member_id,'vendor_trans_id'=>$vendor_trans_id,
            'amount'=>$amount,'currency'=>$this -> currency,'direction'=>'1','wallet_id'=>'1');
        $QS=http_build_query($data);
        $ch = curl_init($this->api_url."FundTransfer");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $QS);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT,$this->timeout);
        $output = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        curl_close($ch);
        $output=json_decode($output);
        //print_r($output);
        if(!$curl_errno){
            if($http_code===200 && $output->error_code=='0'){
                $WalletTotal = getWalletTotal($mem_num);    //會員餘額
                $before_balance = (float)$WalletTotal;    //異動前點數
                $after_balance = (float)$before_balance - (float)$amount;//異動後點數
                $parameter = array();
                $colSql = "mem_num,kind,points,makers_num,makers_balance,admin_num,buildtime,before_balance,after_balance";
                $sqlStr = "INSERT INTO `member_wallet` (" . sqlInsertString($colSql, 0) . ")";
                $sqlStr .= " VALUES (" . sqlInsertString($colSql, 1) . ")";
                $parameter[":mem_num"] = $mem_num;
                $parameter[":kind"] = 3;    //轉入遊戲
                $parameter[":points"] = "-" . $amount;
                $parameter[":makers_num"] = $gamemaker_num;
                $parameter[":makers_balance"] = (float)$output->Data->after_amount;
                $parameter[":admin_num"] = tb_sql("admin_num", "member", $mem_num);
                $parameter[":buildtime"] = now();
                $parameter[':before_balance'] = $before_balance;
                $parameter[':after_balance'] = $after_balance;
                $this->CI->webdb->sqlExc($sqlStr, $parameter);
                return NULL;
            }else{
                return "轉點錯誤：".$output->message;
            }
        }else{
            return $this->CheckFundTransfer($u_id,$mem_num,$gamemaker_num,$vendor_trans_id,$amount,1);
            //return '系統繁忙中，請稍後再試'	;
        }
    }

    //{"error_code":0,"message":"Success","Data":{"trans_id":298,"before_amount":150.0,"after_amount":100.0,"bonus_before_amount":0,"bonus_after_amount":0.0,"system_id":"AEUGUUS08002","status":0}}
    //{"error_code":0,"message":"Success","Data":{"trans_id":299,"before_amount":100.0,"after_amount":50.0,"bonus_before_amount":0,"bonus_after_amount":0.0,"system_id":"AEUGUUS08002","status":0}}
	public function withdrawal($u_id,$amount,$mem_num,$gamemaker_num=112,$logID=NULL){	//遊戲點數轉出
		$OrderId='IN'.date('YmdHis').trim($u_id);
		//將轉點編號寫入DB
		$upSql="UPDATE `member_wallet_log` SET `TradeNo`='".$OrderId."' where num=".$logID;
		$this->CI->webdb->sqlExc($upSql);
		$OperatorID = $this->get_OperatorID();
        $vendor_member_id = $this -> operatorId . "_" . $u_id; //此遊戲自己前綴
		$vendor_trans_id=$OperatorID . "_" . $OrderId;
		$data=array('vendor_id'=>$this -> vendor_id,'vendor_member_id'=>$vendor_member_id,'vendor_trans_id'=>$vendor_trans_id,
					'amount'=>$amount,'currency'=>$this -> currency,'direction'=>'0','wallet_id'=>'1');
		$QS=http_build_query($data);
		$ch = curl_init($this->api_url."FundTransfer");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $QS);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT,$this->timeout); 
		$output = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curl_errno = curl_errno($ch);
		curl_close($ch);
		$output=json_decode($output);
        print_r($output);
		if(!$curl_errno){
			if($http_code===200 && $output->error_code=='0'){	//帳號創建成功
                $WalletTotal = getWalletTotal($mem_num);    //會員餘額
                $before_balance = (float)$WalletTotal;//異動前點數
                $after_balance = (float)$before_balance + (float)$amount;//異動後點數
                $parameter = array();
                $colSql = "mem_num,kind,points,makers_num,makers_balance,admin_num,buildtime,before_balance,after_balance";
                $sqlStr = "INSERT INTO `member_wallet` (" . sqlInsertString($colSql, 0) . ")";
                $sqlStr .= " VALUES (" . sqlInsertString($colSql, 1) . ")";
                $parameter[":mem_num"] = $mem_num;
                $parameter[":kind"] = 4;    //遊戲轉出
                $parameter[":points"] = $amount;
                $parameter[":makers_num"] = $gamemaker_num;
                $parameter[":makers_balance"] = (float)$output->Data->after_amount;
                $parameter[":admin_num"] = tb_sql("admin_num", "member", $mem_num);
                $parameter[":buildtime"] = now();
                $parameter[':before_balance'] = $before_balance;
                $parameter[':after_balance'] = $after_balance;
                $this->CI->webdb->sqlExc($sqlStr, $parameter);
                return NULL;
            }else{
                return "轉點錯誤：".$output->message;
            }
        }else{
            return $this->CheckFundTransfer($u_id,$mem_num,$gamemaker_num,$vendor_trans_id,$amount,2);
            //return '系統繁忙中，請稍後再試'	;
        }
	}
    //轉入遊戲 type=1;轉出遊戲 type=2
	public function CheckFundTransfer($u_id,$mem_num,$gamemaker_num,$vendor_trans_id,$amount,$type){	//點查轉帳情況 如果可以再次檢查 或 查詢錯誤的話才會有這個function
		$err[1]='執行過程中失敗';
		$err[2]='交易紀錄不存在';
		$err[3]='等待五分鐘後再次確認';
		$err[7]='wallet_id 輸入錯誤';
		$data=array('vendor_id'=>$this -> vendor_id,'vendor_trans_id'=>$vendor_trans_id,'wallet_id'=>'1');
		$QS=http_build_query($data);
		$ch = curl_init($this->api_url."CheckFundTransfer");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $QS);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT,$this->timeout); 
		$output = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curl_errno = curl_errno($ch);
		curl_close($ch);	
		//print_r($output);
		$output=json_decode($output);
		if(!$curl_errno){
			if($http_code===200 && $output->error_code=='0'){	
				if($output->isExist=='true'){
					$makers_balance=$this->get_balance($u_id);
					if($type==1){
						$WalletTotal=getWalletTotal($mem_num);	//檢查錢包點數
						if((int)$WalletTotal >=(int)$amount){
							$before_balance=(float)$WalletTotal;//異動前點數
							$after_balance= (float)$before_balance - (float)$amount;//異動後點數
							$parameter=array();
							$colSql="mem_num,kind,points,makers_num,makers_balance,admin_num,buildtime,before_balance,after_balance";
							$sqlStr="INSERT INTO `member_wallet` (".sqlInsertString($colSql,0).")";
							$sqlStr.=" VALUES (".sqlInsertString($colSql,1).")";
							$parameter[":mem_num"]=$mem_num;
							$parameter[":kind"]=3;	//轉入遊戲
							$parameter[":points"]="-".$amount;
							$parameter[":makers_num"]=$gamemaker_num;
							$parameter[":makers_balance"]=$makers_balance;
							$parameter[":admin_num"]=tb_sql("admin_num","member",$mem_num);
							$parameter[":buildtime"]=now();
							$parameter[':before_balance']=$before_balance;
							$parameter[':after_balance']=$after_balance;
							$this->CI->webdb->sqlExc($sqlStr,$parameter);
							return NULL;
						}else{
							return '錢包點數不足';
						}
					}else{
						$WalletTotal=getWalletTotal($mem_num);	//會員餘額
						$before_balance=(float)$WalletTotal;//異動前點數
						$after_balance= (float)$before_balance + (float)$amount;//異動後點數
						$parameter=array();
						$colSql="mem_num,kind,points,makers_num,makers_balance,admin_num,buildtime,before_balance,after_balance";
						$sqlStr="INSERT INTO `member_wallet` (".sqlInsertString($colSql,0).")";
						$sqlStr.=" VALUES (".sqlInsertString($colSql,1).")";
						$parameter[":mem_num"]=$mem_num;
						$parameter[":kind"]=4;	//遊戲轉出
						$parameter[":points"]=$amount;
						$parameter[":makers_num"]=$gamemaker_num;
						$parameter[":makers_balance"]=$makers_balance;
						$parameter[":admin_num"]=tb_sql("admin_num","member",$mem_num);
						$parameter[":buildtime"]=now();
						$parameter[':before_balance']=$before_balance;
						$parameter[':after_balance']=$after_balance;
						$this->CI->webdb->sqlExc($sqlStr,$parameter);
						return NULL;
					}
				}else{
					return '無此記錄';
				}
			}else{
				return "查詢轉點錯誤：".$err[$output->error_code];	
			}
		}else{
			return '系統繁忙中，請稍後再試';
		}
	}

    //取得遊戲token
    public function forward_game($u_id){
        //$this->SetBetLimit($u_id);	//限紅
        $err[2]='會員不存在';
        $vendor_member_id = $this -> operatorId . "_" . $u_id; //此遊戲自己前綴
        $data=array('vendor_id'=>$this -> vendor_id,'domain'=>$this->api_url,'vendor_member_id'=>$vendor_member_id);
        $QS=http_build_query($data);
        $ch = curl_init($this->api_url."LogIn");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $QS);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT,$this->timeout);
        $output = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        curl_close($ch);
        //print_r($output);
        $output= json_decode($output);
        //header('Location: http://sbtest.igptech.net/Deposit_ProcessLogin.aspx?token='.$data);
        if(!$curl_errno){
            if($http_code===200 && $output->error_code=='0'){	//帳號創建成功
                return 'http://sbtest.igptech.net/Deposit_ProcessLogin.aspx?token='.$output->Data;
            }else{
                return $err[$output->error_code];
            }
        }else{
            return '系統繁忙中，請稍後再試';
        }
    }

	public function reporter_all($version_key=NULL,$options=NULL){
			$data=array('vendor_id'=>$this->vendor_id,'version_key'=>$version_key,'options'=>$options);
			$QS=http_build_query($data);
			$ch = curl_init($this->api_url."GetBetDetail");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $QS);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT,$this->timeout); 
			$output = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$curl_errno = curl_errno($ch);
			curl_close($ch);	
			$output=json_decode($output);
			$key= $output->Data->last_version_key;
			//print_r($output);
			//echo $key;
			$sql="SELECT `version_key` FROM `saba_report` ORDER BY id DESC LIMIT 1"; //取最新一筆比對
			$val=$this->CI->webdb->sqlRow($sql);
			//echo $val['version_key'];

			//if($val['version_key'] != $key){
				if(!$curl_errno){
					if($http_code===200 && $output->error_code=='0'){	//帳號創建成功 && }}.$key

                        return $output;
//						for ($i=0; $i < 500; $i++) {
//							$out=$output->Data->BetDetails[$i];
//							if($out){
//
//						$colSql="trans_id,vendor_member_id,operator_id,league_id,match_id,home_id,away_id,team_id,match_datetime,sport_type,bet_type,parlay_ref_no,odds,stake,transaction_time,ticket_status,winlost_amount,after_amount,currency,winlost_datetime,odds_type,bet_team,isLucky,parlay_type,combo_type,exculding,bet_tag,home_hdp,away_hdp,hdp,betfrom,islive,last_ball_no,home_score,away_score,customInfo1,customInfo2,customInfo3,customInfo4,customInfo5,ba_status,version_key,ParlayData";
//						$upSql="REPLACE INTO `saba_report` (".sqlInsertString($colSql,0).") VALUES (".sqlInsertString($colSql,1).")";
//						$parameter=array();
//						$parameter[':trans_id']=$out->trans_id;
//						$parameter[':vendor_member_id']=$out->vendor_member_id;
//						$parameter[':operator_id']=$out->operator_id;
//						$parameter[':league_id']=$out->league_id;
//						$parameter[':match_id']=$out->match_id;
//						$parameter[':home_id']=$out->home_id;
//						$parameter[':away_id']=$out->away_id;
//						$parameter[':team_id']=$out->team_id;
//						$parameter[':match_datetime']=$out->match_datetime;
//						$parameter[':sport_type']=$out->sport_type;
//						$parameter[':bet_type']=$out->bet_type;
//						$parameter[':parlay_ref_no']=$out->parlay_ref_no;
//						$parameter[':odds']=$out->odds;
//						$parameter[':stake']=$out->stake;
//						$parameter[':transaction_time']=$out->transaction_time;
//						$parameter[':ticket_status']=$out->ticket_status;
//						$parameter[':winlost_amount']=$out->winlost_amount;
//						$parameter[':after_amount']=$out->after_amount;
//						$parameter[':currency']=$out->currency;
//						$parameter[':winlost_datetime']=$out->winlost_datetime;
//						$parameter[':odds_type']=$out->odds_type;
//						$parameter[':bet_team']=$out->bet_team;
//						$parameter[':isLucky']=$out->isLucky;
//						$parameter[':parlay_type']=$out->parlay_type;
//						$parameter[':combo_type']=$out->combo_type;
//						$parameter[':exculding']=$out->exculding;
//						$parameter[':bet_tag']=$out->bet_tag;
//						$parameter[':home_hdp']=$out->home_hdp;
//						$parameter[':away_hdp']=$out->away_hdp;
//						$parameter[':hdp']=$out->hdp;
//						$parameter[':betfrom']=$out->betfrom;
//						$parameter[':islive']=$out->islive;
//						$parameter[':last_ball_no']=$out->last_ball_no;
//						$parameter[':home_score']=$out->home_score;
//						$parameter[':away_score']=$out->away_score;
//						$parameter[':customInfo1']=$out->customInfo1;
//						$parameter[':customInfo2']=$out->customInfo2;
//						$parameter[':customInfo3']=$out->customInfo3;
//						$parameter[':customInfo4']=$out->customInfo4;
//						$parameter[':customInfo5']=$out->customInfo5;
//						$parameter[':ba_status']=$out->ba_status;
//						$parameter[':version_key']=$out->version_key;
//						$parameter[':ParlayData']=$out->ParlayData;
//						$this->CI->webdb->sqlExc($upSql,$parameter);
//						//return NULL;
//							}
//						}
					}else{
						return $err[$output->error_code];
					}
					
				}else{
					return '系統繁忙中，請稍後再試'	;
				}
			//}
			//else{	return $key;			}
			
	}


	public function SetMemberBetSetting($vendor_id,$vendor_member_id){
		$err[2]='會員不存在';
		$err[7]='傳入參數錯誤';
		$bet_setting=array (0 => array ('sport_type' => '1','min_bet' => 1,'max_bet' => 100,'max_bet_per_match' => 100)	,
			1 => array (
			  'sport_type' => '2',
			  'min_bet' => 1,
			  'max_bet' => 100,
			  'max_bet_per_match' => 100
			),
			2 =>array (
			  'sport_type' => '3',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			3 =>array (
			  'sport_type' => '5',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			4 => array (
			  'sport_type' => '8',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			5 => array (
			  'sport_type' => '10',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			6 => array (
			  'sport_type' => '11',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			7 => array (
			  'sport_type' => '99',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			8 => array (
			  'sport_type' => '99MP',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			9 => array (
			  'sport_type' => '151',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			10 => array (
			  'sport_type' => '152',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			11 => array (
			  'sport_type' => '153',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			12 => array (
			  'sport_type' => '154',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			13 => array (
			  'sport_type' => '161',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			14 => array (
			  'sport_type' => '180',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			15 => array (
			  'sport_type' => '181',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			16 => array (
			  'sport_type' => '182',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			17 => array (
			  'sport_type' => '183',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			18 => array (
			  'sport_type' => '184',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			19 => array (
			  'sport_type' => '185',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			20 => array (
			  'sport_type' => '186',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			21 => array (
			  'sport_type' => '190',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			22 => array (
			  'sport_type' => '191',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			23 => array (
			  'sport_type' => '192',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			24 => array (
			  'sport_type' => '193',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			),
			25 => array (
			  'sport_type' => '43',
			  'min_bet' => NULL,
			  'max_bet' => NULL,
			  'max_bet_per_match' => NULL
			)
		);
		$bet=json_encode($bet_setting);
		$data=array('vendor_id'=>$vendor_id,'vendor_member_id'=>$vendor_member_id,'bet_setting'=>$bet);
		$QS=http_build_query($data);
		$ch = curl_init($this->api_url."SetMemberBetSetting");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $QS);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT,$this->timeout); 
		$output = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curl_errno = curl_errno($ch);
		curl_close($ch);	
		if(!$curl_errno){
			if($http_code===200 && $output->error_code=='0'){	//帳號創建成功
				return NULL;
			}else{
				return $err[$output->error_code];
			}
		}else{
			return '系統繁忙中，請稍後再試';
		}        
	}

    public function UpdateMember($vendor_id,$vendor_member_id,$firstname,$lastname,
                                 $maxtransfer,$mintransfer,$custominfo1,$custominfo2,$custominfo3,$custominfo4,$custominfo5){	//創建遊戲帳號
        $err = array('0' => '執行成功', '1' => '執行過程中失敗','2' =>'會員不存在','9'=> '廠商識別碼失效','10'=>'系統維護中');
        $data=array('vendor_id'=>$vendor_id,'Vendor_Member_ID'=>$vendor_member_id,
            'FirstName'=>$firstname,'LastName'=>$lastname,
            'MaxTransfer'=>$maxtransfer,'MinTransfer'=>$mintransfer,
            'Custominfo1'=>$custominfo1,'Custominfo2'=>$custominfo2,'Custominfo3'=>$custominfo3,
            'Custominfo4'=>$custominfo4,'Custominfo5'=>$custominfo5);
        $QS=http_build_query($data);
        //echo $QS."<br>";
        $ch = curl_init($this->api_url."UpdateMember");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $QS);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT,$this->timeout);
        $output = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        //print_r($output);
        $output=json_decode($output);
        if(!$curl_errno){
            if($http_code===200 && $output->error_code=='0'){	//帳號創建成功
                return NULL;
            }else{
                return $err[$output->error_code];
            }
        }else{
            return '系統繁忙中，請稍後再試';
        }
    }

    public function KickUser($vendor_id,$vendor_member_id){
        $err=array('0' => '執行成功', '1' => '執行過程中失敗','2' =>'會員不存在','3'=>'會員不在線上','9'=> '廠商識別碼失效','10'=>'系統維護中');
        $data=array('vendor_id'=>$vendor_id,'Vendor_Member_ID'=>$vendor_member_id);
        $QS=http_build_query($data);
        $ch = curl_init($this->api_url."KickUser");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $QS);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT,$this->timeout);
        $output = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        curl_close($ch);
        $output=json_decode($output);
        if(!$curl_errno){
            if($http_code===200 && $output->error_code=='0'){	//帳號創建成功
                return NULL;
            }else{
                return $err[$output->error_code];
            }
        }else{
            return '系統繁忙中，請稍後再試';
        }
    }


    public function FundTransfer($u_id,$mem_num,$gamemaker_num=112,$vendor_id,$vendor_member_id,$vendor_trans_id,$amount,
                                 $currency,$direction,$wallet_id,$logID=NULL){	//轉入點數到遊戲帳號內
        $err[1] = '執行過程中失敗';
        $err[2] = '會員不存在';
        $err[3] = '會員餘額不足';
        $err[4] = '比最小或最大限制的轉帳金額還更少或更多';
        $err[5] = '重複的轉帳識別碼';
        $err[6] = '幣別錯誤';
        $err[7] = '傳入參數錯誤';
        $err[8] = '玩家盈餘限制(玩家贏超過系統可轉出有效值時)';
        $err[11] = '系統忙綠中，請稍後再試';
        $err[12] = '無效的前綴字元';
        $err[13] = '會員被封存';
        if($direction==0){
            $OrderId='IN'.date('YmdHis').trim($u_id);
        }else{
            $OrderId='OUT'.date('YmdHis').trim($u_id);
        }
        $SN=time().mt_rand();
        //將轉點編號寫入DB
        $upSql="UPDATE `member_wallet_log` SET `TradeNo`='".$OrderId."' where num=".$logID;
        $this->CI->webdb->sqlExc($upSql);

        $OperatorID = $this->get_OperatorID($vendor_id);
        $VTID=$OperatorID."_".$vendor_trans_id;
        $data=array('vendor_id'=>$this -> vendor_id,'vendor_member_id'=>$u_id,'vendor_trans_id'=>$VTID,
            'amount'=>$amount,'currency'=>$this -> currency,'direction'=>$direction,'wallet_id'=>$wallet_id);
        $QS=http_build_query($data);
        $ch = curl_init($this->api_url."FundTransfer");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $QS);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT,$this->timeout);
        $output = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        curl_close($ch);

        $output=json_decode($output);
        if(!$curl_errno){
            if($http_code===200 && $output->error_code=='0'){	//帳號創建成功
                if($direction==0){
                    $WalletTotal=getWalletTotal($mem_num);	//會員餘額
                    $before_balance=(float)$WalletTotal;//異動前點數
                    $after_balance= (float)$before_balance - (float)$amount;//異動後點數
                    $parameter=array();
                    $colSql="mem_num,kind,points,makers_num,makers_balance,admin_num,buildtime,before_balance,after_balance";
                    $sqlStr="INSERT INTO `member_wallet` (".sqlInsertString($colSql,0).")";
                    $sqlStr.=" VALUES (".sqlInsertString($colSql,1).")";
                    $parameter[":mem_num"]=$mem_num;
                    $parameter[":kind"]=3;	//轉入遊戲
                    $parameter[":points"]="-".$amount;
                    $parameter[":makers_num"]=$gamemaker_num;
                    $parameter[":makers_balance"]=(float)$output->Balance;
                    $parameter[":admin_num"]=tb_sql("admin_num","member",$mem_num);
                    $parameter[":buildtime"]=now();
                    $parameter[':before_balance']=$before_balance;
                    $parameter[':after_balance']=$after_balance;
                    $this->CI->webdb->sqlExc($sqlStr,$parameter);
                    return NULL;
                }else{
                    $WalletTotal=getWalletTotal($mem_num);	//會員餘額
                    $before_balance=(float)$WalletTotal;//異動前點數
                    $after_balance= (float)$before_balance + (float)$amount;//異動後點數
                    $parameter=array();
                    $colSql="mem_num,kind,points,makers_num,makers_balance,admin_num,buildtime,before_balance,after_balance";
                    $sqlStr="INSERT INTO `member_wallet` (".sqlInsertString($colSql,0).")";
                    $sqlStr.=" VALUES (".sqlInsertString($colSql,1).")";
                    $parameter[":mem_num"]=$mem_num;
                    $parameter[":kind"]=4;	//遊戲轉出
                    $parameter[":points"]=$amount;
                    $parameter[":makers_num"]=$gamemaker_num;
                    $parameter[":makers_balance"]=(float)$output->Balance;
                    $parameter[":admin_num"]=tb_sql("admin_num","member",$mem_num);
                    $parameter[":buildtime"]=now();
                    $parameter[':before_balance']=$before_balance;
                    $parameter[':after_balance']=$after_balance;
                    $this->CI->webdb->sqlExc($sqlStr,$parameter);
                    return NULL;
                }
            }else{
                return "轉點錯誤：".$err[$output->error_code];
            }
        }else{
            return $this->CheckFundTransfer($OrderId,$direction+1,$u_id,$amount,$mem_num,$gamemaker_num);
            //return '系統繁忙中，請稍後再試'	;
        }

    }
	
	//報表 需要自行開一個資料表，例如：EG遊戲就是 eg_report，再把所有會收到的欄位盡量都記錄下來，呼叫的是Eg_report.php 的 get_report()

	private function getWalletTotal($acc){//這裡先寫固定假的
		return 10000;
	}
}

?>