<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sxbapi {
    var $CI;
    var $timeout = SXB_timeout;	//curl允許等待秒數

	public function __construct(){
		$this->CI = &get_instance();
	}

    function signKey($post_data){
        $token = array("token" => SXB_Token);
        $post_data =array_merge($post_data,$token);
        $md5str="";
        foreach ($post_data as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }
        $sign= substr_replace($md5str,'',-1);
        return md5($sign);
    }

    public function EGConnect($post_data, $path){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, SXB_API_URL . $path);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $headers = array('api_key:' . SXB_API_Key);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,$this -> timeout);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        curl_close($ch);
        return array('httpCode' => $httpCode, 'response' => $response, 'curl_errno' => $curl_errno);
    }

    //註冊一樣找是否有21(原SSB)但API用新的方式
	public function create_account($u_id, $u_password, $mem_num, $gamemaker_num = 21){
        //$currency = '1';  //1 = TWD， 2 = CNY
        //$istest = '2';    //1 = 正式會員， 2 = 測試
		$parameter = array();
		$sqlStr = "select * from `games_account` where `mem_num` = ? and `gamemaker_num` = ?";
		$parameter[':mem_num'] = $mem_num;
		$parameter[':gamemaker_num'] = $gamemaker_num;
		$row = $this -> CI -> webdb -> sqlRow($sqlStr, $parameter);
		if($row == NULL){	//該館遊戲帳號不存在則呼叫API
            $path = '/Create_Member.php';
            $post_data  = array(
                "username" => $u_id,
                "alias" => $u_id,
                "currency" => SXB_currency,
                "istest" => SXB_istest,
                "top" => SXB_Agent
            );
            $signKey = array("sign_key" => $this -> signKey($post_data));    //取得sign_key
            $post_data =array_merge($post_data,$signKey);                    //將取得的sign_key 加回陣列
            $output = $this -> EGConnect($post_data, $path);
            $outputJson = json_decode($output['response']);
            //print_r($outputJson);
			if(!$output['curl_errno']){
				if($output['httpCode'] == 200 && $outputJson -> code == "001"){
					$colSql = "u_id,mem_num,gamemaker_num,cid";
					$upSql = "INSERT INTO `games_account` (".sqlInsertString($colSql,0).") VALUES (".sqlInsertString($colSql,1).")";
					$parameter = array();
					$parameter[':u_id'] = trim($u_id);
					$parameter[':mem_num'] = $mem_num;
					$parameter[':gamemaker_num'] = $gamemaker_num;
                    $parameter[':cid'] = $outputJson -> mem_id;
					$this -> CI -> webdb -> sqlExc($upSql, $parameter);
					return NULL;
				}else{
					return '創建失敗：'.$outputJson -> code.':'.$outputJson -> msg;
				}
			}else{
				return '系統繁忙中，請稍後再試！';
			}
		}else{
			return '會員已有此類型帳號';	
		}
	}

	public function get_balance($u_id){	//餘額查詢
        $path = '/Member_Money.php';
        $post_data = array(
            "username" => $u_id
        );
        $signKey = array("sign_key" => $this -> signKey($post_data));    //取得sign_key
        $post_data =array_merge($post_data,$signKey);                     //將取得的sign_key 加回陣列
        $output = $this -> EGConnect($post_data, $path);
        $outputJson = json_decode($output['response']);
        if(!$output['curl_errno']){
            if($output['httpCode'] == 200 && $outputJson -> code == "001"){
				return $outputJson -> money;
			}else{
                return '查詢餘額失敗：'.$outputJson -> code.':'.$outputJson -> msg;
			}
		}else{
            return '系統繁忙中，請稍後再試！';
		}
	}
	
	//轉入遊戲 type=1;轉出遊戲 type=2
	public function deposit($u_id, $amount, $mem_num, $gamemaker_num = 21, $logID = NULL){	//轉入點數到遊戲帳號內
		$out_trade_no = time().mt_rand(1111, 9999);
		//將轉點編號寫入DB
		$upSql = "UPDATE `member_wallet_log` SET `TradeNo` = '".$out_trade_no."' where num = ".$logID;
		$this -> CI -> webdb -> sqlExc($upSql);

        $path = '/Transfer_Money.php';
        $post_data = array(
            'username' => trim($u_id),
            'money' => $amount,
            'billno' => $out_trade_no       //int
        );
        $signKey = array("sign_key" => $this -> signKey($post_data));    //取得sign_key
        $post_data =array_merge($post_data,$signKey);                     //將取得的sign_key 加回陣列
        $output = $this -> EGConnect($post_data, $path);
        $outputJson = json_decode($output['response']);

        if(!$output['curl_errno']) {
            if($output['httpCode'] == 200 && $outputJson -> code == "001") {
                $WalletTotal = getWalletTotal($mem_num);	//會員餘額
                $before_balance = (float)$WalletTotal;    //異動前點數
                $after_balance = (float)$before_balance - (float)$amount;//異動後點數
                $parameter = array();
                $colSql = "mem_num,kind,points,makers_num,makers_balance,admin_num,buildtime,before_balance,after_balance";
                $sqlStr = "INSERT INTO `member_wallet` (".sqlInsertString($colSql,0).")";
                $sqlStr .= " VALUES (".sqlInsertString($colSql,1).")";
                $parameter[":mem_num"] = $mem_num;
                $parameter[":kind"] = 3;	//轉入遊戲
                $parameter[":points"] = "-".$amount;
                $parameter[":makers_num"] = $gamemaker_num;
                $parameter[":makers_balance"] = $outputJson -> money;
                $parameter[":admin_num"] = tb_sql("admin_num","member",$mem_num);
                $parameter[":buildtime"] = now();
                $parameter[':before_balance'] = $before_balance;
                $parameter[':after_balance'] = $after_balance;
                $this -> CI -> webdb -> sqlExc($sqlStr,$parameter);
                return NULL;

			}else{
				return '轉點錯誤：'.$outputJson -> code.':'.$outputJson -> msg;
			}
		}else{
			return $this -> point_checking($out_trade_no,1, $u_id, $mem_num, $gamemaker_num);
			//return '系統繁忙中，請稍候再試';	
		}
	}

	//轉入遊戲 type=1;轉出遊戲 type=2
	public function withdrawal($u_id, $amount, $mem_num, $gamemaker_num = 21, $logID = NULL){	//轉出遊戲點數到錢包內
		$out_trade_no = time().mt_rand(1111,9999);
		//將轉點編號寫入DB
		$upSql = "UPDATE `member_wallet_log` SET `TradeNo`='".$out_trade_no."' where num=".$logID;
		$this -> CI -> webdb -> sqlExc($upSql);

        $path = '/Transfer_Money.php';
        $post_data = array(
            'username' => trim($u_id),
            'money' => '-'.$amount,
            'billno' => $out_trade_no       //int
        );
        $signKey = array("sign_key" => $this -> signKey($post_data));    //取得sign_key
        $post_data =array_merge($post_data,$signKey);                     //將取得的sign_key 加回陣列
        $output = $this -> EGConnect($post_data, $path);
        $outputJson = json_decode($output['response']);

        if(!$output['curl_errno']){
            if($output['httpCode'] == 200 && $outputJson -> code == "001"){
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
                $parameter[":makers_balance"] = $outputJson -> money;
                $parameter[":admin_num"] = tb_sql("admin_num", "member", $mem_num);
                $parameter[":buildtime"] = now();
                $parameter[':before_balance'] = $before_balance;
                $parameter[':after_balance'] = $after_balance;
                $this->CI->webdb->sqlExc($sqlStr, $parameter);
                return NULL;
			}else{
				return '轉點錯誤：'.$outputJson -> code.':'.$outputJson -> msg;
			}
		}else{
			return $this -> point_checking($out_trade_no,2, $u_id, $amount, $mem_num, $gamemaker_num);
			//return '系統繁忙中，請稍候再試';	
		}
	}
	
	public function point_checking($out_trade_no, $type, $u_id, $amount, $mem_num, $gamemaker_num){	//點查轉帳情況
        $path = '/Transfer_Check.php';
        $post_data = array(
            "username" => $u_id, //查詢區間不得超過一天的時間
            "billno" => $out_trade_no
        );
        $signKey = array("sign_key" => $this -> signKey($post_data));    //取得sign_key
        $post_data =array_merge($post_data,$signKey);                     //將取得的sign_key 加回陣列
        $output = $this -> EGConnect($post_data, $path);
        $outputJson = json_decode($output['response']);

        if(!$output['curl_errno']){
            if($output['httpCode'] == 200 && $outputJson -> code == "001"){
				$WalletTotal = getWalletTotal($mem_num);	//錢包餘額
				if($type == 1){	//轉入遊戲
                    $parameter = array();
					$before_balance = (float)$WalletTotal;	//異動前點數
					$after_balance = (float)$before_balance - (float)$amount;//異動後點數
					$colSql = "mem_num,kind,points,makers_num,makers_balance,admin_num,buildtime,before_balance,after_balance";
					$sqlStr = "INSERT INTO `member_wallet` (".sqlInsertString($colSql,0).")";
					$sqlStr .= " VALUES (".sqlInsertString($colSql,1).")";
					$parameter[":mem_num"] = $mem_num;
					$parameter[":kind"] = 3;	//轉入遊戲
					$parameter[":points"] = "-".$amount;
					$parameter[":makers_num"] = $gamemaker_num;
					$parameter[":makers_balance"] = $outputJson -> after;
					$parameter[":admin_num"] = tb_sql("admin_num","member", $mem_num);
					$parameter[":buildtime"] = now();
					$parameter[':before_balance'] = $before_balance;
					$parameter[':after_balance'] = $after_balance;
					$this -> CI -> webdb -> sqlExc($sqlStr, $parameter);
					return NULL;
				} else {	//轉出遊戲
					$parameter = array();
					$before_balance = (float)$WalletTotal;//異動前點數
					$after_balance = (float)$before_balance + (float)$amount;//異動後點數
					$colSql = "mem_num,kind,points,makers_num,makers_balance,admin_num,buildtime,before_balance,after_balance";
					$sqlStr = "INSERT INTO `member_wallet` (".sqlInsertString($colSql,0).")";
					$sqlStr .= " VALUES (".sqlInsertString($colSql,1).")";
					$parameter[":mem_num"] = $mem_num;
					$parameter[":kind"] = 4;	//遊戲轉出
					$parameter[":points"] = $amount;
					$parameter[":makers_num"] = $gamemaker_num;
					$parameter[":makers_balance"] = $outputJson -> after;
					$parameter[":admin_num"] = tb_sql("admin_num","member", $mem_num);
					$parameter[":buildtime"] = now();
					$parameter[':before_balance'] = $before_balance;
					$parameter[':after_balance'] = $after_balance;
					$this -> CI -> webdb -> sqlExc($sqlStr, $parameter);
					return NULL;
				}
			} else {
				return '查詢轉點錯誤：'.$outputJson -> code.':'.$outputJson -> msg;
			}
		} else {
			return '系統繁忙中，請稍候再試';
		}
	}

	public function forward_game($u_id){	//登入遊戲
        $this -> CI -> agent -> is_mobile()? $mobile = "1" : $mobile ="0";  //0 = PC版，1 = 手機版
        $slangx = "zh-tw"; //繁體 = zh-tw，簡體 = zh-cn
        $path = '/Member_Login.php';
        $post_data = array(
            "username" => $u_id,
            "slangx" => $slangx,
            //"mobile" => $mobile,
        );
        $signKey = array("sign_key" => $this -> signKey($post_data));    //取得sign_key
        $post_data =array_merge($post_data,$signKey);                     //將取得的sign_key 加回陣列
        $output = $this -> EGConnect($post_data, $path);
        $outputJson = json_decode($output['response']);

        if(!$output['curl_errno']){
            if($output['httpCode'] == 200 && $outputJson -> code == "001"){
                if($this -> CI -> agent -> is_mobile()){	//電腦版
                    return SXB_LoginGame.$outputJson -> lid;
                }else{
                    return SXB_LoginGame.$outputJson -> lid;
                }
			}else{
				return '登入遊戲錯誤：'.$outputJson -> code.':'.$outputJson -> msg;
			}
		}else{
			return '系統繁忙中，請稍候再試';	
		}
	}

    public function reporter_all($maxModId = 0, $checked = 0){  //報表
        $path = '/Get_Tix.php';
        $post_data = array(
            "agent" => SXB_Agent,
            "maxModId" => $maxModId,    //最大修改注單紀錄的id
            "checked" => $checked       //0所有注單  1有結果的注單
        );
        $signKey = array("sign_key" => $this -> signKey($post_data));    //取得sign_key
        $post_data =array_merge($post_data,$signKey);                     //將取得的sign_key 加回陣列
        $output = $this -> EGConnect($post_data, $path);
        $outputJson = json_decode($output['response']);

        if(!$output['curl_errno']){
            if($output['httpCode'] == 200 && ($outputJson -> code == "001" || $outputJson -> code == "002")){
                return $outputJson;
            }else{
                return '下注取得錯誤：'.$outputJson -> code.':'.$outputJson -> msg;
            }
        }else{
            return '系統繁忙中，請稍候再試';
        }
    }

