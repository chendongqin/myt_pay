<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 2019/5/12
 * Time: 14:29
 */

class PayController extends \Base\ApiController
{

    public function indexAction()
    {
        $payCode = Ku\Consts::KUAIQIANPAY['scan_code'];
        $orderId = $payCode . \Ku\Tool::createOrderSn();
        $payBusiness = \Business\Kuaiqianpay::getInstance();
//        $payBusiness->scan_code();
    }


    /**
     * 商户扫码支付
     * @return false
     */
    public function scan_code_b2cAction()
    {
        $merchantId = $this->getParam('merchantId', 0, 'int');
        $payType = $this->getParam('payType', '', 'string');
        $amount = $this->getParam('amount', 0, 'string');
        $authCode = $this->getParam('authCode', '', 'string');
        $goodsName = $this->getParam('goodsName', '', 'string');
        if (empty($goodsName)) {
            return $this->returnData('商品名称不能为空', 201);
        }
        if (!is_numeric($amount) || $amount <= 0) {
            return $this->returnData('支付金额错误', 202);
        }
        //防止传入金额与交易金额不一致
        $amount = \Ku\Tool::decimal($amount);
        if (empty($authCode)) {
            return $this->returnData('用户付款码不能为空', 203);
        }
        $amt = bcmul($amount, 100);
        $merchantMapper = \M\Mapper\MytMerchant::getInstance();
        $merchant = $merchantMapper->findById($merchantId);
        if (!$merchant instanceof \M\MytMerchant) {
            return $this->returnData('商户不存在', 204);
        }
        $payCode = Ku\Consts::KUAIQIANPAY['scan_code_b2c'];
        $orderId = $payCode . \Ku\Tool::createOrderSn();
        $payBusiness = \Business\Kuaiqianpay::getInstance();
        $orderMapper = \M\Mapper\MytTradeOrder::getInstance();
        $type = $orderMapper->getOrderType('商户扫码');
        var_dump($type);die();
        $randomNum = 'v' . $type . \Ku\Tool::createOrderSn();
        $insertRes = $orderMapper->createKuaiqian($orderId, $merchantId, $goodsName, $type, $amount, $this->getDiver(), $randomNum);
        if ($insertRes === false) {
            return $this->returnData('添加订单失败', 205);
        }
        $res = $payBusiness->scan_code_b2c($merchant, $orderId, $amt, $goodsName, $authCode, $payType);
        if ($res === false) {
            return $this->returnData($payBusiness->getMessage());
        }
        $order = $orderMapper->findByOut_trade_no($orderId);
        if (!$order instanceof \M\MytTradeOrder) {
            return $this->returnData('订单不存在', 206);
        }
        if (isset($res['randomNum']) && $order->getRandom_num() != $res['randomNum']) {
            return $this->returnData('数据校验不正正确', 207);
        }
        $tradeStatus = $orderMapper->getKqTradeStatus($res['responseCode']);
        $order->setStatus($tradeStatus);
        $order->setTrade_info(json_encode($res['data']));
        if ($tradeStatus == 3) {
            $order->setError($res['responseMsg']);
            $orderMapper->update($order);
            return $this->returnData($res['responseMsg'], 208, false, ['orderId' => $orderId]);
        }
        $order->setUpdate_at(date('YmdHis'));
        $updateRes = $orderMapper->update($order);
        if ($updateRes === false) {
            return $this->returnData('更新订单信息失败');
        }
        return $this->returnData('成功', 200, true, ['orderId' => $orderId]);
    }

    /**
     * 用户扫码支付
     * @return false
     */
    public function scan_code_c2bAction()
    {
        $merchantId = $this->getParam('merchantId', 0, 'int');
        $payType = $this->getParam('payType', '', 'string');
        $amount = $this->getParam('amount', 0, 'string');
        $goodsName = $this->getParam('goodsName', '', 'string');
        if (empty($goodsName)) {
            return $this->returnData('商品名称不能为空', 201);
        }
        if (!is_numeric($amount) || $amount <= 0) {
            return $this->returnData('支付金额错误', 202);
        }
        //防止传入金额与交易金额不一致
        $amount = \Ku\Tool::decimal($amount);
        $amt = bcmul($amount, 100);
        $merchantMapper = \M\Mapper\MytMerchant::getInstance();
        $merchant = $merchantMapper->findById($merchantId);
        if (!$merchant instanceof \M\MytMerchant) {
            return $this->returnData('商户不存在', 204);
        }
        $payCode = \Ku\Consts::KUAIQIANPAY['scan_code_c2b'];
        $orderId = $payCode . \Ku\Tool::createOrderSn();
        $payBusiness = \Business\Kuaiqianpay::getInstance();
        $orderMapper = \M\Mapper\MytTradeOrder::getInstance();
        if (!$payBusiness->verifyScanC2BTypes($payType)) {
            return $this->returnData('扫码类型不正确');
        }
        $type = $orderMapper->getOrderType('用户扫码');
        $randomNum = 'v' . $type . \Ku\Tool::createOrderSn();
        $insertRes = $orderMapper->createKuaiqian($orderId, $merchantId, $goodsName, $type, $amount, $this->getDiver(), $randomNum);
        if ($insertRes === false) {
            return $this->returnData('添加订单失败', 205);
        }
        $res = $payBusiness->scan_code_c2b($merchant, $orderId, $amt, $goodsName, $payType);
        if ($res === false) {
            return $this->returnData($payBusiness->getMessage());
        }
        $order = $orderMapper->findByOut_trade_no($orderId);
        if (!$order instanceof \M\MytTradeOrder) {
            return $this->returnData('订单不存在', 206);
        }
        if (isset($res['randomNum']) && $order->getRandom_num() != $res['randomNum']) {
            return $this->returnData('数据校验不正正确', 207);
        }
        if ($res['responseCode'] != '00') {
            return $this->returnData($res['responseMsg'], 208, false, ['orderId' => $orderId]);
        }
        $order->setStatus(1);
        $order->setTrade_info(json_encode($res['data']));
        $order->setUpdate_at(date('YmdHis'));
        $updateRes = $orderMapper->update($order);
        if ($updateRes === false) {
            return $this->returnData('更新订单信息失败', 209);
        }
        return $this->returnData('成功', 200, true, ['orderId' => $orderId, 'authCode' => $res['data']['authCode']]);
    }

