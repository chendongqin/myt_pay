<?php

/**
 * 用户资金表
 * 
 * @Table Schema: payment
 * @Table Name: pay_user_finance
 */
namespace M;

class MytUserFinance extends \M\ModelAbstract {

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
     * 用户id
     * 
     * Column Type: int(11)
     * Default: 0
     * 
     * @var int
     */
    protected $_user_id = 0;

    /**
     * 可提现金额
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @var float
     */
    protected $_able_withdraw = 0.00;

    /**
     * 不可提现金额
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @var float
     */
    protected $_un_withdraw = 0.00;

    /**
     * 冻结金额
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @var float
     */
    protected $_freezed = 0.00;

    /**
     * 返利（存钱罐）
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @var float
     */
    protected $_rebate_money = 0.00;

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
     * 总收益
     * 
     * Column Type: decimal(12,2)
     * Default: 0.00
     * 
     * @var float
     */
    protected $_total_revenue = 0.00;

    /**
     * 总充值
     * 
     * Column Type: decimal(12,2)
     * Default: 0.00
     * 
     * @var float
     */
    protected $_total_recharge = 0.00;

    /**
     * 总提现
     * 
     * Column Type: decimal(12,2)
     * Default: 0.00
     * 
     * @var float
     */
    protected $_total_withdraw = 0.00;

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
     * @return \M\MytUserFinance
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
     * 用户id
     * 
     * Column Type: int(11)
     * Default: 0
     * 
     * @param int $user_id
     * @return \M\MytUserFinance
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
     * 可提现金额
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @param float $able_withdraw
     * @return \M\MytUserFinance
     */
    public function setAble_withdraw($able_withdraw) {
        $this->_able_withdraw = (float)$able_withdraw;
        $this->_params['able_withdraw'] = (float)$able_withdraw;
        return $this;
    }

    /**
     * 可提现金额
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @return float
     */
    public function getAble_withdraw() {
        return $this->_able_withdraw;
    }

    /**
     * 不可提现金额
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @param float $un_withdraw
     * @return \M\MytUserFinance
     */
    public function setUn_withdraw($un_withdraw) {
        $this->_un_withdraw = (float)$un_withdraw;
        $this->_params['un_withdraw'] = (float)$un_withdraw;
        return $this;
    }

    /**
     * 不可提现金额
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @return float
     */
    public function getUn_withdraw() {
        return $this->_un_withdraw;
    }

    /**
     * 冻结金额
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @param float $freezed
     * @return \M\MytUserFinance
     */
    public function setFreezed($freezed) {
        $this->_freezed = (float)$freezed;
        $this->_params['freezed'] = (float)$freezed;
        return $this;
    }

    /**
     * 冻结金额
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @return float
     */
    public function getFreezed() {
        return $this->_freezed;
    }

    /**
     * 返利（存钱罐）
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @param float $rebate_money
     * @return \M\MytUserFinance
     */
    public function setRebate_money($rebate_money) {
        $this->_rebate_money = (float)$rebate_money;
        $this->_params['rebate_money'] = (float)$rebate_money;
        return $this;
    }

    /**
     * 返利（存钱罐）
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @return float
     */
    public function getRebate_money() {
        return $this->_rebate_money;
    }

    /**
     * 创建时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @param int $create_at
     * @return \M\MytUserFinance
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
     * @return \M\MytUserFinance
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
     * 总收益
     * 
     * Column Type: decimal(12,2)
     * Default: 0.00
     * 
     * @param float $total_revenue
     * @return \M\MytUserFinance
     */
    public function setTotal_revenue($total_revenue) {
        $this->_total_revenue = (float)$total_revenue;
        $this->_params['total_revenue'] = (float)$total_revenue;
        return $this;
    }

    /**
     * 总收益
     * 
     * Column Type: decimal(12,2)
     * Default: 0.00
     * 
     * @return float
     */
    public function getTotal_revenue() {
        return $this->_total_revenue;
    }

    /**
     * 总充值
     * 
     * Column Type: decimal(12,2)
     * Default: 0.00
     * 
     * @param float $total_recharge
     * @return \M\MytUserFinance
     */
    public function setTotal_recharge($total_recharge) {
        $this->_total_recharge = (float)$total_recharge;
        $this->_params['total_recharge'] = (float)$total_recharge;
        return $this;
    }

    /**
     * 总充值
     * 
     * Column Type: decimal(12,2)
     * Default: 0.00
     * 
     * @return float
     */
    public function getTotal_recharge() {
        return $this->_total_recharge;
    }

    /**
     * 总提现
     * 
     * Column Type: decimal(12,2)
     * Default: 0.00
     * 
     * @param float $total_withdraw
     * @return \M\MytUserFinance
     */
    public function setTotal_withdraw($total_withdraw) {
        $this->_total_withdraw = (float)$total_withdraw;
        $this->_params['total_withdraw'] = (float)$total_withdraw;
        return $this;
    }

    /**
     * 总提现
     * 
     * Column Type: decimal(12,2)
     * Default: 0.00
     * 
     * @return float
     */
    public function getTotal_withdraw() {
        return $this->_total_withdraw;
    }

    /**
     * Return a array of model properties
     * 
     * @return array
     */
    public function toArray() {
        return array(
            'id'             => $this->_id,
            'user_id'        => $this->_user_id,
            'able_withdraw'  => $this->_able_withdraw,
            'un_withdraw'    => $this->_un_withdraw,
            'freezed'        => $this->_freezed,
            'rebate_money'   => $this->_rebate_money,
            'create_at'      => $this->_create_at,
            'update_at'      => $this->_update_at,
            'total_revenue'  => $this->_total_revenue,
            'total_recharge' => $this->_total_recharge,
            'total_withdraw' => $this->_total_withdraw
        );
    }

}
