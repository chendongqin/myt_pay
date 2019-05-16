<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 2019/5/13
 * Time: 21:32
 */

namespace Business;
class Kuaiqianpay extends BusinessAbstract
{
    use Instance;

    private $_params = [];

    public function test()
    {
        $pay = new \Ku\Pay\Kuaiqianpay\Payer();
        $config = $pay->getConfig();
        $pay->addParamData('orderId', '201905130714955999');
        $pay->addParamData('cur', 'CNY');
//        $this->addParamData('payType', 'WECHATCSB');
        $pay->addParamData('amt', 1);
        $pay->addParamData('authCode', '288006526043109618');
        $pay->addParamData('merchName', '好商品');
        $pay->addParamData('merchantId', $config['merchantId']);
        $pay->addParamData('terminalId', $config['terminalId']);
        $pay->addParamData('termTraceNo', '000105');
        $pay->addParamData('termInvoiceNo', '000105');
        $pay->addParam('bizType', 'ISV011');
        $pay->setBaseUrl($config['url']);
        $send = $pay->postJsonRequest();
        $json = json_decode($send,true);
        $verify = $pay->checkSign($json);
        var_dump($json);
        var_dump($verify);
        return $json;
    }



}