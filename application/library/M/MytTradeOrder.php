<?php

/**
 * 流水订单表
 * 
 * @Table Schema: myt_pay
 * @Table Name: myt_trade_order
 */
namespace M;

class MytTradeOrder extends \M\ModelAbstract {

    /**
     * Params
     * 
     * @var array
     */
    protected $_params = null;

    /**
     * Id
     * 
     * Column Type: int(11)
     * auto_increment
     * PRI
     * 
     * @var int
     */
    protected $_id = null;

    /**
     * 商品名称
     * 
     * Column Type: varchar(255)
     * 
     * @var string
     */
    protected $_goods_name = '';

    /**
     * 交易流水号
     * 
     * Column Type: char(21)
     * 
     * @var string
     */
    protected $_out_trade_no = '';

    /**
     * 内部订单号（退款时为原订单号）
     * 
     * Column Type: varchar(21)
     * 
     * @var string
     */
    protected $_into_trade_no = '';

    /**
     * 商户id
     * 
     * Column Type: int(11)
     * Default: 0
     * 
     * @var int
     */
    protected $_merchant_id = 0;

    /**
     * 支付渠道
     * 
     * Column Type: varchar(20)
     * 
     * @var string
     */
    protected $_payment_type = '';

    /**
     * 交易类型
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @var int
     */
    protected $_type = 0;

    /**
     * 交易金额
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @var float
     */
    protected $_amount = 0.00;

    /**
     * 状态
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @var int
     */
    protected $_status = 0;

    /**
     * 创建时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @var int
     */
    protected $_create_at = 0;

    /**
     * 更新时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @var int
     */
    protected $_update_at = 0;

    /**
     * 是否已执行
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @var int
     */
    protected $_is_done = 0;

    /**
     * 操作设备
     * 
     * Column Type: varchar(20)
     * Default: local
     * 
     * @var string
     */
    protected $_diver = 'local';

    /**
     * 随机校验码
     * 
     * Column Type: varchar(30)
     * 
     * @var string
     */
    protected $_random_num = '';

    /**
     * 交易信息json
     * 
     * Column Type: varchar(800)
     * 
     * @var string
     */
    protected $_trade_info = '';

    /**
     * 错误描述
     * 
     * Column Type: varchar(255)
     * 
     * @var string
     */
    protected $_error = '';

    /**
     * 轮询时间
     * 
     * Column Type: int(5)
     * Default: 0
     * 
     * @var int
     */
    protected $_polling = 0;

    /**
     * 备注
     * 
     * Column Type: varchar(255)
     * 
     * @var string
     */
    protected $_remark = '';

    /**
     * Params
     * 
     * Column Type: array
     * Default: null
     * 
     * @var array
     */
    public function getParams() {
        return $this->_params;
    }

    /**
     * Id
     * 
     * Column Type: int(11)
     * auto_increment
     * PRI
     * 
     * @param int $id
     * @return \M\Myttradeorder
     */
    public function setId($id) {
        $this->_id = (int)$id;
        $this->_params['id'] = (int)$id;
        return $this;
    }

    /**
     * Id
     * 
     * Column Type: int(11)
     * auto_increment
     * PRI
     * 
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * 商品名称
     * 
     * Column Type: varchar(255)
     * 
     * @param string $goods_name
     * @return \M\Myttradeorder
     */
    public function setGoods_name($goods_name) {
        $this->_goods_name = (string)$goods_name;
        $this->_params['goods_name'] = (string)$goods_name;
        return $this;
    }

    /**
     * 商品名称
     * 
     * Column Type: varchar(255)
     * 
     * @return string
     */
    public function getGoods_name() {
        return $this->_goods_name;
    }

    /**
     * 交易流水号
     * 
     * Column Type: char(21)
     * 
     * @param string $out_trade_no
     * @return \M\Myttradeorder
     */
    public function setOut_trade_no($out_trade_no) {
        $this->_out_trade_no = (string)$out_trade_no;
        $this->_params['out_trade_no'] = (string)$out_trade_no;
        return $this;
    }

