<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 2019/5/13
 * Time: 21:32
 */

namespace Business;

use Ku\Consts;

class Kuaiqianpay extends BusinessAbstract
{
    use Instance;

    private $_params = [];
    private $_cur = 'CNY';


    /**
     * 扫码支付
     * @param $orderId
     * @param $amount
     * @param $goodsName
     * @param $payType
     * @param string $authCode
     * @param string $ranNum
     * @param string $termTraceNo
     * @param string $termInvoiceNo
     * @param string $termSettleDays
     * @return bool|mixed
     * @throws \Exception
     */
    public function scan_code($orderId, $amount, $goodsName, $payType, $authCode = '', $ranNum ='' , $termTraceNo ='' ,$termInvoiceNo ='', $termSettleDays = '')
    {
        $pay = new \Ku\Pay\Kuaiqianpay\Payer();
        $config = $pay->getConfig();
//        $payCode = Consts::KUAIQIANPAY['scan_code'];
//        $orderId = $payCode . \Ku\Tool::createOrderSn();
        $pay->addParamData('orderId', $orderId);
        //货币类型：固定CNY
        $pay->addParamData('cur', $this->getCur());
        //扫码类型
        $this->addParamData('payType', $payType);
        //金额，单位分
        $pay->addParamData('amt', $amount);
        //扫码条纹码
        if($authCode){
            $pay->addParamData('authCode', $authCode);
        }
        //商品名称
        $pay->addParamData('merchName', $goodsName);
        $pay->addParamData('merchantId', $config['merchantId']);
        $pay->addParamData('terminalId', $config['terminalId']);
        if($termTraceNo){
            $pay->addParamData('termTraceNo', $termTraceNo);
        }
        if($termInvoiceNo){
            $pay->addParamData('termInvoiceNo', $termInvoiceNo);
        }
        //扫码支付
        $pay->addParam('bizType', 'ISV011');
        //随机值，校验参数
        if($ranNum){
            $pay->addParam('randomNum', $ranNum);
        }
        $pay->setBaseUrl($config['url']);
        $send = $pay->postJsonRequest();
        $json = json_decode($send, true);
        $verify = $pay->checkSign($json);
        if($verify === false){
            return $this->getMsg(500,'返回的签名不正确');
        }
        return $json;

    }

    //轮询
    public function polling(){

    }


    /**
     * 设置币种
     * @param $cur
     * @return $this
     */
    public function setCur($cur)
    {
        $this->_cur = (string)$cur;
        return $this;
    }

    /**
     * 获取币种
     * @return string
     */
    public function getCur()
    {
        return $this->_cur;
    }

    /**
     * 获取B2C扫码类型
     * @return array
     */
    public function getScanB2CTypes(){
        return $this->_scanB2CType;
    }

    /**
     * 获取C2B扫码类型
     * @return array
     */
    public function getScanC2BTypes(){
        return $this->_scanC2BType;
    }

    private $_scanB2CType = [
        '99BILL'=>	'快钱钱包B扫C',
        'BAIDU'=>	'百度B扫C',
        'FFAN'=>	'飞凡B扫C',
        'ALIPAY'=>	'支付宝B扫C',
        'CUPBSC'=>	'银联B扫C',
        'WECHAT'=>	'微信B扫C',
    ];

    private $_scanC2BType = [
        '99BILLCSB'=>'快钱钱包C扫B',
        'BAIDUCSB'=>	'百度C扫B',
        'FFANCSB'=>	'飞凡C扫B',
        'ALIPAYCSB'=>	'支付宝C扫B',
        'CUPCSB'=>	'银联C扫B',
        'WECHATCSB'=>	'微信C扫B',
    ];
}