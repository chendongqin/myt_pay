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
        $goodsAttribute = $this->getParam('goodsAttribute', '', 'string');
        //商品属性转化为数组和json
        if($goodsAttribute){
            $explodes = explode(',',$goodsAttribute);
            $attributes = [];
            foreach ($explodes as $explode){
                $temp = implode(':',$explode);
                if(isset($temp[1])){
                    $attributes[$temp[0]] = $temp[1];
                }else{
                    $attributes[] = $temp[0];
                }
            }
            $goodsAttribute = json_encode($attributes);
        }
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
        $randomNum = 'v' . $type . \Ku\Tool::createOrderSn();
        $insertRes = $orderMapper->createKuaiqian($orderId, $merchantId, $goodsName, $type, $amount, $this->getDiver(), $randomNum,$goodsAttribute);
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
        $isShowQr = $this->getParam('isShowQr', 1, 'int');
        $size = $this->getParam('size', 10, 'int');
        $margin = $this->getParam('margin', 3, 'int');
        $goodsAttribute = $this->getParam('goodsAttribute', '', 'string');
        //商品属性转化为数组和json
        if($goodsAttribute){
            $explodes = explode(',',$goodsAttribute);
            $attributes = [];
            foreach ($explodes as $explode){
                $temp = implode(':',$explode);
                if(isset($temp[1])){
                    $attributes[$temp[0]] = $temp[1];
                }else{
                    $attributes[] = $temp[0];
                }
            }
            $goodsAttribute = json_encode($attributes);
        }
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
        $c2bScan = $payBusiness->verifyScanC2BTypes($payType);
        if (!$c2bScan) {
            return $this->returnData('扫码类型不正确');
        }
        $type = $orderMapper->getOrderType('用户扫码');
        $randomNum = 'v' . $type . \Ku\Tool::createOrderSn();
        $insertRes = $orderMapper->createKuaiqian($orderId, $merchantId, $goodsName, $type, $amount, $this->getDiver(), $randomNum,$goodsAttribute);
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
        $url = $res['data']['authCode'];
        if ($isShowQr) {
            $homeUrl = $this->getApiDomain('homeUrl');
            $html = '<img src="'.$homeUrl.'/api/pay/qrcode?url='.$url.'&size='.$size.'&margin='.$margin.'">
            <div><span style="font-size: 45px">请使用'.$c2bScan.'</span></div>';
            echo $html;
//            $QRcode = new \Qrcode\QRcode();
//            $errorCorrectionLevel = 'H'; //容错级别
//            $matrixPointSize = $size; //生成图片大小
//            $QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize, $margin);
            return false;
        }
        return $this->returnData('成功', 200, true, ['orderId' => $orderId, 'url' => $url]);


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
        if (empty($refundReason)) {
            return $this->returnData('退款原因，不能为空', 204);
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
        $res = $payBusiness->refund($order, $refundType, $amt, $termOperId);
        if ($res === true) {
            $order->setUpdate_at(date('YmdHis'));
            $order->setStatus(4);
            $order->setRemark('取消原因：' . $refundReason);
            $mapper->update($order);
        }
        return $this->returnData($payBusiness->getMessage());
    }

    /**
     * 订单查询
     * @return false
     */
    public function queryAction()
    {
        $orderSn = $this->getParam('orderSn', '', 'string');
        $mapper = \M\Mapper\MytTradeOrder::getInstance();
        $order = $mapper->findByOut_trade_no($orderSn);
        if (!$order instanceof \M\MytTradeOrder) {
            return $this->returnData('订单不存在', 201);
        }
        $payBusiness = \Business\Kuaiqianpay::getInstance();
        $res = $payBusiness->query($order);
        if ($res === false) {
            return $this->returnData($payBusiness->getMessage());
        }
        //扫码类型
        $res['scanPayType'] = $payBusiness->getScanType($res['scanPayType']);
        //订单支付状态
        $res['txnFlag'] = $mapper->getKqOrderTradeStatus($res['txnFlag']);
        //交易订单类型
        $res['txnType'] = $mapper->getKqOrderType($res['txnType']);
        //金额分单位转化为元
        $res['amt'] = bcdiv($res['amt'], 100, 2);
        $res['refundAmt'] = bcdiv($res['refundAmt'], 100, 2);
        if (!empty($res['equityInfo'])) {
            foreach ($res['equityInfo'] as $key => $val) {
                $res['equityInfo'][$key] = bcdiv($val, 100, 2);
            }
        }
        //时间格式转化
        $res['txnTime'] = date('Y-m-d H:i:s', strtotime($res['txnTime']));
        unset($res['merchantId']);
        unset($res['terminalId']);
        return $this->returnData('成功', 200, true, ['detail' => $res]);
    }

    /**
     * url转为二维码
     */
    public function qrcodeAction()
    {
        $url = $this->getParam('url', '', 'string');
        $size = $this->getParam('size', 10, 'int');
        $margin = $this->getParam('margin', 3, 'int');
        $url = urldecode($url);
        $QRcode = new \Qrcode\QRcode();
        $errorCorrectionLevel = 'H'; //容错级别
        $matrixPointSize = $size; //生成图片大小
        $QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize, $margin);
    }

    /**
     * 获取商户信息
     * @return false
     * @throws Exception
     */
    public function get_merchantAction()
    {
        $name = $this->getParam('name', '', 'string');
        $where = ['is_del' => 0];
        if ($name) {
            $where[] = "merchant_name like '" . $name . "%'";
        }
        $mapper = \M\Mapper\MytMerchant::getInstance();
        $select = $mapper->select();
        $select->where($where);
        $select->order(['id' => 'DESC']);
        $select->columns(['id', 'merchant_name']);
        $page = $this->getParam('page', 1, 'int');
        $pagelimit = $this->getParam('pagelimit', 15, 'int');
        $pager = new \Ku\Page($select, $page, $pagelimit, $mapper->getAdapter());
        return $this->returnData('成功', 200, true, ['page' => $page, 'pageLimit' => $pagelimit, 'lists' => $pager->getList()]);
    }

    /**
     * 获取商户扫码类型
     * @return false
     */
    public function csan_b2c_typesAction()
    {
        $payBusiness = \Business\Kuaiqianpay::getInstance();
        $data = $payBusiness->getScanB2CTypes();
        foreach ($data as $key => $val) {
            $data[$key] = str_replace('(商户扫码)', '', $val);
        }
        return $this->returnData('成功', 200, true, $data);
    }

    /**
     * 获取用户扫码类型
     * @return false
     */
    public function csan_c2b_typesAction()
    {
        $payBusiness = \Business\Kuaiqianpay::getInstance();
        $data = $payBusiness->getScanC2BTypes();
        return $this->returnData('成功', 200, true, $data);
    }



    public function qqs_queryAction(){
        $orderSn = $this->getParam('orderSn', '', 'string');
        $mapper = \M\Mapper\MytTradeOrder::getInstance();
        $order = $mapper->findByOut_trade_no($orderSn);
        if (!$order instanceof \M\MytTradeOrder) {
            return $this->returnData('订单不存在', 201);
        }
        $merchant = \M\Mapper\MytMerchant::getInstance()->findById($order->getMerchant_id());
        if(!$merchant instanceof \M\MytMerchant){
            return $this->returnData('商户不存在', 202);
        }
        $payBusiness = \Business\Kuaiqianpay::getInstance();
    }


    public function barcodeAction(){
        $orderSn = $this->getParam('orderSn','','string');
        $order = \M\Mapper\MytTradeOrder::getInstance()->findByOut_trade_no($orderSn);
        if(!$order instanceof \M\MytTradeOrder){
            throw new Exception('订单不存在');
        }
        // 加载字体大小
        $font = new \BarcodeBakery\Common\BCGFontFile(PUBLIC_PATH.'/../data/fonts/AntykwaBold.ttf', 18);
        //颜色条形码
        $color_black = new \BarcodeBakery\Common\BCGColor(0, 0, 0);
        $color_white = new \BarcodeBakery\Common\BCGColor(255, 255, 255);

        $drawException = null;
        try {
            $code = new \BarcodeBakery\Barcode\BCGcode128();
            $code->setScale(2);
            $code->setThickness(30); // 条形码的厚度
            $code->setForegroundColor($color_black); // 条形码颜色
            $code->setBackgroundColor($color_white); // 空白间隙颜色
            $code->setFont($font); //
            $code->parse($order->getOut_trade_no()); // 条形码需要的数据内容
        } catch(Exception $exception) {
            $drawException = $exception;
        }

        //根据以上条件绘制条形码
        $drawing = new \BarcodeBakery\Common\BCGDrawing('', $color_white);
        if($drawException) {
            $drawing->drawException($drawException);
        } else {
            $drawing->setBarcode($code);
            $drawing->draw();
        }
        // 生成PNG格式的图片
        header('Content-Type: image/png');
        $drawing->finish(\BarcodeBakery\Common\BCGDrawing::IMG_FORMAT_PNG);
    }


}