    /**
     * 正常退款/退货
     * @return false
     */
    public function refundAction()
    {
        $orderSn = $this->getParam('orderSn', '', 'string');
        $termOperId = $this->getParam('termOperId', '', 'string');
        $refundType = $this->getParam('refundType', 0, 'int');
        $refundReason = $this->getParam('refundReason', '', 'string');
        if (!$refundType) {
            return $this->returnData('请填写退款类型', 203);
        }
        if(empty($refundReason)){
            return $this->returnData('退款原因，不能为空',204);
        }
        $refundType = $refundType == 1 ? '01' : '03';
        $mapper = \M\Mapper\MytTradeOrder::getInstance();
        $order = $mapper->findByOut_trade_no($orderSn);
        if (!$order instanceof \M\MytTradeOrder) {
            return $this->returnData('订单不存在', 201);
        }
        $refundAmount = $this->getParam('refundAmount', '', 'string');
        if (!is_numeric($refundAmount) || $refundAmount <= 0 || $refundAmount > $order->getAmount()) {
            return $this->returnData('退款金额错误', 202);
        }
        //防止传入金额与交易金额不一致
        $refundAmount = \Ku\Tool::decimal($refundAmount);
        $amt = bcmul($refundAmount, 100);
        $payBusiness = \Business\Kuaiqianpay::getInstance();
        $res = $payBusiness->refund($order,$refundType,$amt,$termOperId);
        if($res === true){
            $order->setUpdate_at(date('YmdHis'));
            $order->setStatus(4);
            $order->setRemark('取消原因：'.$refundReason);
            $mapper->update($order);
        }
        return $this->returnData($payBusiness->getMessage());
    }

    public function queryAction(){
        $orderSn = $this->getParam('orderSn', '', 'string');
        $mapper = \M\Mapper\MytTradeOrder::getInstance();
        $order = $mapper->findByOut_trade_no($orderSn);
        if (!$order instanceof \M\MytTradeOrder) {
            return $this->returnData('订单不存在', 201);
        }
        $payBusiness = \Business\Kuaiqianpay::getInstance();
        $res = $payBusiness->query($order);
        if ($res['responseCode'] != '00') {
            return $this->returnData($res['responseMsg'], 202);
        }
//        var_dump($res);die();
        $orderDetail = $res['data'];
        //扫码类型
        $orderDetail['scanPayType'] = $payBusiness->getScanType($orderDetail['scanPayType']);
        //订单支付状态
        $orderDetail['txnFlag'] = $mapper->getKqOrderTradeStatus($orderDetail['txnFlag']);
        //交易订单类型
        $orderDetail['txnType'] = $mapper->getKqOrderType($orderDetail['txnType']);
        return $this->returnData('成功',200,true,['detail'=>$orderDetail]);
    }

    public function testAction()
    {
        $mapper = \M\Mapper\MytTradeOrder::getInstance();
        $where = ['status'=>1, 'is_done' => 0, 'type' => 11];
        $order = $mapper->fetch($where);
        $payBusiness = \Business\Kuaiqianpay::getInstance();
        if ($order instanceof \M\MytTradeOrder) {
//            $order->setIs_done(1);
            $res = $payBusiness->refund($order,'02');
//            var_dump($res);die();
            if (!$res) {
                return $this->returnData($payBusiness->getMessage());
            }
            $status = $mapper->getKqTradeStatus($res['responseCode']);
            $order->setStatus($status);
            $order->setUpdate_at(date('YmdHis'));
            if ($status == 3) {
                $order->setError($res['responseMsg']);
                $mapper->update($order);
                return $this->returnData($res['responseMsg'], 202);
            }
            $updateRes = $mapper->update($order);
            if ($updateRes === false) {
                return $this->returnData('更新失败', 203);
            }
            return $this->returnData('更新成功', 200, true, ['orderId' => $order->getOut_trade_no()]);
        }
    }

}