    /**
     * 交易流水号
     * 
     * Column Type: char(21)
     * 
     * @return string
     */
    public function getOut_trade_no() {
        return $this->_out_trade_no;
    }

    /**
     * 内部订单号（退款时为原订单号）
     * 
     * Column Type: varchar(21)
     * 
     * @param string $into_trade_no
     * @return \M\Myttradeorder
     */
    public function setInto_trade_no($into_trade_no) {
        $this->_into_trade_no = (string)$into_trade_no;
        $this->_params['into_trade_no'] = (string)$into_trade_no;
        return $this;
    }

    /**
     * 内部订单号（退款时为原订单号）
     * 
     * Column Type: varchar(21)
     * 
     * @return string
     */
    public function getInto_trade_no() {
        return $this->_into_trade_no;
    }

    /**
     * 商户id
     * 
     * Column Type: int(11)
     * Default: 0
     * 
     * @param int $merchant_id
     * @return \M\Myttradeorder
     */
    public function setMerchant_id($merchant_id) {
        $this->_merchant_id = (int)$merchant_id;
        $this->_params['merchant_id'] = (int)$merchant_id;
        return $this;
    }

    /**
     * 商户id
     * 
     * Column Type: int(11)
     * Default: 0
     * 
     * @return int
     */
    public function getMerchant_id() {
        return $this->_merchant_id;
    }

    /**
     * 支付渠道
     * 
     * Column Type: varchar(20)
     * 
     * @param string $payment_type
     * @return \M\Myttradeorder
     */
    public function setPayment_type($payment_type) {
        $this->_payment_type = (string)$payment_type;
        $this->_params['payment_type'] = (string)$payment_type;
        return $this;
    }

    /**
     * 支付渠道
     * 
     * Column Type: varchar(20)
     * 
     * @return string
     */
    public function getPayment_type() {
        return $this->_payment_type;
    }

    /**
     * 交易类型
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @param int $type
     * @return \M\Myttradeorder
     */
    public function setType($type) {
        $this->_type = (int)$type;
        $this->_params['type'] = (int)$type;
        return $this;
    }

    /**
     * 交易类型
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @return int
     */
    public function getType() {
        return $this->_type;
    }

    /**
     * 交易金额
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @param float $amount
     * @return \M\Myttradeorder
     */
    public function setAmount($amount) {
        $this->_amount = (float)$amount;
        $this->_params['amount'] = (float)$amount;
        return $this;
    }

    /**
     * 交易金额
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @return float
     */
    public function getAmount() {
        return $this->_amount;
    }

    /**
     * 状态
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @param int $status
     * @return \M\Myttradeorder
     */
    public function setStatus($status) {
        $this->_status = (int)$status;
        $this->_params['status'] = (int)$status;
        return $this;
    }

    /**
     * 状态
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @return int
     */
    public function getStatus() {
        return $this->_status;
    }

    /**
     * 创建时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @param int $create_at
     * @return \M\Myttradeorder
     */
    public function setCreate_at($create_at) {
        $this->_create_at = (int)$create_at;
        $this->_params['create_at'] = (int)$create_at;
        return $this;
    }

    /**
     * 创建时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @return int
     */
    public function getCreate_at() {
        return $this->_create_at;
    }

    /**
     * 更新时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @param int $update_at
     * @return \M\Myttradeorder
     */
    public function setUpdate_at($update_at) {
        $this->_update_at = (int)$update_at;
        $this->_params['update_at'] = (int)$update_at;
        return $this;
    }

    /**
     * 更新时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @return int
     */
    public function getUpdate_at() {
        return $this->_update_at;
    }

    /**
     * 是否已执行
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @param int $is_done
     * @return \M\Myttradeorder
     */
    public function setIs_done($is_done) {
        $this->_is_done = (int)$is_done;
        $this->_params['is_done'] = (int)$is_done;
        return $this;
    }

