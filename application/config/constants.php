<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESCTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


define('IS_SECURE', (string) (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on'));

/*
 |--------------------------------------------------------------------------
| Docment root folders
|--------------------------------------------------------------------------
|
| These constants use existing location information to work out web root, etc.
|
*/

// Base URL (keeps this crazy sh*t out of the config.php
if (isset($_SERVER['HTTP_HOST'])){
	$base_url = (IS_SECURE ? 'https' : 'http')
	. '://' . $_SERVER['HTTP_HOST']
	. str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

	// Base URI (It's different to base URL!)
	$base_uri = parse_url($base_url, PHP_URL_PATH);
	if (substr($base_uri, 0, 1) != '/')
		$base_uri = '/' . $base_uri;
	if (substr($base_uri, -1, 1) != '/')
		$base_uri .= '/';
}
else
{
	$base_url = 'http://localhost/';
	$base_uri = '/';
}

// Define these values to be used later on
define('BASE_URL', $base_url);
define('BASE_URI', $base_uri);
define('APPPATH_URI', BASE_URI.APPPATH);

// We dont need these variables any more
unset($base_uri, $base_url);

/*
|--------------------------------------------------------------------------
| NEWOIL Description 
|--------------------------------------------------------------------------
|
| Which metadata of NEWOIL is currently running?
|
*/

define('CMS_NAME', '後台管理系統');
define('SITE_NAME', '金邊娛樂');
define('CMS_VERSION', '1.0.0');
define('CMS_RELEASE_DATE', '2016/05/06');

/*
 |--------------------------------------------------------------------------
| CMS Global Path
|--------------------------------------------------------------------------
|
| Global Path in CMS
|
*/

define('UPLOADS_PATH', dirname(__FILE__)."/../../upload");
define('UPLOADS_URL', BASE_URL."upload");

define('ASSETS_PATH', dirname(__FILE__)."/../../assets");
define('ASSETS_URL', BASE_URL."assets");
define('THEME_URL', BASE_URL."assets/"."www");

//定義後台路徑
define('SYSTEM_URL' , 'VCWzXTjb8h');

//AB
define("AB_Agent", "vcal8yn");                                             //*
define("AB_PROPERTY_ID", '8485479');                                       //*
define("AB_DES_KEY", "RxoAQ5YTmDepVY583q0STtmqBUsxwi4w");                  //*
define("AB_MD5_KEY", "J7ERlNHFoZntwtutIv//86QXGq4ZUeVHA3g1D89sXvI=");      //*
define("AB_API_URL", "https://api3.abgapi.net");
define("AB_IDEN_CODE",'vcl');                                              //*
define("AB_timeout",10);

//SA
define("SA_timeout",10);	                                    //curl允許等待秒數
define("SA_Checkkey",'O3IsEOE9O8R8G1iS');	                    //自行設定
define("SA_api_url",'http://api.sa-apisvr.com/api/api.aspx');	//API URL  備用 http://api.sa-apisvr.net/api/api.aspx
define("SA_rpt_api_url",'http://api.sa-rpt.com/api/api.aspx');	//取得報表 URL  備用 http://api.sa-rpt.net/api/api.aspx
define("SA_game_url",'https://vcl.sa-api4.com/app.aspx');	    //*遊戲URL
define("SA_Lobbycode",'A1136 ');	                            //*大廳名稱
define("SA_SecretKey",'30BA05E246C248CEB8C97829AEBCC9AA');	    //*私密金鑰
define("SA_Md5Key",'GgaIMaiNNtg');	                            //MD5金鑰
define("SA_EncryptKey",'g9G16nTs');	                            //DES 金鑰

//DG
define("DG_timeout",15);	//curl允許等待秒數
define("DG_api_url",'https://api.dg99api.com');
define("DG_agentName",'DG02128871');    //*代理账号
define("DG_key",'4d8ac265a3d74757b0da70b50ca6db3f');    //*key
define("DG_currencyName",'TWD');
define("DG_iden_suffix",'VCL');     //*手机APP登入后缀

//WM
define("WM_timeout", 10);    //curl允許等待秒數
define("WM_url", 'https://rswb-039.wmapi88.com/api/public/Gateway.php');
define("WMagentAccount",'ventureapi');  //*
define("WM_signature", 'ce305fb2d14cbc77547577714d2e8ecb'); //*
define("WM_lang", 0);//0或空值 为简体中文

//SUPER  KEY IV 固定
define("SUPER_up_account",'F5185'); //*
define("SUPER_up_passwd",'Wyu983jk');   //*
define("SUPER_API_URL","http://apiball.king588.net/api");
define("SUPER_key",'WGI@X9ENgpo138jL');
define("SUPER_iv",'m%2qQ7L&wfafUj&b');
define("SUPER_copy_target","F6105");    //*
define("SUPER_timeout",10);	//curl允許等待秒數

//Super 彩 Slotteryapi  KEY IV 固定
define("slottery_up_acc",'F5185');  //*
define("slottery_up_pwd",'Wyu983jk');   //*
define("slottery_api_url",'http://apilt.king588.net/api_101');
define("slottery_cipher", MCRYPT_RIJNDAEL_128);
define("slottery_mode", MCRYPT_MODE_CBC);
define("slottery_copy_target",'F6105'); //*要複製的會員帳號
define("slottery_key",'WGI@X9ENgpo138jL');
define("slottery_iv",'m%2qQ7L&wfafUj&b');
define("slottery_timeout",10);	//curl允許等待秒數

//AVIA
define("AV_timeout",10);	//curl允許等待秒數
define("AV_api_url", 'https://api.avia-gaming.com/handler/api');
define("AV_Authorization",'4711085f8f41425ca6a75b68bb78fdd4');  //*

//7pk
define("s7pk_agent",'venture'); //*
define("s7pk_api_url",'http://gs.jb777.com/api');
define("s7pk_api_key",'sn79t8bU6SEqKktd');  //*
define("s7pk_login_url",'http://login.jb777.com/index_1222.php?uid=');
define("s7pk_timeout",6);	//curl允許等待秒數

//BINGO 只要修改 KEY
define("Bingo_timeout",15);	//curl允許等待秒數
define("Bingo_API_URL", 'http://www.sbingo.net');
define("Bingo_API_KEY",'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjUyZjdkZGUwODU3OGNiMzljMDY1ZDA4MWQxZTliMGEwOWEyYjg0NjJlYThjYjY4NTVhYTE2YWRkNmZlMmZlNzgwZThmNWIzZWY3OWI4YzU1In0.eyJhdWQiOiIxIiwianRpIjoiNTJmN2RkZTA4NTc4Y2IzOWMwNjVkMDgxZDFlOWIwYTA5YTJiODQ2MmVhOGNiNjg1NWFhMTZhZGQ2ZmUyZmU3ODBlOGY1YjNlZjc5YjhjNTUiLCJpYXQiOjE1NTc5MDU4NTYsIm5iZiI6MTU1NzkwNTg1NiwiZXhwIjoxNTg5NTI4MjU2LCJzdWIiOiI5NiIsInNjb3BlcyI6W119.I9fmQmaOPeggefoGUwxjy55iSuCGdLSLwhVp6xVwV2BV_SLqRXywGtzGnqM3n76n4gCZ7QYFZh4YT1oTj3XJwPwGI65ofvdMYNE6AATbSQIXRHDKeIDdl0DNcnqEt0aG6thq5CjhAX7I2_FN6SlfJmAEuhMGGGjrdDwtH-orBF2MaexSRjU8oi35ejDXfBvdU0rb1veXZskhtrPNg0sRPeRqoyqgEDuujOAI-oUS5XshzR8t9OTcfI_AKDugyCbzJCVajkVO_eqI4n0M3a1Hqg0TZcxv3qbYuklCy07j0u-1-34Gj5ab3DmlLFkTHzXLWsMTguI57KCTKPmjj5jyg8jIYX6ToWEfB7GQzEue08TR8qXwRMRXMao0szxysGrdsPEBrJFcgq6Z_oHqXiYKM1j-R_yUI1zskXaylda593MiZLIcWT1ipYay9gQJY0ET-y87r3xkJ-7gjYg8fxnt41QqNyxs9G-1JCioCFVN4bDG9Hu5-bw-QJEz90dVnQ8_WcknWX9nZQyVd6AQqq9ehIsYlNEx-tIa-WMCbhiivZXQS-z2mOr5cVu6wRPPOHkNfyKWFlNTo8X1iVyWwJ6qX3V73cd1O8c3b6D0Ujv6mNidCzi9faZzobc9Eu4kr1QrvVxkCEb9Au7PBUeEh96m_B41cGdfdqMC1c087whKgs0');

//RTG
define("rtg_timeout",6);	//curl允許等待秒數
define("rtg_api_url",'https://cms.rtgintegrations.com/api'); //測試 https://cms-pre.rtgintegrations.com/api  正式 https://cms.rtgintegrations.com/api
define("rtg_id",'Venture');  //*
define("rtg_key",'Gthj89eH'); //*

//EG
define("EG_ClientId", 'ME00006');
define("EG_ClientKey", "B0Mdxa6N3");
define("EG_ParentId", "vc"); //*
define("EG_API_URL", "http://kal365.com/member/external/api");
define("EG_GameID", "101");  //捕魚遊戲ID
define("EG_ReturnUrl", "http://www.em66.net/");  //返回網址
define("EG_StationID", "VC");  //*前綴
define("EG_timeout", 10);  //curl允許等待秒數

//9K
define("s9k_timeout",15);	//curl允許等待秒數
define("s9k_BossID",'vc_twd');  //*
define("s9k_api_url",'https://sb-api.9k168.com/api/');
define("s9k_ApiToken",'4729295aeaa8256ea086c36e1f297cf68697a5e8'); //*

//SXB 鑫寶2
define("SXB_API_Key", "");        //*
define("SXB_Token", "f45d017f-6a25-11e9-bd51-005056ae7b69");
define("SXB_API_URL", "http://789ab.com");          //正式環境
define("SXB_Agent", "");       //*
define("SXB_currency", "1");       //1 = TWD， 2 = CNY
define("SXB_istest", "1");         //1 = 正式會員， 2 = 測試
define("SXB_LoginGame", " http://dm33m.sxb168.win/loginPath.php?lid=");   //備用 http://dm3m.sxb168.win/loginPath.php?lid=
define("SXB_timeout", 10);