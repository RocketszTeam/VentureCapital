<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once (dirname(__FILE__)."/Core_controller.php");
class EEgame extends Core_controller{
	
	public function __construct(){
		parent::__construct();
		
	}
	
	public function index(){
		
		//輪播
		$this->load->library('banner');
		$this->data["bannerList"]=$this->banner->banner_show(1);
		$this -> load -> view("www/eegame.php", $this -> data);
	}
	

		
} 