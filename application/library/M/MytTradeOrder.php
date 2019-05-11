<?php

/**
 * 流水订单表
 * 
 * @Table Schema: payment
 * @Table Name: pay_trade_order
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
     * 交易流水号
     * 
     * Column Type: char(21)
     * 
     * @var string
     */
    protected $_out_trade_no = '';

    /**
     * 支付渠道
     * 
     * Column Type: varchar(20)
     * 
     * @var string
     */
    protected $_payment_type = '';

    /**
     * 用户id
     * 
     * Column Type: int(11)
     * Default: 0
     * 
     * @var int
     */
    protected $_user_id = 0;

    /**
     * 用户第三方账号
     * 
     * Column Type: varchar(60)
     * 
     * @var string
     */
    protected $_user_account = '';

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
     * @return \M\MytTradeOrder
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
     * 交易流水号
     * 
     * Column Type: char(21)
     * 
     * @param string $out_trade_no
     * @return \M\MytTradeOrder
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
     * 支付渠道
     * 
     * Column Type: varchar(20)
     * 
     * @param string $payment_type
     * @return \M\MytTradeOrder
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
     * 用户id
     * 
     * Column Type: int(11)
     * Default: 0
     * 
     * @param int $user_id
     * @return \M\MytTradeOrder
     */
    public function setUser_id($user_id) {
        $this->_user_id = (int)$user_id;
        $this->_params['user_id'] = (int)$user_id;
        return $this;
    }

    /**
     * 用户id
     * 
     * Column Type: int(11)
     * Default: 0
     * 
     * @return int
     */
    public function getUser_id() {
        return $this->_user_id;
    }

    /**
     * 用户第三方账号
     * 
     * Column Type: varchar(60)
     * 
     * @param string $user_account
     * @return \M\MytTradeOrder
     */
    public function setUser_account($user_account) {
        $this->_user_account = (string)$user_account;
        $this->_params['user_account'] = (string)$user_account;
        return $this;
    }

    /**
     * 用户第三方账号
     * 
     * Column Type: varchar(60)
     * 
     * @return string
     */
    public function getUser_account() {
        return $this->_user_account;
    }

    /**
     * 交易类型
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @param int $type
     * @return \M\MytTradeOrder
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
     * @return \M\MytTradeOrder
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
     * @return \M\MytTradeOrder
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
     * @return \M\MytTradeOrder
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
     * @return \M\MytTradeOrder
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
     * @return \M\MytTradeOrder
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
     * Return a array of model properties
     * 
     * @return array
     */
    public function toArray() {
        return array(
            'id'           => $this->_id,
            'out_trade_no' => $this->_out_trade_no,
            'payment_type' => $this->_payment_type,
            'user_id'      => $this->_user_id,
            'user_account' => $this->_user_account,
            'type'         => $this->_type,
            'amount'       => $this->_amount,
            'status'       => $this->_status,
            'create_at'    => $this->_create_at,
            'update_at'    => $this->_update_at,
            'is_done'      => $this->_is_done
        );
    }

}
