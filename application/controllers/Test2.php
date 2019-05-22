<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test2 extends CI_Controller{
    function __construct(){
        parent::__construct(); // needed when adding a constructor to a controller
		//$this->load->library('rsa');
		//$CI =& get_instance();
		//$CI =& get_instance();

 		$this->load->library('api/allgameapi');

    }
	
	public function index(){
        //echo $this->bingo->create_account('VCTest123','a123456',1756,28);
        //echo $this->dreamgame->query_handicaps();
        //print_r($this->wmapi->deposit('U88Test123',100,1756,13));
        //echo $this->sagamingapi->get_balance('U88Test123');
        //print_r($this->rtgapi->withdrawal('U88Test123',200,1756,51));
        //echo $this->wmapi->forward_game('VCTest123');
        print_r($this->PragmaticPlayAPI->get_balance('VCTest123')); //1179880  1179710


        //歐博流程
        //1 查詢限紅
        //echo $this->allbetapi->query_handicaps();

        //SUP 彩球 流程
        //1 建立代理
        //print_r($this->slotteryapi->create_agent());
        //2 建立複製會員
        //print_r($this->slotteryapi->create_exampleaccount());
        //3 給代理點數
        //print_r($this->slotteryapi->deposit_agent());
        //4 測試建立遊戲會員
        //print_r($this->slotteryapi->create_account('U88Test123','a123456',1756,20));
	}


	

}

?>