<?php

/*
 * 推送App消息
 */

namespace Cron;


class Kqpay extends CronAbstract
{
    private $_pollingKey = 'KQ_POLLING_%S';

    public function main()
    {
        $func = $this->getArgv(2);

        call_user_func(array('\Cron\Kqpay', $func));

    }


    public function polling()
    {
        $mapper = \M\Mapper\MytTradeOrder::getInstance();
        $payBusiness = \Business\Kuaiqianpay::getInstance();
        $beginTime = time();
        $redis = $this->getRedis();
        while (time() - $beginTime < 60) {
            $order = $mapper->pull();
            if (!$order instanceof \M\MytTradeOrder) {
                sleep(1);
                continue;
            }
            $key = sprintf($this->_pollingKey, $order->getOut_trade_no());
            if ($redis->get($key) !== false) {
                $order->setIs_done(0);
                $mapper->update($order);
                continue;
            }
            $redis->set($key, 1, 3);
            $requestTime = time();
            $res = $payBusiness->polling($order);
            if ($res === false) {
                $msg = $payBusiness->getMessage();
                $this->log($order->getOut_trade_no() . ':' . $msg['msg']);
                continue;
            }
            $status = $mapper->getKqTradeStatus($res['responseCode']);
            $order->setStatus($status);
            $order->setUpdate_at(date('YmdHis'));
            if ($status == 3) {
                //失败处理
                $order->setIs_done(2);
                $order->setError($res['responseMsg']);
                $mapper->update($order);
                return $this->returnData($res['responseMsg'], 202);
            }else if ($order->getStatus() == 1) {
                //轮询订单排序处理
                $payData = json_decode($order->getTrade_info());
                $payData->txnTime = empty($payData->txnTime) ? $order->getCreate_at() : $payData->txnTime;
                $polling = $requestTime - strtotime($payData->txnTime);
                $order->setPolling($polling);
                //轮询超时撤销
                if ($order->getPolling() > 120) {
                    $this->log($order->getOut_trade_no() . ':超时撤销');
                    //B2C do refund
                    if($payBusiness->verifyScanB2CTypes($payData->payType)){
                        $res = $payBusiness->refund($order,'02');
                        if($res === true){
                            $order->setIs_done(2);
                            $order->setStatus(4);
                            $order->setError('轮询超时退款');
                        }else{
                            $msg = $payBusiness->getMessage();
                            $this->log($order->getOut_trade_no().':轮询超时退款失败,'.$msg['msg']);
                        }
                    }else{//超时无效
                        $order->setStatus(3);
                        $order->setError('超时过期');
                        $order->setIs_done(2);
                    }
                } else {
                    $order->setIs_done(0);
                }
            }elseif($status == 2){
                //交易成功，更新新的数据
                $payData = json_decode($order->getTrade_info(),true);
                foreach ($res as $key => $val){
                    $payData[$key] = $val;
                }
                $order->setIs_done(2);
                $order->setTrade_info(json_encode($payData));
            }
            $updateRes = $mapper->update($order);
            if ($updateRes === false) {
                $this->log($order->getOut_trade_no().':更新失败,'.json_encode($order->toArray()));
                continue;
            }
        }
        return false;
    }


}
