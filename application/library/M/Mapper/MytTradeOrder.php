<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 2019/4/26
 * Time: 9:08
 */

namespace M\Mapper;

use M\Instance;

class MytTradeOrder extends MapperAbstract
{
    use Instance;
    protected $table = 'myt_trade_order';
    protected $modelClass = '\M\MytTradeOrder';

    /**
     * 获取快钱待轮询处理的订单
     * @return \M\ModelAbstract|null
     */
    public function pull()
    {
        //只有支付支持轮询|支付类型为11,12
//        $where = ['status'=>1,'is_done'=>0 ,'type < 13','payment_type'=>'kuaiqianpay'];
        $where = ['status' => 1, 'is_done' => 0, 'is_pos'=>0,'type < 13'];
        $order = ['polling asc', 'id desc'];
        $model = $this->fetch($where, $order);
        if (!$model instanceof \M\MytTradeOrder) {
            return null;
        }
        $model->setIs_done(1);
        $this->update($model);
        return $model;
    }


    public function createKuaiqian($orderId, $merchantId, $goodsName, $type, $amount, $diver = 'local', $ispos = 0, $randomNum = '', $goodsAttribute = '', $intoTradeNo = '')
    {
        $model = new \M\MytTradeOrder();
        $model->setOut_trade_no($orderId);
        $model->setMerchant_id($merchantId);
        $model->setPayment_type('kuaiqianpay');
        $model->setType($type);
        $model->setAmount($amount);
        $model->setDiver($diver);
        $model->setRandom_num($randomNum);
        $model->setInto_trade_no($intoTradeNo);
        $model->setCreate_at(date('YmdHis'));
        $model->setGoods_name($goodsName);
        $model->setGoods_attribute($goodsAttribute);
        $model->setIs_pos($ispos);
        $res = $this->insert($model);
        if ($res === false) {
            return false;
        }
        return true;
    }

    /**
     * 获取订单交易类型
     * @param $key
     * @return bool|mixed
     */
    public function getOrderType($key)
    {
        if (!isset($this->_orderTypes[$key])) {
            return false;
        }
        return $this->_orderTypes[$key];
    }

    /**
     * 快钱支付的交易结果
     * @param $key
     * @return bool|mixed
     */
    public function getKqTradeStatus($key)
    {
        if (!isset($this->_tradeStatus[$key])) {
            return 3;
        }
        return $this->_tradeStatus[$key];
    }

    /**
     * 快钱支付订单状态
     * @param $key
     * @return mixed|string
     */
    public function getKqOrderTradeStatus($key)
    {
        if (!isset($this->_orderTradeStatus[$key])) {
            return '';
        }
        return $this->_orderTradeStatus[$key];
    }

    /**
     * 快钱支付订单类型
     * @param $key
     * @return mixed|string
     */
    public function getKqOrderType($key)
    {
        if (!isset($this->_KqOrderTypes[$key])) {
            return '';
        }
        return $this->_KqOrderTypes[$key];
    }


    private $_orderTypes = [
        '商户扫码' => 11,
        '用户扫码' => 12,
        '正常撤销' => 21,
        '超时撤销' => 22,
        '退货'   => 23,
    ];

    private $_tradeStatus = [
        'C0' => 1,
        '68' => 1,
        '00' => 2,
    ];

    private $_orderTradeStatus = [
        'S' => '成功',
        'F' => '交易失败',
        'P' => '交易处理中',
        'V' => '交易撤销',
        'R' => '交易冲正',
        'D' => '已提交收单行(退货成功)',
    ];

    private $_KqOrderTypes = [
        '20200' => '扫码支付',
        '00500' => '退货',
        '20210' => '扫码撤销',
    ];

}