    /**
     * 是否已执行
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @return int
     */
    public function getIs_done() {
        return $this->_is_done;
    }

    /**
     * 操作设备
     * 
     * Column Type: varchar(20)
     * Default: local
     * 
     * @param string $diver
     * @return \M\Myttradeorder
     */
    public function setDiver($diver) {
        $this->_diver = (string)$diver;
        $this->_params['diver'] = (string)$diver;
        return $this;
    }

    /**
     * 操作设备
     * 
     * Column Type: varchar(20)
     * Default: local
     * 
     * @return string
     */
    public function getDiver() {
        return $this->_diver;
    }

    /**
     * 随机校验码
     * 
     * Column Type: varchar(30)
     * 
     * @param string $random_num
     * @return \M\Myttradeorder
     */
    public function setRandom_num($random_num) {
        $this->_random_num = (string)$random_num;
        $this->_params['random_num'] = (string)$random_num;
        return $this;
    }

    /**
     * 随机校验码
     * 
     * Column Type: varchar(30)
     * 
     * @return string
     */
    public function getRandom_num() {
        return $this->_random_num;
    }

    /**
     * 交易信息json
     * 
     * Column Type: varchar(800)
     * 
     * @param string $trade_info
     * @return \M\Myttradeorder
     */
    public function setTrade_info($trade_info) {
        $this->_trade_info = (string)$trade_info;
        $this->_params['trade_info'] = (string)$trade_info;
        return $this;
    }

    /**
     * 交易信息json
     * 
     * Column Type: varchar(800)
     * 
     * @return string
     */
    public function getTrade_info() {
        return $this->_trade_info;
    }

    /**
     * 错误描述
     * 
     * Column Type: varchar(255)
     * 
     * @param string $error
     * @return \M\Myttradeorder
     */
    public function setError($error) {
        $this->_error = (string)$error;
        $this->_params['error'] = (string)$error;
        return $this;
    }

    /**
     * 错误描述
     * 
     * Column Type: varchar(255)
     * 
     * @return string
     */
    public function getError() {
        return $this->_error;
    }

    /**
     * 轮询时间
     * 
     * Column Type: int(5)
     * Default: 0
     * 
     * @param int $polling
     * @return \M\Myttradeorder
     */
    public function setPolling($polling) {
        $this->_polling = (int)$polling;
        $this->_params['polling'] = (int)$polling;
        return $this;
    }

    /**
     * 轮询时间
     * 
     * Column Type: int(5)
     * Default: 0
     * 
     * @return int
     */
    public function getPolling() {
        return $this->_polling;
    }

    /**
     * 备注
     * 
     * Column Type: varchar(255)
     * 
     * @param string $remark
     * @return \M\Myttradeorder
     */
    public function setRemark($remark) {
        $this->_remark = (string)$remark;
        $this->_params['remark'] = (string)$remark;
        return $this;
    }

    /**
     * 备注
     * 
     * Column Type: varchar(255)
     * 
     * @return string
     */
    public function getRemark() {
        return $this->_remark;
    }

    /**
     * Return a array of model properties
     * 
     * @return array
     */
    public function toArray() {
        return array(
            'id'            => $this->_id,
            'goods_name'    => $this->_goods_name,
            'out_trade_no'  => $this->_out_trade_no,
            'into_trade_no' => $this->_into_trade_no,
            'merchant_id'   => $this->_merchant_id,
            'payment_type'  => $this->_payment_type,
            'type'          => $this->_type,
            'amount'        => $this->_amount,
            'status'        => $this->_status,
            'create_at'     => $this->_create_at,
            'update_at'     => $this->_update_at,
            'is_done'       => $this->_is_done,
            'diver'         => $this->_diver,
            'random_num'    => $this->_random_num,
            'trade_info'    => $this->_trade_info,
            'error'         => $this->_error,
            'polling'       => $this->_polling,
            'remark'        => $this->_remark
        );
    }

}
