<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once (dirname(__FILE__)."/Gateway_tpl.php");
class Newebpay extends Gateway_tpl {
	public function __construct(){
	    parent::__construct();
	}

	public function getData($orderNo, $amount, $member = NULL){
        $data['MerchantID'] = $this->merchant;
        $data['RespondType'] = 'JSON';
        $data['TimeStamp'] = time();
        $data['Version'] = '1.5';
        $data['LangType'] = 'zh-tw';
        $data['MerchantOrderNo'] = $orderNo;
        $data['Amt'] = $amount;
        $data['ItemDesc'] = self::ITEM_NAME;
        $data['TradeInfo'] = $this->sendValidate($data);
        $data['TradeSha'] = strtoupper(hash("sha256", 'HashKey='.$this->hashKey.'&'.$data['TradeInfo'].'&'.'HashIV='.$this->hashIV));
        $data['NotifyURL'] = $this->getPayResultURL();
        $data['CustomerURL'] =$this->getCodeURL();
//        $data['Email'] = (isset($member['email'])) ? $member['email'] : 'payment'.rand(10,999).'@gmail.com';
//        $data['LoginType'] = '0';
        return $data;
    }

    //測試串接網址：https://ccore.newebpay.com/MPG/mpg_gateway
    //正式串接網址：https://core.newebpay.com/MPG/mpg_gateway

	public function atmPay($orderNo, $amount, $type = NULL, $member = NULL){
        $this->saveData($orderNo, 'ATM', '013'); // 指定收單銀行，空值代表不指定。013:國泰世華  812:台新銀行  822:中國信託
	    $data = $this->getData($orderNo, $amount, $member);
        $data['VACC'] = '1';
        $data['ExpireDate'] = date('Ymd',time() + (5 * 24 * 60 * 60));  //繳費期限
        //$s='[Status]=>SUCCESS[MerchantID]=>3430112[TradeInfo]=>3716aa2a929c1b40071a732f1b8c57c3ecb6a6aeefed4061705dba662c14d0ecd5ae3aa9ed14e96745b3542fdda87c89ad4e9909e9b7f8d05288dae032526e7e0825b39b9e4df97b7b70e50866a71b6f9e17c6514e56cf5e3befee9c3371df308e3554e0713c07f7042818f24b8100ccc3728e2b590310416eff8a53a9d807d94a1df600f76c6931afab103ffc9e551d54974d59b3a54f255fed4062fb5da8470f127077979c60070a6a6f1793cddf3d34c521817ba26e78394dec16cbda8ded9b21f977be42ad4946ec9c4481e130ef812888df401cb0ab40d4f8348f848b6f5f4473184dd6a0d86916b3ccb1198eee41014554196628c74a22e7d7e3183cd8c2270a1236fed34102f7c71fb44913d5edd87f1b5432d3532786c83ad12fc341a2c45e9b8294605e50059d3792d7a6cb76ecaab7e6d0209ea65cc5bb2371ef177a5e869d0ae306fce2210b59bf90c6f6e7cf4807d069c1fed3bb199eb89f25556aebbe0dd8d384481c452a807762685537239fff06e2bf5bd3fb1d612e55fceb34b1425e458ba5b6b946ba943a7e42598f2f0a9713d8cf2327a2bd0d7d7952053f109ea896d2c88c4f1fc7680ff12af9877a9c3e888367d65fdb69d13b3e7a3f955ef1e286ae94a183652b4c36b3639ba39d3affb1833feef1797874a61b57bc3247e4cb9b30532a7c92b6997e2476e9b90aebaab2367a25ff1fa33f1b380c772822fea4f34b7b8002d537e8944e91a9045c328e21eaaec80fbbb5d6bbf067e7936f18a1ecd1e3a0c8db44c8215e8ba2624894ef4c31fab41e537157b206a0a7ea26ad326aae5b07856b3e7be32c0f0dddd4e8275f09d90a2233aecb0470409b7d67b6d4b6778faa7dd26f6143130786b8a4cfc9b05ae76976b709474c34d409605cd32c4c5e0f6c341349efc2ed002fdf74f35a559fff6dd1dc4c138629bc02b96edb06c48cf6b4976f5379576a2eec897094a2460781ea251859b72a2fc3339ff66a56c8737e9a79ad25ae9e4cd8febc5c9ac1632e8706bcf4b0dda66ff9f6[TradeSha]=>3052314E7E9A6418128705697ECA25DE3381FF603B9614291DBD9F19FF93F8A9';

        print_r($data);
        exit;
        $this->submit($this->apiUrl, $data);
    }
    public function cvsPay($orderNo, $amount, $type = 'CVS', $member = NULL){
        $this->saveData($orderNo, 'CVS', $type);
        $data = $this->getData($orderNo, $amount, $member);
        $data['CVS'] = '1';
        $data['ExpireDate'] = date('Ymd',time() + (5 * 24 * 60 * 60));  //繳費期限
        $this->submit($this->apiUrl, $data);
    }

    public function sendValidate($data = NULL){
        //aes-256加密
        $return_str = '';
        if (!empty($data)) {
            //將參數經過 URL ENCODED QUERY STRING
            $return_str = http_build_query($data);
        }
        return trim(bin2hex(openssl_encrypt($this->addpadding($return_str), 'aes-256-cbc', $this->hashKey, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $this->hashIV)));
    }

    public function receiveValidate($data = NULL){
        //md5(StoreID+交易密碼+id+Amount+errorcode)
        $validate = $data['StoreID'].$this->hashKey.$data['id'].$data['Amount'].$data['errorcode'];
        return md5($validate);
    }

    public function checkValidate($data = NULL){
        $flag = FALSE;
        if($data['MerchantID'] = $this->merchant && $data['Status'] == 'SUCCESS')$flag = TRUE;
        return $flag;
    }

    public function getOrderNo($data){
        return $data["MerchantOrderNo"];
    }
    public function getAmount($data){
        return $data["Amt"];
    }

    public function getCode($data){
        $code = NULL;
        if(isset($data['CodeNo']))$code = $data['CodeNo'];
        elseif(isset($data['PayBankCode']))$code = $data['PayBankCode'];
        return $code;
    }

    public function getType($data){
        $type = NULL;
        if(isset($data['StoreType'])){
            switch($data['StoreType']){
                case '2':
                    $type = 'FAMI';
                    break;
                case '1':
                    $type = 'IBON';
                    break;
                case '3':
                    $type = 'OKGO';
                    break;
                case '4':
                    $type = 'HILIFEET';
                    break;
            }
        }
        elseif(isset($data['BankCode']))$type = $data['BankCode'];
        return $type;
    }
    public function getMsgSuccess(){
        return 'SUCCESS';
    }

    function addpadding($string, $blocksize = 32) { //加密
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }

    function create_aes_decrypt($s) {  //解密
        return $this->strippadding(openssl_decrypt(hex2bin($s),'AES-256-CBC', $this->hashKey, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $this->hashIV));
    }
    function strippadding($string) {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        } else {
            return false;
        }
    }
}
?>