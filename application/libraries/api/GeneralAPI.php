<?php

defined('BASEPATH') OR exit('No direct script access allowed');

abstract class GeneralAPI
{

    public $CI;

    public function __construct()
    {
        $this->CI =& get_instance();

    }

    /**
     * @param $u_id 遊戲帳號
     * @param $mem_num 系統會員PK
     * @param $mem_num
     * @param int $gamemaker_num
     */
    public function create_account($u_id, $mem_num, $gamemaker_num)
    {
        $colSql = "u_id,mem_num,gamemaker_num";
        $column = sqlInsertString($colSql, 0);
        $value = sqlInsertString($colSql, 1);
        $upSql = "
                    INSERT INTO 
                        `games_account` ({$column})
                     VALUES 
                            ({$value})
         ";

        $parameter = [];
        $parameter[':u_id'] = trim($u_id);
        $parameter[':mem_num'] = $mem_num;
        $parameter[':gamemaker_num'] = $gamemaker_num;

        $this->CI->webdb->sqlExc($upSql, $parameter);
    }

    /**
     * 檢查帳號是否存在
     *
     * @param $u_id 遊戲帳號
     * @param $mem_num 系統會員PK
     * @param $gamemaker_num 遊戲廠商代號 e.g. 112
     * @return mixed
     */
    protected function get_game_account($u_id, $mem_num, $gamemaker_num)
    {
        $parameter = [];
        $sqlStr = "
                    SELECT 
                        * 
                    FROM
                        `games_account` 
                     WHERE
                             `u_id` = ? 
                         AND `mem_num` = ? 
                         AND `gamemaker_num` = ?
         ";
        $parameter[':u_id'] = trim($u_id);
        $parameter[':mem_num'] = $mem_num;
        $parameter[':gamemaker_num'] = $gamemaker_num;

        return $this->CI->webdb->sqlRow($sqlStr, $parameter);
    }

    /**
     * 將轉點編號寫入DB ???
     *
     * @param $order_id
     * @param $log_id
     */
    protected function set_member_wallet_log($order_id, $log_id)
    {
        $up_sql = "UPDATE `member_wallet_log` SET `TradeNo`='" . $order_id . "' where num=" . $log_id;

        $this->CI->webdb->sqlExc($up_sql);
    }

    /**
     * 看起來是轉點紀錄
     * @param $before_balance 異動前點數
     * @param $amount 異動的點數
     * @param $mem_num 系統會員PK
     * @param $gamemaker_num 遊戲代號
     * @param $makers_balance 遊戲廠商餘額
     * @param $type 類型 1.點數轉入遊戲 2.點數由遊戲轉出
     */
    protected function set_member_wallet($before_balance, $amount, $mem_num, $gamemaker_num, $makers_balance, $type)
    {
        $after_balance = (float)$before_balance - (float)$amount;
        $parameter = [];
        $colSql = "mem_num,kind,points,makers_num,makers_balance,admin_num,buildtime,before_balance,after_balance";
        $column = sqlInsertString($colSql, 0);
        $value = sqlInsertString($colSql, 1);
        $sqlStr = "INSERT INTO `member_wallet` ({$column})";
        $sqlStr .= " VALUES ({$value})";
        $parameter[":mem_num"] = $mem_num;
        if ($type === 1) {
            $parameter[":kind"] = 3;    //轉入遊戲
            $parameter[":points"] = "-" . $amount;
        }
        if ($type === 2) {
            $parameter[":kind"] = 4;    //轉入遊戲
            $parameter[":points"] = $amount;
        }

        $parameter[":makers_num"] = $gamemaker_num;

        $parameter[":makers_balance"] = (float)$makers_balance;
        $parameter[":admin_num"] = tb_sql("admin_num", "member", $mem_num);
        $parameter[":buildtime"] = now();
        $parameter[':before_balance'] = $before_balance;
        $parameter[':after_balance'] = $after_balance;

        $this->CI->webdb->sqlExc($sqlStr, $parameter);
    }
}