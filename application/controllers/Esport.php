<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once (dirname(__FILE__)."/Core_controller.php");
class Esport extends Core_controller{
	
	public function __construct(){
		parent::__construct();
		
	}
	
	public function index(){
		
		
		$this -> load -> view("www/esport.php", $this -> data);
	}
	

		
} 