//---自有API------------------------------------------------------------------------------------------------------------

    public function memberEdit($username){ //修改會員資料
        $path = '/Member_Edit.php';
        $post_data = array(
            "username" => $username,
            "top" => SXB_Agent,
//        "alias" => $alias,    //(選)名稱
//        "istest" => $istest,   //(選)1 = 正式會員， 2 = 測試
//        "status" => $status    //(選)狀態 1 = 啟用， 2 = 停押， 3 = 停用(無法登入)
        );
        $signKey = array("sign_key" => $this -> signKey($post_data));    //取得sign_key
        $post_data =array_merge($post_data,$signKey);                     //將取得的sign_key 加回陣列
        $output = $this -> EGConnect($post_data, $path);
        $outputJson = json_decode($output['response']);

        if(!$output['curl_errno']){
            if($output['httpCode'] == 200 && ($outputJson -> code == "001" || $outputJson -> code == "002")){
                return $outputJson;
            }else{
                return '發生錯誤：'.$outputJson -> code.':'.$outputJson -> msg;
            }
        }else{
            return '系統繁忙中，請稍候再試';
        }
    }

    public function minusMoney(){ //抓取負額度會員
        $path = '/Minus_Money.php';
        $post_data = array();
        $signKey = array("sign_key" => $this -> signKey($post_data));    //取得sign_key
        $post_data =array_merge($post_data,$signKey);                     //將取得的sign_key 加回陣列
        $output = $this -> EGConnect($post_data, $path);
        $outputJson = json_decode($output['response']);

        if(!$output['curl_errno']){
            if($output['httpCode'] == 200 && ($outputJson -> code == "001" || $outputJson -> code == "002")){
                return $outputJson;
            }else{
                return '發生錯誤：'.$outputJson -> code.':'.$outputJson -> msg;
            }
        }else{
            return '系統繁忙中，請稍候再試';
        }
    }

    public function zeroMoney($username){ //負額度會員的額度歸零
        $path = '/Zero_Money.php';
        $post_data = array(
            "username" => $username
        );
        $signKey = array("sign_key" => $this -> signKey($post_data));    //取得sign_key
        $post_data =array_merge($post_data,$signKey);                     //將取得的sign_key 加回陣列
        $output = $this -> EGConnect($post_data, $path);
        $outputJson = json_decode($output['response']);

        if(!$output['curl_errno']){
            if($output['httpCode'] == 200 && ($outputJson -> code == "001" || $outputJson -> code == "002")){
                return $outputJson;
            }else{
                return '發生錯誤：'.$outputJson -> code.':'.$outputJson -> msg;
            }
        }else{
            return '系統繁忙中，請稍候再試';
        }
    }

    public function getMsg(){ //最新消息
        $path = '/Get_Msg.php';
        $post_data = array(
            "maxId" => '0'
        );
        $signKey = array("sign_key" => $this -> signKey($post_data));    //取得sign_key
        $post_data =array_merge($post_data,$signKey);                     //將取得的sign_key 加回陣列
        $output = $this -> EGConnect($post_data, $path);
        $outputJson = json_decode($output['response']);

        if(!$output['curl_errno']){
            if($output['httpCode'] == 200 && ($outputJson -> code == "001" || $outputJson -> code == "002")){
                return $outputJson;
            }else{
                return '發生錯誤：'.$outputJson -> code.':'.$outputJson -> msg;
            }
        }else{
            return '系統繁忙中，請稍候再試';
        }
    }


}
