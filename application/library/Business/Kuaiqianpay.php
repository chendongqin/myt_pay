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
     * 扫码支付(商户扫用户)
     * @param \M\MytMerchant $merchant
     * @param $orderId
     * @param $amount
     * @param $goodsName
     * @param string $authCode
     * @param $payType
     * @param string $ranNum
     * @param string $termTraceNo
     * @param string $termInvoiceNo
     * @param string $termSettleDays //延迟结算天数
     * @return bool|mixed
     * @throws \Exception
     */
    public function scan_code_b2c(\M\MytMerchant $merchant, $orderId, $amount, $goodsName, $authCode, $payType = '', $ranNum = '', $termTraceNo = '', $termInvoiceNo = '', $termSettleDays = '')
    {
        $pay = new \Ku\Pay\Kuaiqianpay\Payer($merchant->getPublic_key(), $merchant->getPrivate_key());
        $config = $pay->getConfig();
        $pay->addParamData('orderId', $orderId);
        //货币类型：固定CNY
        $pay->addParamData('cur', $this->getCur());
        //扫码类型
        $pay->addParamData('payType', $payType);
        //金额，单位分
        $pay->addParamData('amt', $amount);
        //扫码条纹码
        $pay->addParamData('authCode', $authCode);
        //商品名称
        $pay->addParamData('merchName', $goodsName);
        $pay->addParamData('merchantId', $merchant->getMerchat_sn());
        $pay->addParamData('terminalId', $merchant->getTermianal_sn());
        if ($termTraceNo) {
            $pay->addParamData('termTraceNo', $termTraceNo);
        }
        if ($termInvoiceNo) {
            $pay->addParamData('termInvoiceNo', $termInvoiceNo);
        }
        //扫码支付
        $pay->addParam('bizType', 'ISV011');
        $pay->addParam('appId', $merchant->getApp_id());
        //随机值，校验参数
        if ($ranNum) {
            $pay->addParam('randomNum', $ranNum);
        }
        $pay->setBaseUrl($config['url']);
        $send = $pay->postJsonRequest();
        $json = json_decode($send, true);
        $verify = $pay->checkSign($json);
        if ($verify === false) {
            return $this->getMsg(290, '返回的签名不正确');
        }
        return $json;
    }


    public function scan_code_c2b(\M\MytMerchant $merchant, $orderId, $amount, $goodsName, $payType, $ranNum = '', $termTraceNo = '', $termInvoiceNo = '', $termSettleDays = '')
    {
        $pay = new \Ku\Pay\Kuaiqianpay\Payer($merchant->getPublic_key(), $merchant->getPrivate_key());
        $config = $pay->getConfig();
        $pay->addParamData('orderId', $orderId);
        //货币类型：固定CNY
        $pay->addParamData('cur', $this->getCur());
        //扫码类型
        $pay->addParamData('payType', $payType);
        //金额，单位分
        $pay->addParamData('amt', $amount);
        //商品名称
        $pay->addParamData('merchName', $goodsName);
        $pay->addParamData('merchantId', $merchant->getMerchat_sn());
        $pay->addParamData('terminalId', $merchant->getTermianal_sn());
        if ($termTraceNo) {
            $pay->addParamData('termTraceNo', $termTraceNo);
        }
        if ($termInvoiceNo) {
            $pay->addParamData('termInvoiceNo', $termInvoiceNo);
        }
        //扫码支付
        $pay->addParam('bizType', 'ISV011');
        $pay->addParam('appId', $merchant->getApp_id());
        //随机值，校验参数
        if ($ranNum) {
            $pay->addParam('randomNum', $ranNum);
        }
        $pay->setBaseUrl($config['url']);
        $send = $pay->postJsonRequest();
        $json = json_decode($send, true);
        $verify = $pay->checkSign($json);
        if ($verify === false) {
            return $this->getMsg(290, '返回的签名不正确');
        }
        return $json;
    }


    /**
     * 订单轮询 //responseCode=00表示交易成功，68和C0表示交易处理中，其他表示交易失败
     * @param \M\MytTradeOrder $mytTradeOrder
     * @return bool|mixed
     * @throws \Exception
     */
    public function polling(\M\MytTradeOrder $mytTradeOrder)
    {
        $merchant = \M\Mapper\MytMerchant::getInstance()->findById($mytTradeOrder->getMerchant_id());
        if (!$merchant instanceof \M\MytMerchant) {
            return $this->getMsg(260, '订单商户不存在');
        }
        $payData = json_decode($mytTradeOrder->getTrade_info());
        $pay = new \Ku\Pay\Kuaiqianpay\Payer($merchant->getPublic_key(), $merchant->getPrivate_key());
        $config = $pay->getConfig();
        $pay->addParamData('orderId', $mytTradeOrder->getOut_trade_no());
        //货币类型：固定CNY
        $pay->addParamData('cur', $this->getCur());
        //扫码类型
        $pay->addParamData('payType', $payData->payType);
        //金额，单位分
        $pay->addParamData('amt', $payData->amt);
        $pay->addParamData('merchantId', $merchant->getMerchat_sn());
        $pay->addParamData('terminalId', $merchant->getTermianal_sn());
        //支付轮询
        $pay->addParam('bizType', 'ISV012');
        $pay->addParam('appId', $merchant->getApp_id());
        $pay->setBaseUrl($config['url']);
        $send = $pay->postJsonRequest();
        $json = json_decode($send, true);
        $verify = $pay->checkSign($json);
        if ($verify === false) {
            return $this->getMsg(500, '返回的签名不正确');
        }
        return $json;
    }

    /**
     *
     * @param \M\MytTradeOrder $mytTradeOrder
     * @param $cancelType
     * @param int $refundAmt
     * @param string $termOperId
     * @return bool|mixed
     * @throws \Exception
     */
    public function refund(\M\MytTradeOrder $mytTradeOrder, $cancelType, $refundAmt = 0, $termOperId = 'admin')
    {
        $merchant = \M\Mapper\MytMerchant::getInstance()->findById($mytTradeOrder->getMerchant_id());
        if (!$merchant instanceof \M\MytMerchant) {
            return $this->getMsg(260, '订单商户不存在');
        }
        $payData = json_decode($mytTradeOrder->getTrade_info());
        if ($cancelType == '02') {
            if (!$this->verifyScanB2CTypes($payData->payType)) {
                return $this->getMsg(261, '超时撤销只针对商户扫码支付');
            } elseif (time() - strtotime($payData->txnTime) < 120) {
                return $this->getMsg(262, '未达到撤销时间，不可超时撤销');
            } elseif ($mytTradeOrder->getStatus() != 1) {
                return $this->getMsg(265, '订单状态不属于处理中，不可超时撤销');
            }
            $refundAmt = $payData->amt;
            $typeStr = '超时撤销';
        } else {
            if (time() <= strtotime($payData->txnTime)) {
                return $this->getMsg(263, '退货/正常退款需要隔天才能操作');
            } elseif ($mytTradeOrder->getStatus() != 2) {
                return $this->getMsg(265, '订单状态不成共，不可撤销/退货');
            }
            $refundAmt = $refundAmt > 0 ? $refundAmt : $payData->amt;
            $typeStr = $cancelType == '01' ? '正常撤销' : '退货';
        }
        $pay = new \Ku\Pay\Kuaiqianpay\Payer($merchant->getPublic_key(), $merchant->getPrivate_key());
        $config = $pay->getConfig();
        $mapper = \M\Mapper\MytTradeOrder::getInstance();
        $payCode = \Ku\Consts::KUAIQIANPAY['refund_' . $cancelType];
        $orderId = $payCode . \Ku\Tool::createOrderSn();
        $type = $mapper->getOrderType($typeStr);
        $randomNum = 'v' . $type . \Ku\Tool::createOrderSn();
        $insertRes = $mapper->createKuaiqian($orderId, $merchant->getId(), $mytTradeOrder->getGoods_name(), $type, bcdiv($refundAmt, 100, 2), 'local', 0, $randomNum, $mytTradeOrder->getGoods_attribute(), $mytTradeOrder->getOut_trade_no());
        if ($insertRes === false) {
            return $this->getMsg(264, '添加退款订单失败');
        }
        $pay->addParamData('orderId', $orderId);
        //货币类型：固定CNY
        $pay->addParamData('originalIdTxn', $payData->idTxn);
        //扫码类型
        $pay->addParamData('cancelType', $cancelType);
        //金额，单位分
        $pay->addParamData('amt', $refundAmt);
        $pay->addParamData('originalOrderId', $mytTradeOrder->getOut_trade_no());
        $pay->addParamData('originalPayType', $payData->payType);
        $pay->addParamData('termOperId', $termOperId);
        $pay->addParamData('merchantId', $merchant->getMerchat_sn());
        $pay->addParamData('terminalId', $merchant->getTermianal_sn());
        //退款
        $pay->addParam('bizType', 'ISV013');
        $pay->addParam('appId', $merchant->getApp_id());
        $pay->setBaseUrl($config['url']);
        $send = $pay->postJsonRequest();
        $json = json_decode($send, true);
        $verify = $pay->checkSign($json);
        if ($verify === false) {
            return $this->getMsg(500, '返回的签名不正确');
        }
        //退款订单处理
        $status = $mapper->getKqTradeStatus($json['responseCode']);
        $order = $mapper->findByOut_trade_no($orderId);
        if (!$order instanceof \M\MytTradeOrder) {
            return $this->getMsg(266, '订单不存在');
        }
        $order->setStatus($status);
        $order->setUpdate_at(date('YmdHis'));
        if ($order->getStatus() == 3) {
            $order->setError($json['responseMsg']);
            $mapper->update($order);
            return $this->getMsg(267, $json['responseMsg']);
        }
        $order->setTrade_info(json_encode($json['data']));
        $mapper->update($order);
        return true;
    }

    /**
     * 扫码确认结算API(只有支付时做了延迟结算的可以调这个接口，正常扫码支付不需要调这个接口！)
     * @param \M\MytTradeOrder $mytTradeOrder
     * @return bool|mixed
     * @throws \Exception
     */
    public function sure_pay(\M\MytTradeOrder $mytTradeOrder)
    {
        $merchant = \M\Mapper\MytMerchant::getInstance()->findById($mytTradeOrder->getMerchant_id());
        if (!$merchant instanceof \M\MytMerchant) {
            return $this->getMsg(260, '订单商户不存在');
        }
        $payData = json_decode($mytTradeOrder->getTrade_info());
        $pay = new \Ku\Pay\Kuaiqianpay\Payer($merchant->getPublic_key(), $merchant->getPrivate_key());
        $config = $pay->getConfig();
        $pay->addParamData('idTxnCtrl', $payData->idTxnCtrl);
        $pay->addParamData('merchantId', $merchant->getMerchat_sn());
        $pay->addParamData('terminalId', $merchant->getTermianal_sn());
        //延迟订单支付确认
        $pay->addParam('bizType', 'ISV014');
        $pay->addParam('appId', $merchant->getApp_id());
        $pay->setBaseUrl($config['url']);
        $send = $pay->postJsonRequest();
        $json = json_decode($send, true);
        $verify = $pay->checkSign($json);
        if ($verify === false) {
            return $this->getMsg(500, '返回的签名不正确');
        }
        return $json;
    }

    /**
     * 查询订单
     * @param \M\MytTradeOrder $mytTradeOrder
     * @return bool|mixed
     * @throws \Exception
     */
    public function query(\M\MytTradeOrder $mytTradeOrder)
    {
        $merchant = \M\Mapper\MytMerchant::getInstance()->findById($mytTradeOrder->getMerchant_id());
        if (!$merchant instanceof \M\MytMerchant) {
            return $this->getMsg(260, '订单商户不存在');
        }
        $payData = json_decode($mytTradeOrder->getTrade_info());
        $pay = new \Ku\Pay\Kuaiqianpay\Payer($merchant->getPublic_key(), $merchant->getPrivate_key());
        $config = $pay->getConfig();
        $orderType = 2;
        if ($mytTradeOrder->getType() > 20) {
            //文档未备注其他订单的订单类型
//            $orderType = 1;
        }
        $pay->addParamData('orderType', $orderType);
        if (isset($payData->idTxn)) {
            $pay->addParamData('idTxn', $payData->idTxn);
        }
        if (isset($payData->termTraceNo)) {
            $pay->addParamData('termTraceNo', $payData->termTraceNo);
        }
        if (isset($payData->txnType)) {
            $pay->addParamData('txnType', $payData->txnType);
        }
        $pay->addParamData('orderId', $mytTradeOrder->getOut_trade_no());
        if (isset($payData->idTxnCtrl)) {
            $pay->addParamData('idTxnCtrl', $payData->idTxnCtrl);
        }
        $pay->addParamData('merchantId', $merchant->getMerchat_sn());
        $pay->addParamData('terminalId', $merchant->getTermianal_sn());
        //订单查询
        $pay->addParam('bizType', 'ISV001');
        $pay->addParam('appId', $merchant->getApp_id());
        $pay->setBaseUrl($config['url']);
        $send = $pay->postJsonRequest();
        $json = json_decode($send, true);
        $verify = $pay->checkSign($json);
        if ($verify === false) {
            return $this->getMsg(500, '返回的签名不正确');
        }
        if ($json['responseCode'] != '00') {
            return $this->getMsg(500, $json['responseMsg']);
        }
        return $json['data'];
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
    public function getScanB2CTypes()
    {
        return $this->_scanB2CType;
    }

    /**
     * 验证B2C扫码类型是否有效
     * @param $key
     * @return bool
     */
    public function verifyScanB2CTypes($key)
    {
        if (isset($this->_scanB2CType[$key])) {
            return $this->_scanB2CType[$key];
        }
        return false;
    }

    /**
     * 获取C2B扫码类型
     * @return array
     */
    public function getScanC2BTypes()
    {
        return $this->_scanC2BType;
    }

    /**
     * 验证C2B扫码类型是否有效
     * @param $key
     * @return bool
     */
    public function verifyScanC2BTypes($key)
    {
        if (isset($this->_scanC2BType[$key])) {
            return $this->_scanC2BType[$key];
        }
        return false;
    }

    public function getScanType($key)
    {
        $types = array_merge($this->_scanC2BType, $this->_scanB2CType);
        if (!isset($types[$key])) {
            return '';
        }
        return $types[$key];
    }

    private $_scanB2CType = [
        '99BILL' => '快钱钱包(商户扫码)',
        'BAIDU'  => '百度(商户扫码)',
        'FFAN'   => '飞凡(商户扫码)',
        'ALIPAY' => '支付宝(商户扫码)',
        'CUPBSC' => '银联(商户扫码)',
        'WECHAT' => '微信(商户扫码)',
    ];

    private $_scanC2BType = [
        '99BILLCSB' => '快钱钱包扫码支付',
        'BAIDUCSB'  => '百度扫码支付',
        'FFANCSB'   => '飞凡扫码支付',
        'ALIPAYCSB' => '支付宝扫码支付',
        'CUPCSB'    => '银联扫码支付',
        'WECHATCSB' => '微信扫码支付',
    ];

    /**
     * 快钱支付mas回调处理
     * @param $params
     * @return bool
     */
    public function callback($params)
    {
        if (!isset($params['externalTraceNo'])) {
            return $this->getMsg(201, '获取参数错误');
        }
        $mapper = \M\Mapper\MytTradeOrder::getInstance();
        $order = $mapper->findByOut_order_no($params['externalTraceNo']);
        if (!$order instanceof \M\MytTradeOrder) {
            return $this->getMsg(202, '平台订单不存在');
        }
        $merchant = \M\Mapper\MytMerchant::getInstance()->findById($order->getMerchant_id());
        if (!$merchant instanceof \M\MytMerchant) {
            return $this->getMsg(203, '商户不存在');
        }
        $verifyRes = $this->verifyMasSign($params, APPLICATION_PATH . $merchant->getMas_public_key());
        if($verifyRes === false){
            return $this->getMsg(204,'签名错误');
        }
        //记录信息
        $tradeInfo = json_encode($params);
        $order->setTrade_info($tradeInfo);
        if($params['processFlag'] == 0){
            $order->setStatus(2);//处理成功
        }elseif($params['processFlag'] == 1){
            $order->setError($params['responseMsg']);
            $order->setStatus(3);//处理失败
        }
        $mapper->update($order);
        return true;
    }

    /**
     * 回调验签
     * @param $params
     * @param $path
     * @return bool
     */
    public function verifyMasSign($params, $path)
    {
        $signSort = [
            'processFlag', 'txnType', 'orgTxnType', 'amt',
            'externalTraceNo', 'orgExternalTraceNo', 'terminalOperId', 'authCode',
            'RRN', 'txnTime', 'shortPAN', 'responseCode', 'cardType', 'issuerId'
        ];
        $signStr = '';
        foreach ($signSort as $value) {
            $signStr .= empty($params[$value]) ? '' : $params[$value];
        }
        $signature = $params['signature'];
        $fp = fopen($path, 'r');
        $cert = fread($fp, 8192);
        fclose($fp);
        $pubkeyid = openssl_get_publickey($cert);
        $ok = (boolean)openssl_verify($signStr, $signature, $pubkeyid);
        return $ok;
    }

}