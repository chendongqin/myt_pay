<?php

namespace Ku\Pay\Kuaiqianpay;

/**
 * 快钱付支付
 *
 * @author chendongqin
 */
final class Payer extends \Ku\Pay\PayAbstract {

    private $_charset = 'UTF-8';
    protected $_sign_type = 'RSA';
    public $_paramsData = [];
    private $_publicKey = '';
    private $_privateKey = '';


    
    public function __construct($publicKey ,$privateKey) {
        $this->_pay_type = 'kuaiqianpay';
        $this->_publicKey = $publicKey;
        $this->_privateKey = $privateKey;
    }


    /**
     * 订单生成签名结果
     * @return string 签名结果字符串
     * @throws \Exception
     */
    public function buildOrderRequest() {
        $config = $this->getConfig();
        $params = $this->buildRequestParam();
        $url = $this->appendURI($config['url'], $params);
        return $url;
    }

    /**
     * 订单生成签名结果
     * @param $para_sort 已排序要签名的数组
     * return 签名结果字符串
     */
    public function buildUserRequest() {
        $config = $this->getConfig();
        $params = $this->buildRequestParam();
        $url = $this->appendURI($config['url'], $params);
        return $url;
    }

    /**
     * 用于防钓鱼，调用接口query_timestamp来获取时间戳的处理函数
     * 注意：该功能PHP5环境及以上支持，因此必须服务器、本地电脑中装有支持DOMDocument、SSL的PHP配置环境。建议本地调试时使用PHP开发软件
     * return 时间戳字符串
     */
    public function queryTimestamp() {
        $url = $this->getBaseUrl() . "?service=query_timestamp&partner=" . $this->getConfig()->get('partner') . "&_input_charset=" . $this->_charset;
        $doc = new \DOMDocument();
        $doc->load($url);
        $itemEncrypt_key = $doc->getElementsByTagName("encrypt_key");
        $encrypt_key = $itemEncrypt_key->length ? $itemEncrypt_key->item(0)->nodeValue : '';

        return $encrypt_key;
    }

    /**
     * 生成要请求的参数数组
     * @return array 要请求的参数数组
     * @throws \Exception
     */
    public function buildRequestParam() {
        $config = $this->getConfig();
        $this->addParam('version', $config['version']);
        $this->addParam('charset',$this->_charset);
        $this->addParam('signType', $this->_sign_type);
        $params = $this->paramsFilter();
        $params['data']= $this->getParamData();
        $sign = $this->createSign($params,$this->_privateKey);
        //签名结果与签名方式加入请求提交参数组中
        $params['sign']= $sign;
        return $params;
    }


    public function paramsFilter()
    {
        $paramsFilter = array();
        $params = $this->getParams();
        foreach ($params as $key => $val) {
            if ($key == "sign" || $val == "") {
                continue;
            } else {
                $paramsFilter[$key] = $params[$key];
            }
        }
        $this->_params = $paramsFilter;
        return $this->_params;
    }


    public function checkSign($response) {
        $sign = $response['sign'];
        unset($response['sign']);
        $params = $this->argSort($response);
        $signStr = '';
        foreach ( $params as $k => $val ) {
            if(is_array($val)){
                //必须不转义，否则不通过
                $signStr .= "&" . $k . "=" . json_encode($val,JSON_UNESCAPED_UNICODE);
            }else{
                $signStr .= "&" . $k . "=" . $val;
            }
        }
        $signStr = trim($signStr,'&');
        //对url连接有转移符处理
        $signStr = str_replace('\\','',$signStr);
        $signStr = strtoupper(md5($signStr));
        $res = $this->rsaCheck($signStr,$sign,$this->_publicKey);
        return $res;
    }







    /**
     * [curlPost 模拟表单提交]
     * @param string $url
     * @param string $data
     * @return string $data
     */
    public function httpRequest($post = true)
    {
        $http = new \Ku\Http();
        $http->setTimeout(5);
        $url = $post === true ? $this->getBaseUrl() : $this->assemble();
        $http->setUrl($url);
        $http->setParam($this->buildRequestParam(),true);
        return $http->send();
    }

    /**
     * json形式提交模拟表单
     * @return bool|mixed
     * @throws \Exception
     */
    public function postJsonRequest()
    {
        $http = new \Ku\Http();
        $http->setTimeout(5);
        $url = $this->getBaseUrl();
        $http->setUrl($url);
        $http->setParam($this->buildRequestParam(),true,true);
        return $http->postJson();
    }


    /**
     * 通过公钥进行rsa加密
     * @param $data
     * @return string 加密好的密文
     * @throws \Exception
     */
    private function rsaEncrypt($data)
    {
        $encrypted = '';
        $cert = $this->_publicKey;
        $cert = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($cert, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";
        $pu_key = openssl_pkey_get_public ($cert ); // 这个函数可用来判断公钥是否是可用的
        openssl_public_encrypt ( $data, $encrypted, $pu_key ); // 公钥加密
        $encrypted = base64_encode ( $encrypted ); // 进行编码
        return $encrypted;
    }


    /**
     * 重写创建sign的方法——获取sign
     * @param array $params
     * @param $config //私钥key
     * @return bool|string
     */
    public function createSign($params, $config){
        $params = $this->argSort($params);
        $signType = $this->_sign_type;
        $signStr = '';
        unset($params['sign']);
        foreach ( $params as $k => $val ) {
            if(is_array($val)){
                //必须不转义
                $signStr .= "&" . $k . "=" . json_encode($val,JSON_UNESCAPED_UNICODE);
            }else{
                $signStr .= "&" . $k . "=" . $val;
            }
        }
        $signStr = trim($signStr,'&');
        $signStr = strtoupper(md5($signStr));
        if($signType == 'RSA'){
            return $this->rsaSign($signStr,$config);
        }
        return false;
    }

    //建签
    public function rsaSign($signStr,$config){
        $sign = '';
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($config, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        $pkeyid = openssl_pkey_get_private ( $privateKey );
        if(!$pkeyid){
            return false;
        }
        openssl_sign ( $signStr, $sign, $pkeyid, OPENSSL_ALGO_SHA1 );
        openssl_free_key ( $pkeyid );
        $sign = base64_encode($sign);
        return $sign;
    }

    //验签
    public function rsaCheck($data, $sign , $config)  {
        $public_key = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($config, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";
        $res = openssl_get_publickey($public_key);
        if(!$res)
        {
            return false;
        }
        $result = (bool)openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA1);
        openssl_free_key($res);
        return $result;
    }

    /**
     * 添加data参数的具体参数
     * @param $key
     * @param $value
     * @return $this
     */
    public function addParamData($key, $value)
    {
        $this->_paramsData[$key] = (string)$value;
        return $this;
    }

    /**
     * 获取data参数的详细信息
     * @return array
     */
    public function getParamData()
    {
        return $this->_paramsData;
    }

}
